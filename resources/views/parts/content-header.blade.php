<div class="app-content-header fabrux-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row align-items-center g-3">
        <div class="col-sm-6">
            @hasSection ('page-title')
            <h3 class="mb-1">@yield('page-title')</h3>
            @endif
            
            @isset($breadcrumbs)
            <ol class="breadcrumb mb-0">
                @foreach ($breadcrumbs as $item)
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                </li>
                @endforeach
            </ol>
            @endisset
        </div>
        <div class="col-sm-6 text-sm-end d-none d-sm-block">
            <span class="fabrux-page-date">
                <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
            </span>
        </div>
    </div>
    <!--end::Row-->
    </div>
    <!--end::Container-->
</div>