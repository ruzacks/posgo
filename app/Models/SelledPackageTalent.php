<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelledPackageTalent extends Model
{
    use HasFactory;

    public function talent()
    {
        return $this->belongsTo(Talent::class, 'talent_id', 'id');
    }
}
