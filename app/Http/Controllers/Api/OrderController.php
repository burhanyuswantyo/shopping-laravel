<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::query()
            ->with('orderItems.product')
            ->where('user_id', request()->query('user_id'))
            ->get();

        if ($orders->isNotEmpty()) {
            return response()->json([
                'message' => 'Data order berhasil ditemukan',
                'data' => $orders
            ]);
        } else {
            return response()->json([
                'message' => 'Data order tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = DB::transaction(function () use ($request) {
            $carts = Cart::query()
                ->with('product', fn($query) => $query->select('id', 'price'))
                ->where('user_id', $request->user_id)
                ->select('id', 'product_id', 'quantity',)
                ->get();

            $order = Order::query()->create($request->all());
            $cartItems = $carts->map(function ($cart) {
                return [
                    'product_id' => $cart['product_id'],
                    'quantity' => $cart['quantity'],
                    'price' => $cart['product']['price']
                ];
            })->toArray();
            $order->orderItems()->createMany($cartItems);

            $carts->each->delete();

            return $order;
        });

        if ($order) {
            return response()->json([
                'message' => 'Data order berhasil ditambahkan',
                'data' => $order
            ]);
        } else {
            return response()->json([
                'message' => 'Data order gagal ditambahkan'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::query()->find($id);

        if ($order) {
            return response()->json([
                'message' => 'Data order berhasil ditemukan',
                'data' => $order
            ]);
        } else {
            return response()->json([
                'message' => 'Data order tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::query()->find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Data order tidak ditemukan'
            ], 404);
        }

        $order->update($request->all());

        return response()->json([
            'message' => 'Data order berhasil diperbaharui',
            'data' => $order
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
