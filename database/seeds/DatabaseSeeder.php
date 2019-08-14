<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $this->call(RoleTableSeeder::class);
		
		$this->call(UserTableSeeder::class);

        $this->call(InstructionLevelTableSeeder::class);

        $this->call(CategoryTableSeeder::class);

        $this->call(ConfigTableSeeder::class);

        $this->call(CourseTableSeeder::class);

        $this->call(BlogTableSeeder::class);

    }
}
