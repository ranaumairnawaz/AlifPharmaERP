<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ProjectManager::create(['name' => 'Dr. Khawaja Mushtaq']);
        \App\Models\ProjectManager::create(['name' => 'Engr. Bilal Ahmad']);
        \App\Models\ProjectManager::create(['name' => 'Dr. Salman Haider']);
    }
}
