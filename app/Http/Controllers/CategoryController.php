<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;



class CategoryController extends Controller
{
    public function view_category(Request $request){
        $categories = Category::all();
        return view("layouts.category", compact("categories"));
    }
    public function add_category(Request $request)
    {
       
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name',
        ]);
    
        // Save the category if validation passes
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();
    
        return back()->with('message', 'Category created successfully.');
    }

    public function delete_category($id){
        
       $category = Category::find($id);
       $category->delete();
       return back()->with('message', 'Category deleted successfully.');

    }
}
