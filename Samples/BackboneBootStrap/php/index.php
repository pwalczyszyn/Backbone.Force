<html>
<!--
Copyright (c) 2011, salesforce.com, inc.
All rights reserved.

Redistribution and use in source and binary forms, with or without modification, are permitted provided
that the following conditions are met:

Redistributions of source code must retain the above copyright notice, this list of conditions and the
 following disclaimer.

Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
the following disclaimer in the documentation and/or other materials provided with the distribution.

Neither the name of salesforce.com, inc. nor the names of its contributors may be used to endorse or
promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED
WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
POSSIBILITY OF SUCH DAMAGE.
-->
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
  <title>Contacts in Backbone.js</title>

  <!-- ========= -->
  <!--    CSS    -->
  <!-- ========= -->
  <link href="resources/css/jquery.mobile-1.3.0.min.css" rel="stylesheet" />

  <!-- ========= -->
  <!-- Libraries -->
  <!-- ========= -->
  <script src="resources/lib/jquery.js" type="text/javascript"></script>
  <script src="resources/lib/lodash.js" type="text/javascript"></script>
  <script src="resources/lib/backbone.js" type="text/javascript"></script>
  <script src="resources/lib/forcetk.js" type="text/javascript"></script>
  <script src="resources/lib/backbone.force.js" type="text/javascript"></script>
  <script src="resources/lib/jquerymobile.js" type="text/javascript"></script>

<script>

var loginUrl    = 'https://login.salesforce.com/';
var clientId    = '<?=$_ENV['client_id']?>'; //demo only
var redirectUri = '<?=$_ENV['app_url']?>/index.php';
var proxyUrl    = '<?=$_ENV['app_url']?>/proxy.php?mode=native';

var client = new forcetk.Client(clientId, loginUrl, proxyUrl);

$(document).ready(function() {
    //Add event listeners and so forth here
    console.log("onLoad: jquery ready");
	$.mobile.ajaxEnabled = false;
    $.mobile.linkBindingEnabled = false;
	console.log("mobile init end");
	console.log('DOCUMENT READY '+window.location.href);
	if(client.sessionId == null) {
		var oauthResponse = {};
		if (window.location.hash && window.location.href.indexOf('access_token') > 0) {
			var message = window.location.hash.substr(1);
			var nvps = message.split('&');
			for (var nvp in nvps) {
			    var parts = nvps[nvp].split('=');
				oauthResponse[parts[0]] = unescape(parts[1]);
			}
			console.log('init app');
			if(oauthResponse['access_token']) {sessionCallback(oauthResponse);}
		} else {
			url = getAuthorizeUrl(loginUrl, clientId, redirectUri);
			window.location.href = url;
		}
	}
});

function getAuthorizeUrl(loginUrl, clientId, redirectUri){
    return loginUrl+'services/oauth2/authorize?display=touch'
        +'&response_type=token&client_id='+escape(clientId)
        +'&redirect_uri='+escape(redirectUri);
}

function sessionCallback(oauthResponse) {
    if (typeof oauthResponse === 'undefined'
        || typeof oauthResponse['access_token'] === 'undefined') {
        errorCallback({
            status: 0, 
            statusText: 'Unauthorized', 
            responseText: 'No OAuth response'
        });
    } else {
        client.setSessionToken(oauthResponse.access_token, null, oauthResponse.instance_url);
		console.log("init backbone");
		window.location.href = window.location.href.split('#')[0]+'#contacts';
		myapp(client);
 
    }
}



function getAuthCredentialsError(error) {
    console.log("getAuthCredentialsError: " + error);
}
</script>



</head>
<body>

  <!-- ========= -->
  <!-- HTML CODE -->
  <!-- ========= -->
  <div id="contacts" data-role="page" data-title="Contacts">
    <div data-role="header">
      <h1>Contacts</h1>
    </div><!-- /header -->
    <div data-role="content" id="contacts-content">
    </div>
  </div>

  <div id="contact" data-role="page" data-title="Contact">
    <div data-role="header">
      	<a href='#' id="back" class='ui-btn-left' data-icon='arrow-l'>Back</a>
		<h1>Contact</h1>
    </div><!-- /header -->
    <div data-role="content" id="contact-content">
    </div>
  </div>

  <!-- ========= -->
  <!-- Templates -->
  <!-- ========= -->
  <script type="text/template" id="contacts-template">
    <form>
        <button data-role="button" class="new">New Contact</button>
    </form>
    <ul data-role="listview" data-inset="true" id="contact-list">
    </ul>
    <div data-role="footer">
      <div data-role="fieldcontain">
        <label for="select-theme" class="select">UI Theme:</label>
        <select class="theme-selector" name="select-theme" id="select-theme">
          <option value="default">default</option>
          <option value="a">a</option>
          <option value="b">b</option>
          <option value="c">c</option>
          <option value="d">d</option>
          <option value="e">e</option>
        </select>
      </div>
    </div>
  </script>

  <script type="text/template" id="contact-template">
    <% if (typeof(Id) !== 'undefined') { %>
      <a href="#	<%= Id %>"><%- Name %></a> 
    <% } else { %>
      <%- Name %>
    <% } %>
  </script>

  <script type="text/template" id="contact-detail-template">
    <form name="contactform" id="contactform">
      <% if (typeof(Id) !== 'undefined') { %>
        <input type="hidden" name="Id" id="Id" value="<%- Id %>" />
      <% } %>
      <div data-role="fieldcontain">
        <label for="Name">First Name:</label>
        <% if (typeof(FirstName) !== 'undefined') { %>
          <input name="FirstName" id="FirstName" value="<%- FirstName %>" />
        <% } else { %>
          <input name="FirstName" id="FirstName" />
        <% } %>
      </div>
	  <div data-role="fieldcontain">
        <label for="Name">Last Name:</label>
        <% if (typeof(LastName) !== 'undefined') { %>
          <input name="LastName" id="LastName" value="<%- LastName %>" />
        <% } else { %>
          <input name="LastName" id="LastName" />
        <% } %>
      </div>
      <div data-role="fieldcontain">
        <label for="Email">Email:</label>
        <% if (typeof(Email) !== 'undefined') { %>
          <input name="Email" id="Email" value="<%- Email %>" />
        <% } else { %>
          <input name="Email" id="Email" />
        <% } %>
      </div>
      <button data-role="button" data-icon="check" data-inline="true" data-theme="b" class="save">Save</button>
      <% if (typeof(Id) !== 'undefined') { %>
        <button data-role="button" data-icon="delete" data-inline="true" class="destroy">Delete</button>
      <% } %>
    </form>
  </script>

  <!-- =============== -->
  <!-- Javascript code -->
  <!-- =============== -->
  <script type="text/javascript">


    
    function changeTheme(theme){
      var hfTheme = theme, 
          cTheme = theme;

      if (theme === 'default') {
        // "If no theme swatch letter is set at all, the framework uses the 
        // "a" swatch (black in the default theme) for headers and footers 
        // and the "c" swatch (light gray in the default theme) for the page 
        // content to maximize contrast between the both."
        // http://jquerymobile.com/demos/1.2.1/docs/api/themes.html
        hfTheme = "a";
        cTheme = "c";
      }

      $.mobile.activePage.find('.ui-btn').not('.ui-li-divider')
                         .removeClass('ui-btn-up-a ui-btn-up-b ui-btn-up-c ui-btn-up-d ui-btn-up-e ui-btn-hover-a ui-btn-hover-b ui-btn-hover-c ui-btn-hover-d ui-btn-hover-e')
                         .addClass('ui-btn-up-' + cTheme)
                         .attr('data-theme', cTheme);
      
      $.mobile.activePage.find('.ui-li-divider').each(function (index, obj) {
        if ($(this).parent().attr('data-divider-theme') == 'undefined') {
            $(this).removeClass('ui-bar-a ui-bar-b ui-bar-c ui-bar-d ui-bar-e')
                   .addClass('ui-bar-' + cTheme)
                   .attr('data-theme', cTheme);
        }
      })
                         
      $.mobile.activePage.find('.ui-header, .ui-footer')
                         .removeClass('ui-bar-a ui-bar-b ui-bar-c ui-bar-d ui-bar-e')
                         .addClass('ui-bar-' + hfTheme)
                         .attr('data-theme', hfTheme);
      $.mobile.activePage.removeClass('ui-body-a ui-body-b ui-body-c ui-body-d ui-body-e')
                         .addClass('ui-body-' + cTheme)
                         .attr('data-theme', cTheme);
    }



    function myapp(client) {
      console.log(client);
      Backbone.Force.initialize(client);
	  
      var app = {}; // create namespace for our app
	  	console.log("backbone started");
	
      //--------------
      // Models
      //--------------
      app.Contact = Backbone.Force.Model.extend({
        type:'Contact',
        fields:['Id', 'Name', 'FirstName', 'LastName', 'Email']
      });

      //--------------
      // Collections
      //--------------
      app.ContactsCollection = Backbone.Force.Collection.extend({
        model: app.Contact,
        query: "WHERE IsDeleted = false"
      }),

      //--------------
      // Views
      //--------------

      // renders individual Contact list item (li)
      app.ContactView = Backbone.View.extend({
        tagName: 'li',
        template: _.template($('#contact-template').html()),
        render: function(){
          this.$el.html(this.template(this.model.toJSON()));
          return this; // enable chained calls
        },
        initialize: function(){
        }
      });

		console.log("contact list init");
	

      // renders individual Contact for editing
      app.ContactDetailView = Backbone.View.extend({
        template: _.template($('#contact-detail-template').html()),
        render: function(){
          this.$el.html(this.template(this.model.toJSON()));
          return this; // enable chained calls
        },
        initialize: function(){
          this.model.on('destroy', this.remove, this);
          this.render();
        },
        events: {
          'change' : 'change',
          'click .save' : 'save',
          'click .destroy': 'destroy'
        },
        change: function (event) {
            // Apply the change to the model
            var target = event.target;
            var change = {};
            change[target.name] = target.value;
            this.model.set(change);
        },
        save: function(){
          this.model.save(null, {
            success: function(model) {
				app.router.navigate('contacts', {trigger: true});
            },
            error: function () {
              alert('Error saving');
            }
          });
          return false;
        },
        destroy: function(){
          this.model.destroy({
            success: function() {
				app.router.navigate('contacts', {trigger: true});              
            },
              error: function () {
                alert('Error deleting');
              }
          });
          return false;
        }
      });

	  	console.log("contact edit init");
	

      // renders the full list of Contacts calling ContactView for each one.
      app.ContactsView = Backbone.View.extend({
        template: _.template($('#contacts-template').html()),
        initialize: function() {
          this.render();
          this.input = this.$('#new-contact');
          this.model.on('add', this.render, this);
          this.model.on('reset', this.render, this);
        },
        events: {
          'click .new' : 'newContact',
          'change .theme-selector' : 'changeTheme'
        },
        createContactOnEnter: function(e){
          if ( e.which !== 13 || !this.input.val().trim() ) { // ENTER_KEY = 13
            return;
          }
          // Wait for the server response so we have the Id with which to render 
          // the new Contact
          this.model.create(this.newAttributes(), {wait: true});
          this.input.val(''); // clean input box
        },
        renderOne: function(contact){
          var view = new app.ContactView({model: contact});
          this.$('#contact-list').append(view.render().el);
        },
        render: function(){
          this.$el.html(this.template());
          this.$('#contact-list').empty();
          for (var i = 0, l = this.model.models.length; i < l; i++) {
            this.renderOne(this.model.models[i]);
          }
        },
        newAttributes: function(){
          return {
            Name: this.input.val().trim()
          }
        },
        changeTheme: function(event){
          event.preventDefault();
          
          var theme = $(event.target).children("option").filter(":selected").text();

          changeTheme(theme);
        },
        newContact: function(){
          app.router.navigate('/new', true);
          return false;
        }
      });

			console.log("contact render init");
		
			console.log("contact router init begin");				
      //Define the Application Router
      app.Router = Backbone.Router.extend({ 
        routes: {
          "": "contacts",
          "contacts": "contacts",
		  "new": "newContact",
          ":id": "contact"
        },          
        contacts: function() {
          var contactsCollection = new app.ContactsCollection();
		  console.log("collection begin");	
          $.mobile.loading( "show", { text: 'Loading Contacts', textVisible: true } );
          console.log("collection search");
          contactsCollection.fetch({success: function(){
            console.log("collection found");
                                   
            $.mobile.loading( "hide" );
            $("#contacts-content").html(new app.ContactsView({model: contactsCollection}).el);
            // Let jQuery Mobile do its stuff
            $("#contacts-content").trigger( 'create' );
            $.mobile.changePage( "#contacts" , { reverse: false, changeHash: false } );
         },error: function(model, response) {console.log('ERROR::'+response.responseText);}});
		 console.log("collection end");	
		
        },
        contact: function(id) {
          console.log("contact read begin");	
		  var contact = new app.Contact({Id: id});
          $.mobile.loading( "show", { text: 'Loading Contact', textVisible: true } );
          contact.fetch({success: function(){
            $.mobile.loading( "hide" );
            $("#contact-content").html(new app.ContactDetailView({model: contact}).el);
            $("#contact-content").trigger( 'create' );
            $.mobile.changePage( "#contact" , { reverse: false, changeHash: false } );
          }});
        },
        newContact: function(id) {
          console.log("new contact begin");	
		  var contact = new app.Contact();
          $("#contact-content").empty();
          $("#contact-content").html(new app.ContactDetailView({model: contact}).el);
          $("#contact-content").trigger( 'create' );
          $.mobile.changePage( "#contact" , { reverse: false, changeHash: false } );
        }
      });
	
   	  app.router = new app.Router();
		console.log("contact router init end");
      Backbone.history.start();
		console.log("backbone end");
		
    }
  </script>

</body>
</html>