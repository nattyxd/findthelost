@extends('layouts.template')

@section('title', 'Welcome')

@section('aestheticHeader')
      <section id="topSplash">
        <div id="splashBoxContainer">
          <div id="splashBox">
            <div id="splashBoxHeadText" class="lm"><h1>Accidents happen</h1></div>
            <div id="splashBoxMainText">
              <p class="openSans">Everyday, thousands of valuable items are lost from homes, trains, airports, etc. Many of those lost items are never returned to their owners because it is difficult to link a lost item to the owner.</p>
            </div>
          </div>
        </div>
      </section>
@stop

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            Introducing <span class="logoGreen italic openSans reducedSpacing">fi</span><span class="italic openSans">l</span><span class="italic openSans minus2px">o</span>
          </div>
      </section>
      <section id="coreContent" class="openSans">
        <h1 class="lm" style="margin-bottom: 10px">How do we do it?</h1>
          <p>When a member of our community finds a lost item, they can post it here to tell other uses that they've found an item.</p>
          <p>Using the power of croudsourcing, and the latest technology, we can bring you the following features:</p>
          <h2 style="text-decoration: underline; margin-bottom: 4px;">For registered users (R):</h2>
          <ol>
            <li>Log in/out the system</li>
            <li>View item information based on category and/or date, firstly listing basic information (e.g. category, color, date). Click each item to see more details (photo, place, description etc.).</li>
            <li>Report a found item by inputting all details</li>
            <li>Make a request to an item and give the reason of the request</li>
          </ol>
          <h2 style="text-decoration: underline; margin-bottom: 4px;">For public users (P):</h2>
          <ol>
            <li>View the lost/found items listing the category, place, and date information by the three different categories</li>
            <li>Register to become a registered user</li>
          </ol>
          <h2 style="text-decoration: underline; margin-bottom: 4px;">For administrators (A):</h2>
          <ol>
            <li>Log in/out the system</li>
            <li>View all the item requests</li>
            <li>View the item’s details</li>
            <li>Approve/refuse the item requests</li>
          </ol>
      </section>
      @stop