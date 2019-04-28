<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SincronizacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sincronizacao')->insert([
            'informacao' => 0,
            'notificacao' => 0,
            'bairro' => 0,
            'posto' => 0,
            'duvidas_frequentes' => 0
        ]);
    }
}
