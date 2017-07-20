@extends('layouts.chat')

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
                        <h2 class="text-center ">Got something to say?</h2>
                        <div class="input-group">
                          <input id="data " type="text " ng-model="message " class="form-control " placeholder="Type your message here ">
                          <span class="input-group-btn ">
                            <button class="btn btn-primary " id="datasend " type="button " ng-click="doPost(message) ">Send!</button>
                          </span>
                        </div>
                        <div class="clearfix "></div>
                      </div>
                    </div>
                  </div>


                </div>
            </div>
          </div>
          <div class="col-sm-4">


              <h4>Join Room</h4>
              <div class="form-group ">
                <label for="exampleInputEmail1 ">Your Name</label>
                <input type="text " ng-model="join.username " class="form-control " id="join_room_email " placeholder="Enter Name " />
              </div>
              <div class="form-group ">
                <label for="exampleInputEmail1 ">Room Code</label>
                <input type="text " ng-model="join.room " class="form-control " id="join_room_code " placeholder="Enter Room Code " />
              </div>
              <button type="submit " id="join " ng-click="joinRoom(join) " class="btn btn-default ">Submit</button>
              <hr>
              <h4>Create Room</h4>
              <div class="form-group ">
                <label for="exampleInputEmail1 ">Your Name</label>
                <input type="text " ng-model="create.username " class="form-control " id="create_room_email " placeholder="Enter Name " />
              </div>
              <button type="submit " id="create " ng-click="createRoom(create) " class="btn btn-default ">Submit</button>
              <div class="clearfix "></div>


          </div>
        </div>
    </div>
</div>
@endsection
