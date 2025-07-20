<?php

namespace App\Http\Controllers;

use App\Enums\EntityType;
use App\Models\Asset\Country;
use App\Models\User\User;
use App\Repositories\Movie\MovieRepository;
use App\Services\Helper;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function loginView(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('profile');
        }
        return view('pages.Auth.login');
    }
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('profile');
        }
        $request->validate([
            'phone' => 'required|ir_mobile',
            'password' => 'required'
        ]);
        $user = User::query()->firstOrCreate([
            'phone' => Helper::formatPhone($request->get('phone')),
        ] , ['max_profiles' => 5 , 'is_block' => false,'password' => bcrypt($request->get('password'))]);
        if ( ! Hash::check($request->get('password') , $user->password) )
            return redirect()->back()->withInput()->withErrors(['password' => 'رمز عبور صحیح نمی باشد!']);
        if ( $user->is_block )
            return redirect()->back()->withInput()->withErrors(['phone' => 'حساب کاربری شما مسدود شده است!']);
        Auth::guard('web')->loginUsingId($user->id , $request->has('remember'));
        return redirect()->route('profile');
    }

}
