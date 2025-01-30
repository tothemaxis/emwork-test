<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class DailyOperationsFactory extends Factory
{
    public function definition()
    {
        $start_time = Carbon::now()->subDays(rand(1, 15))->setHour(rand(8, 16))->setMinute(0)->setSecond(0);
        $end_time = (rand(0, 1) === 1) ? $start_time->copy()->addHours(rand(1, 5)) : null;

        return [
            'name' => 'Job ' . $this->faker->unique()->word,
            'work_type' => $this->faker->randomElement(['Test', 'Development', 'Document']),
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => $this->faker->randomElement(['ดำเนินการ', 'เสร็จสิ้น', 'ยกเลิก']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
