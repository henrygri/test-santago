<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'Coaching', 
            'Consulenza di Direzione',
            'Consulenza Accordo Quadro',
            'Percorso di Consulenza e di Carriera',
            'Formazione Manageriale',
            'Finanziamenti per la Formazione',
            'Outplacement',
            'Politiche Attive del Lavoro',
            'Ricerca e Selezione del Personale ed Head Hunting'
        ];

        foreach($services as $service) {
            Service::create([
                'name' => $service,
            ]);
        }
    }
}
