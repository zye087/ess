<style>
   .nav-account .nav-item .nav-link.active {
      background: green;
   }
</style>

<section class="py-lg-7 py-5 bg-light-subtle">
    <div class="container">
       <div class="row">
          <div class="col-lg-3 col-md-4">
             <div class="d-flex align-items-center mb-4 justify-content-center justify-content-md-start">
                  <img src="{{ auth()->guard('parents')->user()->profile_picture 
                  ? asset('storage/' . auth()->guard('parents')->user()->profile_picture) 
                  : asset('images/frontend/default.png') }}" alt="profile"
                   class="avatar avatar-lg rounded-circle" />
                <div class="ms-3">
                   <h5 class="mb-0">{{ auth()->guard('parents')->user()->name }}</h5>
                   <small>{{ auth()->guard('parents')->user()->email }}</small>
                   <p><small><a href="{{route('parent.profile')}}" class="text-info"><i class="bx bx-pencil"></i> Edit Profile</a></small></p>
                </div>
             </div>

             <div class="d-md-none text-center d-grid">
                <button class="btn btn-light mb-3 d-flex align-items-center justify-content-between" type="button"
                   data-bs-toggle="collapse" data-bs-target="#collapseAccountMenu" aria-expanded="false"
                   aria-controls="collapseAccountMenu">
                   Account Menu
                   <i class="bi bi-chevron-down ms-2"></i>
                </button>
             </div>

             <div class="collapse d-md-block" id="collapseAccountMenu">
                <ul class="nav flex-column nav-account">
                   <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}" href="{{route('parent.dashboard')}}">
                         <i class="align-bottom bx bx-home-alt-2"></i>
                         <span class="ms-2">Dashboard</span>
                      </a>
                   </li>
                   <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('parent.child') ? 'active' : '' }}" href="{{route('parent.child')}}">
                         <i class="align-bottom bx bx-child"></i>
                         <span class="ms-2">Children</span>
                      </a>
                   </li>
                   <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('parent.guardians') ? 'active' : '' }}" href="{{route('parent.guardians')}}">
                        <i class="align-bottom bx bx-group"></i>
                        <span class="ms-2">Guardians</span>
                     </a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link {{ request()->routeIs('parent.pickup.logs') ? 'active' : '' }}" href="{{route('parent.pickup.logs')}}">
                        <i class="align-bottom bx bx-list-ul"></i>
                        <span class="ms-2">Pickups</span>
                     </a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('parent.profile') ? 'active' : '' }}" href="{{route('parent.profile')}}">
                         <i class="align-bottom bx bx-user"></i>
                         <span class="ms-2">Profile</span>
                      </a>
                   </li>
                   <li class="nav-item ">
                     <a class="nav-link {{ request()->routeIs('parent.security') ? 'active' : '' }}" href="{{ route('parent.security') }}">
                        <i class="align-bottom bx bx-lock-alt"></i>
                        <span class="ms-2">Security</span>
                     </a>
                  </li>
                   <li class="nav-item">
                      <a class="nav-link text-danger" href="{{route('parent.logout')}}">
                         <i class="align-bottom bx bx-log-out"></i>
                         <span class="ms-2">Logout</span>
                      </a>
                   </li>
                </ul>
             </div>
          </div>
          @yield('content')
       </div>
    </div>
 </section>
