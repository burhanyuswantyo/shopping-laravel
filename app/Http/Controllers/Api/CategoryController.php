<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil semua data kategori
        $categories = Category::query()
            ->when(request()->query('limit'), function ($query, $limit) {
                $query->take($limit);
            })->get();

        // Cek apakah data kategori kosong atau tidak
        if ($categories->isEmpty()) {
            // Jika data kosong
            return response()->json([
                'message' => 'Data kategori tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data kategori berhasil ditemukan',
            'data' => $categories
        ]);
    }

    public function show(string $id)
    {
        // Ambil data kategori berdasarkan ID
        $category = Category::query()
            ->with('products')
            ->find($id);

        // Jika data kategori ditemukan
        if ($category) {
            return response()->json([
                'message' => 'Data kategori berhasil ditemukan',
                'data' => $category
            ]);
        }
        // Jika data kategori tidak ditemukan
        else {
            return response()->json([
                'message' => 'Data kategori tidak ditemukan'
            ], 404);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        // Cek apakah data yang dikirim dari postman sudah sesuai
        // return response()->json($request->all());

        // Insert data request ke dalam tabel categories
        $category = Category::query()->create($request->all());

        // Cek apakah data berhasil diamasukkan atau tidak
        if ($category) {
            return response()->json([
                'message' => 'Data kategori berhasil disimpan',
                'data' => $category
            ]);
        } else {
            return response()->json([
                'message' => 'Data gagal disimpan'
            ], 501);
        }
    }

    public function update(StoreCategoryRequest $request, string $id)
    {
        // Ambil data kategori berdasarkan ID
        $category = Category::query()->find($id);

        // Jika kategori kosong
        if (!$category) {
            return response()->json([
                'message' => 'Data kategori tidak ditemukan'
            ], 404);
        }

        // Query update data kategori
        $category->update($request->all());

        return response()->json([
            'message' => 'Data kategori berhasil diperbaharui',
            'data' => $category
        ]);
    }

    public function destroy(string $id)
    {
        // Ambil data kategori berdasarkan ID
        $category = Category::query()->find($id);

        // Jika kategori kosong
        if (!$category) {
            return response()->json([
                'message' => 'Data kategori tidak ditemukan'
            ], 404);
        }

        // Jika kategori berelasi dengan data yang ada di product
        if ($category->has('products')) {
            return response()->json([
                'message' => 'Data kategori gagal dihapus'
            ], 422);
        }

        // Hapus kategori
        $category->delete();

        return response()->json([
            'message' => 'Data kategori berhasil dihapus'
        ]);
    }
}
