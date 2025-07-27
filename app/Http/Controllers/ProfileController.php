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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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


    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'age_range_id' => ['required', 'exists:age_ranges,id'],
            'avatar' => ['nullable', 'image', 'max:5248'],
        ]);
        /** @var User $user */
        $user = auth()->user();
        $profile = $user->currentProfile();
        $profile->name = $validated['name'];
        $profile->age_range_id = $validated['age_range_id'];
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->store('avatar/'.now()->format('Y/m/d'), 'public');

            if ($profile->avatar && Storage::disk('public')->exists($profile->avatar)) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $profile->avatar = $path;
        }
        $profile->save();
        return redirect()->back()->withInput()->with('success', 'تغییرات با موفقیت ذخیره شد.');
    }


    public function updatePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'وارد کردن پسورد فعلی الزامی است.',
            'password.required' => 'وارد کردن پسورد جدید الزامی است.',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
            'password.confirmed' => 'تایید رمز عبور با مقدار وارد شده هم‌خوانی ندارد.',
        ]);
        /** @var User $user */
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['رمز عبور فعلی اشتباه است.']
            ]);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'رمز عبور با موفقیت تغییر یافت.');
    }

}
