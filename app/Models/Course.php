<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'course_category_id',
        'title',
        'description',
        'video_url',
        'is_embed',
        'embed_code',
        'featured_image'
    ];

    public function scopeFilter($query, $sortBy, $sortOrder)
    {
        return $query->orderBy($sortBy, $sortOrder)->get();
    }

    public function courseCategory()
    {
        return $this->belongsTo('App\Models\CourseCategory', 'course_category_id');
    }
}
