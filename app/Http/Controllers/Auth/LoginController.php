<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
	use AuthenticatesUsers;
	protected $redirectTo = '/';

	public function __construct()
	{
		$this->middleware('guest')->except('logout');
		$this->middleware('auth')->only('logout');
	}

	protected function authenticated(Request $request, $user)
	{
		if ($user->email === 'admin@gmail.com') {
			return redirect('/admin/dashboard');
		}else{
			return redirect('/');
		}
	}
}
