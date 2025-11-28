<!doctype html>
<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('/') }}"
  data-template="vertical-menu-template"
  data-style="light"
>
<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') | Aplikasi SiKantin</title>
  <meta name="description" content="" />

  <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('/img/favicon/logo.png') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('/vendor/fonts/fontawesome.css') }}" />
  <link rel="stylesheet" href="{{ asset('/vendor/fonts/tabler-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('/vendor/fonts/flag-icons.css') }}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('/css/demo.css') }}" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('/vendor/libs/node-waves/node-waves.css') }}" />
  <link rel="stylesheet" href="{{ asset('/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('/vendor/libs/typeahead-js/typeahead.css') }}" />
  <link rel="stylesheet" href="{{ asset('/vendor/libs/@form-validation/form-validation.css') }}" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="{{ asset('/vendor/css/pages/page-auth.css') }}" />

  <!-- Helpers -->
  <script src="{{ asset('/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('/vendor/js/template-customizer.js') }}"></script>
  <script src="{{ asset('/js/config.js') }}"></script>

  @stack('styles')
  
</head>

<body>

  <!-- === KONTEN UTAMA === -->
  <div id="main-content">
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content')
          </div>
          <div class="content-backdrop fade"></div>
        </div>
        <!-- /Content wrapper -->

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area -->
        <div class="drag-target"></div>
      </div>
    </div>
  </div>

  <!-- === SCRIPT VENDOR === -->
  <script src="{{ asset('/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('/vendor/libs/node-waves/node-waves.js') }}"></script>
  <script src="{{ asset('/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('/vendor/libs/hammer/hammer.js') }}"></script>
  <script src="{{ asset('/vendor/libs/i18n/i18n.js') }}"></script>
  <script src="{{ asset('/vendor/libs/typeahead-js/typeahead.js') }}"></script>
  <script src="{{ asset('/vendor/js/menu.js') }}"></script>
  <script src="{{ asset('/js/main.js') }}"></script>

  @stack('scripts')
</body>
</html>