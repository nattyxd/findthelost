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
                    <div class="panel-body openSans" style="font-size: 22px;">
                        <div class="panel-body-text">
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
                </div>
            </div>
        </div>
    </div>
@stop