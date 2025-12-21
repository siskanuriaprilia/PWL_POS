<div class="sidebar">
    <!-- User Profile at the Top -->
    <div class="user-profile text-center py-3">
        <a href="{{ url('/profile') }}" class="d-block {{ $activeMenu == 'profile' ? 'active' : '' }}">
            <img src="{{ Auth::check() && Auth::user()->profile_picture ? asset('uploads/profile/' . Auth::user()->profile_picture) : asset('profile.png') }}"
                 class="img-circle elevation-2"
                 alt="User Image"
                 style="width: 60px; height: 60px; object-fit: cover;">
            <p class="mt-2 mb-0 text-white">{{ Auth::check() ? Auth::user()->nama : 'Guest' }}</p>
        </a>
    </div>
    
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
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
            
            <!-- Menu Dashboard -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <!-- Data Pengguna (Hanya untuk Admin) -->
            @if(Auth::check() && Auth::user()->level_id == 1)
            <li class="nav-header">Data Pengguna</li>
            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Level User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Data User</p>
                </a>
            </li>
            @endif

            <!-- Data Barang -->
            <li class="nav-header">Data Barang</li>
            
            <!-- Kategori (Hanya Admin) -->
            @if(Auth::check() && Auth::user()->level_id == 1)
            <li class="nav-item">
                <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori') ? 'active' : '' }}">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Kategori Barang</p>
                </a>
            </li>
            @endif
            
            <!-- Barang (Admin & Manager) -->
            @if(Auth::check() && (Auth::user()->level_id == 1 || Auth::user()->level_id == 2))
            <li class="nav-item">
                <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang') ? 'active' : '' }}">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Data Barang</p>
                </a>
            </li>
            @endif

            <!-- Transaksi -->
            <li class="nav-header">Data Transaksi</li>
            
            <!-- Menu Manajemen Stok (Admin, Manager, Staff) -->
            @if(Auth::check() && (Auth::user()->level_id == 1 || Auth::user()->level_id == 2 || Auth::user()->level_id == 3))
            <li class="nav-item">
                <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <p>Manajemen Stok</p>
                </a>
            </li>
            @endif

            <!-- Laporan -->
            <li class="nav-header">Laporan</li>
            @if(Auth::check() && (Auth::user()->level_id == 1 || Auth::user()->level_id == 2 || Auth::user()->level_id == 3))
            <li class="nav-item">
                <a href="{{ url('/stok/report') }}" class="nav-link {{ ($activeMenu == 'laporan-stok' || $activeMenu == 'stok-report') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>Laporan Stok</p>
                </a>
            </li>
            @endif
            
            <!-- Akun -->
            <li class="nav-header">Akun</li>
            
            <!-- Profil -->
            <li class="nav-item">
                <a href="{{ url('/profile') }}" class="nav-link {{ ($activeMenu == 'profile') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profil</p>
                </a>
            </li>

            <!-- Logout -->
             <!-- Logout -->
        <li class="nav-item">
            <a href="{{ url('/logout') }}" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                <p>Logout</p>
            </a>
        </li>
    </li>
            
        </ul> <!-- Penutup ul nav -->
    </nav> <!-- Penutup nav -->
</div> <!-- Penutup sidebar -->