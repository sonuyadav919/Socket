@extends('layouts.chat')
@section('extra_style')
<style>
.avatar-wrapper {
  float: left;
  margin-right: 5px;
}
</style>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <div class="panel-heading">Chat</div>
          <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                  <div class="ng-scope">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="row" id="userList" style="display: block;">
                          <div ng-repeat="user in users" class="col-sm-12 ng-scope">
                            <div class="row" ng-if="user">
                              <div class="col-xs-2"  ng-class="{'col-xs-push-10' : (user.username == curtrentUser)}">
                                <ng-avatar initials="@{{user.username.charAt(0).toUpperCase()}}" corner-radius="7" auto-color="true"></ng-avatar>
                              </div>
                              <div class="col-xs-10" ng-class="{'col-xs-pull-2' : (user.username == curtrentUser)}">
                                <div class="panel panel-default ">
                                  <div class="panel-body ng-binding "> <strong>@{{user.username}}</strong> : @{{user.message}} <br>
                                    <span class="label label-info ng-binding ">@{{user.date | date: 'h:mma'}}</span>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="input-group">
                          <input id="data " type="text " ng-model="message" class="form-control " placeholder="Type your message here ">
                          <span class="input-group-btn ">
                            <button class="btn btn-primary " id="datasend " type="button " ng-click="privateChat(message,{{$authId}}) ">Send!</button>
                          </span>
                        </div>
                        <div class="clearfix "></div>
                      </div>
                    </div>
                  </div>


                </div>
            </div>
          </div>
          <div class="col-sm-4 usersList" >

            <h4> Users List </h4>

            <ul class="list-group">
              @foreach($users as $user)
                <?php $object = ['room' => $user->id+$authId, 'username' => $user->name, 'sender_id' => $authId, 'recever_id' => $user->id]; ?>
                <li class="list-group-item" ng-click="startPrivateChat({{json_encode($object)}})">
                    <ng-avatar initials="{{strtoupper(substr($user->name,0,1))}}" corner-radius="7" auto-color="true" width="25"></ng-avatar>
                    <span>{{$user->name}}</span>
                    <span class="badge">12</span>
                 </li>
              @endforeach
            </ul>

              <div class="clearfix "></div>
          </div>
        </div>
    </div>
</div>
@endsection
