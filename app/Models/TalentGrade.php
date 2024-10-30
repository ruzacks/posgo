<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalentGrade extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function talent()
    {
        return $this->hasMany(Talent::class, 'grade_id', 'id');
    }
}
