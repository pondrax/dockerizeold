<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('lumen123'),
            'role_id' => 2,
            'created_at' =>$this->faker->dateTimeBetween('-2 months'),
            'updated_at' =>$this->faker->dateTimeBetween('-2 months')
        ];
    }
}
