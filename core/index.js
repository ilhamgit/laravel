'use strict';
 var cors = require('cors');
var app = require('express')();
 app.use(cors({origin: '*'}));
var server = require('http').Server(app);
var io = require('socket.io')(server);
require('dotenv').config();
var userid = [];

var redisPort = process.env.REDIS_PORT;
var redisHost = process.env.REDIS_HOST;
var ioRedis = require('ioredis');
var redis = new ioRedis(redisPort, redisHost);
redis.subscribe('laravel_database_action-channel-one');
redis.subscribe('laravel_database_action-channel-two');

var users = {} ;


io.on('connection', function(socket) {

var userId     = socket.handshake.query.token;
users[userId]  = socket;
console.log(userId);
});

redis.on('message', function (channel, message) {
  message  = JSON.parse(message);

  var userId      = message.data.actionData.id;
  var userSocket  = users[userId] || null;

  console.log('=======[Message received]=======');
  console.log('UserId:', userId);
  console.log('SocketId:', userSocket.id);


  if(userSocket){
    userSocket.emit(channel + ':' + message.event, message.data.actionData.message);
    console.log("Message was succefully sent!");
  }else{
    console.log('User socket unavailable');
  }


  // io.to(test).emit(channel + ':' + message.event, message.data.actionData.id);
});

var broadcastPort = process.env.BROADCAST_PORT;
server.listen(broadcastPort, function () {
  console.log('Socket server is running.');
});