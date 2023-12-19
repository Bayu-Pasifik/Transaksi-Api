<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Proses;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json([
            "message" => "menampilan semua data",
            "data" => $transactions]);
    }

    public function store(Request $request, $id_proses)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'required|string',
            'nama_barang' => 'required|string',
            'harga_barang' => 'required|integer',
            'jumlah_barang' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(["message" => "Validasi Gagal", "errors" => $validator->errors()], 422);
        }

        try {
            $proses = Proses::findOrFail($id_proses);
            $total_harga = $request->harga_barang * $request->jumlah_barang;
            $transaction = Transaction::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'id_proses' => $id_proses,
                'nama_barang' => $request->nama_barang,
                'harga_barang' => $request->harga_barang,
                'jumlah_barang' => $request->jumlah_barang,
                'total_harga' => $total_harga,
            ]);

            $proses->total_bayar = $total_harga + $proses->total_bayar;
            $proses->save();

            return response()->json([
                "message" => "berhasil menambahkan data",
                "data" => $transaction]);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            return response()->json($transaction);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'required|string',
            'nama_barang' => 'required|string',
            'harga_barang' => 'required|integer',
            'jumlah_barang' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(["message" => "Validasi Gagal", "errors" => $validator->errors()], 422);
        }

        try {

            $transaction = Transaction::findOrFail($id);
            $proses = Proses::findOrFail($transaction->id_proses);
            $total_harga = $request->harga_barang * $request->jumlah_barang;
            $data = [
                'nama_pelanggan' => $request->nama_pelanggan,
                'nama_barang' => $request->nama_barang,
                'harga_barang' => $request->harga_barang,
                'jumlah_barang' => $request->jumlah_barang,
                'total_harga' => $total_harga
            ];

            $proses->total_bayar = $proses->total_bayar - $transaction->total_harga;
            $proses->total_bayar = $total_harga + $proses->total_bayar;
            $proses->save();
            $transaction->update($data);
            return response()->json([
                "message" => "berhasil update data",
                "data" => $transaction]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }
    }

    public function destroy($id)
    {
        // $transactions = Transaction::all();
        try {
            $transaction = Transaction::findOrFail($id);
            $proses = Proses::findOrFail($transaction->id_proses);
            $proses->total_bayar = $proses->total_bayar - $transaction->total_harga;
            $proses->save();
            $transaction->delete();

            return response()->json([
                'message' => "data dibawah ini berhasil dihapus",
                'data' => $transaction]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

    }
}
