<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'grade_id',
        'strand_id'
    ];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher')
            ->withTimestamps();
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function strand()
    {
        return $this->belongsTo(Strand::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'subject_user')
            ->withPivot(['status'])
            ->withTimestamps();
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function scopeAvailable($query)
    {
        return $query->has('users', '<', 40); // Adjust max slots as needed
    }
} 