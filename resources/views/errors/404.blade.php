@extends('layouts.template')

@section('title', 'Page not found!')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            404 - Page not found!
        </div>
    </section>
    <section id="coreContent" class="openSans">
        <h1 class="lm" style="text-align:center;">We couldn't find what you were looking for!</h1>
          <h2 style="font-style:italic;font-size: 160%;text-align:center;">But maybe a member of our community can.</h2><br />
          <p style="text-align: center;">Click <a href="/">here</a> to go back to the home page.</p><br />
    </section>
@endsection
