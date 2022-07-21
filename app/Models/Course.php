<?php

declare(strict_types=1);

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
        'id',
        'user_id',
        'course_category_id',
        'title',
        'description',
        'video_url',
        'is_embed',
        'embed_code',
        'featured_image',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'embed_video_url',
    ];

    // ADDITIONAL
    public function getEmbedVideoUrlAttribute() // notice that the attribute name is in CamelCase.
    {
        return 'https://www.youtube.com/embed/' . $this->embed_code;
    }

    public function scopeFilter($query, $sortBy, $sortOrder)
    {
        return $query->orderBy($sortBy, $sortOrder)->get();
    }

    public function courseCategory()
    {
        return $this->belongsTo('App\Models\CourseCategory', 'course_category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function userCourse()
    {
        return $this->hasOne('App\Models\UserCourse', 'course_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\CourseComment', 'course_id', 'id');
    }
}
