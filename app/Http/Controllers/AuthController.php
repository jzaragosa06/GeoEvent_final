<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            Session::flash('form', 'login');
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Login Error',
                'text' => 'Please check your credentials and try again.',
            ]);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (($user) && ($request->password == $user->password)) {
            Auth::login($user);
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Login Successful',
                'text' => 'Welcome back!',
            ]);

            //store the value in session
            session()->put([
                'userid' => $user->userid,
                'name' => $user->name,
                'email' => $user->email,
            ]);


            return redirect()->route('index');
        } else {

            Session::flash('form', 'login');
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Login Error',
                'text' => 'Invalid credentials. Please try again.',
            ]);
            return redirect()->back()->withInput();
        }
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            Session::flash('form', 'signup');
            Session::flash('alert', [
                'type' => 'error',
                'title' => 'Registration Error',
                'text' => 'Please check your inputs and try again.',
            ]);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $status = User::create($request->all());

        if ($status) {
            Session::flash('form', 'login');
            Session::flash('alert', [
                'type' => 'success',
                'title' => 'Registration Successful',
                'text' => 'You can now login.',
            ]);
            return redirect()->route('login');
        } else {
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('landingpage');
    }
}
