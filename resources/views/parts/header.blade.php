 <nav class="app-header navbar navbar-expand bg-body fabrux-topbar border-bottom-0 shadow-sm">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Start Navbar Links-->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                <i class="bi bi-list"></i>
              </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="/" class="nav-link">Painel</a></li>
          </ul>
          <!--end::Start Navbar Links-->
          <!--begin::End Navbar Links-->
          <ul class="navbar-nav ms-auto">
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
              <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
              </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
              <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
                <span class="fabrux-user-avatar" aria-hidden="true">{{ mb_substr(Auth::user()->usr_name, 0, 1) }}</span>
                <span class="d-none d-md-inline">{{ Auth::user()->usr_name }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary fabrux-user-header">
                  <p>
                    {{ Auth::user()->usr_name }}
                    <small>Membro desde {{ucfirst(Auth::user()->usr_dt_criacao->translatedFormat('F Y')) }}</small>
                  </p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Footer-->
                <li class="user-footer">
                  <form action="{{ route('logout') }}" method="POST" >
                    @csrf
                    <button type="submit" class="btn btn-default btn-flat float-end">
                      Sair
                    </button>
                    <a href="{{ route('seguranca::configUsuario') }}" class="btn btn-default btn-flat">Alterar Senha</a>
                  </form>
                </li>
                <!--end::Menu Footer-->
              </ul>
            </li>
            <!--end::User Menu Dropdown-->
          </ul>
          <!--end::End Navbar Links-->
        </div>
        <!--end::Container-->
      </nav>