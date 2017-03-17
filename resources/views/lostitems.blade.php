@extends('layouts.template')

@section('title', 'View lost goods')

@section('aestheticHeader')

@stop

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            Lost property
          </div>
      </section>
    <div class="container-fluid">
        <div class="row" style="">
            <div class="col-xl-12">
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="img/filter.svg" width="35" height="35"/>Filter items (new search)</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text lostItemForm" style="margin-top: -30px">
                          <form action="/lostitems" method="GET">
                              {{ csrf_field() }}
                              <br />
                          <div class="floatLeft" style="padding-right: 10px">
                            <p>Order:</p>
                            <p>Categories:</p>
                            <p>City:</p>
                            <p>Lost or found:</p>
                          </div>
                          <div class="floatLeft" style="padding-right: 10px">
                              <p>
                                <select name="order">
                                    <option value="newest">Newest to Oldest</option>
                                    <option value="oldest">Oldest to Newest</option>
                                </select>
                              </p>
                              <p>
                                <select name="category">
                                  <option value="all">All Categories</option>
                                  <option value="pets">Pets</option>
                                  <option value="electronics">Electronics</option>
                                  <option value="jewellery">Jewellery</option>
                                </select>
                              </p>
                              <p>
                                <select name="city">
                                  <option value="all">All Cities</option>
                                  <?php
                                    $cities = App\LostItem::select('city')->groupBy('city')->get()->toArray();
                                    foreach($cities as $city){
                                        echo "<option value=" . $city['city'] . ">" . $city['city'] . "</option>";
                                    }
                                  ?>
                                </select>
                              </p>
                              <p>
                                <select name="lostorfound">
                                  <option value="all">Both Lost + Found</option>
                                  <option value="1">Lost Only</option>
                                  <option value="0">Found Only</option>
                                </select>
                              </p>
                          </div>
                          <div class="searchButton" style="clear: both;padding-top: 15px;">
                            <button type="submit">Search</button>
                          </div>
                         </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: -20px;">
            <div class="col-xl-12">
                <div class="panel panel-default" style="height: 80px;">
                    <div class="panel-heading">
                        <div class="panel-heading-text responsive-smaller"><img src="img/magnify.svg" width="35" height="35"/>Found {{count($lostItems)}} items matching your current parameters</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text">
                            <!--<h2 style="margin-top: -2px;">Search parameters: </h2>-->
                            <?php
                                // if(Request::has('order')){
                                //     if(Request::input('order') == "newest"){
                                //         echo "Newest to Oldest, ";
                                //     }
                                //     else{
                                //         echo "Oldest to Newest, ";
                                //     }
                                // }

                                // if(Request::has('category')){
                                //     if(Request::input('category') == "all"){
                                //         echo "All Categories, ";
                                //     }
                                //     else{
                                //         echo "'" . Request::input('category') . "' category, ";
                                //     }
                                // }

                                // if(Request::has('city')){
                                //    if(Request::input('city') == "all"){
                                //         echo "all cities, ";
                                //     }
                                //     else{
                                //         echo "'" . Request::input('city') . "' city, ";
                                //     }
                                // }

                                // if(Request::has('lostorfound')){
                                //    if(Request::input('lostorfound') == "all"){
                                //         echo "both lost + found items.";
                                //     }
                                //     else{
                                //         echo "'" . Request::input('lostorfound') . "' items.";
                                //     }
                                // }
                            ?> 
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>
    <div id="lostItems">
    @if (count($lostItems) == 0)
        <div style="width: 100%; text-align: center; font-size: 32px; color: #000;font-weight: bold;padding-bottom: 30px;">Oh no! Try searching with different parameters, or subscribe to this feed using Pusher.</div>
    @endif
    @foreach ($lostItems as $item)  
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
            <div class="lostItemImg"><img src="{{$item->image_url}}" /></div>
            <div class="lostItemContent">
                <p><span style="font-weight: bold"><?php if($item->lostitem == 1){echo "Lost: ";}else{echo "Found: ";}?></span> {{$item->title}} ({{$item->category}}) <br /><img src="img/location.svg" width="30" height="30" style="margin-top: -7px"/><span style="font-weight: bold">&nbsp;{{$item->city}}</span></p>
                <p style="margin-top: -16px;font-size:22px;"><img src="img/calendar.svg" width="25" height="25" style="float:left; margin-top:5px;margin-right: 10px;margin-left: 2px;"/>{{$item->created_at}}</p>
                <p style="font-size: 22px;font-weight: lighter;">{{$item->description}}</p>
                <a href="../view/{{$item->id}}"><button type="button" class="btn btn-primary" style="font-size: 22px;">See More/Make Request</button></a>
                <?php
                    if(!is_null(Auth::user())){
                        if(Auth::user()->userlevel == 1 || $item->user_id == Auth::user()->id){
                            echo '<a href="/edit/' . $item->id . '"><button type="button" class="btn btn-primary" style="font-size: 22px;">Edit Item</button></a>';
                        }
                    }
                ?>
            </div>
        </div>
    @endforeach
    </div>

@stop