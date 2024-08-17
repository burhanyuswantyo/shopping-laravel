<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Melakukan pemanggilan model Product untuk melakukan query data produk
        $products = Product::query()
            // Mengambil data relasi category
            ->with('category')
            // Mengambil data produk
            // Filter data produk berdasarkan query parameter name
            ->when(request()->query('name'), function ($query) {
                return $query->where('name', 'like', '%' . request()->query('name') . '%');
            })
            // Filter data produk berdasarkan query parameter category_id
            ->when(request()->query('category_id'), function ($query) {
                return $query->where('category_id', request()->query('category_id'));
            })
            // Gunakan take / limit jika query parameter limit bernilai true
            ->when(request()->query('limit'), function ($query) {
                return $query->take(request()->query('limit'));
            })
            // Ambil data terbaru
            ->latest()
            // Gunakan paginate jika query parameter paginate bernilai true
            ->when(request()->query('paginate'), function ($query) {
                return $query->paginate(request()->query('paginate'));
            }, function ($query) {
                return $query->get();
            });

        if ($products->isEmpty()) {
            // Kirim response data produk dengan status code 404
            return response()->json([
                'message' => 'Data produk tidak ditemukan'
            ], 404);
        }

        // Kirim response data produk dengan status code 200
        return response()->json([
            'message' => 'Data produk berhasil ditemukan',
            'data' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // Ambil file image dari request
        $image = $request->file('image');

        // Memasukkan semua request ke dalam variabel $insertData
        $insertData = $request->all();
        // Store file ke folder storage/products dan simpan filenya ke dalam variabel $insertData
        $insertData['image'] = $image->store('products', 'public');

        $product = Product::query()
            ->create($insertData);

        // Merubah image menjadi full URL (Sudah dilakukan mutator di model Product)
        // $product->image = asset('storage/' . $product->image);

        return response()->json([
            'message' => 'Data produk berhasil disimpan',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Cari data produk berdasarkan id
        $product = Product::query()
            ->with('category')
            ->find($id);

        // Jika data produk tidak ditemukan
        if (!$product) {
            // Kirim response dengan status code 404
            return response()->json([
                'message' => 'Data produk tidak ditemukan'
            ], 404);
        }

        // Kirim response dengan status code 200
        return response()->json([
            'message' => 'Data produk berhasil ditemukan',
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        // Cari data produk berdasarkan id
        $product = Product::query()
            ->find($id);

        // Jika data produk tidak ditemukan
        if (!$product) {
            // Kirim response dengan status code 404
            return response()->json([
                'message' => 'Data produk tidak ditemukan'
            ], 404);
        }

        // Memasukkan semua request ke dalam variabel $updateData
        $updateData = $request->all();

        // Jika request memiliki file image
        if ($request->hasFile('image')) {
            // Ambil file image dari request
            $image = $request->file('image');
            // Store file ke folder storage/products dan simpan filenya ke dalam variabel $updateData
            $updateData['image'] = $image->store('products', 'public');
        }

        // Update data produk
        $product->update($updateData);

        // Kirim response dengan status code 200
        return response()->json([
            'message' => 'Data produk berhasil diupdate',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data produk berdasarkan id
        $product = Product::query()
            ->find($id);

        // Jika data produk tidak ditemukan
        if (!$product) {
            // Kirim response dengan status code 404
            return response()->json([
                'message' => 'Data produk tidak ditemukan'
            ], 404);
        }

        // Hapus data produk
        $product->delete();

        // Kirim response dengan status code 200
        return response()->json([
            'message' => 'Data produk berhasil dihapus'
        ]);
    }

    public function getBestSellerProducts()
    {
        // Get 5 products with the highest quantity of order items
        $products = Product::query()
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(request()->query('limit', 5))
            ->get();

        return response()->json([
            'message' => 'Data produk terlaris berhasil ditemukan',
            'data' => $products
        ]);
    }
}
