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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // -----------↓新規追加↓-----------
            'profile_text' => ['nullable','string','max:255'],
            'profile_image' => ['nullable','image','max:1024'],
            // -----------↑新規追加↑-----------
        ]);

        // -----------↓元のコード↓-----------
        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);
        // -----------↑元のコード↑-----------

        // -----------↓新規追加↓-----------
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if(request('profile_text')) {
            $user->profile_text = $request->profile_text;
        }

        if(request('profile_image')) {
            $name = request()->file('profile_image')->getClientOriginalName();
            request()->file('profile_image')->move('storage/images',$name);
            $user->profile_image = $name;
        }

        $user->save();

        // -----------↑新規追加↑-----------

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
