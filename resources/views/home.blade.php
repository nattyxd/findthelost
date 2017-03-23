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
                            <ul style="font-size: 22px;padding:0;list-style-type:none;">
                                <li>
                                    <a href={{url('/add')}}>
                                        <div class="homeItem homeItemPlus">
                                            <div class="homeItemImg plusBg" style="background-color: #DAF1C4"></div>
                                            <div class="homeItemText" style="background-color: #DAF1C4">Add a new item</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href={{url('/lostitems')}}>
                                        <div class="homeItem homeItemViewAllItems">
                                            <div class="homeItemImg viewAllItemsBg" style="background-color: #4E9797"></div>
                                            <div class="homeItemText" style="background-color: #4E9797">View items in the system</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href={{url('/myitems')}}>
                                        <div class="homeItem homeItemMyItems">
                                            <div class="homeItemImg myItemsBg" style="background-color: #6EACD5"></div>
                                            <div class="homeItemText" style="background-color: #6EACD5">My items</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href={{url('/myaccount')}}>
                                        <div class="homeItem homeItemMyAccount">
                                            <div class="homeItemImg myAccountBg" style="background-color: #6b363e"></div>
                                            <div class="homeItemText" style="background-color: #6b363e">My account</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if (Auth::user()->userlevel === 1) {{-- Only show Administrator Tasks to admins --}}
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="img/cog.svg" width="35" height="35"/>Administrator Tasks</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text">
                            <ul style="font-size: 22px;padding:0;list-style-type:none;">
                                <li>
                                    <a href={{url('/admin/invisibleitems')}}>
                                        <div class="homeItem homeItemHidden">
                                            <div class="homeItemImg hiddenBg" style="background-color: #6EACD5"></div>
                                            <div class="homeItemText" style="background-color: #6EACD5">Publish/Remove Hidden Items</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href={{url('/admin/itemrequests')}}>
                                        <div class="homeItem homeItemAttention">
                                            <div class="homeItemImg attentionBg" style="background-color: #F09595"></div>
                                            <div class="homeItemText" style="background-color: #F09595">Unhandled item claims</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href={{url('/admin/users')}}>
                                        <div class="homeItem homeItemManage">
                                            <div class="homeItemImg manageBg" style="background-color: #0495b0"></div>
                                            <div class="homeItemText" style="background-color: #0495b0">Manage Users</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>                    
                    @endif

                    
                </div>
            </div>
        </div>
    </div>
@endsection
