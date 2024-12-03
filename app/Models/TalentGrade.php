<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentGrade extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Add a computed property for the total price
    protected $appends = ['price'];

    public function getPriceAttribute()
    {
        return $this->talent_price + $this->agency_price + $this->office_price;
    }

    public function talent()
    {
        return $this->hasMany(Talent::class, 'grade_id', 'id');
    }
}
