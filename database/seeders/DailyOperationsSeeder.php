<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DailyOperations;
use Carbon\Carbon;

class DailyOperationsSeeder extends Seeder
{
    public function run()
    {
        // Generate data for at least 7 days
        foreach (range(1, 7) as $day) {
            DailyOperations::factory()->count(7)->create([
                'start_time' => Carbon::now()->subDays($day)->setHour(rand(8, 16))->setMinute(0)->setSecond(0),
            ]);
        }
    }
}
