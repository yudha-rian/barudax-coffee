<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data kopi
        $coffees = Menu::where('category', 'coffee')->get();
        // Ambil data non-kopi
        $nonCoffees = Menu::where('category', 'non-coffee')->get();

        // Kirim data ke tampilan (view) 'welcome'
        return view('welcome', compact('coffees', 'nonCoffees'));
    }
}