@extends('layouts.template')

@section('title', 'My Account')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            {!! strstr(Auth::user()->name . ' ', ' ', true ) !!} 's Dashboard
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
                            <ul style="font-size: 22px;">
                                <li><a href={{url('/add')}}>Add a new item to the system</a></li>
                                <li>View my approved items</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
