<?php

namespace Database\Seeders;

use App\Models\becas_nivel;
use Illuminate\Database\Seeder;

class Becas_nivelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $becas_nivel = becas_nivel::select('SELECT id FROM becas_nivel WHERE tipo = "C" ');
        dd($becas_nivel);

    }
}
