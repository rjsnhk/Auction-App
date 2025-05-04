<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $auctions = Auction::all()->where('host_id', Auth::user()->id);
        return view('profile.manageauction', compact('auctions'));
    }

    /**
     * Show the form for creating a new auction.
     */
    public function create(string $id): View
    {
        if(Auth::user()->address == null){
            $products = Product::where('seller', Auth::user()->id)->get();
            session()->flash('status', 'Complete your profile before create auction.');
            return view('profile.manage', compact('products'));
        }

        $product = Product::findorfail($id);
        return view('profile.create', compact('product'));
    }

    /**
     * Store a newly created auction in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $product = Product::find($request->product);

        $auction = Auction::create([
            'name' => $request->name,
            'final_price' => $request->final_price,
            'host_id' => Auth::user()->id,
            'product_id' => $product->id,
        ]);

        if(Auth::user()->role == 0){
            return Redirect::route('dashboard')->with('status', 'Auction created successfully. Please wait for administrator review to seen it online');
        }
        else{
            return Redirect::route('admin.index')->with('status', 'Auction created successfully. please check auction request to make it online');
        }
        
    }

    /**
     * Display the ongoing auction.
     */
    public function show(Auction $auction): View
    {
        $auction = Auction::findorfail($auction->id);
        return view('ongoing', compact('auction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auction $auction): View
    {
        //
    }

    /**
     * Update the specified auction in storage.
     */
    public function update(Request $request, Auction $auction): RedirectResponse
    {
        $request->validate([
            'final_price' => ['required', 'integer'],
        ],[
            'final_price.required' => 'Amount is required!',
        ]);

        if($request->final_price > Auth::user()->asset + 50){
            return Redirect::route('auction.show', compact('auction'))->with('status', 'You have insufficient balance for bid!');
        }
        if($request->final_price < $auction->final_price){
            return Redirect::route('auction.show', compact('auction'))->with('status', 'Your bid is lower than present value!');
        }
        
        $auctions = Auction::where('id',$auction->id)->update([
            'final_price' => $request->final_price,
            'owner_id' => Auth::user()->id,
        ]);

        $auctions = Auction::where('id', $auction->id)->increment('no_of_bid');
        Auth::user()->increment('total_bid');

        return Redirect::route('auction.show', compact('auction'));
    }

    /**
     * Remove the specified auction from storage.
     */
    public function destroy(Auction $auction): RedirectResponse
    {
        Auction::destroy($auction->id);

        return Redirect::route('auction.index')->with('status', 'Auction deleted successfully!');
    }
}
