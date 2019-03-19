<?php

namespace App\Models\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Loan.
 */
class Loan extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'status',
		'book_id',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function book() {
		return $this->belongsTo(Book::class);
	}
}
