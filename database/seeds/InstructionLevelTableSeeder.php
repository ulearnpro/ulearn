<?php

use Illuminate\Database\Seeder;
use App\Models\InstructionLevel;

class InstructionLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $is_exist = InstructionLevel::all();

        if (!$is_exist->count()) {
            $instruction_levels = new InstructionLevel();
            $instruction_levels->level = 'Introductory';
            $instruction_levels->save();

            $instruction_levels = new InstructionLevel();
            $instruction_levels->level = 'Intermediate';
            $instruction_levels->save();

            $instruction_levels = new InstructionLevel();
            $instruction_levels->level = 'Advanced';
            $instruction_levels->save();

            $instruction_levels = new InstructionLevel();
            $instruction_levels->level = 'Comprehensive';
            $instruction_levels->save();
        }
    }
}
