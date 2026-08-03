<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteReport extends Model
{
    use HasFactory;

    // Disable automatic timestamp management by Laravel
    public $timestamps = false;

    // Specify the table name (if it's not the plural of the model)
    protected $table = 'quotereports';  // Make sure this is the correct table name

    // Specify the fillable fields
    protected $fillable = [
        'quote_id',
        'report_option_id',
        'additional_details',
        'timestamp',  // Ensure the timestamp field is included in fillable
    ];

    // Automatically set the timestamp field on creation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quoteReport) {
            // If no timestamp is provided, set it automatically
            if (!$quoteReport->timestamp) {
                $quoteReport->timestamp = now();  // Set the current timestamp
            }
        });
    }
}
