<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(["name" => "create attendance"]);
        Permission::create(["name" => "read attendance"]);
        Permission::create(["name" => "update attendance"]);
        Permission::create(["name" => "delete attendance"]);

        Permission::create(["name" => "create user"]);
        Permission::create(["name" => "read user"]);
        Permission::create(["name" => "update user"]);
        Permission::create(["name" => "delete user"]);

        Permission::create(["name" => "create career experience"]);
        Permission::create(["name" => "read career experience"]);
        Permission::create(["name" => "update career experience"]);
        Permission::create(["name" => "delete career experience"]);

        Permission::create(["name" => "create contract"]);
        Permission::create(["name" => "read contract"]);
        Permission::create(["name" => "update contract"]);
        Permission::create(["name" => "delete contract"]);

        Permission::create(["name" => "create department"]);
        Permission::create(["name" => "read department"]);
        Permission::create(["name" => "update department"]);
        Permission::create(["name" => "delete department"]);

        Permission::create(["name" => "create education"]);
        Permission::create(["name" => "read education"]);
        Permission::create(["name" => "update education"]);
        Permission::create(["name" => "delete education"]);

        Permission::create(["name" => "create employee_type"]);
        Permission::create(["name" => "read employee_type"]);
        Permission::create(["name" => "update employee_type"]);
        Permission::create(["name" => "delete employee_type"]);

        Permission::create(["name" => "create final evaluation"]);
        Permission::create(["name" => "read final evaluation"]);
        Permission::create(["name" => "update final evaluation"]);
        Permission::create(["name" => "delete final evaluation"]);

        Permission::create(["name" => "create goals"]);
        Permission::create(["name" => "read goals"]);
        Permission::create(["name" => "update goals"]);
        Permission::create(["name" => "delete goals"]);

        Permission::create(["name" => "create insurance"]);
        Permission::create(["name" => "read insurance"]);
        Permission::create(["name" => "update insurance"]);
        Permission::create(["name" => "delete insurance"]);

        Permission::create(["name" => "create job level"]);
        Permission::create(["name" => "read job level"]);
        Permission::create(["name" => "update job level"]);
        Permission::create(["name" => "delete job level"]);

        Permission::create(["name" => "create leave"]);
        Permission::create(["name" => "read leave"]);
        Permission::create(["name" => "update leave"]);
        Permission::create(["name" => "delete leave"]);

        Permission::create(["name" => "create mid evaluation"]);
        Permission::create(["name" => "read mid evaluation"]);
        Permission::create(["name" => "update mid evaluation"]);
        Permission::create(["name" => "delete mid evaluation"]);

        Permission::create(["name" => "create project"]);
        Permission::create(["name" => "read project"]);
        Permission::create(["name" => "update project"]);
        Permission::create(["name" => "delete project"]);

        Permission::create(["name" => "create responsibility"]);
        Permission::create(["name" => "read responsibility"]);
        Permission::create(["name" => "update responsibility"]);
        Permission::create(["name" => "delete responsibility"]);

        Permission::create(["name" => "create salary"]);
        Permission::create(["name" => "read salary"]);
        Permission::create(["name" => "update salary"]);
        Permission::create(["name" => "delete salary"]);

        Permission::create(["name" => "create task"]);
        Permission::create(["name" => "read task"]);
        Permission::create(["name" => "update task"]);
        Permission::create(["name" => "delete task"]);

        Permission::create(["name" => "create teams"]);
        Permission::create(["name" => "read teams"]);
        Permission::create(["name" => "update teams"]);
        Permission::create(["name" => "delete teams"]);

    

       
    }
}
