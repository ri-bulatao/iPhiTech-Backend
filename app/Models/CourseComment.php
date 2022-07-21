<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'course_id',
        'comment',
        'created_at',
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'course_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
