            <!--@if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif-->
<!DOCTYPE HTML>
<html lang="{{ config('app.locale') }}">
  <head>
    <title>Hi</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/app.css"/>
    <link rel="stylesheet" href="css/main.css"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <header>
      <div id="logo"><a href="#"><span class="logoGreen italic openSans reducedSpacing">fi</span><span class="italic openSans">l</span><span class="italic openSans minus2px">o</span><span style="font-size: 50%;">&nbsp;</span>:<span style="font-size: 50%;">&nbsp;</span><span class="logoGreen veryReducedSpacing">find</span><span class="minus2px reducedSpacing">the</span><span class="minus3px veryReducedSpacing" style="font-weight: 300;">lost</span></a></div>
      <nav class="openSans">
        <ul>
          <li><a href="#">View Items</a></li>
          <?php
              $user = Auth::user();
              if($user == null){
                echo '<li><a href="' . route('login') . '">Log In</a></li>';
                echo '<li><a href="' . route('register') . '">Register</a></li>';
              }
              else{
                echo "<li><img src='img/generic_user.svg' width='40' height='40' /> &nbsp;" . strstr(Auth::user()->name . ' ', ' ', true ) . "'s account</li>";
                echo '<li><a href="' . route('logout') . '">Logout</a></li>';
              }
            ?>
        </ul>
      </nav>
    </header>
    <main>
      <section id="topSplash">
        <div id="splashBoxContainer">
          <div id="splashBox">
            <div id="splashBoxHeadText" class="lm"><h1>Accidents happen</h1></div>
            <div id="splashBoxMainText">
              <p class="openSans">Everyday, hundreds and thousands of valuable items are lost from home, trains, and airports etc. Many of those lost items are never returned to their owners because it is just very difficult to link a lost item to the owner.</p>
            </div>
          </div>
        </div>
      </section>
      <section id="pageTagline">
          <div class="thePageTagLine">
            Introducing <span class="logoGreen italic openSans reducedSpacing">fi</span><span class="italic openSans">l</span><span class="italic openSans minus2px">o</span>
          </div>
      </section>
      <section id="coreContent" class="openSans">
        <h1 class="lm" style="margin-bottom: 10px">How do we do it?</h1>
        <p>
"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
 incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
 nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
 Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
culpa qui officia deserunt mollit anim id est laborum."
        </p>
      </section>
    </main>
  </body>
</html>
