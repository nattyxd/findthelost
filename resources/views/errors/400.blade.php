@extends('layouts.template')

@section('title', 'Bad Request')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            400 - Bad Request
        </div>
    </section>
    <section id="coreContent" class="openSans">
        <h1 class="lm" style="text-align:center;">This is awkward!</h1>
          <h2 style="font-style:italic;font-size: 160%;text-align:center;">You submitted a bad request. If this keeps happening, we probably did something wrong, so let us know.</h2><br />
          <p style="text-align: center;">Click <a href="/">here</a> to go back to the home page.</p><br />
    </section>
@endsection
