<?php

namespace Altenic\MaybeCms\Tests\Unit;

use Altenic\MaybeCms\Factories\BlockFactory;
use Altenic\MaybeCms\Factories\PresetFactory;
use Altenic\MaybeCms\Factories\UserFactory;
use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Preset;
use Altenic\MaybeCms\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;

class PresetTest extends TestCase
{
    use DatabaseTransactions;

    public function test_list_presets_unauthorized()
    {
        $this->getJson('/api/presets')
            ->assertUnauthorized();
    }

    public function test_list_presets_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->getJson('/api/presets')
            ->assertForbidden();
    }

    public function test_list_presets_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->getJson('/api/presets')
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
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
        $this->getJson('/api/presets/' . app(PresetFactory::class)->create()->id)
            ->assertUnauthorized();
    }

    public function test_show_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->getJson('/api/presets/' . app(PresetFactory::class)->create()->id)
            ->assertForbidden();
    }

    public function test_show_preset_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->getJson('/api/presets/' . Preset::max('id') + 1)
            ->assertNotFound();
    }

    public function test_show_preset_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->getJson('/api/presets/' . app(PresetFactory::class)->create()->id)
            ->assertSuccessful()
            ->assertJsonStructure([
                'id',
                'title',
                'blocks' => [],
                'created_at',
                'updated_at',
            ]);
    }

    public function test_create_preset_unauthorized()
    {
        $this->postJson('/api/presets')
            ->assertUnauthorized();
    }

    public function test_create_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/presets')
            ->assertForbidden();
    }

    public function test_create_preset_validation_failed()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/presets')
            ->assertUnprocessable()
            ->assertJson([
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
        $this->postJson('/api/presets', $data)
            ->assertCreated()
            ->assertJsonStructure([
                'id',
            ]);
        $this->assertDatabaseHas((new Preset)->getTable(), [
            'title' => $data['title'],
            'user_id' => auth()->id(),
        ]);
    }

    public function test_update_preset_unauthorized()
    {
        $this->postJson('/api/presets/' . app(PresetFactory::class)->create()->id)
            ->assertUnauthorized();
    }

    public function test_update_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/presets/' . app(PresetFactory::class)->create()->id)
            ->assertForbidden();
    }

    public function test_update_preset_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/presets/' . Preset::max('id') + 1)
            ->assertNotFound();
    }

    public function test_update_preset_validation_failed()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/presets/' . app(PresetFactory::class)->create()->id, [
            'title' => '',
            'blocks' => 123,
        ])
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'title' => 'The title field is required.',
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
        ];
        $this->postJson('/api/presets/' . $preset->id, $data)
            ->assertSuccessful();
        $this->assertDatabaseHas((new Preset)->getTable(), [
            'id' => $preset->id,
            'title' => $data['title'],
        ]);
    }

    public function test_delete_preset_unauthorized()
    {
        $this->deleteJson('/api/presets/' . app(PresetFactory::class)->create()->id)
            ->assertUnauthorized();
    }

    public function test_delete_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->deleteJson('/api/presets/' . app(PresetFactory::class)->create()->id)
            ->assertForbidden();
    }

    public function test_delete_preset_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/presets/' . Preset::max('id') + 1)
            ->assertNotFound();
    }

    public function test_delete_preset_success()
    {
        $preset = app(PresetFactory::class)->create();
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/presets/' . $preset->id)
            ->assertNoContent();
        $this->assertDatabaseMissing((new Preset)->getTable(), [
            'id' => $preset->id,
        ]);
    }

    public function test_apply_preset_unauthorized()
    {
        $this->postJson('/api/presets/' . app(PresetFactory::class)->create()->id . '/apply')
            ->assertUnauthorized();
    }

    public function test_apply_preset_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/presets/' . app(PresetFactory::class)->create()->id . '/apply')
            ->assertForbidden();
    }

    public function test_apply_preset_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/presets/' . Preset::max('id') + 1 . '/apply')
            ->assertNotFound();
    }

    public function test_apply_preset_validation_failed_empty_body()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/presets/' . app(PresetFactory::class)->create()->id . '/apply')
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'attachable_id' => 'The attachable id field is required.',
                    'attachable_type' => 'The attachable type field is required.',
                ],
            ]);
    }

    public function test_apply_preset_validation_failed_incorrect_attachable_id()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/presets/' . app(PresetFactory::class)->create()->id . '/apply', [
            'attachable_type' => 'block',
            'attachable_id' => Block::max('id') + 1,
        ])
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'attachable_id' => 'The selected attachable id is invalid.',
                ],
            ]);
    }

    //TODO: apply preset tests
}
