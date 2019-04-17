<?php

namespace App\Models\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Copy.
 */
class Copy extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod',
        'book_id',
    ];

    public function book() {
        return $this->belongsTo(Book::class);
    }
}
