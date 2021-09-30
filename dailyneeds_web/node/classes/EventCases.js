var randtoken = require('rand-token');
module.exports = {
	getTimeDifference: (startDate, endDate, type)=>{
	   	var date1 = new Date(startDate);
		var date2 = new Date(endDate);
		var diffMs = (date2 - date1); // milliseconds between now & Christmas
		var one_day = 1000*60*60*24;
		if(type == 'day'){
		  	var date1 = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate(),0,0,0);
		  	var date2 = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate(),0,0,0);
		  	var timeDiff = date2.getTime() - date1.getTime();
		  	var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
		  	return diffDays;

	 	}else if(type == 'hour'){
		  	return Math.round((diffMs % 86400000) / 3600000); 
	 	}else if(type == 'minute'){
		  	return Math.round(((diffMs % 86400000) % 3600000) / 60000);
	 	}else{
		   return Math.round((diffMs / 1000)); 
	 	}
	},
	initEvents: (socket)=>{
		socket.removeAllListeners();
		socket.on('online', (data)=>{
			socket.emit('online', {error: 'N', data: {'uid': data.uid, 'status': data.status}});
		})

		/*socket.on('sendOrderMessages', (data)=>{
			console.log("data ::::::::: ", data, socket.room);
			if(typeof socket.room != 'undefined' && typeof data.status != 'undefined'){
				var card = {
					senderid: data.senderid,
					receiverid: data.receiverid,
					message: data.message,
					orderid: data.orderid,
					status: data.status
				};
				db.query("INSERT INTO order_messages SET ?",card, function (error, results, fields) {
	      	if (error) {
						socket.emit('createRoomforOrder', {
	              "error": "Y",
	              "errorType": "error ocurred",
	              "msg": error
	          });
	        }else{
	        	console.log("res results  :::::: ", results);
	        	io.to(socket.room).emit('sendOrderMessages', {error: 'N', 'data': card});
	        }
	      })		
			}else{
				socket.emit('sendOrderMessages', {error: 'Y', msg: 'Order Completed Or Cancelled', data: {}});
			}
		})*/
		socket.on('createRoom', (data)=>{
			console.log("data :::::: ", data);
			var card = {
          "buyerid": data.buyerid,
          "freelancerid": data.freelancerid,
          "serviceid": data.serviceid
      };
      if(typeof data.buyerid != 'undefined' && typeof data.freelancerid != 'undefined' && typeof data.serviceid != 'undefined'
      	&& data.buyerid != '' && data.freelancerid != '' && data.serviceid != ''){

      	db.query("SELECT * FROM room WHERE (buyerid = '"+data.buyerid+"' and freelancerid = '"+data.freelancerid+"') or (buyerid = '"+data.freelancerid+"' and freelancerid = '"+data.buyerid+"')", function (error, results, fields) {
					if (error) {
						socket.emit('createRoomResponse', {
	                "error": "Y",
	                "errorType": "error ocurred",
	                "msg": error,
	                "room": ""
	            });
	            

	        }else{
	        	if(results.length == 0){
	        			socket.join(card.room);
	        			card["room"] = randtoken.generate(16);
	        			db.query('INSERT INTO room SET ?', card, function (error, results, fields) {
									if (error) {
										socket.emit('createRoomResponse', {
				                "error": "Y",
				                "errorType": "error ocurred",
				                "msg": "error ocurred",
				                "room": ""
				            });
					        }else{
					        	var chatcard = {
												room: card["room"],
						      			senderid: data.buyerid,
						      			receiverid: data.freelancerid,
						      			msg: data.message,
						      			date: new Date()
						      		};
					        	db.query('INSERT INTO chat SET ?', chatcard, function (error, results, fields) {
											console.log("Chat error :::::: ",error);
											console.log("Chat results :::::: ",results);
											if (error) {
												socket.emit('createRoomResponse', {
						                "error": "Y",
						                "errorType": "error ocurred",
						                "msg": "error ocurred",
						                "room": ""
						            });
											}else{
												socket.emit('createRoomResponse', {
						                "error": "N",
						                "msg": "Message Successfully Sent",
						                "room": chatcard.room
						            });
											}
										})
					        }
								})
	        	}else{
	        		socket.join(results[0]['room']);
	        		socket.emit('createRoomResponse', {
	                "error": "N",
	                "msg": "Message Successfully Sent",
	                "room": results[0]['room']
	            });
	        	}
	        }
				})

      }else{
				socket.emit('createRoomResponse', {
            "error": "Y",
            "msg": "data not valid!",
            "room": ""
        });
      }
      
		});
		socket.on('sendOrderMessagesList', (data)=>{
			console.log("Data :::::: ", data);
			if(typeof data.orderid == 'undefined'){
				socket.emit('sendOrderMessagesList', {error: 'Y', 'data': data, 'msg': 'Order id not Present on call!'});
				return true;
			}
			db.query("SELECT status FROM orders WHERE id='"+data.orderid+"';SELECT order_messages.orderid,order_messages.senderid,order_messages.status,order_messages.receiverid,order_messages.message,register.profile FROM order_messages,register WHERE orderid='"+data.orderid+"' and register.id=order_messages.senderid ORDER BY  `order_messages`.`date` ASC", function (error, results, fields) {
	      	if (error) {
						socket.emit('sendOrderMessagesList', {
	              "error": "Y",
	              "errorType": "error ocurred",
	              "msg": "error ocurred"
	          });
	        }else{
	        	socket.emit('sendOrderMessagesList', {error: 'N', 'data': results[1], 'msg': '', orderStatus: results[0][0]['status']});
	        }
	      })
		})
		socket.on('make_review', (data)=>{
			if(typeof socket.room != 'undefined'){
				io.to(socket.room).emit('make_review', data);
			}else{
				console.log('socket room not defined!');
			}
		})
		socket.on('sendOrderMessages', (data)=>{
			console.log("requested sendOrderMessages data ::::::::: ", data, socket.room);
			if(typeof socket.room != 'undefined'){
				var card = {
					senderid: data.senderid,
					receiverid: data.receiverid,
					message: data.message,
					orderid: data.orderid,
					status: data.status,
					room: socket.room
				};
				db.query("INSERT INTO order_messages SET ?;SELECT * FROM orders WHERE id='"+card.orderid+"'", card, function (error, results, fields) {
	      		console.log("error :::: ", error);
	      	if (error) {
						socket.emit('createRoomforOrder', {
	              "error": "Y",
	              "errorType": "error ocurred",
	              "msg": "error ocurred"
	          });
	        }else{
	        	console.log("response sendOrderMessages results  :::::: ", card, results[0]);
	        	io.to(socket.room).emit('sendOrderMessages', {error: 'N', 'data': card, orderStatus: results[1][0]['status']});
	        }
	      })		
			}else{
				socket.emit('sendOrderMessages', {error: 'Y', msg: 'Order Completed Or Cancelled', data: {}});
			}
		})
		socket.on('joinConnectionOnOrder', (data)=>{
			console.log("data ::::::: ",data);
			if(typeof data.myid != 'undefined' && typeof data.orderid != 'undefined'){
				db.query("SELECT count(*) as total, room FROM order_messages WHERE (senderid='"+data.myid+"' or receiverid='"+data.myid+"') and orderid='"+data.orderid+"' and  status='new' GROUP BY room", function (error, results, fields) {
							console.log("results ::::::: ",results);
							console.log("error ::::::: ",error);
						if(!error){
							if(results.length && results[0]['total']){
								socket.join(results[0].room);
								socket.room = results[0].room;
								socket.emit('joinConnectionOnOrder', {
			              "error": "N",
			              "msg": 'room joined!'
			          });
							}else{
								socket.emit('joinConnectionOnOrder', {
			              "error": "Y",
			              "msg": 'room not joined!'
			          });
							}
						}else{
							socket.emit('reloadPage', {});
						}
				})
			}
		})
		socket.on('createRoomforOrder', (data)=>{
			console.log("createRoomforOrder data :::::::::: ", data);
			if(data){
				var card = {
					senderid: data.buyerid,
					receiverid: data.userid,
					message: 'Order placed!',
					orderid: data.cc,
					status: 'new'
				};
				card["room"] = randtoken.generate(16);
				db.query("SELECT count(*) as total, room from order_messages WHERE senderid='"+card.senderid+"' and receiverid='"+card.receiverid+"' and orderid='"+card.orderid+"'  and status='new'", function (error, results, fields) {
					console.log("results ::::::: ",results);
					console.log("error ::::::: ",error);

					if(results[0]['total']){
						socket.join(results[0]['room']);
						socket.room = results[0]['room'];
						socket.emit('createRoomforOrder', {
	              "error": "N",
	              "msg": 'room already Created!'
	          });
					}else{
						 db.query("INSERT INTO order_messages SET ?",card, function (error, results, fields) {
		        	if (error) {
								socket.emit('createRoomforOrder', {
			              "error": "Y",
			              "errorType": "error ocurred",
			              "msg": error
			          });
			        }else{
			        	console.log("res results  :::::: ", results, card);
			        	socket.join(card.room);
			        	socket.room = card.room;
			        	socket.emit('createRoomforOrder', {
			              "error": "N",
			              "msg": 'room Created!'
			          });
			        }
		        })			
					}
				})
       
			}
		})
		socket.on('getChatUsersList', (data)=>{
			console.log("getChatUsersList ::::: data :::: ", data);

			var query = "SELECT chat.id as chatId,chat.senderid,chat.receiverid, room.room FROM chat,room WHERE (room.buyerid = '"+parseInt(data.id)+"' or room.freelancerid = '"+parseInt(data.id)+"') and chat.room = room.room GROUP BY room.room";
        db.query(query, function (error, results, fields) {
          if (error) {
              console.log("error ::::: ", error);

          }else{
            console.log("main results ::::: ", results);
            
            function temp(results, i, done){
              var query = '';
              if(results[i].senderid == data.id){
                query = "SELECT id, username, status, profile FROM register WHERE id="+results[i]['receiverid'];
              }else{
                query = "SELECT id, username, status, profile FROM register WHERE id="+results[i]['senderid'];
              }
              db.query(query, function (error, myresults, fields) {
                if (error) {
                    socket.emit('getChatUsersListResponse', {
                        "error": "Y",
                        "errorType": "error ocurred",
                        "msg": error
                    });

                }else{
                    results[i].id = myresults[0].id;
                    results[i].profile = myresults[0].profile;
                    results[i].status = myresults[0].status;
                    results[i].username = myresults[0].username;
                }
                if(typeof results[++i] != 'undefined'){
                  temp(results, i, done);
                }else{
                  return done(results);
                }
              })

            }
            if(results.length){
            	temp(results, 0, (done)=>{
	              console.log("reslt temp done :::::::: ", done);

	              function temp1(done, i, mydone){
	              	done[i].profile = url+'/images/upload/'+done[i].profile;
	              	if(typeof done[i].receiverid != 'undefined'){
	              		delete done[i].receiverid;
	              	}
	              	if(typeof done[i].senderid != 'undefined'){
	              		delete done[i].senderid;
	              	}
	              	if(typeof done[i].room != 'undefined'){
	              		socket.join(done[i].room);
	              	}
	              	var query = "SELECT msg,date FROM chat WHERE id='"+done[i].chatId+"' ORDER BY date DESC LIMIT 1;";
	              	db.query(query, function (error, myResults, fields) {
							      if (error) {
							          socket.emit('getChatUsersListResponse', {
						                "error": "Y",
						                "errorType": "error ocurred",
						                "msg": error
						            });
							      }else{
							      	console.log("myResults :::::::::: ",myResults);
							   			  done[i].message = {msg: myResults[0].msg, date: myResults[0].date};
							   			  var date = new Date(myResults[0].date);
								      	done[i].time = event.getTimeDifference(date, new Date(), 'hour')+' hours ago';
							      }

							      if(typeof done[++i] != 'undefined'){
							      	temp1(done,i,mydone);
							      }else{
							      	return mydone(done);
							      }
							    })
	              }
	              temp1(done, 0, (mydone)=>{
	              	console.log("mydone ::::::::::::::::::::::::::::::: ", mydone);
		              socket.emit('getChatUsersListResponse', {
		                  "error": "N",
		                  "data": mydone
		              });
		            })
	            })	
            }else{
            	socket.emit('getChatUsersListResponse', {
                  "error": "N",
                  "data": results
              });
            }
            
          }
        })
    })

		socket.on('getChatMsgList', (data)=>{
			console.log("getChatMsgList :::::: >>>>>>>>>>>>>>>>>>>>>> ",data);
			var query = "SELECT msg,date,senderid,receiverid FROM chat WHERE room='"+data.room+"' and (senderid='"+data.id+"' or receiverid='"+data.id+"') ORDER BY date ASC";
			db.query(query, function (error, results, fields) {
        if(error){
          console.log("error :::::: ", error);
          socket.emit('getChatMsgListResponse', {
              "error": "Y",
              "errorType": "error ocurred",
              "msg": error
          });
        }else{
          console.log('results ::::::::: ', results);
          socket.emit('getChatMsgListResponse', {error: 'N', 'data': results});
        }
      })
		})
		socket.on('sendMsg', (data)=>{
			var card = {
									room: data.room,
			      			senderid: data.senderid,
			      			receiverid: data.receiverid,
			      			msg: data.msg,
			      			date: new Date()
			      		};
			db.query('INSERT INTO chat SET ?', card, function (error, results, fields) {
				if (error) {
					socket.emit('sendMsgResponse', {
              "error": "Y",
              "errorType": "error ocurred",
              "msg": error
          });
        }else{
        	console.log("res results  :::::: ", results);
        	socket.join(data.room);
        	io.to(data.room).emit('sendMsgResponse', {error: 'N', 'data': data});
        }
			})
		})
		socket.on('getChatUsers', (data)=>{
			var query = "SELECT chat.id,chat.date,chat.msg,chat.senderid,chat.receiverid,register.profile FROM chat INNER JOIN register ON register.id='"+data.id+"' WHERE senderid = '"+data.id+"' or receiverid='"+data.id+"'";
	  	db.query(query, function (error, myResults, fields) {
	      if (error) {
	          socket.emit('getChatUsersResponse', {
                "error": "Y",
                "errorType": "error ocurred",
                "msg": error
            });

	      }else{
	          
	        if(myResults.length >0){
	          var ids = [];
	          for (var i = 0; i < myResults.length; i++) {
	            if(myResults[i].senderid == data.id){
	              ids.push(myResults[i]['receiverid']);
	            }else{
	              ids.push(myResults[i]['senderid']);
	            }
	          }

	          var query = "SELECT id, username, status, profile FROM register WHERE ";
	          for (var i = 0; i < ids.length; i++) {
	            query += (i==0) ? "id="+ids[i] : " OR id="+ids[i];
	          }
	          db.query(query, function (error, results, fields) {
	            if (error) {
	                socket.emit('getChatUsersResponse', {
			                "error": "Y",
			                "errorType": "error ocurred",
			                "msg": error
			            });

	            }else{

	            	for (var i = 0; i < results.length; i++) {
	            		results[i].profile = url+'/images/upload/'+results[i].profile;
	            	}

	            	function temp(i, results, done){
									console.log("data.id :::::: ", data.id);
	            		console.log("results[i].id :::::: ", results[i].id);
	            		// var query = "SELECT msg,date FROM chat WHERE senderid = '"+results[i].id+"' or receiverid='"+results[i].id+"' ORDER BY date DESC";
	            		var query = "SELECT chat.msg, chat.date, register.profile FROM chat INNER JOIN register ON register.id='"+results[i].id+"' WHERE chat.senderid = '"+results[i].id+"' or chat.receiverid='"+results[i].id+"' ORDER BY date DESC LIMIT 1;"+
	            								"SELECT chat.msg, chat.date, register.profile, register.id, chat.senderid, chat.receiverid FROM chat INNER JOIN register ON register.id='"+results[i].id+"' WHERE (chat.senderid = '"+data.id+"' and chat.receiverid='"+results[i].id+"') or (chat.senderid = '"+results[i].id+"' and chat.receiverid='"+data.id+"') ORDER BY date ASC";
							  	
							  	db.query(query, function (error, chatResults, fields) {
							      if (error) {
							          return done(results);
							      }else{
							      	
							      	// console.log("chatResults :::: getUser ", chatResults);
							      	// return done(chatResults);
							      	for (var j = 0; j < chatResults[0].length; j++) {
							      		chatResults[0][j].profile = url+'/images/upload/'+chatResults[0][j].profile;
							      	}
							      	for (var j = 0; j < chatResults[1].length; j++) {
							      		if(chatResults[1][j]['senderid'] == data.id){
							      			chatResults[1][j].profile = url+'/images/upload/'+myResults[0].profile;
							      		}else{
							      			chatResults[1][j].profile = url+'/images/upload/'+chatResults[1][j].profile;
							      		}
							      	}
							      	results[i].messages = chatResults[0];
							      	results[i].AllMessages = chatResults[1];
							      	var date = new Date(chatResults[0][0].date);
							      	results[i].time = event.getTimeDifference(date, new Date(), 'hour')+' hours ago';

							      	if(typeof results[++i] != 'undefined'){
							      		temp(i, results, done);
							      	}else{
							      		console.log("results :::::: ", results);
							      		return done(results);
							      	}
							      }
							    })
	            	}

	            	if(results.length){
	            		temp(0, results, (done)=>{
		            		db.query('SELECT room FROM room WHERE buyerid = ? or freelancerid = ?',[data.id, data.id], function (error, results, fields) {
											if (error) {
							            socket.emit('getChatUsersResponse', {
							                "error": "Y",
							                "errorType": "error ocurred",
							                "msg": error
							            });

							        }else{
							        	if(results.length >0){
							        		for (var i = 0; i < results.length; i++) {
							        			socket.join(results[i].room);
							        		}
							        	}
							        }
										})
		            		socket.emit('getChatUsersResponse', {
				                "error": "N",
				                "data": done
				            });
		            	})	
	            	}else{
	            		socket.emit('getChatUsersResponse', {
			                "error": "N",
			                "data": results
			            });
	            	}
	            	
	            }
	          })
	        }else{
	        	console.log("results not found :::");
	        }
	      }
	    })
		})

		/*socket.on('sendMsg', (data)=>{
			console.log("id :::::: ",data);
			var query = "select * from room where (buyerid='"+data.id+"' and freelancerid='"+data.opp+"') or (buyerid='"+data.opp+"' and freelancerid='"+data.id+"')";
			db.query(query,function(error, roomResults, fields){
				if(error){
					socket.emit('createRoomResponse', {
                "error": "Y",
                "errorType": "error ocurred",
                "msg": error
            });
				}else{
					console.log("results ::: ", roomResults);
					if(roomResults.length){
						socket.join(roomResults[0].room);
					}
					db.query('SELECT * FROM register WHERE id = ?',[data.id], function (error, results, fields) {
						if (error) {
		            socket.emit('sendMsgResponse', {
		                "error": "Y",
		                "errorType": "error ocurred",
		                "msg": error
		            });

		        }else{
		        	if(results.length >0){
		        		data.profile = url+'/images/upload/'+results[0].profile;
		        		var card = {
		        			senderid: data.id,
		        			receiverid: data.opp,
		        			msg: data.msg
		        		};
		        		db.query('INSERT INTO chat SET ?', card, function (error, results, fields) {
									if (error) {
										socket.emit('sendMsgResponse', {
				                "error": "Y",
				                "errorType": "error ocurred",
				                "msg": error
				            });
					        }else{
					        	console.log("res results  :::::: ", results);
					        	io.to(roomResults[0].room).emit('sendMsgResponse', {error: 'N', 'data': data});
					        }
								})
		        	}
		        }
					})
				}
			})
		})*/

		socket.on('sendChatMessage', (data)=>{
			db.query('SELECT * FROM chat WHERE email = ?',[email], function (error, results, fields) {
				if (error) {
            res.send({
                "error": "Y",
                "errorType": "error ocurred",
                "msg": error
            });

        }else{
        	if(results.length >0){

        	}
        }
			})
		})
	},
	disconnect: (socket)=>{
		console.log("disconnect ::::::::::::::::::::::::::::::: ");
		/*if(typeof socket.userID != 'undefined' && socket.userID.length == 24 && typeof socket.user_type != 'undefined'){
			db.query('SELECT * FROM register WHERE  isDeleted = 0 and type="user" and user_login = ?',[email], function (error, results, fields) {
			})
		}*/
	}

}