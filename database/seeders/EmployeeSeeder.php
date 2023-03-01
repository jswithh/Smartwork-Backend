<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name' => 'Hari Agus Permana',
            'email' => 'hari@hracademy.id',
            'gender' => 'male',
            'age' => 22,
            'phone' => '086722728888',
            'photo' => 'https://via.placeholder.com/150',
            'team_id' => 1,
            'department_id' => 1,
            'created_at' => '2021-01-01 00:00:00',
            'updated_at' => '2021-01-01 00:00:00',
        ]);
    }
}
