<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'position_id', 'id');
    }

    public function scopeFilter($query, $sortBy, $sortOrder)
    {
        return $query->orderBy($sortBy, $sortOrder)->get();
    }
}
