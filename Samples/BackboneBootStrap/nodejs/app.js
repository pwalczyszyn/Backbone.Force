/**
 * Module dependencies.
 */

var client_id = process.env.client_id;
var app_url = process.env.app_url;

var express = require('express')
    , http = require('http')
    , path = require('path')
    , request = require('request');

var ejs = require('ejs'); 
ejs.open = '{{'; 
ejs.close = '}}';

//SET APP_RELATIVE_PATH to a folder where your app's index.html resides.
 var APP_RELATIVE_PATH = path.join(__dirname, '/public/');
 console.log(APP_RELATIVE_PATH);
   

var app = express();

app.configure(function () {
    app.set('port', process.env.PORT || 3000);
	app.set('view engine', 'ejs');
    app.use(express.favicon());
    app.use(express.logger('dev'));
    app.use(express.bodyParser());
    app.use(express.static(APP_RELATIVE_PATH));
});

app.configure('development', function () {
    app.use(express.errorHandler());
});

app.get('/', function(req, res) {
  res.render('index', { client_id: client_id, app_url: app_url });
});

app.get('/index.html', function(req, res) {
  res.render('index', { client_id: client_id, app_url: app_url });
});

app.all('/proxy/?*', function (req, res) {
    log(req);
    var body = req.body;
    var contentType = "application/x-www-form-urlencoded";
    var sfEndpoint = req.headers["salesforceproxy-endpoint"];
    if (body) {
        //if doing oauth, then send body as form-urlencoded
        if (sfEndpoint && sfEndpoint.indexOf('oauth2') > 0) {
            body = getAsUriParameters(body);
        } else {//for everything else, it's json
            contentType = "application/json";
            body = JSON.stringify(body);
        }
    }

    if((!body || JSON.stringify(body) === "\"{}\"") && (typeof sfEndpoint != "string")) {
        return res.send('Request successful (but nothing to proxy to SF)');
    }
    request({
        url: sfEndpoint || "https://login.salesforce.com//services/oauth2/token",
        method: req.method,
        headers: {"Content-Type": contentType,
            "Authorization": req.headers["x-authorization"],
            "X-User-Agent": req.headers["x-user-agent"]},
        body: body
    }).pipe(res);
});

function log(req) {
    console.log("req.headers[\"authorization\"] = " + req.headers["x-authorization"]);
    console.log("req.headers[\"salesforceproxy-endpoint\"] = " + req.headers["salesforceproxy-endpoint"]);
    console.log('req.method = ' + req.method);
    console.log('req.body ' + JSON.stringify(req.body));
}

function getAsUriParameters(data) {
    var url = '';
    for (var prop in data) {
        url += encodeURIComponent(prop) + '=' +
            encodeURIComponent(data[prop]) + '&';
    }
    var result = url.substring(0, url.length - 1);
    console.log(result);
    return result;
}


http.createServer(app).listen(app.get('port'), function () {
    console.log("Express server listening on port " + app.get('port'));
});
