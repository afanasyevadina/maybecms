<?php

namespace Altenic\MaybeCms\Tests\Unit;

use Altenic\MaybeCms\Factories\PageFactory;
use Altenic\MaybeCms\Factories\UserFactory;
use Altenic\MaybeCms\Models\Page;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Altenic\MaybeCms\Tests\TestCase;

class PageTest extends TestCase
{
    use DatabaseTransactions;

    public function test_create_page_unauthorized()
    {
        $this->postJson('/api/pages')
            ->assertUnauthorized();
    }

    public function test_create_page_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/pages')
            ->assertForbidden();
    }

    public function test_create_page_validation_failed()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/pages')
            ->assertUnprocessable()
            ->assertJson([
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
        $this->postJson('/api/pages', $data)
            ->assertCreated()
            ->assertJsonStructure([
                'id',
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
        $this->postJson('/api/pages/' . app(PageFactory::class)->create()->id)
            ->assertUnauthorized();
    }

    public function test_update_page_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->postJson('/api/pages/' . app(PageFactory::class)->create()->id)
            ->assertForbidden();
    }

    public function test_update_page_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/pages/' . Page::max('id') + 1)
            ->assertNotFound();
    }

    public function test_update_page_validation_failed()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->postJson('/api/pages/' . app(PageFactory::class)->create()->id, [
            'title' => '',
            'slug' => '',
        ])
            ->assertUnprocessable()
            ->assertJson([
                'errors' => [
                    'title' => 'The title field is required.',
                    'slug' => 'The slug field is required.',
                ],
            ]);
    }

    public function test_update_page_success()
    {
        $page = app(PageFactory::class)->create();
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $slug = fake()->sentence(2);
        $data = [
            'title' => fake()->sentence(2),
            'slug' => $slug,
        ];
        $this->postJson('/api/pages/' . $page->id, $data)
            ->assertSuccessful();
        $this->assertDatabaseHas((new Page)->getTable(), [
            'id' => $page->id,
            'title' => $data['title'],
            'slug' => Str::slug($data['slug']),
        ]);
    }

    public function test_delete_page_unauthorized()
    {
        $this->deleteJson('/api/pages/' . app(PageFactory::class)->create()->id)
            ->assertUnauthorized();
    }

    public function test_delete_page_permission_denied()
    {
        $this->actingAs(app(UserFactory::class)->create(), 'sanctum');
        $this->deleteJson('/api/pages/' . app(PageFactory::class)->create()->id)
            ->assertForbidden();
    }

    public function test_delete_page_not_found()
    {
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/pages/' . Page::max('id') + 1)
            ->assertNotFound();
    }

    public function test_delete_page_success()
    {
        $page = app(PageFactory::class)->create();
        $this->actingAs(app(UserFactory::class)->admin()->create(), 'sanctum');
        $this->deleteJson('/api/pages/' . $page->id)
            ->assertNoContent();
        $this->assertDatabaseMissing((new Page)->getTable(), [
            'id' => $page->id,
        ]);
    }
}
