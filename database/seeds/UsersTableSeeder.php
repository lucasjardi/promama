<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@promama.com',
            'password' => 'adminpromama',
            'api_token' => env('API_SECRET','secret'),
            'senha_reserva' => ''
        ]);
    }
}
