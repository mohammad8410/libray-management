<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserScore;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserScoreFactory extends Factory
{
    protected $model = UserScore::class;

    public function definition(): array
    {
        return [
            'user_id' => fn() => User::factory()->create()->id,
            'score'   => $this->faker->numberBetween(-2,2),
            'description' => $this->faker->name,
        ];
    }

    public function withUser(User $user): self
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }
}
