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
            'name' => 'Americano',
            'price' => 18000,
            'category' => 'coffee',
            'description' => 'Espresso dengan tambahan air.',
            'image' => 'img/coffee1.jpeg' 
        ]);

        Menu::create([
            'name' => 'Caramel Macchiato',
            'price' => 25000,
            'category' => 'coffee',
            'description' => 'Kopi susu dengan tambahan saus caramel dan macchiato.',
            'image' => 'img/coffee2.jpeg'
        ]);

        Menu::create([
            'name' => 'Kopi Susu',
            'price' => 20000,
            'category' => 'coffee',
            'description' => 'Espresso dengan susu foam tebal yang lembut.',
            'image' => 'img/coffee3.jpeg'
        ]);

        Menu::create([
            'name' => 'Mocchachino',
            'price' => 23000,
            'category' => 'coffee',
            'description' => 'Perpaduan espresso, coklat, dan susu yang creamy.',
            'image' => 'img/coffee4.jpeg'
        ]);

        Menu::create([
            'name' => 'Kopi Susu Gula Aren',
            'price' => 28000,
            'category' => 'coffee',
            'description' => 'Perpaduan espresso, gula aren, dan susu yang creamy.',
            'image' => 'img/coffee5.jpeg'
        ]);


        // ================================
        // 2. KATEGORI NON-COFFEE 
        // (File: non1.jpeg s/d non5.jpeg)
        // ================================

        Menu::create([
            'name' => 'Red Velvet Milky',
            'price' => 22000,
            'category' => 'non-coffee',
            'description' => 'Bubuk red velvet premium dengan susu yang creamy.',
            'image' => 'img/non1.jpeg'
        ]);

        Menu::create([
            'name' => 'Choco Avocado',
            'price' => 25000,
            'category' => 'non-coffee',
            'description' => 'Sirup avocado ditambah coklat premium dan susu yang creamy.',
            'image' => 'img/non2.jpeg' 
        ]);

        Menu::create([
            'name' => 'Matcha Cheezy',
            'price' => 28000,
            'category' => 'non-coffee',
            'description' => 'Perpaduan matcha bubuk premium dengan keju yang gurih dan susu yang creamy.',
            'image' => 'img/non3.jpeg'
        ]);

        Menu::create([
            'name' => 'Strawberry Cheezy Milk',
            'price' => 30000,
            'category' => 'non-coffee',
            'description' => 'Perpaduan antara sirup dan selai strawberry, ditambah keju yang gurih, dan susu yang creamy.',
            'image' => 'img/non4.jpeg'
        ]);

        Menu::create([
            'name' => 'Matcha Latte',
            'price' => 20000,
            'category' => 'non-coffee',
            'description' => 'Perpaduan antara matcha premium dan susu creamy.',
            'image' => 'img/non5.jpeg'
        ]);
    }
}