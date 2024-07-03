<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nom_user'=>'Dongmo Russel',
            "email"=>'russeldongmo05@gmail.com',
            'tel_user'=>'675 87 66 84',
            'password'=> bcrypt('12345678'),
            'tbl_filiere_id'=>'1',
        ]);

        User::create([
            'nom_user'=>'jean jack',
            "email"=>'jean@gmail.com',
            'tel_user'=>'659 87 66 84',
            'password'=> bcrypt('20056663'),
            'tbl_filiere_id'=>'1',
        ]);

        User::create([
            'nom_user'=>'Fosso Cabrel',
            "email"=>'fossocabrel08@gmail.com',
            'tel_user'=>'675 88 66 84',
            'password'=> bcrypt('12345678'),
            'tbl_filiere_id'=>'1',
        ]);

        User::create([
            'nom_user'=>'Gildas Landry',
            "email"=>'gildas@gmail.com',
            'tel_user'=>'655 87 66 84',
            'password'=> bcrypt('20056663'),
            'tbl_filiere_id'=>'1',
        ]);

        User::create([
            'nom_user'=>' Michele Serena',
            "email"=>'michelle@gmail.com',
            'tel_user'=>'673 87 66 84',
            'password'=> bcrypt('12345678'),
            'tbl_filiere_id'=>'1',
        ]);
    }
}
