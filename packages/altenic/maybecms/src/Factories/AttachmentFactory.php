<?php

namespace Altenic\MaybeCms\Factories;

use Altenic\MaybeCms\Models\Attachment;
use Altenic\MaybeCms\Models\Block;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AttachmentFactory extends Factory
{

    protected $model = Attachment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type' => fake()->randomElement(['image', 'video']),
            'attachable_type' => Block::class,
            'attachable_id' => app(BlockFactory::class)->create(['type' => 'image'])->id,
        ];
    }
}
