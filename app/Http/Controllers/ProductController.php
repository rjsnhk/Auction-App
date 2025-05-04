<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(): View
    {
        $products = Product::where('seller', Auth::user()->id)->get();
        return view('profile.manage', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        return view('profile.product');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:550'],
            'starting_price' => ['required', 'numeric'],
            'picture' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        $picName = time().'.'.$request->picture->extension();
        $path = $request->picture->move('storage', $picName);

        $product = Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'picture' => $path,
            'seller' => Auth::user()->id,
        ]);

        return Redirect::route('product.index')->with('status', 'Product add successfully! Check it out in list.');
    }

    /**
     * Display the specified product.
     */
    public function show(string $id): View
    {
        $product = Product::findorfail($id);
        return view('productview', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(string $id): view
    {
        $product = Product::findorfail($id);
        return view('profile.update', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $product = Product::where('id', $id)->update([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
        ]);

        return Redirect::route('product.index')->with('status', 'product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $product = Product::find($id);
        unlink(public_path($product->picture));

        Product::destroy($id);

        return Redirect::route('product.index')->with('status', 'Product delete successfully!');
    }
}
