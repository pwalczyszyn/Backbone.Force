# Mobile Pack for Backbone.js

<p align='center'>
  <img src="http://res.cloudinary.com/hy4kyit2a/image/upload/v1365281769/ypqq9g8at1y1yqoo8h6g.png"/>
</p>

***[Backbone.js](http://backbonejs.org/)*** provides a structure for JavaScript-heavy applications by providing **models** with key-value binding and custom events, **collections** with a rich API of enumerable functions, and **views** with declarative event handling, while connecting it all to your existing application over a RESTful JSON interface. This Mobile Pack presents a [single page](http://en.wikipedia.org/wiki/Single-page_application) JavaScript contact management app that demonstrates how to use Backbone with the Force.com REST API to retrieve data from Salesforce from either a Visualforce page or an external mobile web app implemented in PHP or Node.js.

## Getting Started

The Mobile Pack for Backbone.js supports two deployment options for your HTML5 mobile app. 

1. To use the Mobile Pack with a Visualforce page (i.e. host the app on Force.com), follow [this quick start](https://events.developerforce.com/mobile/getting-started/html5#backbone).
2. To deploy your HTML5 app externally (e.g. on [Heroku](http://www.heroku.com/)) and source data from Salesforce, follow [this quick start](https://events.developerforce.com/mobile/getting-started/html5#backbone-heroku).
 
## What’s included in this Mobile Pack

* `backbone.force.js` - a plugin library, originally written by [Piotr Walczyszyn](https://github.com/pwalczyszyn), but since extended for the Mobile Packs, that enables Force.com connectivity for Backbone's Model and Collection types.
* `Samples/BackboneVFJQueryMobile` - a Visualforce page and supporting static resources that implements the single page contact management app.
* `Samples/BackboneBootStrap` - sample mobile web applications that can be deployed outside Force.com; for example, to Heroku. Each serves up the same single page contact management app, but includes a back end implemented for a different web environment:
 * `Samples/BackboneBootStrap/nodejs` - for Node.js
 * `Samples/BackboneBootStrap/php` - for PHP

![Main jQuery Mobile Sample Page](http://developerforce.github.com/Backbone.Force-Samples/jqm-login.png) ![Main jQuery Mobile Sample Page](http://developerforce.github.com/Backbone.Force-Samples/jqm-auth.png)

![Main jQuery Mobile Sample Page](http://developerforce.github.com/Backbone.Force-Samples/jqm-main.png) ![Detail jQuery Mobile Sample Page](http://developerforce.github.com/Backbone.Force-Samples/jqm-detail.png)
 
## Learn More

For much more information building enterprise mobile applications on Force.com with Mobile Packs, go to the [Mobile Packs home page](https://events.developerforce.com/mobile/services/mobile-packs).