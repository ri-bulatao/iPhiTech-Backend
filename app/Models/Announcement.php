<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Position;

class Announcement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function positions()
    {
        return $this->belongsTo(Position::class);
    }

    public function scopeSort($query, $sortBy, $sortOrder)
    {
        return $query->orderBy($sortBy, $sortOrder)->get();
    }
}
