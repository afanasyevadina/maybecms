<?php

namespace Altenic\MaybeCms\Factories;

use Altenic\MaybeCms\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->jobTitle(),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Role $role) {
            $role->slug = Str::slug($role->title);
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'slug' => 'admin',
                'title' => 'Admin',
            ];
        });
    }
}
