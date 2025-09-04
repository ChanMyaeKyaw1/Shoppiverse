<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Rating extends Model
{
    //
    protected $fillable = [
        'user_id',
        'product_id',
        'count',
    ];
}
