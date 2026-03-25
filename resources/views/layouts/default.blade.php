<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    
    <meta name="title" content="{{ config('app.name', 'Laravel') }}" />
    <meta name="author" content="TMSystem" />
    
    <meta name="supported-color-schemes" content="light dark" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    
  </head>
  
  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary sidebar-mini">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
     @include('parts.header')
      <!--end::Header-->
      <!--begin::Sidebar-->
     @include('parts.sidebar')
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        @include('parts.content-header')
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div id="content_area" class="container-fluid">
            
            @if(session('message'))
            <div class="alert alert-{{ session('message.type') }} flash-msg">
                {{ session('message.text') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @yield('content')

            <div id="modal-default-sistema"></div>

          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      @include('parts.footer')
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
    <!--begin::Script-->
    @stack('scripts')
    <script>
       /* setTimeout(() => {
        document.querySelectorAll('.flash-msg').forEach(el => {
            el.remove();
        });
    }, 4000);*/
    </script>
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>