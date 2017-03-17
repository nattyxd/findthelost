@extends('layouts.template')

@section('title', 'Edit Item')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            Edit <b>{{($itemToEdit->title)}}</b>
        </div>
    </section>
    <div class="container-fluid">
        <div class="row" style="">
            <div class="col-xl-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="../img/magnify.svg" width="35" height="35"/>Complete the form</div>
                    </div>

                    <div class="panel-body" class="openSans" style="font-size: 24px;">
                        <div class="panel-body-text">
                            <?php
                            //dd($errors);
                            ?>
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <p>* Denotes a required field</p>
                            {!! Form::open(['action' => array('HomeController@submitedit', $itemToEdit->id), 'files' => true]) !!}
                            <div class="floatLeft" style="text-align: right;margin-right: 15px;">
                                <p>{{Form::label('category', 'Category*: ')}}</p>
                                <p>{{Form::label('title', 'Brief title*: ')}}</p>
                                <p>{{Form::label('description', 'Description*: ')}}</p>
                                <p>{{Form::label('lostitem', 'Is it a lost item?*: ')}}</p>
                                <p style="margin-top: 74px;">Location</p>
                                <p>{{Form::label('addressline1', 'Address Line 1*: ')}}</p>
                                <p>{{Form::label('addressline2', 'Address Line 2: ')}}</p>
                                <p>{{Form::label('addressline3', 'Address Line 3: ')}}</p>
                                <p>{{Form::label('city', 'City*: ')}}</p>
                                <p>{{Form::label('postcode', 'Postcode*: ')}}</p>
                                <p>{{Form::label('photo', 'New Image: ')}}</p>
                            </div>
                            <div class="floatLeft">
                                <p>{{Form::select('category', ['pets' => 'Pets', 'electronics' => 'Electronics', 'jewellery' => 'Jewellery'], $itemToEdit->category)}}</p>
                                <p>{{Form::text('title', $itemToEdit->title)}}</p>
                                <p>{{Form::text('description', $itemToEdit->description)}}</p>
                                <p class="radio"><label>{{Form::radio('lostitem', 'I have lost this item', $itemToEdit->lostitem == 1)}}I have lost this item</label></p>
                                <p class="radio"><span class="secondRadio"><label>{{Form::radio('lostitem', 'I have found this item', $itemToEdit->lostitem == 0)}}I have found this item</label></span></p>
                                <div class="formSectionSeperator"></div>
                                <p>{{Form::text('addressline1', $itemToEdit->addressline1)}}</p>
                                <p>{{Form::text('addressline2', $itemToEdit->addressline2)}}</p>
                                <p>{{Form::text('addressline3', $itemToEdit->addressline3)}}</p>
                                <p>{{Form::text('city', $itemToEdit->city)}}</p>
                                <p>{{Form::text('postcode', $itemToEdit->postcode)}}</p>
                                <p>{{Form::file('photo')}}</p>

                                <p>{{Form::submit('Submit')}}</p>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
