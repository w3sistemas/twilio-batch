<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','name','status','total','processed','result_path','error'
    ];

    public function items()
    {
        return $this->hasMany(BatchItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
