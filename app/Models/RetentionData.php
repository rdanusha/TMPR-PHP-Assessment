<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetentionData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'onboarding_percentage', 'count_applications', 'count_accepted_applications', 'created_at',
    ];

    protected $casts = [
        'onboarding_percentage' => 'integer',
    ];

}
