<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'prenom'       => 'N\'da Josue',
            'nom'          => 'AHOUTOU',
            'email'        => 'ahoutoundajosue45@gmail.com',
            'password'     => bcrypt('A0545397593@'),
            'ville'        => 'Abidjan',
            'pays'         => 'Côte d\'Ivoire',
            'telephone'    => '+225 07 00 00 00',
            'poste_actuel' => 'Développeur Full-Stack',
            'biographie'   => 'Passionné par le code depuis mes études, je mets mon expertise au service de vos projets.',
            'disponible'   => true,
            'role'         => 'admin',
        ]);
    }
}