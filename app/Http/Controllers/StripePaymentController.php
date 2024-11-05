<?php
      
namespace App\Http\Controllers;
       
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe;
       
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(): View
    {
        return view('stripe');
    }
      
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request): RedirectResponse
    {
            
         Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
         
         
         $totalAmount = $request->input('total_amount'); 
     
         try{
            
             Stripe\Charge::create([
                 "amount" => $totalAmount * 100, 
                 "currency" => "usd",
                 "source" => $request->stripeToken,
                 "description" => "Payment from E-commerce platform."
             ]);
             $order = Order::findOrFail($request->orderId);
             $order->payment_status = 'Paid'; 
             $order->save();
             
             return back()->with('success', 'Payment successful!');
         }catch (\Exception $e) {
             
             return back()->with('error', 'Payment failed: ' . $e->getMessage());
         }
    }
}