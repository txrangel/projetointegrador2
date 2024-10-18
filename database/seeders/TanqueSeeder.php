<?php 

namespace Database\Seeders;

use App\Models\DadoConsumo;
use App\Models\Tanque;
use Illuminate\Database\Seeder;

class TanqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cria 3 tanques
        $tanques = Tanque::factory()->count(3)->create();

        // Para cada tanque, cria dados de consumo para cada dia de setembro de 2024
        foreach ($tanques as $tanque) {
            for ($day = 1; $day <= 30; $day++) {
                // Gera uma data e hora aleatórias
                $dataHora = "2024-09-" . str_pad($day, 2, '0', STR_PAD_LEFT) . ' ' . rand(0, 23) . ':' . rand(0, 59) . ':00';
                
                // Cria um dado de consumo para o tanque
                DadoConsumo::factory()->create([
                    'data_hora' => $dataHora,
                    'nivel' => rand(0, 1000), // Nível aleatório entre 0 e 1000
                    'tanque_id' => $tanque->id,
                ]);
            }
        }
    }
}
