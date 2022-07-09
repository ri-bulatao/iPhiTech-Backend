<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handbook extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'version_name',
        'metadata',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'handbook_pages' => 'array',
    ];

    public function handbook_pages()
    {
        return $this->hasMany('App\Models\Handbook');
    }
}
