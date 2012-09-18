### Description

**Backbone.Force** is a plugin that enables Force.com connectivity to [Backbone.js](http://backbonejs.org/) Model and Collection types.

In the back it uses [forcetk](https://github.com/developerforce/Force.com-JavaScript-REST-Toolkit) library provided by Salesforce.com team.

## Usage

To initialize it you need to call initialize function and pass it authorized forcetk.Client object:

```JavaScript
Backbone.Force.initialize(forcetkClient);
```

Defining Model type:

```JavaScript
var Opportunity = Backbone.Force.Model.extend({
    type:'Opportunity'
});
```

Fetching Model by Id:
```JavaScript
var myOpp = new Opportunity({
    Id:'OPPORTUNITY_ID'
});

myOpp.fetch({
    success:function (model, response) {
        alert('Fetched opportunity name: ' + model.get('Name'));
    },
    error:function (model, response) {
        alert('Error fetching Opportunity!');
    }
});
```

Updating Model:
```JavaScript
myOpp.set('Name', 'New Opp name');
myOpp.save(null, {
    success:function (model, response) {
        alert('Model updated successfully!');
    },
    error:function (model, response) {
        alert('Updating model failed!');
    }
});
```

### Demo

Snippet below will work in Safari browser on desktop or on mobile device using PhoneGap/Cordova and ChildBrowser plugin. It uses yet another project of mine that is called forcetk.ui and can be found [here](http://github.com/pwalczyszyn/forcetk.ui).

```html
<!DOCTYPE html>
<html>
<head>
    <title>forcetk.ui demo</title>

    <script type="text/javascript" src="scripts/libs/jquery-1.8.1.js"></script>

    <script type="text/javascript" src="scripts/libs/forcetk.js"></script>
    <script type="text/javascript" src="scripts/libs/forcetk.ui.js"></script>

    <script type="text/javascript" src="scripts/libs/underscore.js"></script>
    <script type="text/javascript" src="scripts/libs/backbone.js"></script>
    <script type="text/javascript" src="scripts/libs/backbone.force.js"></script>

    <script type="text/javascript">

        function login() {
            // Salesforce login URL
            var loginURL = 'https://login.salesforce.com/',

            // Consumer Key from Setup | Develop | Remote Access
                    consumerKey = 'CONSUMER_KEY',

            // Callback URL from Setup | Develop | Remote Access
                    callbackURL = 'https://login.salesforce.com/services/oauth2/success',

            // Instantiating forcetk ClientUI
                    ftkClientUI = new forcetk.ClientUI(loginURL, consumerKey, callbackURL,
                            function forceOAuthUI_successHandler(forcetkClient) { // successCallback
                                console.log('OAuth success!');

                                var Force = Backbone.Force;
                                Force.initialize(forcetkClient);

                                // Creating Opportunity type that maps to Salesforce Opportunity object
                                var Opportunity = Force.Model.extend({
                                            type:'Opportunity'
                                        }),

                                // Creating instance of Opportunity type with specified id
                                        myOpp = new Opportunity({
                                            Id:'006E0000004sgoo'
                                        });

                                // Fetching opportunity with specified id
                                myOpp.fetch({
                                    success:function (model, response) {
                                        alert('Fetched opportunity name: ' + model.get('Name'));
                                    },
                                    error:function (model, response) {
                                        alert('Error fetching Opportunity!');
                                    }
                                })

                            },

                            function forceOAuthUI_errorHandler(error) { // errorCallback
                                alert('OAuth error!');
                            });

            // Initiating login process
            ftkClientUI.login();
        }

    </script>

</head>
<body onload="login()">
<h3>Backbone.Force tests</h3>
</body>
</html>
```