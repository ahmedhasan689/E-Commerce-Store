<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
    ];

    protected $primaryKey = 'name';

    protected $keyType = 'string';

    public $incrementing = false;

    public static function getValue($name, $default = null)
    {
        $config = static::find($name);
        if (!$config) {
            return $default;
        }

        return $config->value;
    }

    public static function setValue($name, $value)
    {
        return static::query()->updateOrCreate([
            'name' => $name,
        ], [
            'value' => $value,
        ]);
    }
}
