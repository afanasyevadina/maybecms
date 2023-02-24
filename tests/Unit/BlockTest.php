<?php

namespace Tests\Unit;

use Altenic\MaybeCms\Factories\BlockFactory;
use Altenic\MaybeCms\Factories\PageFactory;
use Altenic\MaybeCms\Factories\UserFactory;
use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class BlockTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_block_unauthorized()
    {
        $this->postJson('/api/admin/blocks')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_create_block_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/admin/blocks')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_create_block_validation_failed_empty_body()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/blocks')
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'attachable_id' => 'The attachable id field is required.',
                    'attachable_type' => 'The attachable type field is required.',
                    'type' => 'The type field is required.',
                ],
            ]);
    }

    public function test_create_block_validation_failed_incorrect_type()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/blocks', [
            'attachable_type' => Block::class,
            'attachable_id' => app(BlockFactory::class)->create(['type' => 'section'])->id,
            'type' => 'invalid-type',
        ])
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'type' => 'The selected type is invalid.',
                ],
            ]);
    }

    public function test_create_block_validation_failed_incorrect_attachable_type()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/blocks', [
            'attachable_type' => 'invalid-type',
            'attachable_id' => app(BlockFactory::class)->create(['type' => 'section'])->id,
            'type' => 'section',
        ])
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'attachable_type' => 'Attachable class not exists.',
                ],
            ]);
    }

    public function test_create_block_validation_failed_incorrect_attachable_id()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/blocks', [
            'attachable_type' => Block::class,
            'attachable_id' => Block::max('id') + 1,
            'type' => 'section',
        ])
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'attachable_id' => 'Attachable model not found.',
                ],
            ]);
    }

    public function test_create_section_block_with_title_for_block_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'title' => fake()->sentence(2),
            'attachable_type' => Block::class,
            'attachable_id' => app(BlockFactory::class)->create(['type' => 'section'])->id,
            'type' => 'section',
        ];
        $this->postJson('/api/admin/blocks', $data)
            ->assertCreated()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'class_name' => Block::class,
                    'type' => $data['type'],
                    'content' => null,
                    'active' => true,
                    'order' => 1,
                    'blocks' => [],
                ],
            ]);
        $this->assertDatabaseHas((new Block)->getTable(), [
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'active' => 1,
            'content' => null,
            'user_id' => auth()->id(),
        ]);
    }

    public function test_create_section_block_for_page_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'attachable_type' => Page::class,
            'attachable_id' => app(PageFactory::class)->create()->id,
            'type' => 'section',
        ];
        $this->postJson('/api/admin/blocks', $data)
            ->assertCreated()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'class_name' => Block::class,
                    'type' => $data['type'],
                    'content' => null,
                    'active' => true,
                    'order' => 1,
                    'blocks' => [],
                ],
            ]);
        $this->assertDatabaseHas((new Block)->getTable(), [
            'active' => 1,
            'content' => null,
            'user_id' => auth()->id(),
        ]);
    }

    public function test_update_block_unauthorized()
    {
        $this->postJson('/api/admin/blocks/' . app(BlockFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_update_block_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/admin/blocks/' . app(BlockFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_update_block_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/blocks/' . Block::max('id') + 1)
            ->assertNotFound()
            ->assertJson([
                'status' => 'error',
                'message' => 'Not Found',
            ]);
    }

    public function test_update_block_validation_failed()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/blocks/' . app(BlockFactory::class)->create()->id, [
            'active' => 123,
        ])
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'active' => 'The active field must be true or false.',
                ],
            ]);
    }

    public function test_update_single_line_text_block_success()
    {
        $block = app(BlockFactory::class)->create(['type' => 'single-line-text']);
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'content' => [
                'text' => fake()->sentence(),
            ],
            'active' => false,
        ];
        $this->postJson('/api/admin/blocks/' . $block->id, $data)
            ->assertSuccessful()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'type' => $block->type,
                    'title' => $block->title,
                    'slug' => $block->slug,
                    'class_name' => Block::class,
                    'active' => $data['active'],
                    'order' => $block->order,
                    'content' => $data['content'],
                ],
            ]);
        $this->assertDatabaseHas((new Block)->getTable(), [
            'id' => $block->id,
            'active' => $data['active'],
            'content' => json_encode($data['content']),
        ]);
    }

    public function test_update_link_text_block_success()
    {
        $block = app(BlockFactory::class)->create(['type' => 'link']);
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'content' => [
                'text' => fake()->sentence(),
                'link' => fake()->url(),
            ],
            'active' => false,
        ];
        $this->postJson('/api/admin/blocks/' . $block->id, $data)
            ->assertSuccessful()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'type' => $block->type,
                    'title' => $block->title,
                    'slug' => $block->slug,
                    'class_name' => Block::class,
                    'active' => $data['active'],
                    'order' => $block->order,
                    'content' => $data['content'],
                ],
            ]);
        $this->assertDatabaseHas((new Block)->getTable(), [
            'id' => $block->id,
            'active' => $data['active'],
            'content' => json_encode($data['content']),
        ]);
    }

    public function test_delete_block_unauthorized()
    {
        $this->deleteJson('/api/admin/blocks/' . app(BlockFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_delete_block_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->deleteJson('/api/admin/blocks/' . app(BlockFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_delete_block_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/admin/blocks/' . Block::max('id') + 1)
            ->assertNotFound()
            ->assertJson([
                'status' => 'error',
                'message' => 'Not Found',
            ]);
    }

    public function test_delete_block_success()
    {
        $block = app(BlockFactory::class)->create();
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/admin/blocks/' . $block->id)
            ->assertNoContent();
        $this->assertDatabaseMissing((new Block)->getTable(), [
            'id' => $block->id,
        ]);
    }
}
