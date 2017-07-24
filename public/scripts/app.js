'use strict';

var app = angular.module('myApp', ['ngAvatar']);

/* Controllers */
app.controller('AppCtrl', function ($scope, $timeout,socket) {

  $scope.users = [];
  $scope.curtrentUser = '';
  socket.on('connect', function () { });

  socket.on('updatechat', function (username, data) {
    var user = {};
    user.username = username;
    user.message = data;
    user.date = new Date().getTime();
    $scope.users.push(user);

    $timeout(function() {
      var scroller = document.getElementById("userList");
      scroller.scrollTop = scroller.scrollHeight;
    }, 0, false);
  });

  socket.on('roomcreated', function (data) {
    socket.emit('adduser', data);
  });

  $scope.createRoom = function (data) {
    $scope.curtrentUser = data.username;
    socket.emit('createroom', data);
  }

  $scope.joinRoom = function (data) {

    $scope.curtrentUser = data.username;
    socket.emit('adduser', data);
  }

  $scope.doPost = function (message) {
    $scope.message = null;
    socket.emit('sendchat', message);
  }

  $scope.startPrivateChat = function (data) {
    data = angular.fromJson(data);
    $scope.curtrentUser = data.username;
    socket.emit('privatechat', data);
  }

  $scope.privateChat = function (message, sender) {
    $scope.message = null;
    var data = {'sender_id': sender, 'message':message};

    socket.emit('sendprivatechat', data);
  }


});


/* Services */
app.factory('socket', function ($rootScope) {
  var socket = io.connect('http://localhost:9000');

  return {
    on: function (eventName, callback) {
      socket.on(eventName, function () {
        var args = arguments;
        $rootScope.$apply(function () {
          callback.apply(socket, args);
        });
      });
    },
    emit: function (eventName, data, callback) {
      socket.emit(eventName, data, function () {
        var args = arguments;
        $rootScope.$apply(function () {
          if (callback) {
            callback.apply(socket, args);
          }
        });
      })
    }
  };
});
