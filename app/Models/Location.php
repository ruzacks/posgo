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
}
