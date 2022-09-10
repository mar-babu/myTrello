<div class="user-profile pull-right">
    {{-- <img class="avatar user-thumb" src="{{ asset('backend/assets/images/author/avatar.png') }}" alt="avatar"> --}}
    <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
        {{ auth()->user()->name  }}
        <i class="fa fa-angle-down"></i></h4>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ url('api/logout') }}"
        onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">Log Out</a>
    </div>

    <form id="logout-form" action="{{ url('/logout') }}" method="get" style="display: none;">
        @csrf
    </form>
</div>