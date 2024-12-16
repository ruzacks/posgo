<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function locationType()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id', 'id');
    }

    public function latestSale()
    {
        return $this->hasOne(Sale::class, 'location_id', 'id')->latest();
    }

    public function getLatestSaleTotal()
    {
        $total = $this->latestSale()->pluck('total')->first();
        return $total;
    }

    public function getLatestSaleCheckIn()
    {
        $sale = $this->latestSale()->first(); // Resolves the query builder into a model instance
        return $sale ? $sale->formatted_check_in : null; // Access formatted_check_in if $sale exists
    }

    public function getLatestSaleCheckOut()
    {
        $sale = $this->latestSale()->first(); // Resolves the query builder into a model instance
        return $sale ? $sale->formatted_check_out : null; // Access formatted_check_in if $sale exists
    }

}
