<nav class="navbar navbar-expand topbar mb-2 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars" style="font-size:25px; color: #000000"></i>
          </button>
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @if ($profile && $profile->photoProfile)
                <img  class="img-profile rounded-circle" src="{{ asset($profile->photoProfile) }}" style="max-width: 60px">
                @else
                <img class="img-profile rounded-circle" src="{{ asset('template/img/boy.png') }}" style="max-width: 60px">
                @endif
                <span class="ml-2 d-none d-lg-inline text-black small">{{Auth::user()->name}}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="/profile">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-black"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-black-400">
 {{ __('Logout') }} </i>
                </a>
              </div>
            </li>
          </ul>
        </nav>