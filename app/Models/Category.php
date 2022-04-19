<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'status',
    ];

    // Accessors [Exists Attribute, Non-Exists Attribute]

        //Exists Attribute get{Attribute-name}Attribute
    // public function getNameAttribute($value)
    // {
    //     if ($this->trashed()) {
    //         return $value . '(Deleted)';
    //     }
    //     return $value;
    // }

        // Non-Exists Attribute
    public function getOriginalNameAttribute()
    {
        return $this->attributes['name'];
    }

    // Relations
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault([
            'name' => 'Not Found',
        ]);
    }

    /**
     * Hidden This Columns In APIs Response
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'original_name'
    ];

    // Event For Slug
    protected static function booted()
    {
        static::creating(function (Category $category) {
            $category->slug = Str::slug($category->name);
        });
    }

    // public function toJson($options = 0)
    // {
    //     return json_encode([
    //         'id' => $this->id,
    //         'title' => $this->name,
    //     ]);
    // }

}
