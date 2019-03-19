<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function isAdmin() {
		$roles = Auth::user()->roles;
		$isAdmin = false;
		foreach($roles as $role) {
			if($role->name === 'administrator') {
				$isAdmin = true;
			}
		}

		return $isAdmin;
	}
}
