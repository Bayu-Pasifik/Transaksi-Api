<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = ['nama_pelanggan', 'id_proses','nama_barang','harga_barang','jumlah_barang','total_harga'];
    protected $primaryKey= 'id_transaksi';
    public $incrementing = true;
    public $timestamps = true;
}
