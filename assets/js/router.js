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

        // HOME
        // new app.AppView();

        $("#home_wrapper").animate({
            opacity: 1
        }, 1000 ).removeClass("info_hidden");

        if ( app.Data.projectVis ) {
            $("#close_button").fadeOut(1000);
            $(".layer").css({
                "opacity" : 0,
                "pointer-events" : "none"
            });
            $("#hyperlink").removeClass("inverted");
        } else {
            console.log("No projects visible.");
            
            appView = new app.AppView();
            
        }

    },

    showSublimations: function () {

    	console.log("MainRouter.showSublimations");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("sublimations");            
        }

    },

    showEden: function () {

        console.log("MainRouter.showEden");
        
        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("eden");
        }

    },

    showTheWake: function () {

        console.log("MainRouter.showTheWake");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("the-wake-of-dust");
        }

    },

    showNarcissus: function () {

        console.log("MainRouter.showNarcissus");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("narcissus-dissolve");
        }

    },

    showAllThatIsSolid: function () {

        console.log("MainRouter.showAllThatIsSolid");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("all-that-is-solid-melts-into-aether");
        }

    },

    showNightLight: function () {

        console.log("MainRouter.showNightLight");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("night-light");
        }

    },

    showOnceRemoved: function () {

        console.log("MainRouter.showOnceRemoved");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("an-image-once-removed");
        }

    },

    showDogwood: function () {

        console.log("MainRouter.showDogwood");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("dogwood-ii");
        }

    },

    showElectronicCottage: function () {

        console.log("MainRouter.showElectronicCottage");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("the-electronic-cottage");
        }

    },

    showAfterParty: function () {

        console.log("MainRouter.showAfterParty");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("after-party");
        }

    },

    showInfinity: function () {

        console.log("MainRouter.showInfinity");

        // IF ALREADY LOADED
        if ( app.Data.srcLoaded ) {
            appView.showProject();
        } else {
            new app.ProjectView("93-to-infinity");
        }

    }

});