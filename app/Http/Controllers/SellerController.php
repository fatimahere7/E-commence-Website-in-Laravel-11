<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function sellerDashboard()
    {
        $seller = Auth::user(); // Assume the seller is logged in
        
        // Fetch products owned by the seller
        $productIds = Product::where('seller_id', $seller->id)->pluck('id');
        
        // Fetch order items related to those products
        $orderItems = OrderItem::whereIn('product_id', $productIds)
            ->with(['order.user', 'product']) // Eager load order and product details
            ->get();
    
        return view('layouts.dash-main', compact('orderItems'));
    
    }
    public function viewSellerOrders()
     {
         $seller = Auth::user();
         
         // Fetch products owned by the seller
         $productIds = Product::where('seller_id', $seller->id)->pluck('id');
         
         // Fetch order items related to those products
         $orderItems = OrderItem::whereIn('product_id', $productIds)
             ->with(['order', 'product'])
             ->get();
     
         return view('layouts.dash-main', compact('orderItems'));
     }
}
