@extends('layouts.template')

@section('title', 'Permission Denied!')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            403 - Permission Denied!
        </div>
    </section>
    <section id="coreContent" class="openSans">
        <h1 class="lm" style="text-align:center;">You don't have permission to view this resource!</h1>
          <h2 style="font-style:italic;font-size: 160%;text-align:center;">You may need to log into an account with higher privileges to perform that action.</h2><br />
          <p style="text-align: center;">Click <a href="/">here</a> to go back to the home page.</p><br />
    </section>
@endsection
