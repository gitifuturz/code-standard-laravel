<!DOCTYPE html>
<html class="bootstrap-layout">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>

  <!-- Global CSS -->
  @include('_includes.css')

  <!-- Page specific CSS -->
  @yield('page-css')

</head>

<body class="layout-container ls-top-navbar si-l3-md-up">

  @include('_includes.nav')

  @include('_includes.sidebar')

  <!-- Right Sidebars -->


  <!-- Content -->
  <div class="layout-content" data-scrollable>
    <div class="container-fluid">

      @include('_includes.breadcrumb')


      @yield('content')

  </div>

  <!-- Global Scripts -->
  @include('_includes.scripts')

  <!-- Page specific scripts -->
  @yield('page-scripts')

  <!-- Page JS -->

  @yield('page-js')

</body>

</html>