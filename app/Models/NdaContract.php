<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NdaContract extends Model
{
    protected $fillable = [
        'user_id',
        'project_name',
        'disclosing_party',
        'receiving_party',
        'duration_years',
        'jurisdiction',
        // Add any other fields you are saving from your form here
    ];
}
