@extends('layouts.admin')

@section('title')
    Admin | View Products
@endsection

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">All Products</h1>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Product Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Category</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ( $products as $product )
                       <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ Str::limit($product->description, 20) }}</td>
                        <td>${{ $product->price}}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->category }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#imageModal{{ $product->id }}">View All Images</button>
                        </td>
                        {{-- <td>
                            <i class="fa fa-eye" aria-hidden="true"></i>
                            <i class="fa fa-trash" aria-hidden="true"></i>

                        </td> --}}
                        <td>
                            
                            <a href="{{ route('admin.editProduct', $product->id) }}" ><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.deleteProduct', $product->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="confirmation(event)">Delete</button>
                            </form>
                        </td>
                       </tr>

                       <!-- Modal for displaying images -->
                       <div class="modal fade" id="imageModal{{ $product->id }}" tabindex="-1" aria-labelledby="imageModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel{{ $product->id }}">{{ $product->title }} - All Images</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        @foreach($product->images as $image)
                                            <div class="col-md-3 mb-2">
                                                <img src="{{ asset('images/products/' .$image->image_path) }}" alt="{{ $product->title }}" class="img-fluid">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   @endforeach
                </tbody>
            </table>

            @if($products->isEmpty())
                <div class="alert alert-warning text-center">No products available.</div>
            @endif

          <!-- Pagination Links -->
          <div class="d-flex justify-content-center mt-4">
              {{ $products->links('pagination::bootstrap-5') }}
          </div>
           
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    function confirmation(ev){
        ev.preventDefault(); // Prevent default form submission
        
        const form = ev.target.form; // Get the form from the event target

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this product!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // Submit the form if the user confirms deletion
                form.submit();
            } else {
                swal("Your product is safe!");
            }
        });
    }
</script>
@endsection