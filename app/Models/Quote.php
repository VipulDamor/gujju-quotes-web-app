<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = ['category_id', 'quote'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function quotereports()
    {
        return $this->hasMany(QuoteReport::class);
    }
}
