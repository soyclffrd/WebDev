<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'description'
    ];

    protected $casts = [
        'level' => 'integer',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'grade_subject');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'grade_teacher');
    }
}