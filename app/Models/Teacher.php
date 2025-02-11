<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'gender',
        'image',
        'subject_id'
    ];

    // Single subject relationship (main subject)
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Multiple subjects relationship (all assigned subjects)
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher')
            ->withTimestamps();
    }
}