<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk',
        'customer_id',
        'no_pk',
        'no_polis',
        'jenis_kredit',
        'jenis_cover',
        'periode_awal_asuransi',
        'periode_akhir_asuransi',
        'periode_asuransi',
        'tanggal_kredit',
        'plafon_kredit',
        'bayar_premi',
        'tgl_bayar_premi',
        'no_bukti_bayar',
        'acceptance'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    // public function perluasan()
    // {
    //     return $this->belongsTo(rCover::class, 'id', 'transcation_id');
    // }
    public function perluasan()
    {
        return $this->hasMany(rCover::class, 'transcation_id', 'id');
    }
}
