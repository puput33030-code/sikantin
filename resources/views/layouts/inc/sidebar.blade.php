        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <style>
    /* Menu aktif atau terbuka */
    #layout-menu .menu-item.active > .menu-link,
    #layout-menu .menu-item.open > .menu-link {
      background-color: #ffffff !important;
      color: #000000 !important;
      box-shadow: none !important;
      border-radius: 0.375rem !important;
    }

    /* Warna ikon dan teks di menu aktif */
    #layout-menu .menu-item.active .menu-icon,
    #layout-menu .menu-item.active .menu-link div,
    #layout-menu .menu-item.open .menu-icon,
    #layout-menu .menu-item.open .menu-link div {
      color: #000000 !important;
    }

    /* Hilangkan garis biru bawaan Vuexy */
    #layout-menu .menu-item.active > .menu-link::before,
    #layout-menu .menu-item.open > .menu-link::before {
      background-color: transparent !important;
    }

    /* Hover tetap lembut */
    #layout-menu .menu-item:hover > .menu-link {
      background-color: #f8f8f8 !important;
      color: #000000 !important;
    }

    /* Saat menu sedang dibuka oleh Vuexy (transisi open) */
    #layout-menu .menu-item.active.open:not(.menu-item-closing) > .menu-link {
      background-color: #ffffff !important;
      color: #000000 !important;
    }
  </style>
          <div class="app-brand demo">
            <a href="" class="app-brand-link">
              <div class="mt-3 mb-3" style="text-align: center;">
                <img src="{{ asset('img/avatars/logo.jpg') }}"
                    alt="Logo"
                    class="rounded-circle"
                    style="width: 50px; height: 50px; object-fit: cover;">
              </div>
              <span class="app-brand-text demo menu-text fw-bold">SiKantin</span>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboards -->
            <li class="menu-item {{ request()->routeIs('home') ? 'active open' : '' }}">
              <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
              </a>
            </li>

            <li class="menu-item {{ request()->routeIs('kasir.*') ? 'active open' : '' }}">
              <a href="{{ route('kasir.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Data Kasir">Data Kasir</div>
              </a>

            <!-- Apps & Pages -->
            <li class="menu-header small">
              <span class="menu-header-text" data-i18n="Pages">Pages</span>
            </li>
            <li class="menu-item {{ request()->routeIs('orderr.*') ? 'active open' : '' }}">
              <a href="{{ route('orderr.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-clipboard-list"></i>
                <div data-i18n="Data Pesanan">Data Pesanan</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('menu.*') ? 'active open' : '' }}">
              <a href="{{ route('menu.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-burger"></i>
                <div data-i18n="Data Menu">Data Menu</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('kategori.*') ? 'active open' : '' }}">
              <a href="{{ route('kategori.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-category"></i>
                <div data-i18n="Kategori Menu">Kategori Menu</div>
              </a>
            </li>
            <li class="menu-header small">
              <span class="menu-header-text" data-i18n="Laporan">Laporan</span>
            </li>
            <li class="menu-item {{ request()->routeIs('laporan.harian') ? 'active open' : '' }}">
              <a href="{{ route('laporan.harian') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-file"></i>
                <div data-i18n="Laporan">Laporan</div>
              </a>
            </li>
          </ul>
        </aside>