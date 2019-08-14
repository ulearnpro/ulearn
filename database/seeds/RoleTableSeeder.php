<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleTableSeeder extends Seeder
{
  public function run()
  {
    $is_exist = Role::all();

    if (!$is_exist->count()) {
        $role_student = new Role();
        $role_student->name = 'student';
        $role_student->description = 'Student to learn course';
        $role_student->save();

        $role_instructor = new Role();
        $role_instructor->name = 'instructor';
        $role_instructor->description = 'Instructor to manage course';
        $role_instructor->save();

        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'Admin to manage the site';
        $role_admin->save();
    }
  }
}
