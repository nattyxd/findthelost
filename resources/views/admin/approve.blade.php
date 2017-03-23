@extends('layouts.template')

@section('title', 'Admin Approval')

@section('content')

      <section id="pageTagline">
          <div class="thePageTagLine">
            Invisible Items
        </div>
    </section>
    <div class="container-fluid">
        <div class="row" style="">
            <div class="col-xl-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="../img/eye.svg" width="35" height="35"/>Not visible to the public</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div id="lostItems">
        @if(session('success'))
            <div class="alert alert-success" style="width: 97%; margin: 0px auto 20px auto;font-size: 26px;">
                <strong>Success!</strong> {{session('success')}}
            </div>
        @endif
        @if (count($unapprovedItems) == 0)
        <div style="width: 100%; text-align: center; font-size: 32px; color: #000;font-weight: bold;color:#517445;">There are no more items waiting for your approval, nice!</div>
        @endif
        @foreach ($unapprovedItems as $item)  
        <div class="lostItem 
        <?php 
            if($item->lostitem == 1){
                echo ' lost">';
                }
            else{
                echo '">';
                }
            ?>
            <div class="lostItemImg"><img src="../{{$item->image_url}}" /></div>
            <div class="lostItemContent">
                <p><span style="font-weight: bold"><?php if($item->lostitem == 1){echo "Lost: ";}else{echo "Found: ";}?></span> {{$item->title}} ({{$item->category}}) <br /><img src="../img/location.svg" width="30" height="30" style="margin-top: -7px;"/><span style="font-weight: bold">&nbsp;{{$item->city}}</span></p>
                <p style="margin-top: -16px;font-size:22px;"><img src="../img/calendar.svg" width="25" height="25" style="float:left; margin-top:5px;margin-right: 10px;margin-left: 2px;"/>{{$item->created_at}}</p>
                <p style="font-size: 22px;font-weight: lighter;">{{$item->description}}</p>
                <form method="POST" action="/admin/invisibleitems/approve/{{$item->id}}" style="display:inline-block;">
                {{ csrf_field() }}
                <input type="submit" class="btn btn-success" style="font-size: 26px;" value="&#10003;" />
                </form>
                <form method="POST" action="/admin/invisibleitems/reject/{{$item->id}}" style="display:inline-block;">
                {{ csrf_field() }}
                <input type="submit" class="btn btn-danger" style="font-size: 26px;" value="&#10007;" />
                </form>                
                <a href="../view/{{$item->id}}"><button type="button" class="btn btn-primary" style="font-size: 22px;height:55px;">More Details</button></a>
            </div>
        </div>
        @endforeach
    </div>
@endsection
