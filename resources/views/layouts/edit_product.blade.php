@extends('layouts.admin')
@section('title')
    Admin | Edit Product
@endsection

@section('content')
<br><br>
<style>
  .img-container {
    position: relative;
    width: 100%;
    height: 300px; /* Set a fixed height for the container */
    overflow: hidden; /* Ensure that overflow is hidden */
    border: 1px solid #ddd; /* Optional: add a border for better visibility */
    display: flex; /* Use flexbox for centering */
    justify-content: center; /* Center the image horizontally */
    align-items: center; /* Center the image vertically */
}

.img-container img {
    max-width: 100%; /* Make sure the image is responsive */
    max-height: 100%; /* Ensure the image fits the container */
    object-fit: cover; /* Cover the entire container while maintaining aspect ratio */
}
</style>
<div class="container">
    <h1 class="text-center mb-4">Edit Product</h1>

    <div class="card">
        <div class="card-body">
            <!-- Display errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Success message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Edit Product Form -->
            {{-- admin.updateProduct --}}
            <form action="{{ route('admin.updateProduct', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Product Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Product Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $product->title) }}" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Price -->
                <div class="mb-3">
                    <label for="price" class="form-label fw-bold">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                </div>

                <!-- Quantity -->
                <div class="mb-3">
                    <label for="quantity" class="form-label fw-bold">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
                </div>

                <!-- Product Category -->
                <div class="mb-3">
                    <label for="category" class="form-label fw-bold">Product Category</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

               <!-- Existing Images -->
               <div class="mb-3">
                 <label for="currentImages" class="form-label fw-bold">Current Images</label>
                 <div class="row">
                     @foreach($product->images as $image)
                         <div class="col-md-3 mb-2">
                             <div class="img-container">
                                 <img src="{{ asset('images/products/' . $image->image_path) }}" alt="Product Image" class="img-fluid">
                                 {{-- <form action="{{ route('admin.deleteProductImage', $image->id) }}" method="POST" style="display:inline-block;">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-sm btn-danger mt-2">Delete</button>
                                  </form> --}}
                             </div>
                         </div>
                     @endforeach
                 </div>
               </div>

                <!-- Image Upload Section for New Images -->
                <div class="mb-3">
                    <label for="inputImage" class="form-label fw-bold">Add New Images:</label>
                    <input type="file" 
                       name="images[]" 
                       id="inputImage" 
                       multiple 
                       class="form-control 
                       @error('images') is-invalid @enderror">
                    @error('images')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Update Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
