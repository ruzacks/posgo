<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasedItems extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'price',
        'quantity',
        'tax_id',
        'tax',
    ];

    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function purchase()
{
    return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
}

}
