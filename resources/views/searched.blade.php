<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title', 'Laravel')</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/site/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/site/css/responsive.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/site/images/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
        .user_option .btn:focus {
            outline: none; 
            box-shadow: none; 
        }
        .user_option .btn:active {
            border-color: none;
        }
        .user_option .icon-link {
            margin-right: 15px; 
        }
        .user_option .login-link {
            margin-right: 30px; 
        }
        .user_option .nav_search-btn {
            margin-right: 15px; 
        }
        .custom-card-img {
            width: 100%;      
            height: 400px;    
            object-fit: cover; 
        }
        .carousel-image {
            width: 100%; 
            height: auto; 
            max-height: 400px; 
            object-fit: contain;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: black; 
            border-radius: 50%; 
        }
        .carousel-control-prev-icon::before,
        .carousel-control-next-icon::before {
            color: white; 
        }
    </style>

    @stack('css')
</head>
<body>
    <header class="header_section">
        <nav class="navbar navbar-expand-lg custom_nav-container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class=""></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('welcomeHome') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="shop.html">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="why.html">Why Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="testimonial.html">Testimonial</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact Us</a>
                    </li>
                </ul>
                <div class="user_option">
                    <a href="{{ route('addedToCart') }}" style="margin-right: 15px;">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    </a>
                    <form class="form-inline" method="GET" action="{{ route('product.search') }}" id="searchForm" style="display: none;">
                        <div class="form-group">
                            <select name="category" class="form-control" style="margin-right: 10px;">
                                <option value="">Select Category</option>
                                @php
                                    // Fetch distinct categories from the products table
                                    $categories = \App\Models\Product::select('category')->distinct()->get();
                                @endphp
                                @foreach($categories as $category)
                                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="search" class="form-control" placeholder="Search products..." style="margin-right: 10px;">
                        </div>
                    
                    </form>
                     <!-- Search Icon -->
                     <button id="searchIcon" class="btn nav_search-btn" style="margin-right: 15px;">
                        <i class="fa fa-search" aria-hidden="true"></i>
                      </button>
                    @if(Auth::check())
                        <div class="dropdown icon-link">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                @if($isAdmin)
                                    <a class="dropdown-item" href="/admin/dashboard">Dashboard</a>
                                @endif
                                <a class="dropdown-item" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="link icon-link login-link">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Login</span>
                        </a>
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <br><br>
    <div class="container">
        <h1>Products</h1>

        @if($products->isEmpty())
            <p>No products found for the selected category.</p>
        @else
            <div class="row">
                @foreach($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card mb-3">
                            <img src="{{ asset('images/products/' . $product->images->first()->image_path) }}" class="card-img-top" alt="{{ $product->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->title }}</h5>
                                <p class="card-text">Price: ${{ $product->price }}</p>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <script>
        document.getElementById('searchIcon').addEventListener('click', function() {
            var form = document.getElementById('searchForm');
            form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="{{ asset('assets/site/js/custom.js') }}"></script>

    @stack('scripts')
</body>
</html>
