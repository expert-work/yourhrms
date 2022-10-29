<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Performance\Goal;
use App\Models\Performance\GoalType;

class GoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // goal type
        $names = ['Employee Experience', 'Objective', 'Target', 'KPI', 'Measure', 'Indicator'];
        foreach ($names as $name) {
           GoalType::create([
                'name' => $name,
                'company_id' => 2,
            ]);
        }

        // goals
        $goals = new Goal();
        $goals->company_id = 2;
        $goals->subject = 'Employee Experience';
        $goals->target = 'Employee Experience';
        $goals->goal_type_id = 1;
        $goals->rating = 0;
        $goals->progress = 1;
        $goals->start_date = date('Y-m-d');
        $goals->end_date = date('Y-m-d', strtotime('+1 year'));
        $goals->created_by = 2;
        $goals->description = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
        $goals->save();
    }
}
