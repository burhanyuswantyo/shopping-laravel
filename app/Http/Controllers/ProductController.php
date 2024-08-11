<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Mendapatkan data semua produk dan relasi dengan kategori
        // $products = Product::query()
        //     ->with('category')
        //     // Menampilkan data yang quantitynya kurang dari 10
        //     // ->where('quantity', '<', 10)
        //     // Mengurutkan data dari quantity terbanyak
        //     ->orderBy('quantity', 'desc')
        //     // Mengambil data price, quantity, dan category_id
        //     ->get(['price', 'quantity', 'category_id']);
        // Mengambil hanya data quantity
        // ->pluck('quantity');

        // return $products;

        // foreach ($products as $product) {
        //     echo $product->price . '<br>';
        // }

        $products = Product::query()
            ->with('category')
            ->paginate(5);

        // Cara pertama untuk mengirim data ke view
        // return view('products.index', [
        //     'products' => $products
        // ]);

        // Cara kedua untuk mengirim data ke view
        return view('products.index', compact('products'));
    }
}
