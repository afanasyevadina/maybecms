<?php

namespace Altenic\MaybeCms\Factories;

use Altenic\MaybeCms\Models\Preset;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class PresetFactory extends Factory
{
    protected $model = Preset::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(2),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Preset $page) {
            $page->slug = Str::slug($page->title);
        });
    }
}
