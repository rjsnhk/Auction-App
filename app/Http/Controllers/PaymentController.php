<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auction;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $payments = Payment::paginate(10);

        return view('profile.payhistory', compact('payments'));
    }

    /**
     * function for completing the payment
     */
    public function pay(string $id): View
    {
        $auction = Auction::find($id);
        $product = Product::find($auction->product_id);

        if($auction->payment == 1){
            session()->flash('status', 'You already pay for this product.');
            return view('payment', compact('auction'));
        }

        if(Auth::user()->asset <= $auction->final_price + 50){
            session()->flash('status', 'Sorry, you have insufficient balance for payment');
            return view('payment', compact('auction'));
        }

        $commission = ($auction->final_price - $product->starting_price) * 0.35;
        $payment = Payment::create([
            'auction_id' => $auction->id,
            'payer' => Auth::user()->id,
            'amount' => $auction->final_price,
            'commission' => $commission,
            'gateway' => 'Auction-app',
        ]);

        $user = Auth::user()->decrement('asset', $payment->amount);
        $user = Auth::user()->increment('total_buy');
        $admin = User::where('role', '2')->increment('asset', $commission);
        $host = User::where('id', $auction->host_id)->increment('asset', $payment->amount - $commission);
        $host = User::where('id', $auction->host_id)->increment('total_sell');

        $auctions = Auction::where('id', $auction->id)->update([
            'payment' => '1',
            'payment_id' => $payment->id,
            'status' => '2',
        ]);

        session()->flash('status', 'Congratulation! your payment is successful.');
        return view('payment', compact('auction'));
    }

    /**
     * function for completing the withdraw
     */
    public function withdraw(string $id): View
    {
        $auction = Auction::find($id);
        $payment = Payment::find($auction->payment_id);
        
        if($payment->withdrawer > 0){
            session()->flash('status', 'You already withdraw for this product');
            return view('payment', compact('auction'));
        }
        
        if($auction->payment == 0){
            session()->flash('status', 'Buyer did not payed yet. Wait for bayer payment.');
            return view('payment', compact('auction'));
        }

        $user = Auth::user()->decrement('asset', $payment->amount - $payment->commission);

        $payment = Payment::where('id',$payment->id)->update([
            'withdrawer' => Auth::user()->id,
        ]);

        session()->flash('status', 'Congratulation! withdraw is in process. You will get your money soon');
        return view('payment', compact('auction'));
    }

    /**
     * function for giving the review of product
     */
    public function review(Request $request, string $id): View
    {
        $auctions = Auction::where('id', $id)->update([
            'massage' => $request->message,
        ]);
        
        $auction = Auction::find($id);
        return view('ongoing', compact('auction'));
    }
}
