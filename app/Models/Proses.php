<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{
    use HasFactory;
    protected $table = 'proses';
    protected $fillable = ['uid', 'status', 'total_bayar'];
    protected $primaryKey= 'id_proses';
    public $incrementing = true;
    public $timestamps = true;

}
