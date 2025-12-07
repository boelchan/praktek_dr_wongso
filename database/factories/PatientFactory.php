<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PatientFactory extends Factory
{
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'nik' => fake()->numerify('##############'),  // 16 digit
            'no_rm' => fake()->numerify('RM#####'),
            'full_name' => fake()->name(),
            'dob' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'address' => fake()->address(),
            'status' => 'active',
        ];
    }
}
