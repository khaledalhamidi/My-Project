<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CacheWorksReport extends Model
{
    //
    protected $table = 'cache_works_reports';

    protected $fillable = [
        'date',
        'new_count',
        'in_progress_count',
        'pending_count',
        'completed_count',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
