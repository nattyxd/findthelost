@extends('layouts.template')

@section('title', 'My Account')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            {{strstr(Auth::user()->name . ' ', ' ', true )}} 's Dashboard
          </div>
      </section>
<div class="container-fluid">
    <div class="row" style="">
        <div class="col-xl-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-heading-text">Quick Actions</div>
                </div>

                <div class="panel-body" class="openSans">
                    <div class="panel-body-text">
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
