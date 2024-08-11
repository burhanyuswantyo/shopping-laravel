<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'Ini halaman index category';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'Ini halaman form create category';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->post('name');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return 'Ini halaman show category dengan id ' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
