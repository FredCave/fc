var app = app || {};

app.MainRouter = Backbone.Router.extend({

    nextCaption: {
        title : "",
        description: "",
        year: ""
    },

	routes: {

        "_sublimations" : "showSublimations",

        // "eden" : "showEden",

        "the-wake-of-dust" : "showTheWake",

        "narcissus-dissolve" : "showNarcissus",

        "all-that-is-solid-melts-into-aether" : "showAllThatIsSolid",        

        "night-light" : "showNightLight",

        "an-image-once-removed" : "showOnceRemoved",

        "dogwood-ii" : "showDogwood",  

        "the-electronic-cottage" : "showElectronicCottage",     
        
        "after-party" : "showAfterParty",        

        "93-to-infinity" : "showInfinity",             

        "*other"    : "showHome"

    },

    showHome: function () {

    	console.log("MainRouter.showHome");

        // CLEAN UP HASH – ???
        history.pushState("#", document.title, window.location.pathname + window.location.search);
        
        // IF ARRIVING FROM PROJECT
        if ( app.Data.projectVis ) {
            
            $("#close_button").fadeOut(1000);
            $(".layer").css({
                "opacity" : 0,
                "pointer-events" : "none"
            }).removeClass("current");
            $("#hyperlink").removeClass("inverted");

            $("#home_wrapper").removeClass("info_hidden");

        } else {

            console.log("New load.");
            appView = new app.AppView("home");

        }

    },

    showSublimations: function () {

    	console.log("MainRouter.showSublimations");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("sublimations");            
        }

    },

    showEden: function () {

        console.log("MainRouter.showEden");
        
        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("eden");
        }

    },

    showTheWake: function () {

        console.log("MainRouter.showTheWake");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("the-wake-of-dust");
        }

    },

    showNarcissus: function () {

        console.log("MainRouter.showNarcissus");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("narcissus-dissolve");
        }

    },

    showAllThatIsSolid: function () {

        console.log("MainRouter.showAllThatIsSolid");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("all-that-is-solid-melts-into-aether");
        }

    },

    showNightLight: function () {

        console.log("MainRouter.showNightLight");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("night-light");
        }

    },

    showOnceRemoved: function () {

        console.log("MainRouter.showOnceRemoved");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("an-image-once-removed");
        }

    },

    showDogwood: function () {

        console.log("MainRouter.showDogwood");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("dogwood-ii");
        }

    },

    showElectronicCottage: function () {

        console.log("MainRouter.showElectronicCottage");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            console.log("Data already loaded.");
            appView.loadNextProject();
        } else {
            console.log("New load.");
            appView = new app.AppView("the-electronic-cottage");
        }

    },

    showAfterParty: function () {

        console.log("MainRouter.showAfterParty");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("after-party");
        }

    },

    showInfinity: function () {

        console.log("MainRouter.showInfinity");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.loadNextProject();
        } else {
            appView = new app.AppView("93-to-infinity");
        }

    }

});