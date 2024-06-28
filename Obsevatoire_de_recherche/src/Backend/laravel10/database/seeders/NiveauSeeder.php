<?php

namespace Database\Seeders;

use App\Models\TblNiveau;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TblNiveau::create([
            'code_niv'=> 'Inf 1',
        ]);
    }
}
