var express = require("express");
var app = express();
var port = 3333;

var partnerID = [];


var io = require('socket.io').listen(app.listen(port));


io.sockets.on('connection', function(socket){
  socket.on('subscribe', function(room) {
    console.log('joining room', room);
    socket.join(room);
  });
  
  socket.on('send', function(data){
    data.strCurDate = getDateTime();
    //io.sockets.emit('message', data);
    console.log('sending room post', data.conversationID);
    
    io.sockets.in(data.conversationID).emit('message', {
        message: data.message,
        username:data.username, 
        userID:data.userID, 
        strCurDate:getDateTime(), 
        conversationID:data.conversationID,
        partnerID:data.partnerID,
        type:data.type
    });

    io.sockets.in(data.conversationID).emit('notification', {
        modul_id:data.modul_id,
        status:data.status
    });

    io.sockets.in(data.conversationID).emit('antrian', {
        panggil:data.panggil,
        antrian_id:data.antrian_id,
        loket_id:data.loket_id
    });

  });
  
});

function getDateTime() {

    var date = new Date();

    var hour = date.getHours();
    hour = (hour < 10 ? "0" : "") + hour;

    var min  = date.getMinutes();
    min = (min < 10 ? "0" : "") + min;

    var sec  = date.getSeconds();
    sec = (sec < 10 ? "0" : "") + sec;

    var year = date.getFullYear();

    var month = date.getMonth() + 1;
    month = (month < 10 ? "0" : "") + month;

    var day  = date.getDate();
    day = (day < 10 ? "0" : "") + day;
    strCurDate = day+'/'+month+'/'+year+' '+hour+':'+min;

    return strCurDate;

}
console.log("Listening on port "+port);
