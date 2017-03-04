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
                        <div class="panel-body-text" style="margin-top: -30px">
                          <form action="/lostitems" method="GET">
                              {{ csrf_field() }}
                              <br />
                          <div class="floatLeft" style="width: 250px;">
                            <p>Order:</p>
                            <p>Categories:</p>
                            <p>City:</p>
                            <p>Lost or found?</p>
                          </div>
                          <div class="floatLeft" style="width: 200px;">
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
                          <div style="clear: both;padding-top: 15px;">
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="img/magnify.svg" width="35" height="35"/>Found {{count($lostItems)}} items matching your current parameters</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text">
                            Currently viewing: Newest -> Oldest
                                
                        </div>
                        
                    </div>
                    @foreach ($lostItems as $item)
                                    <div class="lostItem">Found an item</div>
                                @endforeach
                </div>
            </div>
        </div>
    </div>

@stop