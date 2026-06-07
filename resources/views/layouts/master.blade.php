<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  {{-- <title>InApp Inventory Dashboard</title> --}}
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="{{ asset('assets/images/logo-icon.svg') }}">
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo-icon.svg') }}">

</head>

<body>
  <div id="overlay" class="overlay"></div>

    @include('layouts.sidebar')

    <div id="main-content" class="main-content">
        @include('layouts.header')

        {{-- @include('layouts.jadwal') --}}

        @yield('content')

        @include('layouts.footer')
    </div>

    
</body>

</html>