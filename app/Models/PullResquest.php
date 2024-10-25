<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PullResquest extends Model
{
    protected $fillable = [
        'github_id',
        'github_number',
        'title',
        'state',
        'github_created_at',
        'github_updated_at',
        'github_closed_at',
        'github_merged_at'
    ];
}
