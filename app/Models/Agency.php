<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $guarded = 'id';

    public function talent()
    {
        return $this->hasMany(Talent::class, 'agency_id', 'id');
    }

    public function numOfTalent()
    {
        return $this->talent()->count();
    }
}
