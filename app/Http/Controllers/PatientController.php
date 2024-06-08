<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{

    public function dashboard() {
        return view('patients.dashboard');
    }

    public function loginIndex() {
        return view('patients.login');
    }

    public function loginStore(Request $request) {
        $attributes = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::guard('patient')->attempt($attributes)) {
            return redirect()->route('patient.dashboard');    
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    
    }

    public function signupIndex() {
        return view('patients.signup');
    }

    public function signupStore(Request $request) {
        $attributes = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:patients',
            'password' => 'required|confirmed'
        ]);

        $patient = Patient::create($attributes);

        Auth::guard('patient')->login($patient);

        return redirect()->route('patient.dashboard');
    }

    public function signout() {
        Auth::guard('patient')->logout();
        return redirect()->route('patient.login.index');
    }
}
