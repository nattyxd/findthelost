@extends('layouts.template')

@section('title', 'My Account')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            {!! strstr(Auth::user()->name . ' ', ' ', true ) !!} 's Dashboard
        </div>
    </section>
    <div class="alert alert-warning" style="font-size: 32px;margin-bottom:0px;text-align:center;">
        <strong>Stay safe!</strong> For your safety, please only meet up with filo members in busy public locations.
    </div>
    @if ((Auth::user()->trust < 200) && (Auth::user()->userlevel !== 1))
    <div class="alert alert-info" style="font-size: 32px;margin-bottom:0px;text-align:center;">
        <strong>Welcome!</strong> Your trust rating is currently <strong>{{Auth::user()->trust}}</strong>. An administrator will approve your items until you have built up trust. Enjoy using filo!
    </div>
    @elseif ((Auth::user()->trust >= 200) && (Auth::user()->userlevel !== 1))
    <div class="alert alert-success" style="font-size: 32px;margin-bottom:0px;text-align:center;">
        <strong>Wow!</strong> Your trust rating is currently <strong>{{Auth::user()->trust}}</strong>, thanks for being such a valued member of our community!
    </div>
    @endif
    
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
                                <li>Edit my account information</li>
                            </ul>
                        </div>
                    </div>

                    @if (Auth::user()->userlevel === 1) {{-- Only show Administrator Tasks to admins --}}
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="img/cog.svg" width="35" height="35"/>Administrator Tasks</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text">
                            <ul style="font-size: 22px;">
                                <li><a href={{url('/admin/invisibleitems')}}>Approve or reject items</a></li>
                                <li><a href={{url('/admin/itemrequests')}}>View items with unhandled requests</a></li>
                                <li><a href={{url('/admin/invisibleitems')}}>View/Edit/Message a user of the system</a></li>
                                
                            </ul>
                        </div>
                    </div>

                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="img/cog.svg" width="35" height="35"/>View/Edit/Message Users</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text">
                            Hello
                        </div>
                    </div>

                    
                    @endif

                    
                </div>
            </div>
        </div>
    </div>
@endsection
