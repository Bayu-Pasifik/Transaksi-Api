<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Proses;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;


class ProsesController extends Controller
{
    public function index()
    {
        $proses = Proses::join('users', 'users.id', '=', 'proses.uid')
            ->get(['users.name', 'proses.*']);
        return response()->json([
            "message" => "menampilkan semua data",
            "data" => $proses]);
    }

    public function store(Request $request)
    {
        try {
            $uid = $request->user()->id;
            $proses = Proses::create([
                "uid" => $uid,
                "status" => 0,
                "total_bayar" => 0
            ]);

            return response()->json([
                "message" => "berhasil menambahkan data",
                "data" => $proses]);
        } catch (\Throwable $th) {
            return response()->json(["message" => $th->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $proses = Proses::join('users', 'users.id', '=', 'proses.uid')
                ->where('proses.id_proses', $id)
                ->get(['users.name', 'proses.*'])->first();
            $transaksi = Transaction::where('id_proses', $id)->get();
            return response()->json(['proses' => $proses, 'transaksi' => $transaksi]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Proses tidak ditemukan'], 404);
        }
    }


    public function destroy($id)
    {
        // $proses = Proses::all();
        try {
            $proses = Proses::findOrFail($id);
            $proses->delete();

            $transaksi = Transaction::where('id_proses', $id)->delete();

            return response()->json([
                'message' => "data dibawah ini berhasil dihapus",
                'data' => $proses]);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Proses tidak ditemukan'], 404);
        }

    }
}
