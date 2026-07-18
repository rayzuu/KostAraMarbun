<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'name' => ['required','string','max:255'],

            'email' => ['required','string','lowercase','email','max:255','unique:'.User::class],

            'phone' => ['required','string','max:20'],

            'birth_place' => ['required','string','max:100'],

            'birth_date' => ['required','date'],

            'password' => ['required','confirmed',Rules\Password::defaults()],

        ]);

        $user = User::create([

            'name' => $request->name,

            'email' => $request->email,

            'phone' => $request->phone,

            'birth_place' => $request->birth_place,

            'birth_date' => $request->birth_date,

            'role' => 'customer',

            'password' => Hash::make($request->password),

        ]);

        event(new Registered($user));

        Auth::login($user);
        return redirect('/')
            ->with(
                'success',
                'Registrasi berhasil'
            );
    }
}
