<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_code',
        'branch_name',
        'nomor_identitas',
        'nama_peserta',
        'no_telpon',
        'alamat',
        'kode_pos',
        'jns_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'usia',
    ];
}
