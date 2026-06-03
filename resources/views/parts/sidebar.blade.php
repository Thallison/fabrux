 <aside class="app-sidebar bg-body-secondary shadow fabrux-sidebar" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="{{ url('/') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="{{ Vite::asset('resources/images/AdminLTELogo.png') }}"
              alt="{{ config('app.name', 'Laravel') }} Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-semibold">Fabrux</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        {!! Modules\Base\Helpers\Menu::navigation() !!}
        <!--end::Sidebar Wrapper-->
      </aside>