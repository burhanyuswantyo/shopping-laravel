<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = DB::transaction(function () use ($request) {
            $payment = Payment::query()->create($request->all());
            $payment->order()->update(['status' => 'completed', 'payment_status' => 'paid']);

            return $payment;
        });

        if ($payment) {
            return response()->json([
                'message' => 'Data payment berhasil ditambahkan',
                'data' => $payment
            ]);
        } else {
            return response()->json([
                'message' => 'Data payment gagal ditambahkan'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::query()->find($id);

        if ($payment) {
            return response()->json([
                'message' => 'Data payment berhasil ditemukan',
                'data' => $payment
            ]);
        } else {
            return response()->json([
                'message' => 'Data payment tidak ditemukan',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePaymentRequest $request, string $id)
    {
        $payment = Payment::query()->find($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Data payment tidak ditemukan'
            ], 404);
        }

        $payment->update($request->all());

        if ($payment) {
            return response()->json([
                'message' => 'Data payment berhasil diperbaharui',
                'data' => $payment
            ]);
        } else {
            return response()->json([
                'message' => 'Data payment gagal diperbaharui'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
