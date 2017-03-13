@extends('layouts.template')

@section('title', 'Admin Approval')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            Approve and reject items
        </div>
    </section>
    <div class="container-fluid">
        <div class="row" style="">
            <div class="col-xl-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="../img/magnify.svg" width="35" height="35"/>Here are items waiting for your approval</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div id="lostItems">
    @if (count($unapprovedItems) == 0)
        <div style="width: 100%; text-align: center; font-size: 32px; color: #000;font-weight: bold;padding-bottom: 30px;">Oh no! Try searching with different parameters, or subscribe to this feed using Pusher.</div>
    @endif
    @foreach ($unapprovedItems as $item)  
        <div class="lostItem 
        <?php 
            // dd($item->lostitem);
            if($item->lostitem == 1){
                echo ' lost">';
                // dd("Got here");
                }
            else{
                echo '">';
                }
            ?>
            <div class="lostItemImg"><img src="../{{$item->image_url}}" width="300" height="200" /></div>
            <div class="lostItemContent">
                <p><span style="font-weight: bold"><?php if($item->lostitem == 1){echo "Lost: ";}else{echo "Found: ";}?></span> {{$item->title}} ({{$item->category}}) <img src="../img/location.svg" width="30" height="30" style="margin-top: -7px"/><span style="font-weight: bold">{{$item->city}}</span></p>
                <p style="margin-top: -16px;font-size:22px;"><img src="../img/calendar.svg" width="25" height="25" style="float:left; margin-top:5px;margin-right: 10px;"/>Submitted on {{$item->created_at}}</p>
                <p style="font-size: 22px;font-weight: lighter;">{{$item->description}}</p>
                <button type="button" class="btn btn-success" style="font-size: 22px;">Approve</button>
                <button type="button" class="btn btn-danger" style="font-size: 22px;">Reject</button>
                
            </div>
        </div>
    @endforeach
    </div>
@endsection
