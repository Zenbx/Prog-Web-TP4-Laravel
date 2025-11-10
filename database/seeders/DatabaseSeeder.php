<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Seeder principal qui orchestre tous les seeders de l'application.
 * Ce fichier est le point d'entrée pour peupler la base de données.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Exécute tous les seeders de l'application.
     * Lance le ProductSeeder pour peupler la table products.
     */
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
        ]);
    }
}
