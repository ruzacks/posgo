<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelledItems extends Model
{
    protected $fillable = [
        'sell_id',
        'product_id',
        'price',
        'quantity',
        'tax_id',
        'tax',
    ];

    
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sell_id', 'id');
    }

    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
    
    public function selledPackageItem()
    {
        return $this->hasMany(SelledPackageItem::class, 'selled_item_id', 'id');
    }

    public function selledPackageTalent()
    {
        return $this->hasMany(SelledPackageTalent::class, 'selled_item_id', 'id');
    }
}
