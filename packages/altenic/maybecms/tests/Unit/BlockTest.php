<?php

namespace Altenic\MaybeCms\Tests\Unit;

use Altenic\MaybeCms\Factories\BlockFactory;
use Altenic\MaybeCms\Factories\PageFactory;
use Altenic\MaybeCms\Factories\UserFactory;
use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BlockTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_block_unauthorized()
    {
        $this->postJson('/api/blocks')
            ->assertUnauthorized();
    }

    public function test_create_block_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/blocks')
            ->assertForbidden();
    }

    public function test_create_block_validation_failed_empty_body()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/blocks')
            ->assertUnprocessable()
            ->assertJson([
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
        $this->postJson('/api/blocks', [
            'attachable_type' => 'block',
            'attachable_id' => app(BlockFactory::class)->create(['type' => 'section'])->id,
            'type' => 'invalid-type',
        ])
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'type' => 'The selected type is invalid.',
                ],
            ]);
    }

    public function test_create_block_validation_failed_incorrect_attachable_id()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/blocks', [
            'attachable_type' => 'block',
            'attachable_id' => Block::max('id') + 1,
            'type' => 'section',
        ])
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'attachable_id' => 'The selected attachable id is invalid.',
                ],
            ]);
    }

    public function test_create_section_block_for_block_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'attachable_type' => 'block',
            'attachable_id' => app(BlockFactory::class)->create(['type' => 'section'])->id,
            'type' => 'section',
        ];
        $this->postJson('/api/blocks', $data)
            ->assertCreated()
            ->assertJsonStructure([
                'id',
                'type',
                'title',
                'content',
                'children',
                'class_name',
                'post_type_id',
                'active',
                'order',
                'blocks',
                'created_at',
                'updated_at',
            ]);
    }

    public function test_create_section_block_for_page_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'attachable_type' => 'page',
            'attachable_id' => app(PageFactory::class)->create()->id,
            'type' => 'section',
        ];
        $this->postJson('/api/blocks', $data)
            ->assertCreated()
            ->assertJsonStructure([
                'id',
                'type',
                'title',
                'content',
                'children',
                'class_name',
                'post_type_id',
                'active',
                'order',
                'blocks',
                'created_at',
                'updated_at',
            ]);
    }

    public function test_delete_block_unauthorized()
    {
        $this->deleteJson('/api/blocks/' . app(BlockFactory::class)->create()->id)
            ->assertUnauthorized();
    }

    public function test_delete_block_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->deleteJson('/api/blocks/' . app(BlockFactory::class)->create()->id)
            ->assertForbidden();
    }

    public function test_delete_block_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/blocks/' . Block::max('id') + 1)
            ->assertNotFound();
    }

    public function test_delete_block_success()
    {
        $block = app(BlockFactory::class)->create();
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/blocks/' . $block->id)
            ->assertNoContent();
        $this->assertDatabaseMissing((new Block)->getTable(), [
            'id' => $block->id,
        ]);
    }
}
