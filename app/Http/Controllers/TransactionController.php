<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json([
            "message" => "menampilan semua data",
            "data" => $transactions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string',
            'nama_barang' => 'required|string',
            'harga_barang' => 'required|integer',
            'jumlah_barang' => 'required|integer',
            'total_harga' => 'required|integer',
        ]);

        $transaction = Transaction::create($request->all());

        return response()->json([
            "message" => "berhasil menambahkan data",
            "data" => $transaction]);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string',
            'nama_barang' => 'required|string',
            'harga_barang' => 'required|integer',
            'jumlah_barang' => 'required|integer',
            'total_harga' => 'required|integer',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());

        return response()->json([
            "message" => "berhasil update data",
            "data" => $transaction]);
    }

    public function destroy($id)
    {
        // $transactions = Transaction::all();
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json([
            'message' => "data dibawah ini berhasil dihapus",
           'data' => $transaction]);
    }
}
