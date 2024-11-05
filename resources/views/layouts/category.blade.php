@extends('layouts.admin')
@section('title')
    Admin | Categories
@endsection
@section('content')
<br>
<div style="padding-left: 50px">
    <h1>Categories</h1>
    <br><br>
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

{{-- @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif --}}
    @if (Session::has('message'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ Session::get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>  
    @endif
    <div class="d-flex" style="width: 600px;">
       
        <form action="{{ route('admin.addCategory') }}" method="post" style="width: 500px;">
            @csrf
            <div class="mb-3">
                <label for="category" class="form-label">Category Name</label>
                <div class="d-flex">
                    <input type="text" id="category" name="category_name" class="form-control me-2" required>
                    <button type="submit" class="btn btn-primary" style="white-space: nowrap;">Add Category</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card" style="width: 800px">
        <div class="card-header">
            ALL CATEGORY
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <td scope="row">{{ $category->category_name }}</td>
                        <td>
                            <a href="{{ route('admin.deleteCategory', $category->id) }}" onclick="confirmation(event)"> 
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    function confirmation(ev){
        ev.preventDefault();
        const url = ev.currentTarget.getAttribute('href');

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this category!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // Redirect to the delete URL
                window.location.href = url;
            } else {
                swal("Your category is safe!");
            }
        });
    }
</script>
@endsection
