@extends('layouts.template')

@section('title', 'View Item')

@section('aestheticHeader')

@stop

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            {{$itemToView->title}}
          </div>
      </section>
    <div class="container-fluid">
        <div class="row" style="">
            <div class="col-xl-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="../img/info.svg" width="35" height="35"/><b><?= ($itemToView->lostitem === 1) ? 'Lost' : 'Found' ?></b> Item Details</div>
                    </div>
                    <div class="panel-body openSans responsiveCoreContent">
                        <div class="panel-body-text">
                            @if (!empty($success))
                                <div class="alert alert-success">
                                    {{ $success }}
                                </div>
                            @endif
                            <div style="float: left;">
                                <p><strong><div style="display:inline-block;height:1px;width:106px;"></div>Image:&nbsp;</strong><a href="../{{$itemToView->image_url}}"><img src="../{{$itemToView->image_url}}" width="120" height="68"/></p></a>
                                <p><strong><div style="display:inline-block;height:1px;width:76px;"></div>Category:&nbsp;</strong>{{$itemToView->category}}</p>
                                <p><strong><div style="display:inline-block;height:1px;width:50px;"></div>Description:&nbsp;</strong>{{$itemToView->description}}</p>
                                <p><strong><div style="display:inline-block;height:1px;width:74px;"></div>Reunited:&nbsp;</strong>{{$itemToView->reunited == 1 ? 'Yes' : 'No'}}</p>
                                <p><strong><div style="display:inline-block;height:1px;width:28px;"></div>Lost or found:&nbsp;</strong>{{$itemToView->lostitem == 1 ? 'Lost' : 'Found'}}</p>
                                <p><strong><div style="display:inline-block;height:1px;width:15px;"></div>Address Line 1:&nbsp;</strong>{{$itemToView->addressline1}}</p>
                                <p><strong><div style="display:inline-block;height:1px;width:15px;"></div>Address Line 2:&nbsp;</strong>{{$itemToView->addressline2 == null ? "&nbsp;" : $itemToView->addressline2}}</p>{{-- these can be null, so need to check and append a space if so for alignment reason --}}
                                <p><strong><div style="display:inline-block;height:1px;width:15px;"></div>Address Line 3:&nbsp;</strong>{{$itemToView->addressline3 == null ? "&nbsp;" : $itemToView->addressline3}}</p>
                                <p><strong><div style="display:inline-block;height:1px;width:126px;"></div>City:&nbsp;</strong>{{$itemToView->city}}</p>
                                <p><strong><div style="display:inline-block;height:1px;width:70px;"></div>Postcode:&nbsp;</strong>{{$itemToView->postcode}}</p>
                                <p><strong><div style="display:inline-block;height:1px;width:47px;"></div>Created On:&nbsp;</strong>{{$itemToView->created_at}}</p>
                                <p><strong>Last Updated At:&nbsp;</strong>{{$itemToView->updated_at}}</p>
                                <p><strong><div style="display:inline-block;height:1px;width:14px;"></div>Publicly Visible:&nbsp;</strong>{{$itemToView->approved == 1 ? 'Yes' : 'No'}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="../img/info.svg" width="35" height="35"/>Item Request</div>
                    </div>
                    <div class="panel-body openSans responsiveCoreContent">
                        <div class="panel-body-text">
                            @if(!Auth::user())
                                <div class="alert alert-warning">
                                    <strong>Not Logged In!</strong> You need to be logged in to view information regarding requests.
                                </div>
                            @else
                                {{-- user is logged in --}}
                                {{--dd($privileges)--}}
                                @if ($requests === null)
                                    {{-- No requests to display + authed user = we show them the form to submit a request --}}
                                    @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    @if($itemToView->lostitem === 1)
                                        <div class="alert alert-info">
                                            <strong>Someone misses this item :(</strong> Have you found it? Let us know.
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <strong>So you've lost this item?</strong> Submit a request for it here, and get reunited with it.
                                        </div>
                                    @endif
                                        {!! Form::open(['action' => array('HomeController@submititemrequest', $itemToView->id), 'files' => true]) !!}
                                        <div class="floatLeft" style="text-align: right;margin-right: 15px;">
                                            <p>{{Form::label('reason', 'Reason for request*: ')}}</p>
                                            <p>{{Form::label('photo', 'Supporting Image: ')}}</p>
                                        </div>
                                        <div class="floatLeft">
                                            <p>{{Form::text('reason')}}</p>
                                            <p>{{Form::file('photo')}}</p>
                                            <p>{{Form::submit('Submit')}}</p>
                                        </div>
                                        {!! Form::close() !!}
                                @else
                                    {{-- The requests were not null, so we need to echo each request we have --}}
                                    @if ($privileges == "administrator")
                                        <div class="alert alert-warning">
                                            <strong>Information: </strong> Administrators cannot submit item requests.
                                        </div>
                                    @endif
                                    @if (count($requests) == 0)
                                        <div class="alert alert-info">
                                            <strong>No requests: </strong> There are no requests for this item yet.
                                        </div>                                    
                                    @endif
                                    <div class="lostItems">
                                    @foreach ($requests as $request)
                                        @if(in_array($privileges, ['administrator', 'all_readonly']) || Auth::user()->id == $request->user_id)
                                            {{-- We should show this request --}}
                                            {{--dd($request)--}}
                                            <div class="lostItem request">
                                                @if(!empty($request->image_url))
                                                <div class="lostItemImg">
                                                    <img src="../{{$request->image_url}}" />
                                                </div>
                                                @else
                                                <div class="lostItemImg">
                                                    <p style="text-align: center;line-height: 180px;font-weight: bold;">No picture!</p>
                                                </div>
                                                @endif
                                                <div class="lostItemContent">
                                                    <p>Request by: {{$request->user->email}} (Trust Level {{$request->user->trust}})</p>
                                                    <p style="margin-top: -16px;font-size:22px;"><img src="../img/calendar.svg" width="25" height="25" style="float:left; margin-top:5px;margin-right: 10px;margin-left: 2px;"/>{{$request->created_at}}</p>
                                                    <p>Request Reason: {{$request->reason}}</p>
                                                    <p>Admin Response: 
                                                        <?php
                                                            if($request->adminhandled == 0){
                                                                echo "None Yet";
                                                            }
                                                            else{
                                                                if($request->approved == 0){
                                                                    echo "<font color='red'>Rejected</font>";
                                                                }
                                                                else{
                                                                    echo "<font color='green'>Approved!</font>";
                                                                }
                                                            }
                                                        ?>
                                                    </p>
                                                    @if ($privileges == "administrator")
                                                    {!! Form::open(['action' => array('AdminController@approverequestid', $request->id)]) !!}
                                                        <input type="submit" class="btn btn-success" style="font-size: 26px;width:80px;height:80px;float:left;margin-right:10px;" value="&#10003;" />
                                                    {!! Form::close() !!}
                                                    <form method="POST" action="/admin/invisibleitems/reject/{{$request->id}}" style="display:inline-block;">
                                                        <input type="submit" class="btn btn-danger" style="font-size: 26px;width:80px;height:80px;float:left;" value="&#10007;" />
                                                    </form>  
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop