var express = require('express');
var bodyParser = require('body-parser');
_ = module.exports = require('underscore');
_date = module.exports = require('moment');
var mysql   = require("mysql");
var cors = require('cors');
var FCM = require('fcm-node');
var app = express();
var http = require('http');
var port = 3001;

// url = module.exports = 'localhost';
/*var pool = mysql.createPool({
    connectionLimit : 100,
    waitForConnections : true,
    host     : 'localhost',
    user     : 'root',
    password : '',
    database : 'dailyneeds',
    debug    :  false,
    waitTimeOut : 28800,
    multipleStatements: true
});*/

// url = module.exports = 'http://dailyneeds.co.nz';
// var pool = mysql.createPool({
//     connectionLimit : 100,
//     waitForConnections : true,
//     host     : 'localhost',
//     user     : 'root',
//     password : 'dailyneeds@2019',
//     database : 'dailyneeds',
//     debug    :  false,
//     // waitTimeOut : 28800,
//     multipleStatements: true
// });


c = module.exports = function(arr){  for(var i = 0; i < arguments.length; i++) console.log(arguments[i]); };

app = express();
app.use(cors())
app.options('*', cors())
app.use(bodyParser.urlencoded({ extended: false }));
app.engine('.html', require('ejs').__express);
app.set('view engine','html');
app.use(bodyParser.json());

var secureServer = http.createServer(app);

io = module.exports = require('socket.io').listen(secureServer, {pingInterval: 10000, pingTimeout: 5000});
io.set('transports', ['polling', 'websocket']);

event = module.exports = require('./classes/EventCases.js');


/*function handleDisconnect(connection) {
  console.log('handleDisconnect()');
  connection.destroy();
  connection = mysql.createConnection(db_config);
  connection.connect(function(err) {
      if(err) {
      console.log(' Error when connecting to db  (DBERR001):', err);
      setTimeout(handleDisconnect, 1000);
      }
  });

}*/


function handleConnection(pool){

  pool.getConnection(function(err, connection) {
    if(!err){
      c("database connected!!");
      db = module.exports = connection;
      io.on('connection', function (socket) {
        event.initEvents(socket);
        socket.on('disconnect', ()=>{
          event.disconnect(socket);
        })
      });
    }else{
      c("database error!!", err);
      connection.release();
      console.log(' Error getting mysql_pool connection: ' + err);
      throw err;
      setTimeout(function(){handleConnection(pool);},1000);
    }

    connection.on('error', function(err) {
      if(err.code === "PROTOCOL_CONNECTION_LOST"){    
          console.log("/!\\ Cannot establish a connection with the database. /!\\ ("+err.code+")");
          return handleConnection(pool);
      }

      else if(err.code === "PROTOCOL_ENQUEUE_AFTER_QUIT"){
          console.log("/!\\ Cannot establish a connection with the database. /!\\ ("+err.code+")");
          return handleConnection(pool);
      }

      else if(err.code === "PROTOCOL_ENQUEUE_AFTER_FATAL_ERROR"){
          console.log("/!\\ Cannot establish a connection with the database. /!\\ ("+err.code+")");
          return handleConnection(pool);
      }

      else if(err.code === "PROTOCOL_ENQUEUE_HANDSHAKE_TWICE"){
          console.log("/!\\ Cannot establish a connection with the database. /!\\ ("+err.code+")");
      }

      else{
          console.log("/!\\ Cannot establish a connection with the database. /!\\ ("+err.code+")");
          return handleConnection(pool);
      }
    })
  });
}

handleConnection(pool);

app.post('/sendNotifications', (req, res)=>{
  var data = req.body;
  if(typeof data.category == 'undefined' || typeof data.scategory == 'undefined' || typeof data.userid == 'undefined'){
    return res.send({error: 'Y', msg: 'request invalid!'});
  }

  c("data AndroidNotification >>",data);
    db.query("SELECT user_services.userid, register.firebaseid FROM user_services, register WHERE user_services.category = '"+data.category+"' and user_services.scategory = '"+data.scategory+"' and user_services.userid<>'"+data.userid+"' and register.id=user_services.userid", function (error, results, fields) {
      if (error) {
        res.send({
              "error": "Y",
              "msg": error
          });
      }else{
        var serverKey = 'AAAAan_Q144:APA91bFK33Cnw1pqIwC3ikbfQzOkkbgUaV8L1n0iIqiY5l5-Sgd0-GgF-MPC4K7LCyWjDad7crj22qIQ9-6bg9L2bc8ZeS5nleQd2XdPOHKpRgmKF4Et7SGh2137cjQz3u7F8KL-J2hu';
        
        temp(serverKey, results, 0 , (done)=>{
          return res.send(done);
        })

        function temp(serverKey, results, i, done){
          if(typeof results[i] != 'undefined' && typeof results[i].firebaseid != 'undefined' && results[i].firebaseid != ''){
            c("results[i].firebaseid :::::::::::::::::::::: ", results[i].firebaseid);
            var fcm = new FCM(serverKey);
            var message = { 
                  to: results[i].firebaseid,
                    notification: {
                        title: 'new post request arrived!', 
                        body: ''
                    }
            };
            c("message >>>>>>>>>>>>>> ",message);
            fcm.send(message, function(err, response){
                if (err) {
                    c("Something has gone wrong!"+err);
                } else {
                    c("Successfully sent with response: ", response);
                }

                if(typeof results[++i] != 'undefined'){
                  temp(serverKey, results, i, done);
                }else{
                  return done({error: 'N', msg: 'success!'});
                }
            });
          }else{
            if(typeof results[++i] != 'undefined'){
              temp(serverKey, results, i, done);
            }else{
              return done({error: 'N', msg: 'success!'});
            }
          }
        }
      }
    })
})


secureServer.listen(port, function(){
	console.log("server started at: :::::::: "+port);
});
module.exports = app;
