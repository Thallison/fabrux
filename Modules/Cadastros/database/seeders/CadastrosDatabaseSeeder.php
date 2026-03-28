<?php

namespace Modules\Cadastros\Database\Seeders;

use Illuminate\Database\Seeder;

class CadastrosDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CreateFuncionalidadeMenuSeeder::class,
        ]);
    }
}
