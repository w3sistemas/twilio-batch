<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id','raw_number','e164','country_code','carrier','type','valid','lookup_error'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
