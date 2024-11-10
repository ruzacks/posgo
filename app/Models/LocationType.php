<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function location()
    {
        return $this->hasMany(Location::class, 'location_type_id', 'id');
    }

    public function getTotalLocation($status = null)
    {   
        if($status == null){
            return $this->location()->count();
        } else {
            return $this->location()->where('status',$status)->count();
        }
    }
}
