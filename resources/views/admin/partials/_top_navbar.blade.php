<style>
  .menu-link {
    color: #fff !important;
    padding: 10px 20px;
    border-radius: 5px;
    transition: background 0.3s ease;
  }

  .menu-link:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #fff !important;
  }

  /* Desktop dropdown styles */
  .nav-item.dropdown {
    position: relative;
  }

  .nav-item .dropdown-menu1 {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    min-width: 180px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    z-index: 1000;
  }

  .nav-item .dropdown-menu1 .dropdown-item {
    display: block;
    padding: 8px 15px;
    color: #333;
    text-decoration: none;
  }

  .nav-item .dropdown-menu1 .dropdown-item:hover {
    background: #f5f5f5;
  }
  
  /* Show on hover (desktop only) */
  @media (min-width: 992px) {
    .nav-item.dropdown:hover .dropdown-menu1 {
      display: block;
    }
  }

  /* Mobile styles */
  @media (max-width: 991.98px) {
    .navbar-nav {
      text-align: left;
    }
    
    .nav-item .dropdown-menu1 {
      position: static;
      display: none;
      border: none;
      box-shadow: none;
      background: rgba(255, 255, 255, 0.1);
      margin-left: 20px;
    }
    
    .nav-item .dropdown-menu1.show {
      display: block;
    }
    
    .nav-item .dropdown-menu1 .dropdown-item {
      color: #fff;
      padding: 8px 15px;
    }
    
    .nav-item .dropdown-menu1 .dropdown-item:hover {
      background: rgba(255, 255, 255, 0.2);
    }
    
    .menu-link {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    .menu-link::after {
      content: '▼';
      font-size: 10px;
      margin-left: 5px;
    }

    /* Center alignment for mobile */
    .navbar-collapse {
      text-align: center;
    }
  }

  /* Toggle button styling */
  .navbar-toggler {
    border: 1px solid rgba(255, 255, 255, 0.3);
  }
  
  .navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
  }

  /* Ensure navbar stays on top */
  .main-header {
    position: sticky;
    top: 0;
    z-index: 1030;
  }

  /* Custom layout for desktop */
  @media (min-width: 992px) {
    .navbar-container {
      display: flex;
      align-items: center;
      width: 100%;
    }
    
    .navbar-brand-section {
      flex: 0 0 auto;
      margin-right: 2rem;
    }
    
    .navbar-menu-section {
      flex: 1;
      display: flex;
      justify-content: center;
    }
    
    .navbar-user-section {
      flex: 0 0 auto;
      margin-left: auto;
    }
    
    .center-menu {
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .center-menu .navbar-nav {
      flex-wrap: nowrap;
      justify-content: center;
    }
  }

  /* Mobile layout */
  @media (max-width: 991.98px) {
    .navbar-container {
      width: 100%;
    }
    
    .navbar-brand-section {
      flex: 1;
    }
    
    .navbar-menu-section {
      width: 100%;
    }
    
    .center-menu .navbar-nav {
      text-align: center;
    }
  }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand-lg navbar-light" style="background-color:#2A9DC6;">
  <div class="container-fluid navbar-container">
    <!-- Logo - Left -->
    <div class="navbar-brand-section">
      <a class="navbar-brand" href="{{ route('dashboard')}}">
        <h2>Photo Framer</h2>
      </a>
    </div>

    <!-- Mobile toggle button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainMenu" 
            aria-controls="navbarMainMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Main Menu - Center -->
    <div class="collapse navbar-collapse navbar-menu-section" id="navbarMainMenu">
      <div class="center-menu">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="{{ route('dashboard')}}" class="nav-link menu-link">
              <b>Dashboard</b>
            </a>
          </li>
          
           <li class="nav-item">
            <a href="{{ route('new-frame') }}" class="nav-link menu-link">
              <b>Frames</b>
            </a>
          </li>

          <li class="nav-item">
            <a href="" class="nav-link menu-link">
              <b>Uploaded Photos</b>
            </a>
          </li>

        


  
        </ul>
      </div>
    </div>

    <!-- User Dropdown - Right -->
    <div class="navbar-user-section">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="far fa-user"></i> ({{ optional(auth()->user())->name }})
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <span class="dropdown-item-text">
                <div><b>{{ optional(auth()->user())->name }}</b></div>
                <div class="small">{{ optional(auth()->user())->email }}</div>
              </span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{route('new-users')}}">Add New User</a></li>
            <li><a class="dropdown-item" href="{{route('all-users')}}">Manage All Users</a></li>
            <li><a class="dropdown-item" href="{{route('user-profile', optional(auth()->user())->id)}}">User Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{route('logout')}}">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- /.navbar -->

<!-- Bootstrap 5 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Enhanced dropdown functionality for better mobile experience
document.addEventListener('DOMContentLoaded', function() {
  const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
  
  dropdownToggles.forEach(toggle => {
    toggle.addEventListener('click', function(e) {
      if (window.innerWidth < 992) {
        e.preventDefault();
        const dropdownMenu = this.nextElementSibling;
        const isOpen = dropdownMenu.classList.contains('show');
        
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu1.show').forEach(menu => {
          if (menu !== dropdownMenu) {
            menu.classList.remove('show');
          }
        });
        
        // Toggle current dropdown
        if (!isOpen) {
          dropdownMenu.classList.add('show');
        } else {
          dropdownMenu.classList.remove('show');
        }
      }
    });
  });

  // Close dropdowns when clicking outside
  document.addEventListener('click', function(e) {
    if (window.innerWidth < 992 && !e.target.closest('.nav-item.dropdown')) {
      document.querySelectorAll('.dropdown-menu1.show').forEach(menu => {
        menu.classList.remove('show');
      });
    }
  });

  // Close dropdowns when window is resized to desktop
  window.addEventListener('resize', function() {
    if (window.innerWidth >= 992) {
      document.querySelectorAll('.dropdown-menu1.show').forEach(menu => {
        menu.classList.remove('show');
      });
    }
  });
});
</script>