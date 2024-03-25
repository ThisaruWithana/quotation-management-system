<nav class="main-header navbar navbar-expand navbar-{{ Auth::user()->mode }} navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    </li>
    <li class="nav-item dropdown">
      <form method="POST" action="{{ route('logout') }}"></form> 
      @csrf 
      <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-user"></i>&nbsp; Hi {{ Auth::user()->name }}  
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
        <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">My Profile</a>
        <a class="dropdown-item" href="{{ url('logout') }}">Sign Out</a>
      </div>
      </form>
    </li>
  </ul>
</nav>