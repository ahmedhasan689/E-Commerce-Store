<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'status', 
    ];

    // Accessors [Exists Attribute, Non-Exists Attribute]

        //Exists Attribute get{Attribute-name}Attribute
    public function getNameAttribute($value)
    {   
        if ($this->trashed()) {
            return $value . '(Deleted)';
        }
        return $value;
    }

        //Non-Exists Attribute
    public function getOriginalNameAttribute()
    {
        return $this->attributes['name'];
    }

    // Relations 
    public function products() 
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function childern()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault([
            'name' => 'Not Found',
        ]);
    }

    
}
