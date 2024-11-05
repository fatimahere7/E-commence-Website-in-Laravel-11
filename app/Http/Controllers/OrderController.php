<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OrderController extends Controller
{
    public function confirmOrder(Request $request)
    {
        $user = Auth::user();

    
       $cartItems = Cart::where('user_id', $user->id)->get();
       $subtotal = 0;
       foreach ($cartItems as $cartItem) {
           $subtotal += $cartItem->product->price * $cartItem->quantity;
       }

    
      $shippingFee = 10; 
      $taxAmount = $subtotal * 0.10; // For example, 10% tax

    // Calculate total amount
    $totalAmount = $subtotal + $shippingFee + $taxAmount;

    // Create a new Order
    $order = new Order;
    $order->user_id = $user->id;
    $order->subtotal = $subtotal;
    $order->shipping_fee = $shippingFee;
    $order->tax_amount = $taxAmount;
    $order->total_amount = $totalAmount;
    $order->status = 'Pending'; // Initial order status
    $order->save(); // Save the order to get the order ID

    // Loop through the cart items and add to order_items table
    foreach ($cartItems as $cartItem) {
        $orderItem = new OrderItem;
        $orderItem->order_id = $order->id; // Link to the newly created order
        $orderItem->product_id = $cartItem->product_id;
        $orderItem->quantity = $cartItem->quantity;
        $orderItem->price = $cartItem->product->price * $cartItem->quantity; // Calculate total for this item
        $orderItem->save();
    }

    // Clear the cart after confirming the order
    Cart::where('user_id', $user->id)->delete();

    return redirect()->route('order.confirmation', ['order_id' => $order->id])
        ->with('message', 'Order confirmed successfully!');
    }



    public function orderConfirmation($order_id)
    {
        $order = Order::with('orderItems.product')->findOrFail($order_id);
        $isAdmin = Auth::check() && Auth::user()->role === 'seller';
        return view('confirm', compact('order','isAdmin'));
    }

   
    public function updateOrderStatus(Request $request, $orderId)
    {
        // Find the order by ID
        $order = Order::findOrFail($orderId);
        
        // Update the status
        $order->status = $request->input('status');
        $order->save();
    
        return redirect()->back()->with('message', 'Order status updated successfully!');
    }


    public function updatePaymentStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        // $order->payment_method = $request->input('payment_method');
        $order->payment_status = 'Cash on Delivery';
        $order->save();
    
        return response()->json(['success' => true]);
    }
    
    public function updateAddress(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'adress' => 'required|string|max:255', 
        ]);
    
        // Update the address in the user's profile
        $user = Auth::user();
         
        // $user->save(); 
        $user->update([
            'adress' => $request->input('adress'), // Correct the spelling here if needed
        ]);
        return redirect()->back()->with('success', 'Address updated successfully.');
    }

}
