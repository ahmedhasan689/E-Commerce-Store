<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ratings()
    {
        return $this->morphMany(
            Rating::class, // Related
            'rateable', // Name Of Column That Have a Morph Relation
            'rateable_type', // Morph type
            'rateable_id', // Morph ID
            'id'
        );
    }


}
