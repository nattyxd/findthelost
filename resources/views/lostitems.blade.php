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
                        <div class="panel-heading-text"><img src="img/filter.svg" width="35" height="35"/>Filter lost items</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text">
                          <form action="/admin/cities" method="POST">
                              {{ csrf_field() }}
                              <br />
                          <div class="floatLeft" style="width: 250px;">
                            <p>Currently Viewing:</p>
                            <p>Categories:</p>
                            <p>City:</p>
                          </div>
                          <div class="floatLeft" style="width: 200px;">
                              <p><a href="#">Oldest to Newest</a></p>
                              <p>
                                <select name="category">
                                  <option value="all">All Categories</option>
                                  <option value="pets">Pets</option>
                                  <option value="electronics">Electronics</option>
                                  <option value="jewellery">Jewellery</option>
                                </select>
                              </p>
                              <p>
                                <select name="">
                                  <option value="london">London</option>
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
        <div class="row" style="">
            <div class="col-xl-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-text">Found x items matching your search</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text">
                            Currently viewing: Newest -> Oldest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop