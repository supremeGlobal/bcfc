<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
	protected $redirectTo = '/';

	public function __construct()
	{
		$this->middleware('guest');
	}

	public function showRegistrationForm()
	{
		return view('auth.register');
	}

	public function register(Request $request)
	{
		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			return redirect()->back()
				->withErrors($validator)
				->withInput()
				->with('showModal', true);
		}

		$user = $this->create($request->all(), $request);

		// Auth::login($user);

		return redirect($this->redirectTo)->with('success', 'Registration successful!');
	}

	protected function validator(array $data)
	{
		return Validator::make($data, [
			'name' => ['required', 'string', 'max:255'],
			'father' => ['nullable', 'string'],
			'mother' => ['nullable', 'string'],
			'email' => ['required', 'email', 'max:255', 'unique:users'],
			'mobile' => ['required', 'unique:user_profiles'],
			'password' => ['nullable', 'string', 'min:2'],
			'present' => ['nullable', 'string'],
			'permanent' => ['nullable', 'string'],
			'district' => ['nullable', 'string'],
			'zip' => ['nullable', 'string'],
			'occupation' => ['nullable', 'string'],
			'education' => ['nullable', 'string'],
			'school' => ['nullable', 'string'],
			'gender' => ['nullable', 'string'],
			'marital_status' => ['nullable', 'string'],
			'spouse' => ['nullable', 'string'],
			'family_member' => ['nullable', 'string'],			
			'blood_group' => ['nullable', 'string'],
			'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
		]);
	}

	protected function create(array $data, Request $request)
	{
		$imagePath = null;
		if ($request->hasFile('image')) {
			$image = $request->file('image');
			$imageName = time() . '_' . $image->getClientOriginalName();
			$image->move(public_path('images/users'), $imageName);
			$imagePath = 'images/users/' . $imageName;
		}

		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password'] ?? '123456'),
		]);
	}
}
