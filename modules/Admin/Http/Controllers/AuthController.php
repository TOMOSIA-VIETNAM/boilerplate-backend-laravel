<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Containers\User\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Authentication Controller for Admin Module
 * 
 * Handles authentication functionality including login, logout,
 * and session management for the admin interface.
 */
class AuthController extends Controller
{
    /**
     * Display the admin login form
     * 
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin::auth.login');
    }

    /**
     * Handle admin login authentication
     * 
     * Validates user credentials and attempts to authenticate the user.
     * Includes comprehensive debugging and logging for troubleshooting.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Debug: Check if user exists
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found: ' . $credentials['email']]);
        }

        // Debug: Check if password is correct
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['password' => 'Password incorrect for user: ' . $user->name]);
        }

        // Debug: Log user information
        \Log::info('Login attempt', [
            'email' => $credentials['email'],
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
            'password_check' => Hash::check($credentials['password'], $user->password)
        ]);

        // Attempt to authenticate
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            \Log::info('Login successful', [
                'user_id' => Auth::id(),
                'session_id' => session()->getId()
            ]);
            
            return redirect()->intended(route('admin.dashboard'));
        }

        // Debug: If Auth::attempt returns false
        \Log::error('Auth::attempt failed', [
            'email' => $credentials['email'],
            'user_exists' => $user ? 'yes' : 'no',
            'password_correct' => Hash::check($credentials['password'], $user->password),
            'session_id' => session()->getId(),
            'csrf_token' => csrf_token()
        ]);

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Handle admin logout
     * 
     * Logs out the authenticated user, invalidates the session,
     * and regenerates the CSRF token for security.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
