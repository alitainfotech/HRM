<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand"><img src="{{ asset('assets/images/logo-black.SVG') }}" alt=""></a>

    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Main</li>
      @if (isset(Auth::user()->id))
        <li class="nav-item ">
          <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="briefcase"></i>
            <span class="link-title">Job Openings</span>
          </a>
        </li> 
        <li class="nav-item ">
          <a href="{{ route('user.application') }}" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">Applications</span>
          </a>
        </li> 
      @endif
      @if (isset(Auth::guard('admin')->user()->id))
        <li class="nav-item ">
          <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
      @if(in_array("1", permission()))
        <li class="nav-item ">
          <a href="{{ route('opening.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="briefcase"></i>
            <span class="link-title">Job Openings</span>
          </a>
        </li>
      @endif
      @if(in_array("5", permission()))
        <li class="nav-item ">
          <a href="{{ route('user.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="users"></i>
            <span class="link-title">Users</span>
          </a>
        </li>
      @endif
      @if(in_array("9", permission()))
        <li class="nav-item ">
          <a href="{{ route('role.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">Roles</span>
          </a>
        </li>
      @endif
      @if(in_array("13", permission()))
        <li class="nav-item ">
          <a href="{{ route('permission.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="check-square"></i>
            <span class="link-title">Permission</span>
          </a>
        </li>
      @endif 
      @if(in_array("17", permission()))
        <li class="nav-item ">
          <a href="{{ route('application.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">Applications</span>
          </a>
        </li>
      @endif
      @if(in_array("21", permission()))
        <li class="nav-item ">
          <a href="{{ route('interview.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="user-check"></i>
            <span class="link-title">Interviews</span>
          </a>
        </li>
      @endif
      @if(in_array("25", permission()))
      <li class="nav-item ">
        <a href="{{ route('department.dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="user-check"></i>
          <span class="link-title">Department</span>
        </a>
      </li>
      @endif
      @endif
      
      
    </ul>
  </div>
</nav>
