<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::findByName("admin");
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::findByName("manager");
        $managerRole->givePermissionTo([
            "create attendance",
            "read attendance",
            "update attendance",
            "delete attendance",

            "read user",

            "create career experience",
            "read career experience",
            "update career experience",
            "delete career experience",

            "read contract",
            
            "read department",

            "create education",
            "read education",
            "update education",
            "delete education",

            "read employee_type",

            "create final evaluation",
            "read final evaluation",
            "update final evaluation",
            "delete final evaluation",

            "create goals",
            "read goals",
            "update goals",
            "delete goals",

            "create insurance",
            "read insurance",
            "update insurance",
            "delete insurance",

            "read job level",

            "create leave",
            "read leave",
            "update leave",
            "delete leave",

            "create mid evaluation",
            "read mid evaluation",
            "update mid evaluation",
            "delete mid evaluation",

            "create project",
            "read project",
            "update project",
            "delete project",

            "create responsibility",
            "read responsibility",
            "update responsibility",
            "delete responsibility",

            "read salary",
            

            "create task",
            "read task",
            "update task",
            "delete task",

            "read teams",
          

            "create task",
            "read task",
            "update task",
            "delete task",
        ]);

        $staffRole = Role::findByName("staff");
        $staffRole->givePermissionTo([
            "read attendance",

            "read user",
            "update user",

            "create career experience",
            "read career experience",
            "update career experience",
            "delete career experience",

            "create education",
            "read education",
            "update education",
            "delete education",

            "create final evaluation",
            "read final evaluation",
            "update final evaluation",
            "delete final evaluation",

            "create goals",
            "read goals",
            "update goals",
            "delete goals",

            "create insurance",
            "read insurance",
            "update insurance",
            "delete insurance",


            "create leave",
            "read leave",
            "update leave",
            "delete leave",

            "create mid evaluation",
            "read mid evaluation",
            "update mid evaluation",
            "delete mid evaluation",

            "create project",
            "read project",
            "update project",
            "delete project",

            "create task",
            "read task",
            "update task",
            "delete task",

        ]);
            
       
        
    }
}
