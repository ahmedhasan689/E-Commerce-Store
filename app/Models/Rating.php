<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'rateable_type',
        'rateable_id',
        'rateable',
    ];



    public function rateable()
    {
        return $this->morphTo( // All params Can Be Null 
            'rateable', 
            'rateable_type',
            'rateable_id',
            'id'
        );
    }









}
