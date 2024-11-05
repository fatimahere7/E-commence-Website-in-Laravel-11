<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
//    public function add_cart(Request $request,$id){
//       $product_id=$id;
//       $user = Auth::user();
//       $user_id = $user->id;
//       $request->validate([
//         'quantity' => 'required|integer|min:1',
//     ]);
//     $quantity = $request->input('quantity');
//     $data = new Cart;
//     $data->product_id = $product_id;
//     $data->user_id = $user_id;
//     $data->quantity = $quantity;

   
//     $data->save();

//     // Optionally return a response
//     return redirect()->back()->with('message', 'Product added to cart successfully!');
//    }
}   

