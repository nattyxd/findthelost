@extends('layouts.template')

@section('title', 'My Account')

@section('content')

      <section id="pageTagline">
          <div class="thePageTagLine">
            My Account
        </div>
    </section>
    <div class="container-fluid">
        <div class="row" style="">
            <div class="col-xl-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="../img/magnify.svg" width="35" height="35"/>View your account information</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text">
                            <div style="text-align: center;">
                                <p><h1>{{$user->name}}</h1></p>
                                <p><h2>{{$user->email}}</h1></p>
                                <p><h3>Trust level: {{$user->trust}}</h3></p>
                                <a href="/myitems"><button type="button" class="btn btn-success" style="margin-top: 15px;font-size: 22px;padding:20px 80px">View My Items</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
