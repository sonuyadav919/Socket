var express = require('express');
var app = express();
app.set('port', process.env.PORT || 9000);
var server = require('http').Server(app);
var io = require('socket.io')(server);
var port = app.get('port');
app.use(express.static('public'));

var mysql     =     require("mysql");

/* Creating MySQL connection.*/
var connection    =    mysql.createPool({
      host              :   'localhost',
      user              :   'root',
      password          :   'admin',
      database          :   'socket',
      debug             :   false
});

server.listen(port, function () {
    console.log("Server listening on: http://localhost:%s", port);
});

var usernames = {};
var rooms = [];

io.sockets.on('connection', function (socket) {

    socket.on('adduser', function (data) {
        var username = data.username;
        var room = data.room;

        if (rooms.indexOf(room) != -1) {
            socket.username = username;
            socket.room = room;
            usernames[username] = username;
            socket.join(room);
            socket.emit('updatechat', 'SERVER', 'You are connected. Start chatting');
            socket.broadcast.to(room).emit('updatechat', 'SERVER', username + ' has connected to this room');
        } else {
            socket.emit('updatechat', 'SERVER', 'Please enter valid code.');
        }
    });

    socket.on('createroom', function (data) {
        var new_room = ("" + Math.random()).substring(2, 7);
        rooms.push(new_room);
        data.room = new_room;
        socket.emit('updatechat', 'SERVER', 'Your room is ready, invite someone using this ID:' + new_room);
        socket.emit('roomcreated', data);
    });

    socket.on('sendchat', function (data) {
        io.sockets.in(socket.room).emit('updatechat', socket.username, data);
    });

    socket.on('sendprivatechat', function (data) {
        var recever = socket.room - data.sender_id;
        data.recever_id = recever;

        store_message(data,function(res){});

        io.sockets.in(socket.room).emit('updatechat', socket.username, data.message);
    });

    socket.on('disconnect', function () {
        delete usernames[socket.username];
        io.sockets.emit('updateusers', usernames);
        if (socket.username !== undefined) {
            socket.broadcast.emit('updatechat', 'SERVER', socket.username + ' has disconnected');
            socket.leave(socket.room);
        }
    });

    socket.on('privateroom', function (data) {
        rooms.push(roomid);
        socket.emit('updatechat', 'SERVER', 'You are start chatting with:' + username);
    });


    socket.on('privatechat', function (data) {
      var username = data.username;
      var room = data.room;

        if (rooms.indexOf(room) != -1) {
            socket.username = username;
            socket.room = room;
            usernames[username] = username;
            socket.join(room);
            socket.emit('updatechat', 'SERVER', 'You are connected with '+ username +'. Start chatting...');
            socket.broadcast.to(room).emit('updatechat', 'SERVER', username + ' has connected to private chat room');
        } else {
          rooms.push(room);
          socket.emit('updatechat', 'SERVER', 'You are connected with '+ username +'. Start chatting...');
        }
        // old_messages(data,function(res){});
    });

    socket.on('appendmessages', function (data) {
      io.sockets.in(data.room).emit('updatechat', socket.username, data.rows.length);
      for (var i=0; i<data.rows.length; i++) {
        io.sockets.in(data.room).emit('updatechat', socket.username, data.rows.message);
      }
    });



    var store_message  = function (data,callback) {
        connection.getConnection(function(err,connection){
            if (err) {
              callback(false);
              return;
            }
        connection.query("INSERT INTO `private_chats` (`sender_id`, `recever_id`, `message`) VALUES ('"+data.sender_id+"', '"+data.recever_id+"', '"+data.message+"')",function(err,rows){
                connection.release();
                if(!err) {
                  callback(true);
                }
            });
         connection.on('error', function(err) {
                  callback(false);
                  return;
            });
        });
    }

    var old_messages = function(data, callback){
      connection.getConnection(function(err,connection){
          if (err) {
            callback(false);
            return;
          }
      connection.query("SELECT private_chats.*, sender.name as sender_name, recever.name as recever_name FROM private_chats JOIN users as sender ON private_chats.sender_id = sender.id JOIN users as recever ON private_chats.recever_id = recever.id WHERE (private_chats.sender_id = '"+data.sender_id+"' AND private_chats.recever_id = '"+data.recever_id+"') OR (private_chats.sender_id = '"+data.recever_id+"' AND private_chats.recever_id = '"+data.sender_id+"')")
                .on('result', function(rows){
                  // console.log(data);
                  // console.log(rows);
                  var username = '';
                  if(rows.sender_id ==  data.sender_id)
                    username = rows.sender_name;
                  else
                    username = rows.recever_name;

                  io.sockets.in(data.room).emit('updatechat', username, rows.message);
                });

       connection.on('error', function(err) {
                callback(false);
                return;
          });
      });
    }


});
