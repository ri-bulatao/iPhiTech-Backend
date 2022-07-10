<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'street_address',
        'city',
        'state',
        'zip_code',
        'country'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'position_id' , 'id');
    }
}
