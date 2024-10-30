<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'fixed_products' => 'object',     // Cast as an array or object
        'optional_products' => 'object',  // Cast as an array or object
        'optional_talents' => 'object',   // Cast as an array or object
    ];

    

}
