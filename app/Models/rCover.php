<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rCover extends Model
{
    use HasFactory;

    protected $fillable = [
        'transcation_id',
        'rate_code',
        'rate',
        'premium',
        'scaling',
        'description',
        'sdate',
        'edate'
    ];
}
