<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SysUser>
 */
class SysUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'firstname' => $this->faker->unique()->firstName(),
            'lastname' => $this->faker->firstName(),
            'middlename' => $this->faker->name(),
            'contact' => $this->faker->name(),
            'address' => null,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'type' => rand(1,2),
            'avatar' => null,
        ];
    }
}
