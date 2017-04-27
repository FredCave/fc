var app = app || {};

app.Data = {

    projectVis: false,

    nextProject : 0,

    // nextLayer : 0,

    hyperLinkVisible: false,

    hyperLinkActive: false,

    srcLoaded: false,

    zIndex: 1,

    current: ""

}

$(function() {

    console.log( "Ready." );

    var appView;

    var appRouter = new app.MainRouter();
    Backbone.history.start({});

});