<?php

namespace Altenic\MaybeCms\Factories;

use Altenic\MaybeCms\Models\Block;
use Altenic\MaybeCms\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class BlockFactory extends Factory
{

    protected $model = Block::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(2),
            'type' => fake()->randomElement(array_column(Block::PRIMITIVES, 'type')),
            'attachable_type' => Page::class,
            'attachable_id' => app(PageFactory::class)->create()->id,
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Block $block) {
            $block->slug = Str::slug($block->title);
        });
    }
}
