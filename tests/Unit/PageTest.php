<?php

namespace Tests\Unit;

use Altenic\MaybeCms\Factories\PageFactory;
use Altenic\MaybeCms\Factories\UserFactory;
use Altenic\MaybeCms\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class PageTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_page_unauthorized()
    {
        $this->postJson('/api/admin/pages')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_create_page_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/admin/pages')
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_create_page_validation_failed()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/pages')
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'title' => 'The title field is required.',
                ],
            ]);
    }

    public function test_create_page_success()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'title' => fake()->sentence(2),
        ];
        $this->postJson('/api/admin/pages', $data)
            ->assertCreated()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'class_name' => Page::class,
                    'active' => true,
                    'blocks' => [],
                    'meta' => [],
                ],
            ]);
        $this->assertDatabaseHas((new Page)->getTable(), [
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'active' => 1,
            'user_id' => auth()->id(),
        ]);
    }

    public function test_update_page_unauthorized()
    {
        $this->postJson('/api/admin/pages/' . app(PageFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_update_page_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/admin/pages/' . app(PageFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_update_page_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/pages/' . Page::max('id') + 1)
            ->assertNotFound()
            ->assertJson([
                'status' => 'error',
                'message' => 'Not Found',
            ]);
    }

    public function test_update_page_validation_failed()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/admin/pages/' . app(PageFactory::class)->create()->id, [
            'title' => '',
            'active' => 123,
        ])
            ->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => [
                    'title' => 'The title field must have a value.',
                    'active' => 'The active field must be true or false.',
                ],
            ]);
    }

    public function test_update_page_success()
    {
        $page = app(PageFactory::class)->create();
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $data = [
            'title' => fake()->sentence(2),
            'active' => false,
        ];
        $this->postJson('/api/admin/pages/' . $page->id, $data)
            ->assertSuccessful()
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'class_name' => Page::class,
                    'active' => $data['active'],
                    'blocks' => [],
                    'meta' => [],
                ],
            ]);
        $this->assertDatabaseHas((new Page)->getTable(), [
            'id' => $page->id,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'active' => $data['active'],
        ]);
    }

    public function test_delete_page_unauthorized()
    {
        $this->deleteJson('/api/admin/pages/' . app(PageFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_delete_page_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->deleteJson('/api/admin/pages/' . app(PageFactory::class)->create()->id)
            ->assertForbidden()
            ->assertJson([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
    }

    public function test_delete_page_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/admin/pages/' . Page::max('id') + 1)
            ->assertNotFound()
            ->assertJson([
                'status' => 'error',
                'message' => 'Not Found',
            ]);
    }

    public function test_delete_page_success()
    {
        $page = app(PageFactory::class)->create();
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/admin/pages/' . $page->id)
            ->assertNoContent();
        $this->assertDatabaseMissing((new Page)->getTable(), [
            'id' => $page->id,
        ]);
    }
}
