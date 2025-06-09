<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'specifications',
        'unit',
        'rate',
        'discount',
        'final_amount',
        'status',
        'subcategory_id',
        'image',
    ];


}
