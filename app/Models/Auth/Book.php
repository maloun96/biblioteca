<?php

namespace App\Models\Auth;

use App\Models\Traits\Uuid;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\Traits\SendUserPasswordReset;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\Traits\Relationship\UserRelationship;

/**
 * Class Book.
 */
class Book extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'copies',
	];

}
