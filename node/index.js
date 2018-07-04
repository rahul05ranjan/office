const ccapture = require('capture-phantomjs');
const	generator = require('generate-password');
const uniqid = require('uniqid');
const capture = require('capture-phantomjs')
const fs = require('fs')
const nodemailer = require('nodemailer');
//const md5 = require('md5');
const mysql      = require('mysql');
const curl = new (require( 'curl-request' ))();
const express = require('express');
const bodyParser = require('body-parser');
const driver = require('bigchaindb-driver');
const request = require('request');
var port = 3000;
var app = express();
var jsonParser = bodyParser.json();
var urlencodedParser = bodyParser.urlencoded({ extended: false })
// BigchainDB server instance or IPDB (e.g. https://test.ipdb.io/api/v1/)
const API_PATH = 'http://18.220.184.192:9984/api/v1/';
// Create a new keypair.
const alice = new driver.Ed25519Keypair();

//Mysql Connection
var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'root',
	password : '$#@$#@123',
	database : 'etranscript'
  });
  connection.connect();
  app.use(function(req, res, next) {
	res.header("Access-Control-Allow-Origin", "*");
	res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
	next();
  });


//Api create transaction
app.post('/create', jsonParser, (req, res)	=>	{
	function isEmptyObject(obj) {
	  for (var key in obj) {
	    if (Object.prototype.hasOwnProperty.call(obj, key)) {
	      return false;
	    }
	  }
	  return true;
	}

	if (isEmptyObject(req.body))
	{
		res.status(400).send({"result":"request should not be blank"});	
	}else
	{
		const tx = driver.Transaction.makeCreateTransaction(
		    req.body,
		    { what: 'My first BigchainDB transaction' },
		    [ driver.Transaction.makeOutput(
		            driver.Transaction.makeEd25519Condition(alice.publicKey))
		    ],
		    alice.publicKey
		)
		const txSigned = driver.Transaction.signTransaction(tx, alice.privateKey)
		const conn = new driver.Connection(API_PATH)
		conn.postTransactionCommit(txSigned)
		res.send({"id": txSigned.id});
	}
});


//Api for search transaction detail by some string
app.get('/search/:search', (req, res)	=>	{
	if (!req.params.search) {
		res.status(400).send("Please insert a search string");
	}else {
		let conn =  new driver.Connection(API_PATH)
		conn.searchAssets(req.params.search)
        .then(assets => res.send(assets))
	}
});

//Api for get transaction detail with transaction id
app.get('/gettr/:id', (req, res)	=>	{
	let url = 'http://18.220.184.192:9984/api/v1/transactions/' + req.params.id;
	request(url, function (error, response, body) {
	  //console.log('error:', error); // Print the error if one occurred
	  //console.log('statusCode:', response && response.statusCode); // Print the response status code if a response was received
	 // console.log('body:', body); // Print the HTML for the Google homepage.
	  //res.send(error);
	  //JSON.stringify(body);
	var obj =  JSON.parse(body)
	  res.status(200).send(obj.asset);
	});
});


//Api for login
app.post('/login',	urlencodedParser, (req, res)	=>	{
	let email 		= 	req.body.email;
	let password 	= 	req.body.password;
	if(email != '' && password != ''){
		let query = [email,password];

		//console.log(query);
		connection.query("SELECT * FROM users WHERE `user_id` = ? AND `password` = ?", query ,function (error, results, fields) {
			if (error) throw error;
			if(results.length == '0'){
				res.status(400).send({'result':'email and password does not matched'});
			}else{
				connection.query("SELECT * FROM insert_trans WHERE `user_id` = ?", [results[0].id] ,function (errorr, resultss, fieldss) {
					if (error) throw error;
					if(results.length == '0'){
						res.status(400).send({'result':'email and password does not matched'});
					}else{
						res.status(200).send({'user_details':results,'trans':resultss});
					}
				});
				//console.log(results[0].id);
			}
		});
	}else{
		if(email == '' && password == ''){
			res.status(400).send({'result':'Email & password should not be empty'});
		}else{
			if(email == ''){
				res.status(400).send({'result':'Email should not be empty'});
			}else if(password == ''){
				res.status(400).send({'result':'Password should not be empty'});
			}
		}
	}
});

//Api for register user
app.post('/register', urlencodedParser, (req, res)	=>	{
			var password = generator.generate({
					length: 10,
					numbers: true
			});
	let query = {
		'name'			:	req.body.name,
		'email'			:	req.body.email,
		'status'		:	1,											//1 = enabled, 2 = disabled
		'user_type'	:	req.body.user_type, 	//1 = admin, 2 = user, 3 = interviewer
		'password'	:	password,
		'user_id'	:	uniqid.time()
	};
	if(query.name != '' && query.email != '' && query.status != '' && query.user_type != '' && query.password != ''){
		connection.query("SELECT * FROM users WHERE `email` = ?", [query.email] ,function (error, results, fields) {
			if (error) throw error;
			if(results.length == '0'){
				connection.query('INSERT INTO users SET ?', query, (err, results) => {
					if(err) throw err;
					res.status(200).send({'result' : results.insertId});
				  });
			}else{
				res.status(400).send({'result':'You are already registered'});
			}
		});

	}else{
		res.status(400).send({'result':'Please fill all the fields'});
	}

});


//Api for  insert transaction id with user id
app.post('/insert_trans', urlencodedParser, (req, res)	=>	{
	let query 	=	{
		'user_id' 		: 	req.body.user_id,
		'transcript_id'	:	req.body.transcript_id
	};
	ccapture({
		url: 'http://18.220.184.192/assets/test.php?id=' + query.transcript_id,
		width: 1024,
		height: 768,
		clip: false,
	  }).then(screenshot => {
		fs.writeFileSync(`${__dirname}/${query.transcript_id}.png`, screenshot)
		console.log(`open ${query.transcript_id}.png`)
	  });
	if(query.user_id != '' && query.transcript_id != ''){
		connection.query('INSERT INTO insert_trans SET ?', query, (err, results) => {
			if(err) throw err;
			res.status(200).send({'result' : results.insertId});
		  });
	}else{
		if(query.user_id == '' && query.transcript_id == ''){
			res.status(400).send({'result' : 'Please fill user id and transcript id'});
		}else if(query.user_id == ''){
			res.status(400).send({'result' : 'Please fill user id'});
		}else if(query.transcript_id == ''){
			res.status(400).send({'result' : 'Please fill transcript id'});
		}
	}
});

//Api for get transaction id with user id

app.post('/get_transactions', urlencodedParser, (req, res)	=>	{
	let query	=	{
		'user_id':	req.body.user_id
	};
	connection.query("SELECT * FROM insert_trans WHERE `user_id` = ?", [query.user_id] ,function (error, results, fields) {
		if (error) throw error;
		if(results.length == '0'){
			res.status(400).send({'result':'There is no record in the database related to this user'});
		}else{
			res.status(200).send(results);
		}
	});
	//console.log(query);
});

//Api for forgot password

app.post('/forgot', urlencodedParser, (req, res)	=>	{
	let form_value = {
		'email'	:	req.body.email
	};
	let random_number =  Math.floor(100000 + Math.random() * 900000);
	if(form_value.email != ''){
		connection.query('UPDATE users SET otp = ? Where email = ?',[random_number, form_value.email],(err, result) => {
			  if (err) throw err;
			  console.log(`Changed ${result.changedRows} row(s)`);
			});
		//Nodemailer configuration
		var transporter = nodemailer.createTransport({
			service: 'gmail',
			auth: {
			  user: 'nafisahshahul@gmail.com',
			  pass: 'Qistina15'
			}
		  });
		var mailOptions = {
			from: 'E-transcript',
			to: form_value.email,
			subject: 'OTP for forgot password',
			html: '<p>You OTP for forgot password is </p><b>' + random_number + '</b>'
		  };
		  transporter.sendMail(mailOptions, function(error, info){
			if (error) {
			  res.status(400).send({'result':error});
			} else {
			  res.status(200).send({'result': 'An otp has been sent on your email.'});
			}
		  });
	}else{
		res.status(400).send({'result': 'please fill email address'});
	}
});

app.post('/check_otp',	urlencodedParser, (req, res)	=>	{
	let form_value	=	{
		'email'	:	req.body.email,
		'otp'	:	req.body.otp
	};
	if(form_value.email != '' && form_value.otp != ''){
		connection.query("SELECT * FROM users WHERE `email` = ? AND `otp` = ?", [form_value.email, form_value.otp] ,function (error, results, fields) {
			if (error) throw error;
			if(results.length == '0'){
				res.status(400).send({'result':'Email and otp not matched'});
			}else{
				res.status(200).send({'result': 'otp matched'});
			}
		});
	}else{
		if(form_value.email == '' && form_value.otp == ''){
			res.staus(400).send({'result':'Please fill email and otp'});
		}else{
			if(form_value.email == ''){
				res.status(400).send({'result':'Please fill email'});
			}else if(form_value.otp == ''){
				res.status(400).send({'result':'Please fill otp'});
			}
		}
	}
});

//for change password
app.post('/change_password', urlencodedParser, (req, res)	=>	{
	let form_value 	=	{
		'password' 			: 	req.body.password,
		'confirm_password'	:	req.body.confirm_password,
		'email'				:	req.body.email,
		'otp'				:	null
	};

	if(form_value.password != '' && form_value.confirm_password != '' && form_value.email != ''){
		if(form_value.password == form_value.confirm_password){
			connection.query('UPDATE users SET password = ?, otp = ? Where email = ?',[form_value.password, form_value.otp, form_value.email],(err, result) => {
				if (err) throw err;
				console.log(`Changed ${result.changedRows} row(s)`);
			  });
			res.status(200).send({'result': 'Password changed'});
		}else{
			res.status(400).send({'result': 'Password and confirm password does not matched'});
		}
	}else{
		if(form_value.password == '' && form_value.confirm_password == '' && form_value.email == ''){
			res.status(400).send({'result':'please fill password, confirm password and email'});
		}else{
			if(form_value.password == ''){
				res.status(400).send({'result':'please fill password'});
			}else if(form_value.confirm_password == ''){
				res.status(400).send({'result':'please fill confirm password'});
			}else if(form_value.email == ''){
				res.status(400).send({'result':'please fill email'});
			}
		}
	}
});

app.get('/screenshot', (req, res)	=>	{
	capture({
		url: 'https://www.gofugly.in/mdwelcome',
		width: 1024,
		height: 768,
		clip: false,
		wait: 15000,
		ignoreSSLErrors: true
	  }).then(screenshot => {
		fs.writeFileSync(`${__dirname}/example.png`, screenshot)
		console.log('open example.png')
	  })
});
app.get('/company_list', (req, res)	=>	{
	connection.query("SELECT id,name,email FROM users WHERE `user_type` = ?", [3] ,function (error, results, fields) {
		if (error) throw error;
		if(results.length == '0'){
			res.status(400).send({'result':'no any company in the database'});
		}else{
			//console.log(results);

			res.status(200).send({'result':results});
		}
	});
});

app.post('/share', urlencodedParser, (req, res)	=>	{
	let query 	=	{
		'user_id' 		: 	req.body.user_id,
		'transcript_id'	:	req.body.transcript_id,
		'share_user_id'	:	req.body.share_user_id,
		'name'			:	req.body.name,
		'email'			:	req.body.email,
		'password'		:	req.body.password,
		'last_date'		:	req.body.last_date,
		'c_email'		:	req.body.c_email
	};
	if(query.user_id != '' && query.transcript_id != '' && query.share_user_id != ''){
		connection.query('INSERT INTO share_transcript SET ?', query, (err, results) => {
			if(err) throw err;
			//send email to company
			var transporter = nodemailer.createTransport({
					service: 'gmail',
					auth: {
					user: 'nafisahshahul@gmail.com',
					pass: 'Qistina15'
					}
				});
				var mailOptions = {
					from: 'E-transcript <nafisahshahul@gmail.com>',
					to: query.c_email,
					subject: 'Email and password  fortranscript',
					html: `${query.email} has share his/her transcript with you. To open transcript please insert <b>${query.password}</b>`
				};
				transporter.sendMail(mailOptions, function(error, info){
					// if (error) {
					// res.status(400).send({'result':error});
					// } else {
					// res.status(200).send({'result': 'An otp has been sent on your email.'});
					// }
				});
			res.status(200).send({'result' : results.insertId});
		  });
	}else{
		if(query.user_id == '' && query.transcript_id == '' && query.share_user_id == ''){
			res.status(400).send({'result' : 'Please fill user id and transcript id'});
		}else{
			if(query.user_id == ''){
				res.status(400).send({'result' : 'Please fill user id'});
			}else if(query.transcript_id == ''){
				res.status(400).send({'result' : 'Please fill transcript id'});
			}else if(query.share_user_id == ''){
				res.status(400).send({'result' : 'Please fill share user id'});
			}
		}
	}
});

app.get('/allstudent', (req, res)	=>	{
	connection.query("SELECT *  FROM `users` JOIN insert_trans ON insert_trans.user_id = users.id WHERE `user_type` = ?", [2] ,function (error, results, fields) {
		if (error) throw error;
		if(results.length == '0'){
			res.status(400).send({'result':'no any resgistered student in the database.'});
		}else{
			//console.log(results);

			res.status(200).send({'result':results});
		}
	});
});

app.post('/allsharedtranscript', urlencodedParser, (req, res)	=>	{
	connection.query("SELECT * FROM share_transcript WHERE `share_user_id` = ?", [req.body.share_user_id] ,function (error, results, fields) {
		if (error) throw error;
		if(results.length == '0'){
			res.status(400).send({'result':'no any shared transcript.'});
		}else{
			//console.log(results);

			res.status(200).send({'result':results});
		}
	});
});

app.get('/capture/:id', (req, res)	=>	{
	ccapture({
		url: `http://18.220.184.192/assets/test.php?id=${req.params.id}`,
		width: 1024,
		height: 768,
		clip: false,
	  }).then(screenshot => {
		fs.writeFileSync(`${__dirname}/${req.params.id}.png`, screenshot)
		console.log(`open ${req.params.id}.png`)
	  });
});



app.listen(port, function(){
	console.log('app running on port ' + port);
});
