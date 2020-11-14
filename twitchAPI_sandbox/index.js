/*
Copyright 2017 Amazon.com, Inc. or its affiliates. All Rights Reserved.

Licensed under the Apache License, Version 2.0 (the "License"). You may not use this file except in compliance with the License. A copy of the License is located at

    http://aws.amazon.com/apache2.0/

or in the "license" file accompanying this file. This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.

*/

// Define our dependencies
const express = require('express');
const session = require('express-session');
const passport = require('passport');
const OAuth2Strategy = require('passport-oauth').OAuth2Strategy;
const request = require('request');
const handlebars = require('handlebars');
const fetch = require('node-fetch');
const { profile } = require('console');

// Define our constants, you will change these with your own
// Change these before prod, implement a secured way to keep them
const TWITCH_CLIENT_ID = 'towa4yanmj49k3rsn7tr9lqsh9ayd9';
const TWITCH_SECRET = 'bwoh8zpyvlup6qe88sm2x5ykcqbptm';
const SESSION_SECRET = 'AF2E066C-9E4B-486F-BE86-B1F9FB1B3393';
const CALLBACK_URL = 'http://localhost:3000/auth/twitch/callback'; // You can run locally with - http://localhost:3000/auth/twitch/callback
let options = {};
// Initialize Express and middlewares
const cors = require('cors');
const helmet = require('helmet');
const app = express();
app.use(session({
  secret: SESSION_SECRET,
  resave: false,
  saveUninitialized: false
}));
app.use(express.static('public'));
app.use(passport.initialize());
app.use(passport.session());

app.use((req, res, next) => {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});

app.use(helmet.frameguard({ action: 'SAMEORIGIN' }));
// Override passport profile function to get user profile from Twitch API
OAuth2Strategy.prototype.userProfile = (accessToken, done) => {
  options = {
    url: 'https://api.twitch.tv/helix/users',
    method: 'GET',
    headers: {
      'Access-Control-Allow-Credentials': true,
      'Client-ID': TWITCH_CLIENT_ID,
      'Accept': 'application/vnd.twitchtv.v5+json',
      'Authorization': 'Bearer ' + accessToken
    }
  };

  request(options, (error, response, body) => {
    if (response && response.statusCode == 200) {
      done(null, JSON.parse(body));
    } else {
      done(JSON.parse(body));
    }
  });
}

passport.serializeUser((user, done) => {
  done(null, user);
});

passport.deserializeUser((user, done) => {
  done(null, user);
});

passport.use('twitch', new OAuth2Strategy({
  authorizationURL: 'https://id.twitch.tv/oauth2/authorize',
  tokenURL: 'https://id.twitch.tv/oauth2/token',
  clientID: TWITCH_CLIENT_ID,
  clientSecret: TWITCH_SECRET,
  callbackURL: CALLBACK_URL,
  state: true
},
  (accessToken, refreshToken, profile, done) => {
    profile.accessToken = accessToken;
    profile.refreshToken = refreshToken;

    // Securely store user profile in your DB
    //User.findOrCreate(..., function(err, user) {
    //  done(err, user);
    //});

    done(null, profile);
  }
));

// Set route to start OAuth link, this is where you define scopes to request
app.get('/auth/twitch', passport.authenticate('twitch', {
  scope: 'user_read'
}));

// Set route for OAuth redirect
app.get('/auth/twitch/callback', passport.authenticate('twitch', {
  successRedirect: 'http://localhost:4200/sandbox',
  failureRedirect: 'http://localhost:4200/sandbox'
}));

// Define a simple template to safely generate HTML with values from user's profile
var template = handlebars.compile(`
<html><head><title>Twitch Auth Sample</title></head>
<table>
    <tr><th>Access Token</th><td>{{accessToken}}</td></tr>
    <tr><th>Refresh Token</th><td>{{refreshToken}}</td></tr>
    <tr><th>Display Name</th><td>{{display_name}}</td></tr>
    <tr><th>Bio</th><td>{{bio}}</td></tr>
    <tr><th>Image</th><td>{{logo}}</td></tr>
</table></html>`);

// If user has an authenticated session, display it, otherwise display link to authenticate
app.get('/', (req, res) => {
  if (req.session && req.session.passport && req.session.passport.user) {
    res.send(template(req.session.passport.user));
  } else {
    res.send('<html><head><title>Twitch Auth Sample</title></head><a href="/auth/twitch"><img src="http://ttv-api.s3.amazonaws.com/assets/connect_dark.png"></a></html>');
  }
});

app.listen(3000, () => {
  console.log('Listening on port 3000!')
});


// Custom routes
app.get("/topGamesOnTwitch", (req, res) => {

  fetch('https://api.twitch.tv/helix/games/top', options)
    .then(response => response.json())
    .then(data => {
      return res.status(200).json(data);
    });

})

app.get("/searchChannel/:query", (req, res) => {
  const querySearched = req.params.query;
  fetch('https://api.twitch.tv/helix/search/channels?query=' + querySearched, options)
    .then(response => response.json())
    .then(data => {
      return res.status(200).json(data);
    });

})

app.get("/game-clips/:name", async (req, res, next) => {
  const nameSearched = req.params.name;

  try {
    const game = await fetch('https://api.twitch.tv/helix/games?name=' + nameSearched, options)
      .then(response => response.json())
      .then(data => {
        return data.data[0];
      });

    console.log(game);
    fetch('https://api.twitch.tv/helix/clips?game_id=' + game.id + '&first=10', options)
      .then(response => response.json())
      .then(data => {
        return res.status(200).json(data);
      });
  }
  catch (err) {
    next(err);
  }
})