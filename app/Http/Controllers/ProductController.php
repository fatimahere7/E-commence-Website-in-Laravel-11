<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
 
    public function index()
    {
        $products = Product::with('images')->get();

        $isAdmin = Auth::check() && Auth::user()->role === 'seller';
    
        $products = Product::with('images')->get(); // Fetch all products from the database
        return view('welcome', compact('products','isAdmin'));
    }





    // add product
    public function add_product(Request $request){
        $categories = Category::all();
        return view("layouts.product",compact("categories"));
    }




    public function upload_product(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category' => 'required',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',  
        ]);
        
         $seller = Auth::user();
     
         
         if ($seller->role !== 'seller') {
             return redirect()->back()->withErrors(['error' => 'Only sellers can add products.']);
         }
        
        $product = Product::create([
           
            'seller_id' => $seller->id,
            'title' => $request->title,  
            'description' => $request->description,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'price' => $request->price,
           
        ]);
    
        
        if ($request->hasFile('images')) {
            $files=$request->file('images');
            foreach ($files as $file) {
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $request ['product_id']= $product->id;
                $request['image_path'] = $imageName; // Add image path to the array
                $file->move(public_path('images/products'), $imageName);
                ProductImage::create($request->all());
            }
        }
        
       
        return back()->with('message', 'Product Added successfully.');

        
    }





    public function show_product(Request $request){
        
        
        $seller = Auth::user();
    
        
        if ($seller->role !== 'seller') {
            return redirect()->back()->withErrors(['error' => 'Only sellers can view their products.']);
        }
 
        $products = Product::with('images')
           ->where('seller_id', $seller->id) 
           ->paginate(10);

        $productImages = ProductImage::get();     
        return view("layouts.view_product", compact("products", "productImages"));
    }





    public function show($id)
    {
        $isAdmin = Auth::check() && Auth::user()->role === 'seller';
        $product = Product::with('images')->findOrFail($id);
        return view('productShow', compact('product','isAdmin'));
    }





//    public function passAdmin(){
//        $isAdmin = Auth::check() && Auth::user()->role === 'seller';
//        return view('layouts.app', compact('isAdmin'));
//    }
    




    public function edit_product($id){
       
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all(); 
        return view("layouts.edit_product",compact("product","categories"));
    }






    public function update_product(Request $request,$id){
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $request->category,
        ]);
         // Handle new images if uploaded
         if ($request->hasFile('images')) {
            $files=$request->file('images');
            foreach ($files as $file) {
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $request ['product_id']= $product->id;
                $request['image_path'] = $imageName; // Add image path to the array
                $file->move(public_path('images/products'), $imageName);
                ProductImage::create($request->all());
            }
        }

        return redirect()->route('admin.editProduct', $product->id)->with('success', 'Product updated successfully!');
    }




    public function deleteProductImage($id)
   {
       $image = ProductImage::findOrFail($id);
       Storage::disk('public')->delete('products/' . $image->image_path); // Delete image from storage
       $image->delete(); // Delete record from the database
   
       return back()->with('success', 'Image deleted successfully');
   }





   public function add_cart(Request $request,$id){
        $product_id=$id;
        $user = Auth::user();
        $user_id = $user->id;
        $request->validate([
          'quantity' => 'required|integer|min:1',
      ]);
      $quantity = $request->input('quantity', 1);
      $data = new Cart;
      $data->product_id = $product_id;
      $data->user_id = $user_id;
      $data->quantity = $quantity;
    
     
      $data->save();
    
      // Optionally return a response
      return redirect()->back()->with('message', 'Product added to cart successfully!');
    }




    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);  // Assuming you are using a Cart model
        $cartItem->delete();
    
        return redirect()->back()->with('message', 'Item removed from cart.');
    }





    public function delete_product($id){
        $product = Product::findOrFail($id);
        $images = ProductImage::where('product_id',$product->id)->get();
        foreach( $images as $image ){
            if(File::exists('images/products'.$image->image))
                File::delete('images/products'.$image->image);
        }

        $product->delete();
        return back()->with('message', 'Product Deleted successfully.');

    }  



      public function showCart()
      {
        $user = Auth::user();
        $isAdmin = Auth::check() && Auth::user()->role === 'seller';
        $cartItems = Cart::where('user_id', $user->id)->with('product')->get(); 
        
        // Calculate the total price
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    
        return view('cart', compact('cartItems', 'totalPrice','isAdmin'));
      }


      public function search(Request $request)
      {
         
          $category = $request->input('category');
          $searchTerm = $request->input('search');
          $isAdmin = Auth::check() && Auth::user()->role === 'seller';
      
          $query = Product::with('images'); // Include the images relationship
      
          if ($category) {
              $query->where('category', $category);
          }
      
          if ($searchTerm) {
              $query->where('title', 'like', '%' . $searchTerm . '%');
          }
      
          // Paginate the results
          $products = $query->paginate(7); 
      
          return view('searched', compact('products', 'isAdmin'));
      }
            

}
