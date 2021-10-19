<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'guest_name' => $this->faker->name(),
            'guest_email' => $this->faker->unique()->safeEmail(),
            'commentable_type' => 'App\\Models\\NewsArticle',
            'commentable_id' => '1', // password
            'comment' => $this->faker->sentence(),
            'created_at'=> $this->faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null)

        ];
    }
}
