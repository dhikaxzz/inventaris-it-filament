<?php

use Illuminate\Support\Facades\Route;
use App\Models\Barang;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/barang/search', function (Request $request) {
    $kodeBarang = $request->query('q');

    $barang = Barang::where('kode_barang', $kodeBarang)->first();

    if ($barang) {
        return response()->json([
            'success' => true,
            'barang' => $barang
        ]);
    }

    return response()->json(['success' => false]);
});