<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class SalePayment extends Model
{
    use HasFactory;

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');   
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

}
