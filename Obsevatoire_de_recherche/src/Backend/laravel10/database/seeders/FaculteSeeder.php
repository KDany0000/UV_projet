<?php

namespace Database\Seeders;

use App\Models\TblFaculte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaculteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TblFaculte::create([
            'nom_fac' =>'Faculte des sciences',
            'email_fac'=>'fs@gmail.com',
            'tbl_universite_id'=>'1',
        ]);
    }
}
