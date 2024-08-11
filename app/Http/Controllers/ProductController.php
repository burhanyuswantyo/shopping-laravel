<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Mendapatkan data semua produk dan relasi dengan kategori
        $products = Product::query()
            ->with('category')
            // Menampilkan data yang quantitynya kurang dari 10
            // ->where('quantity', '<', 10)
            // Mengurutkan data dari quantity terbanyak
            ->orderBy('quantity', 'desc')
            // Mengambil data price, quantity, dan category_id
            ->get(['price', 'quantity', 'category_id']);
        // Mengambil hanya data quantity
        // ->pluck('quantity');

        return $products;

        foreach ($products as $product) {
            echo $product->price . '<br>';
        }

        // return view('welcome');
    }
}
