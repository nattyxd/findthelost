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
                    <div class="panel-heading-text"><img src="img/cog.svg" width="35" height="35"/>Quick Actions</div>
                </div>

                <div class="panel-body" class="openSans">
                    <div class="panel-body-text">
                        View my approved items
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
