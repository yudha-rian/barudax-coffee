<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu; // Pastikan baris ini ada di paling atas

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Menu Coffee
    Menu::create([
        'name' => 'Kopi Susu Gula Aren',
        'price' => 18000,
        'category' => 'coffee',
        'description' => 'Espresso dengan susu segar dan gula aren asli.',
        'image' => 'https://placehold.co/400x300?text=Kopi+Susu' // Gambar contoh
    ]);

    Menu::create([
        'name' => 'Americano',
        'price' => 15000,
        'category' => 'coffee',
        'description' => 'Espresso shot dengan air panas.',
        'image' => 'https://placehold.co/400x300?text=Americano'
    ]);

    // Menu Non-Coffee
    Menu::create([
        'name' => 'Matcha Latte',
        'price' => 22000,
        'category' => 'non-coffee',
        'description' => 'Bubuk matcha jepang premium dengan susu.',
        'image' => 'https://placehold.co/400x300?text=Matcha'
    ]);

    Menu::create([
        'name' => 'Chocolate Ice',
        'price' => 20000,
        'category' => 'non-coffee',
        'description' => 'Coklat belgia yang creamy.',
        'image' => 'https://placehold.co/400x300?text=Coklat'
    ]);
}
}
