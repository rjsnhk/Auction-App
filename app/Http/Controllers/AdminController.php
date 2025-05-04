<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Auction;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    /**
    * function for show ongoing auction
    */
    public function index(): View
    {
        $auctions = Auction::where('status', '1')
                            ->where('start_time', '<=', date('Y-m-d H:i:s'))
                            ->where('end_time', '>=', date('Y-m-d H:i:s'))
                            ->get();
        return view('admin', compact('auctions'));
    }

    /**
    * function for show auction request
    */
    public function auction(): View
    {
        $auctions = Auction::where('status', '0')->get();
        return view('profile.requestauction', compact('auctions'));
    }

    /**
    * function for show create a new admin form
    */
    public function create(): View
    {
        return view('profile.add');
    }

    /**
    * function for store new admin data
    */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => '1',
        ]);

        event(new Registered($user));
        
        return Redirect::route('admin.create')->with('status', 'New admin created successfully');
    }
    
    /**
    * function for show all users
    */
    public function users(): View
    {
        $users = User::paginate(10);
        return view('viewusers', compact('users'));
    }

    /**
    * function for accept new auction request
    */
    public function accept(string $id): RedirectResponse
    {
        $timezone = config('app.timezone');
        $start = Carbon::now($timezone)->addMinutes(30);
        $end = Carbon::now($timezone)->addHours(4);
        //$end = Carbon::now($timezone)->addMinutes(30);
        $auctions = Auction::where('id', $id)->update([
            'start_time' => $start,
            'end_time' => $end,
            'status' => '1',
        ]);

        return Redirect::route('admin.auction');
    }

    /**
    * function for deny a auction request
    */
    public function deny(Request $request, string $id): RedirectResponse
    {
        $auctions = Auction::where('id', $id)->update([
            'status' => '3',
            'massage' => $request->massage,
        ]);

        return Redirect::route('admin.auction');
    }
}
