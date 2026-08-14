<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteReport extends Model
{
    use HasFactory;

    // The primary key associated with the table.
    protected $primaryKey = 'report_id';

    // Disable automatic timestamp management by Laravel
    public $timestamps = false;

    // Specify the table name
    protected $table = 'quotereports';

    // Specify the fillable fields
    protected $fillable = [
        'quote_id',
        'report_option_id',
        'additional_details',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }

    public static function getReportOptions()
    {
        return [
            1 => "It's spam",
            2 => "Inappropriate content",
            3 => "Hate speech",
            4 => "Misleading information",
            5 => "Harassment or bullying",
            6 => "Scam or fraud",
            7 => "Violence or dangerous behavior",
            8 => "Copyright violation",
            9 => "Privacy violation",
            10 => "Offensive language",
            11 => "Self-harm or suicidal content",
            12 => "Terrorism-related content",
            13 => "Sexual content or nudity",
            14 => "False news or misinformation",
            15 => "Spam ads or promotions",
            16 => "Other"
        ];
    }

    // Automatically set the timestamp field on creation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quoteReport) {
            if (!$quoteReport->timestamp) {
                $quoteReport->timestamp = now();
            }
        });
    }
}
