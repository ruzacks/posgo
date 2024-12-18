<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelledPackageItem extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function selledItem()
    {
        return $this->belongsTo(selledItems::class, 'selled_item_id', 'id');
    }
}
