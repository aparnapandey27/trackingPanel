<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoalNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $numberOfRecords = 50;

        for ($i = 1; $i <= $numberOfRecords; $i++) {
            $name = 'Default_' . $i;

            // Insert the record into the 'goal_names' table
            DB::table('goal_names')->insert([
                'name' => $name,
            ]);
        }
    }
}
