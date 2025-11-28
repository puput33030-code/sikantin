<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

<style>
  /* Menu aktif */
  #layout-menu .menu-item.menu-active > .menu-link {
    background-color: var(--bg);
    color: #000000;
    border-radius: 12px 30px 30px 12px; /* sudut kanan bulat */
    margin-right: -30px; /* “keluar” dari batas sidebar */
    box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
    position: relative;
    z-index: 2;
  }

  /* Lingkaran putih di belakang ikon */
  #layout-menu .menu-item.menu-active .menu-icon {
    background-color: #ffffff;
    color: #5e2dc4;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
  }

  /* Teks menu aktif */
  #layout-menu .menu-item.menu-active .menu-link div {
    color: #000000;
  }

  #layout-menu .menu-item:not(.menu-active) .menu-link div {
    color: #ffffff;
    transition: color 0.3s ease;
  }

  /* Hover efek umum */
  #layout-menu .menu-item:hover > .menu-link {
    background-color: rgba(255, 255, 255, 0.15);
    color: #000000;
    border-radius: 0 30px 30px 0;
  }

  /* Ikon default */
  #layout-menu .menu-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    transition: 0.3s ease;
  }

  /* Transisi halus */
  #layout-menu .menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 18px;
    transition: all 0.3s ease;
  }
    #layout-menu .menu-header .menu-header-text {
    color: #444141 !important; /* warna hitam */
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 1; /* biar tidak transparan */
    margin-top: 10px;
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
    <li class="menu-item {{ request()->routeIs('home') ? 'menu-active' : '' }}">
      <a href="{{ route('home') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-home"></i>
        <div data-i18n="Dashboard">Dashboard</div>
      </a>
    </li>

    <li class="menu-item {{ request()->routeIs('kasir.*') ? 'menu-active' : '' }}">
      <a href="{{ route('kasir.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="Data Kasir">Data Kasir</div>
      </a>
    </li>

    <!-- Apps & Pages -->
    <li class="menu-header small">
      <span class="menu-header-text" data-i18n="Pages">Pages</span>
    </li>

    <li class="menu-item {{ request()->routeIs('orderr.*') ? 'menu-active' : '' }}">
      <a href="{{ route('orderr.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-clipboard-list"></i>
        <div data-i18n="Data Pesanan">Data Pesanan</div>
      </a>
    </li>

    <li class="menu-item {{ request()->routeIs('menu.*') ? 'menu-active' : '' }}">
      <a href="{{ route('menu.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-burger"></i>
        <div data-i18n="Data Menu">Data Menu</div>
      </a>
    </li>

    <li class="menu-item {{ request()->routeIs('kategori.*') ? 'menu-active' : '' }}">
      <a href="{{ route('kategori.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-category"></i>
        <div data-i18n="Kategori Menu">Kategori Menu</div>
      </a>
    </li>

    <li class="menu-header small">
      <span class="menu-header-text" data-i18n="Laporan">Laporan</span>
    </li>

    <li class="menu-item {{ request()->routeIs('laporan.harian') ? 'menu-active' : '' }}">
      <a href="{{ route('laporan.harian') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-file"></i>
        <div data-i18n="Laporan">Laporan</div>
      </a>
    </li>
  </ul>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const menuItems = document.querySelectorAll('#layout-menu .menu-item');

      menuItems.forEach(item => {
        item.addEventListener('click', function () {
          // Hapus class aktif di semua
          menuItems.forEach(i => i.classList.remove('menu-active'));

          // Tambahkan class aktif di item yang diklik
          this.classList.add('menu-active');

          // Simpan state ke localStorage agar tetap aktif setelah reload
          localStorage.setItem('activeMenu', this.querySelector('.menu-link').getAttribute('href'));
        });
      });

      // Saat reload, aktifkan kembali menu terakhir
      const savedMenu = localStorage.getItem('activeMenu');
      if (savedMenu) {
        const activeItem = Array.from(menuItems).find(item => {
          const link = item.querySelector('.menu-link');
          return link && link.getAttribute('href') === savedMenu;
        });
        if (activeItem) {
          activeItem.classList.add('menu-active');
        }
      }
    });
  </script>

</aside>
