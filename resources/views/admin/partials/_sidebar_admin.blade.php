 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
     <div style="text-align:left;">
      <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{asset('public_assets/images/logos/logo.png')}}" alt="Logo" width="150">
      </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('admin_assets/male.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info" style="margin-top: -10px;">
          <a href="#" class="d-block">{{ optional(auth()->user())->name }}</a>
          <div style="color:#ccc; font-size: 12px;">User Type: {{ optional(auth()->user())->user_type }}</div>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline" style="padding-top:0px;">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{route('all-projects')}}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-header" style="color:#F04473">PROJECTS</li>
          <li class="nav-item">
            <a href="{{route('all-projects')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                All Projects
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('add-new-projects')}}" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Add New Project
              </p>
            </a>
          </li>
       
          <li class="nav-header" style="color:#F04473">VENDORS</li>
          <li class="nav-item">
            <a href="{{route('add-new-vendor')}}" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Add New Vendor
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/gallery.html" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                All Vendors
              </p>
            </a>
          </li>
          <li class="nav-header" style="color:#F04473">PAYMENT & RECEIVE</li>
          <li class="nav-item">
            <a href="pages/kanban.html" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Payment
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/kanban.html" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Received
              </p>
            </a>
          </li>

       
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>