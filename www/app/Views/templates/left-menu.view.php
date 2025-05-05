<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo $_ENV['host.folder'] ?>" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'inicio' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li> 
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?php echo (in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'demo-proveedores'])) ? 'menu-open' : '';?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panel de control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $_ENV['host.folder'] ?>demo-proveedores" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'demo-proveedores' ? 'active' : ''; ?>">
                  <i class="fas fa-laptop-code nav-icon"></i>
                  <p>Demo Proveedores</p>
                </a>
              </li>              
            </ul>
          </li>
            <li class="nav-item">
                <a href="<?php echo $_ENV['host.folder']."proveedores" ?>" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                    </svg>
                    <p>
                        Proveedores
                    </p>
                </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->