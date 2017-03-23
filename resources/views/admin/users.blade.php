@extends('layouts.template')

@section('title', 'Manage Users')

@section('content')
      <section id="pageTagline">
          <div class="thePageTagLine">
            Manage Users
        </div>
    </section>    
    <div class="container-fluid">
        <div class="row" style="">
            <div class="col-xl-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-heading-text"><img src="../img/cog.svg" width="35" height="35"/>Quick Actions</div>
                    </div>
                    <div class="panel-body" class="openSans">
                        <div class="panel-body-text">
                                @foreach ($users as $user)
                                    <p style="font-weight: bold;">({{$user->id}}) {{ $user->name }}
                                    <span style="font-weight: normal"> - {{$user->email}}</span></p>
                                    <p>User level: 
                                    @if($user->userlevel == 1)Administrator</p>
                                    
                                    @else User</p>
                                    <p>Trust level: {{$user->trust}}</p>
                                    <?php
                                        $userItems = App\LostItem::where('user_id', '=', $user->id)->get();

                                        if ($userItems->count() > 0){
                                            foreach($userItems as $userItem){
                                                echo '<a href="../view/' . $userItem->id . '"><button type="button" class="btn btn-primary" style="margin-right: 15px;">View Item ' . $userItem->id . '</button></a>';
                                            }
                                        }
                                        else{ echo "<b>- This user has not yet added any items -</b>" ;}
                                    ?>
                                    <form method="POST" action="/admin/deleteuser/{{$user->id}}" style="margin-top: 15px;">
                                        {{ csrf_field() }}
                                        <input type="submit" class="btn btn-danger" value="&#10007; Permanently Delete User" />
                                    </form>  
                                    @endif
                                    <hr/>
                                @endforeach

                                {{ $users->links() }}

                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection
