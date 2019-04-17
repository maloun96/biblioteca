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
		'copy_id',
	];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function copy() {
		return $this->belongsTo(Copy::class);
	}
}
