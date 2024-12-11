<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function grade()
    {
        return $this->hasOne(TalentGrade::class, 'id', 'grade_id');
    }
    
    public function talentGrade()
    {
        return $this->grade()->first()->name ?? null;;
    }

    public function agency()
    {
        return $this->hasOne(Agency::class, 'id', 'agency_id');
    }

    public function talentAgency()
    {
        return $this->agency()->first()->name ?? null;;
    }

    public function talentGradeDetail()
    {
        return $this->hasOne(TalentGrade::class, 'id', 'grade_id');
    }


}
