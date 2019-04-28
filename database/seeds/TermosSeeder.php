<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TermosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('termos')->insert([
            'titulo' => 'Termos de Uso',
            'texto' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque dolorum, eveniet, est, necessitatibus nulla dolore perferendis alias doloribus in maiores laborum placeat architecto quae tempore. Qui aliquid mollitia nostrum id!'
        ]);
    }
}
