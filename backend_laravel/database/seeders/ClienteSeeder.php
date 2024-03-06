<?php

namespace Database\Seeders;
use Database\Factories\ClienteFactory;
use App\Models\Cliente;

use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::factory()->count(20)->create();
    }
}
