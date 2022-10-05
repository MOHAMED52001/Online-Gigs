<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //User Login.
    public function login()
    {
        return View('users.login');
    }

    //Authenticate User.
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);


        if (auth()->attempt($formFields)) {

            $request->session()->regenerate();

            return Redirect('/')->with('message', 'Welcome! You are now logged in successfully');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    //User Logout.
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out');
    }
    //Register User.
    public function register()
    {
        return View('users.register');
    }

    //Validate User And Store.
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:8'
        ]);

        $formFields['password'] = bcrypt($formFields['password']);


        $user = User::create($formFields);

        auth()->login($user);

        return redirect('/')->with('message', "Welcome $user->name");
    }
}
