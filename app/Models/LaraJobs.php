<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaraJobs extends Model
{
    use HasFactory;

    protected $fillable = [
        'guid',
        'category',
        'title',
        'published_date',
        'creator',
        'link',
        'seen'
    ];
}
