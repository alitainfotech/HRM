<nav class="sidebar">
  <div class="sidebar-header">
    <a href="#" class="sidebar-brand"><img src="{{ asset('assets/images/logo-black.png') }}" alt=""></a>

    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item  nav-category">Main</li>
      @if (Request::segment(1) != 'admin')
        @if (isset(Auth::user()->id))
          <li class="nav-item {{ active_class(['dashboard']) }}">
            <a href="{{ route('dashboard') }}" class="nav-link">
              <i class="link-icon" data-feather="briefcase"></i>
              <span class="link-title">Job Openings</span>
            </a>
          </li> 
          <li class="nav-item {{ active_class(['user/application']) }}">
            <a href="{{ route('user.application') }}" class="nav-link">
              <i class="link-icon" data-feather="user"></i>
              <span class="link-title">Applications</span>
            </a>
          </li> 
        @endif
      @else
        @if (isset(Auth::guard('admin')->user()->id))
          <li class="nav-item {{ active_class(['admin/dashboard']) }} ">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
              <i class="link-icon" data-feather="box"></i>
              <span class="link-title">Dashboard</span>
            </a>
          </li>
        @if(in_array("1", permission()))
          <li class="nav-item {{ active_class(['admin/opening']) }} ">
            <a href="{{ route('opening.dashboard') }}" class="nav-link">
              <i class="link-icon" data-feather="briefcase"></i>
              <span class="link-title">Job Openings</span>
            </a>
          </li>
        @endif
        @if(in_array("5", permission()))
          <li class="nav-item {{ active_class(['admin/user']) }} ">
            <a href="{{ route('user.dashboard') }}" class="nav-link">
              <i class="link-icon" data-feather="users"></i>
              <span class="link-title">Users</span>
            </a>
          </li>
        @endif
        @if(in_array("9", permission()))
          <li class="nav-item {{ active_class(['admin/role']) }} {{ active_class(['admin/role/*']) }}">
            <a href="{{ route('role.dashboard') }}" class="nav-link">
              <i class="link-icon" data-feather="user"></i>
              <span class="link-title">Roles</span>
            </a>
          </li>
        @endif
        @if(in_array("13", permission()))
          <li class="nav-item {{ active_class(['admin/permission']) }} ">
            <a href="{{ route('permission.dashboard') }}" class="nav-link">
              <i class="link-icon" data-feather="check-square"></i>
              <span class="link-title">Permission</span>
            </a>
          </li>
        @endif 
        @if(in_array("17", permission()))
          <li class="nav-item {{ active_class(['admin/application/*']) }} ">
            <a class="nav-link" data-bs-toggle="collapse" href="#email" role="button" aria-expanded="{{ is_active_route(['email/*']) }}" aria-controls="email">
              <i class="link-icon" data-feather="user"></i>
              <span class="link-title">Applications</span>
              <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['admin/application/*']) }}" id="email">
              <ul class="nav sub-menu">
                <li class="nav-item">
                  <a href="{{ route('application.pending') }}" class="nav-link {{ active_class(['admin/application/pending']) }}">Pending</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('application.reject') }}" class="nav-link {{ active_class(['admin/application/rejected']) }}">Rejected</a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('application.select') }}" class="nav-link {{ active_class(['admin/application/selected']) }}">Selected</a>
                </li>
              </ul>
            </div>
          </li>
        @endif
        @if(in_array("21", permission()))
          <li class="nav-item {{ active_class(['admin/interview']) }} ">
            <a href="{{ route('interview.dashboard') }}" class="nav-link">
              <i class="link-icon" data-feather="user-check"></i>
              <span class="link-title">Interviews</span>
            </a>
          </li>
        @endif
        @if(in_array("25", permission()))
        <li class="nav-item {{ active_class(['admin/department']) }} ">
          <a href="{{ route('department.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="cpu"></i>
            <span class="link-title">Department</span>
          </a>
        </li>
        @endif
        @if(in_array("29", permission()))
        <li class="nav-item {{ active_class(['admin/review']) }} ">
          <a href="{{ route('review.dashboard') }}" class="nav-link">
            <i class="link-icon" data-feather="clipboard"></i>
            <span class="link-title">Review</span>
          </a>
        </li>
        @endif
        @endif
      @endif
    </ul>
  </div>
</nav>
