@extends('layouts.template')

@section('title', 'Internal Server Error')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            500 - Internal Server Error
        </div>
    </section>
    <section id="coreContent" class="openSans">
        <h1 class="lm" style="text-align:center;">This is awkward!</h1>
          <h2 style="font-style:italic;font-size: 160%;text-align:center;">An internal server error occured.</h2><br />
          <p style="text-align: center;">Click <a href="/">here</a> to go back to the home page.</p><br />
    </section>
@endsection
