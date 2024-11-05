<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            <div class="sb-sidenav-menu-heading">Interface</div>
            <a class="nav-link" href="{{ route('admin.category') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Category
            </a>
            
            <a class="nav-link" href="#">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-signs-post"></i></div>
                All Posts
            </a>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                Products
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            
            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                    <a class="nav-link" href="{{ route('admin.addProduct') }}">
                        Add New Product
                    </a>
                    <a class="nav-link" href="{{ route('admin.showProduct') }}">
                        View Product
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        @yield('login_admin')
    </div>
</nav>
