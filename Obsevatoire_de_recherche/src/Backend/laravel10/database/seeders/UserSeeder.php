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
            'password'=> bcrypt('12345678'),
            'tbl_filiere_id'=>'1',
            //'role'=>'admin'
        ]);

        User::create([
            'nom_user'=>'Dongmo Russel',
            "email"=>'russeldongmo96@gmail.com',
            'password'=> bcrypt('12345678'),
            'tbl_filiere_id'=>'1',
            'role'=>'admin'
        ]);

        User::create([
            'nom_user'=>'jean jack',
            "email"=>'jean@gmail.com',
            'password'=> bcrypt('20056663'),
            'tbl_filiere_id'=>'1',
        ]);

        User::create([
            'nom_user'=>'Fosso Cabrel',
            "email"=>'fossocabrel08@gmail.com',
            'password'=> bcrypt('12345678'),
            'tbl_filiere_id'=>'1',
        ]);

        User::create([
            'nom_user'=>'Gildas Landry',
            "email"=>'gildas@gmail.com',
            'password'=> bcrypt('1234'),
            'role'=>'admin',
            'tbl_filiere_id'=>'1',
        ]);

        User::create([
            'nom_user'=>' Michele Serena',
            "email"=>'michelle@gmail.com',
            'password'=> bcrypt('12345678'),
            'tbl_filiere_id'=>'1',
        ]);
    }
}
