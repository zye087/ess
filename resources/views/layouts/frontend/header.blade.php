<header>
    <nav class="navbar navbar-expand-lg  navbar-light w-100">
       <div class="container px-3">
         <a class="navbar-brand" href="">
            <img src="{{ asset('images/frontend/favicon-32x32.png') }}" alt="logo" />
            <strong style="color: green;"> {{ $settings['site_name'] ?? 'Enhancing School Safety' }} </strong>
         </a>
          <button class="navbar-toggler offcanvas-nav-btn" type="button">
             <i class="bi bi-list"></i>
          </button>
          <div class="offcanvas offcanvas-start offcanvas-nav" style="width: 20rem">
             <div class="offcanvas-header">
                <a href="" class="text-inverse"><img src="{{ asset('images/frontend/favicon-32x32.png') }}" alt="logo" /></a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
             </div>
             <div class="offcanvas-body pt-0 align-items-center">
                <ul class="navbar-nav mx-auto align-items-lg-center">
                    <li class="nav-item text-success" style="font-size: 25px;font-weight: bold;">
                        {{-- Enhancing School Safety --}}
                     </li>
                </ul>
                <div class="mt-3 mt-lg-0 d-flex align-items-center">
                   <a href="{{route('parent.logout')}}" class="btn btn-danger mx-2 btn-sm">  <i class="bx bx-log-out"></i> Logout</a>
                </div>
             </div>
          </div>
       </div>
    </nav>
 </header>