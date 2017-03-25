<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - filo : findthelost</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <header>
      <div id="logo">@if(Auth::user())
        <a href={{url('/home')}}>
        @else
        <a href={{url('/')}}>
        @endif
        <span class="logoGreen italic openSans reducedSpacing">fi</span><span class="italic openSans">l</span><span class="italic openSans minus2px">o</span><span style="font-size: 50%;">&nbsp;</span>:<span style="font-size: 50%;">&nbsp;</span><span class="logoGreen veryReducedSpacing">find</span><span class="minus2px reducedSpacing">the</span><span class="minus3px veryReducedSpacing" style="font-weight: 300;">lost</span></a></div>
      <nav class="openSans">
        <ul>
          <a href="{{url('lostitems')}}"><li>View Items</li></a>
          <?php
              $user = Auth::user();
              if($user == null){
                echo '<a href="' . route('login') . '"><li>Log In</li></a>';
                echo '<a href="' . route('register') . '"><li>Register</li></a>';
              }
              else{
                echo "<a href='" . url("/home") . "'><li><img src='". asset('img/generic_user.svg') . "' width='40' height='40' /> &nbsp; My Dashboard</li></a>";
                echo '<a href="' . route('logout') . '"><li>Logout</li></a>';
              }
            ?>
        </ul>
      </nav>
    </header>
    <main>
      @yield('aestheticHeader')
      @yield('content')
    </main>
    <footer>
      <p style="margin: 0">&copy; Nathaniel Baulch-Jones, 2017 - Aston University Undergraduate - CS2410 Coursework - Created with ♥ and ☕ in Birmingham, UK</p>
    </footer>
  </body>
</html>
