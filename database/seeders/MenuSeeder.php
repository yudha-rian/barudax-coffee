<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // ============================
        // 1. KATEGORI COFFEE 
        // (File: coffee1.jpeg s/d coffee5.jpeg)
        // ============================
        
        Menu::create([
            'name' => 'Kopi Susu Gula Aren',
            'price' => 18000,
            'category' => 'coffee',
            'description' => 'Espresso dengan susu segar dan gula aren asli.',
            'image' => 'img/coffee1.jpeg' 
        ]);

        Menu::create([
            'name' => 'Americano',
            'price' => 15000,
            'category' => 'coffee',
            'description' => 'Espresso shot dengan air panas.',
            'image' => 'img/coffee2.jpeg'
        ]);

        Menu::create([
            'name' => 'Cappuccino',
            'price' => 20000,
            'category' => 'coffee',
            'description' => 'Espresso dengan susu foam tebal yang lembut.',
            'image' => 'img/coffee3.jpeg'
        ]);

        Menu::create([
            'name' => 'Caramel Macchiato',
            'price' => 23000,
            'category' => 'coffee',
            'description' => 'Perpaduan espresso, vanilla syrup, dan saus karamel.',
            'image' => 'img/coffee4.jpeg'
        ]);

        Menu::create([
            'name' => 'Moccachino',
            'price' => 21000,
            'category' => 'coffee',
            'description' => 'Kopi susu dengan sentuhan rasa cokelat manis.',
            'image' => 'img/coffee5.jpeg'
        ]);


        // ================================
        // 2. KATEGORI NON-COFFEE 
        // (File: non1.jpeg s/d non5.jpeg)
        // ================================

        Menu::create([
            'name' => 'Matcha Latte',
            'price' => 22000,
            'category' => 'non-coffee',
            'description' => 'Bubuk matcha jepang premium dengan susu.',
            'image' => 'img/non1.jpeg'
        ]);

        Menu::create([
            'name' => 'Chocolate Ice',
            'price' => 20000,
            'category' => 'non-coffee',
            'description' => 'Coklat belgia yang creamy.',
            'image' => 'img/non2.jpeg' 
        ]);

        Menu::create([
            'name' => 'Red Velvet Latte',
            'price' => 21000,
            'category' => 'non-coffee',
            'description' => 'Minuman manis dengan rasa red velvet cake yang unik.',
            'image' => 'img/non3.jpeg'
        ]);

        Menu::create([
            'name' => 'Lemon Tea',
            'price' => 12000,
            'category' => 'non-coffee',
            'description' => 'Teh segar dengan perasan lemon asli.',
            'image' => 'img/non4.jpeg'
        ]);

        Menu::create([
            'name' => 'Lychee Yakult',
            'price' => 18000,
            'category' => 'non-coffee',
            'description' => 'Kesegaran yakult dipadu dengan sirup leci dan buah asli.',
            'image' => 'img/non5.jpeg'
        ]);
    }
}