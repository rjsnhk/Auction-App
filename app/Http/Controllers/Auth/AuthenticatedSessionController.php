<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        Auth::user()->active_status = true;
        Auth::user()->save();

        $userRole = Auth::user()->role;

        switch ($userRole) {
            case '0':
                return redirect()->intended(route('dashboard', absolute: false));
                break;
            
            case '1':
                return redirect()->intended(route('admin.index', absolute: false));
                break;
            
            case '2':
                return redirect()->intended(route('admin.index', absolute: false));
                break;
            
            default:
                return redirect()->intended(route('home', absolute: false));
                break;
        }
        
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->user()->active_status = false;

        $request->user()->save();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect('/');
    }
}
