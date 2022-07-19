<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'created_at',
        'updated_at',
    ];

    public function scopeFilter($query, $sortBy, $sortOrder)
    {
        return $query->orderBy($sortBy, $sortOrder)->get();
    }

    public function course()
    {
        return $this->hasMany('App\Models\Course', 'id');
    }
}
