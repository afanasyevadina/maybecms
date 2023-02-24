<?php

namespace Tests\Unit;

use Altenic\MaybeCms\Factories\BlockFactory;
use Altenic\MaybeCms\Factories\PresetFactory;
use Altenic\MaybeCms\Factories\UserFactory;
use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Preset;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class PresetTest extends TestCase
{
    use DatabaseTransactions;

    public function test_list_presets_unauthorized()
    {
        $this->getJson('/api/admin/presets')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_list_presets_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->getJson('/api/admin/presets')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_list_presets_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->getJson('/api/admin/presets')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'slug',
                        'title',
                        'blocks' => [],
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);
    }

    public function test_show_preset_unauthorized()
    {
        $this->getJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_show_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->getJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_show_preset_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->getJson('/api/admin/presets/' . Preset::max('id') + 1)
            ->assertNotFound()
            ->assertJson([
                'status' => 'error',
                'message' => 'Not Found',
            ]);
    }

    public function test_show_preset_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->getJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id)
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'slug',
                    'title',
                    'blocks' => [],
                    'created_at',
                    'updated_at',
                ],
            ]);
    }

    public function test_create_preset_unauthorized()
    {
        $this->postJson('/api/admin/presets')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_create_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/admin/presets')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_create_preset_validation_failed()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/presets')
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'title' => 'The title field is required.',
                ],
            ]);
    }

    public function test_create_preset_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'title' => fake()->sentence(2),
        ];
        $this->postJson('/api/admin/presets', $data)
            ->assertCreated()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'blocks' => [],
                ],
            ]);
        $this->assertDatabaseHas((new Preset)->getTable(), [
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'user_id' => auth()->id(),
        ]);
    }

    public function test_update_preset_unauthorized()
    {
        $this->postJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_update_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_update_preset_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/presets/' . Preset::max('id') + 1)
            ->assertNotFound()
            ->assertJson([
                'status' => 'error',
                'message' => 'Not Found',
            ]);
    }

    public function test_update_preset_validation_failed()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id, [
            'title' => '',
            'blocks' => 123,
        ])
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'title' => 'The title field must have a value.',
                    'blocks' => 'The blocks must be an array.',
                ],
            ]);
    }

    public function test_update_preset_success()
    {
        $preset = app(PresetFactory::class)->create();
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'title' => fake()->sentence(2),
            'blocks' => [
                'type' => 'section',
                'blocks' => [
                    ['type' => 'single-line-text'],
                    ['type' => 'link'],
                ],
            ],
        ];
        $this->postJson('/api/admin/presets/' . $preset->id, $data)
            ->assertSuccessful()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'blocks' => $data['blocks'],
                ],
            ]);
        $this->assertDatabaseHas((new Preset)->getTable(), [
            'id' => $preset->id,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'blocks' => json_encode($data['blocks']),
        ]);
    }

    public function test_delete_preset_unauthorized()
    {
        $this->deleteJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_delete_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->deleteJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_delete_preset_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/admin/presets/' . Preset::max('id') + 1)
            ->assertNotFound()
            ->assertJson([
                'status' => 'error',
                'message' => 'Not Found',
            ]);
    }

    public function test_delete_preset_success()
    {
        $preset = app(PresetFactory::class)->create();
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/admin/presets/' . $preset->id)
            ->assertNoContent();
        $this->assertDatabaseMissing((new Preset)->getTable(), [
            'id' => $preset->id,
        ]);
    }

    public function test_apply_preset_unauthorized()
    {
        $this->postJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id . '/apply')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_apply_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id . '/apply')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_apply_preset_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/presets/' . Preset::max('id') + 1 . '/apply')
            ->assertNotFound()
            ->assertJson([
                'status' => 'error',
                'message' => 'Not Found',
            ]);
    }

    public function test_apply_preset_validation_failed_empty_body()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id . '/apply')
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'attachable_id' => 'The attachable id field is required.',
                    'attachable_type' => 'The attachable type field is required.',
                ],
            ]);
    }

    public function test_apply_preset_validation_failed_incorrect_attachable_type()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id . '/apply', [
            'attachable_type' => 'invalid-type',
            'attachable_id' => app(BlockFactory::class)->create(['type' => 'section'])->id,
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

    public function test_apply_preset_validation_failed_incorrect_attachable_id()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/presets/' . app(PresetFactory::class)->create()->id . '/apply', [
            'attachable_type' => Block::class,
            'attachable_id' => Block::max('id') + 1,
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

    public function test_apply_preset_success()
    {
        $preset = app(PresetFactory::class)->create([
            'blocks' => [
                ['type' => 'single-line-text'],
                ['type' => 'link'],
            ]
        ]);
        $block = app(BlockFactory::class)->create(['type' => 'section']);
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/presets/' . $preset->id . '/apply', [
            'attachable_type' => Block::class,
            'attachable_id' => $block->id,
        ])
            ->assertSuccessful()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    [
                        'attachable_id' => $block->id,
                        'attachable_type' => Block::class,
                        'class_name' => Block::class,
                        'type' => 'single-line-text',
                        'order' => 1,
                        'active' => true,
                        'content' => ['text' => ''],
                    ],
                    [
                        'attachable_id' => $block->id,
                        'attachable_type' => Block::class,
                        'class_name' => Block::class,
                        'type' => 'link',
                        'order' => 2,
                        'active' => true,
                        'content' => ['text' => '', 'link' => ''],
                        'attachment' => null,
                    ],
                ],
            ]);
        collect($preset->blocks)->each(fn($presetBlock) => $this->assertTrue($block->blocks()->where('type', $presetBlock['type'])->exists()));
    }
}
