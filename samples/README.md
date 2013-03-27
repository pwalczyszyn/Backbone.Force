# Backbone.Force Samples

This repository contains a range of single page JavaScript apps that work with Backbone.Force.

The apps use [backbone.force.js](https://github.com/metadaddy-sfdc/Backbone.Force/blob/remotetk/backbone.force.js) from [Pat Patterson's fork of Piotr Walczyszyn's Backbone.Force](https://github.com/metadaddy-sfdc/Backbone.Force/tree/remotetk) (note - the link is to the **remotetk** branch) as it contains fixes necessary for the following samples to work. The backbone.force.js file is included in [resources.zip](https://github.com/developerforce/Backbone.Force-Samples/blob/master/resources.zip) alongside forcetk.js, backbone.js, and other JavaScript, CSS and image files you need to run the samples.

Each of the samples implements the same basic app, a simple Account browser that lists all the Account records that you are able to read. Two alternate interfaces are implemented, leveraging [jQuery Mobile](http://jquerymobile.com/) and [Bootstrap](http://twitter.github.com/bootstrap/) in turn, along with three data access options: [ForceTK](http://blogs.developerforce.com/developer-relations/2011/03/calling-the-rest-api-from-javascript-in-visualforce-pages.html), [RemoteTK](http://blogs.developerforce.com/developer-relations/2012/10/not-calling-the-rest-api-from-javascript-in-visualforce-pages.html) (both deployed as a Visualforce page in Force.com) and Web App (deployed as an HTML page outside Force.com).

You can install an [unmanaged package containing all of the Visualforce Sample apps](https://login.salesforce.com/packaging/installPackage.apexp?p0=04ti0000000UIMe). The package includes a Force.com app comprising a page of links to the individual samples.

If you prefer, you can clone this git repository, upload the following file to an org:

* [resources.zip](https://github.com/developerforce/Backbone.Force-Samples/blob/master/resources.zip) - Static Resource with JavaScript libraries, CSS, etc

and pick out the files for individual samples.

## jQuery Mobile Sample

This sample app uses jQuery Mobile to implement the look and feel of a mobile app from HTML5, CSS and JavaScript.

![Main jQuery Mobile Sample Page](http://developerforce.github.com/Backbone.Force-Samples/jqm-main.png)

You can add a new account, click an existing account to view and modify its Name and Industry fields, and remove Accounts.

![Detail jQuery Mobile Sample Page](http://developerforce.github.com/Backbone.Force-Samples/jqm-detail.png)

The samples disable jQuery Mobile's handling of hashchange events, [as detailed in the jQuery Mobile docs](http://view.jquerymobile.com/1.3.0/docs/examples/backbone-require/index.php), giving the task to a Backbone Router.

### JQMAccountForceTK.page

Simple Account CRUD from Visualforce with ForceTK. This approach consumes API calls in your org, but is easier to setup than the RemoteTK option.

You'll need:

* [JQMAccountForceTK.page](https://github.com/developerforce/Backbone.Force-Samples/blob/master/JQMAccountForceTK.page) - Visualforce Page

### JQMAccountRemoteTK.page

Simple Account CRUD from Visualforce with RemoteTK. This approach uses [JavaScript Remoting](http://www.salesforce.com/us/developer/docs/pages/Content/pages_js_remoting.htm) and requires a Visualforce Component and Apex Class as support, but does not consume API calls.

As well as the Visualforce page from this repository...

* [JQMAccountRemoteTK.page](https://github.com/developerforce/Backbone.Force-Samples/blob/master/JQMAccountRemoteTK.page) - Visualforce Page

you will also need the following files from the [Force.com JavaScript REST Toolkit](https://github.com/developerforce/Force.com-JavaScript-REST-Toolkit).

* [RemoteTKController.cls](https://github.com/developerforce/Force.com-JavaScript-REST-Toolkit/blob/master/RemoteTKController.cls) - Apex Class
* [RemoteTK.component](https://github.com/developerforce/Force.com-JavaScript-REST-Toolkit/blob/master/RemoteTK.component) - Visualforce Component
* [TestRemoteTKController.cls](https://github.com/developerforce/Force.com-JavaScript-REST-Toolkit/blob/master/TestRemoteTKController.cls) - (Optional) Apex Test Class

### JQMAccountWebApp.html

Simple Account CRUD from a web page outside Force.com - e.g. Heroku, or an on-premise system. You can [try it out on Heroku](https://backbone-force-samples.herokuapp.com/JQMAccountWebApp.html); log in with credentials for any org that has access to Accounts (e.g. Developer Edition, Sales or Service Cloud). We strongly recommend you do NOT test this app on production data!

* [JQMAccountWebApp.html](https://github.com/developerforce/Backbone.Force-Samples/blob/master/JQMAccountWebApp.html) - Visualforce Page

To run the sample yourself, you will need to unzip resources.zip into your web app directory. To work around the [JavaScript Same-origin policy](https://developer.mozilla.org/en-US/docs/JavaScript/Same_origin_policy_for_JavaScript), you will need to run an HTTP proxy on the same protocol/host/port as BootstrapAccountWebApp.html. You can use [proxy.php](https://github.com/developerforce/Force.com-JavaScript-REST-Toolkit/blob/master/proxy.php) (from the [Force.com JavaScript REST Toolkit](https://github.com/developerforce/Force.com-JavaScript-REST-Toolkit)) if you are working in PHP.

## Bootstrap Sample

The second set of samples is styled with Bootstrap, giving a clean minimalist look which integrates well with Backbone,js.

![Main Bootstrap Sample Page](http://developerforce.github.com/Backbone.Force-Samples/main-page.png)

Again, you can add, view, modify and remove Accounts.

![Detail Bootstrap Sample Page](http://developerforce.github.com/Backbone.Force-Samples/detail-page.png)

### BootstrapAccountForceTK.page

Simple Account CRUD from Visualforce with ForceTK.

* [BootstrapAccountForceTK.page](https://github.com/developerforce/Backbone.Force-Samples/blob/master/BootstrapAccountForceTK.page) - Visualforce Page

### BootstrapAccountRemoteTK.page

Simple Account CRUD from Visualforce with RemoteTK.

* [BootstrapAccountRemoteTK.page](https://github.com/developerforce/Backbone.Force-Samples/blob/master/BootstrapAccountRemoteTK.page) - Visualforce Page

As with the jQuery Mobile sample above, you will need the [RemoteTK.component](https://github.com/developerforce/Force.com-JavaScript-REST-Toolkit/blob/master/RemoteTK.component) and [controller](https://github.com/developerforce/Force.com-JavaScript-REST-Toolkit/blob/master/RemoteTKController.cls) from the Force.com JavaScript REST Toolkit.

### BootstrapAccountWebApp.html

Simple Account CRUD from a web page outside Force.com. [Try it out on Heroku](https://backbone-force-samples.herokuapp.com/BootstrapAccountWebApp.html).

* [JQMAccountWebApp.html](https://github.com/developerforce/Backbone.Force-Samples/blob/master/JQMAccountWebApp.html) - Visualforce Page

As with the jQuery Mobile sample, you will need to run a proxy to work around the same-origin policy.
