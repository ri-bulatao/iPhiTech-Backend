<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandbookPage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'handbook_id',
        'name',
        'content',
        'created_at',
        'updated_at',
    ];

    public function handbook()
    {
        return $this->belongsTo('App\Models\Handbook', 'handbook_id');
    }
}
