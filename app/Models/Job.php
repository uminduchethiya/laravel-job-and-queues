<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'jobs'; // Specify the table name

    protected $fillable = [
        'queue',
        'payload',
        'attempts',
        'reserved_at',
        'available_at',
        'created_at'
    ];

    public $timestamps = false; // Disable timestamps as they are already managed
}
