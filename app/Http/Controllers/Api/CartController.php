<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data cart setiap user
        $carts = Cart::query()
            ->with('product')
            ->where('user_id', request()->query('user_id'))
            ->get();

        // Cek apakah ada datanya atau tidak
        if ($carts->isNotEmpty()) {
            return response()->json([
                'message' => 'Data keranjang ditemukan',
                'data' => $carts
            ]);
        } else {
            return response()->json([
                'message' => 'Data keranjang tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $cart = Cart::query()->create($request->all());

        if ($cart) {
            return response()->json([
                'message' => 'Data keranjan berhasil ditambahkan',
                'data' => $cart
            ]);
        } else {
            return response()->json([
                'message' => 'Data keranjang gagal ditambahkan'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, string $id)
    {
        $cart = Cart::query()->find($id);

        if (!$cart) {
            return response()->json([
                'message' => 'Data keranjang tidak ditemukan'
            ], 404);
        }

        $cart->update($request->all());

        return response()->json([
            'message' => 'Data keranjang berhasil diperbaharui',
            'data' => $cart
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::query()->find($id);

        if (!$cart) {
            return response()->json([
                'message' => 'Data keranjang tidak ditemukan'
            ], 404);
        }

        $cart->delete();

        return response()->json([
            'message' => 'Data keranjang berhasil dihapus'
        ]);
    }

    public function getCount(string $id)
    {
        $cart = Cart::query()
            ->where('user_id', $id)
            ->count();

        return response()->json([
            'message' => 'Data keranjang ditemukan',
            'data' => $cart
        ]);
    }
}
