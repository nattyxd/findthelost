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
