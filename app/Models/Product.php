<?php

namespace App\Models;

use App\Scopes\ActiveStatusScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_ACTIVE = 'active';
    const STATUS_DRAFT = 'draft';

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'image_path',
        'price',
        'sale_price',
        'quantity',
        'sku',
        'width',
        'height',
        'weight',
        'length',
        'status',
    ];

    protected static function booted() 
    {
        // static::addGlobalScope(new ActiveStatusScope());

        // static::addGlobalScope('owner', function (Builder $builder) {
        //     $user = Auth::user();
        //     if ($user && $user->type == 'store') {
        //         $builder->where('products.user_id', '=', $user->id);
        //     }
        // });
    }


    
    public static function validateRules()
    {
        return [
            'name' => 'required|max:255',
            'categroy_id' => 'nullable|integer|exists:categories,id',
            'description' => 'nullable',
            'image_path' => 'nullable|image|dimensions:min_width=300,min_height:300',
            'price' => 'numeric|min:0|required',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'sku' => 'nulable|unique:products,sku',
            'width' => 'numeric|min:0|nullable',
            'height' => 'numeric|min:0|nullable',
            'weight' => 'numeric|min:0|nullable',
            'length' => 'numeric|min:0|nullable',
            'status' => 'in:' . self::STATUS_ACTIVE . ',' . self::STATUS_DRAFT,
        ];

    }

    // Accessors For Image_Path
    public function getImageAttribute()
    {
        if (!$this->image_path){
            return asset('assets/images/place.png');
        }

        if (stripos($this->image_path, 'http') === 0) {
            return $this->image_path;
        }

        return asset('uploads/' . $this->image_path);
    }  

    // Mutators
    public function setNameAttribute($value) 
    {
        $this->attributes['slug'] = Str::slug($value);
        $this->attributes['name'] = Str::title($value);
    }

}
