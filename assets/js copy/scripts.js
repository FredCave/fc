/*****************************************************************************

*****************************************************************************/

var Data = {

    // HOW TO GET SOURCES FROM PHP??

    sources : ["http://localhost:8888/fredcave/projects/the-electronic-cottage/",
                "http://localhost:8888/fredcave/projects/dogwood-ii/",
                "http://localhost:8888/fredcave/projects/once-removed/",
                "http://localhost:8888/fredcave/projects/night-light/",
                "http://localhost:8888/fredcave/projects/all-that-is-solid/",
                "http://localhost:8888/fredcave/projects/after-party/",
                "http://localhost:8888/fredcave/projects/the-wake-of-dust/",
                "http://localhost:8888/fredcave/projects/_sublimations/",
                "http://localhost:8888/fredcave/projects/eden-book/", 
                "http://localhost:8888/fredcave/projects/93-to-infinity"],

    nextSrc : 0,

    nextLayer : 1,

    hyperLinkVisible: false,

    hyperLinkActive: false,

    currentTextBlock: 0

}

/*****************************************************************************

*****************************************************************************/

var Page = {

    init: function () {

        console.log("Page.init");

        this.bindEvents();

        this.srcInit();

        // Transmissions.init();

    },

    bindEvents: function () {

        console.log("Page.bindEvents");

        $("#hyperlink").on("mouseover", function(){
            if ( Data.hyperLinkActive ) {
                Page.nextFadeIn();
            }
        }).on("mouseout", function(){
            if ( Data.hyperLinkActive ) {
                Page.nextFadeOut();
            }
        }).on("click", function(){
            if ( Data.hyperLinkActive ) {
                Page.hyperLinkClick();
            }
        });

        $("#close_button").on("click", function(){
            Page.infoReset();
        });

        $("#squiggle").on("click", function(){
            Sidebar.sidebarToggle();
        });  

        $(".plus a").on("click", function(e){
            e.preventDefault();
            Page.showMore( $(this) );
        });    

    },

    srcInit: function () {

        console.log("Page.srcInit");

        // SHUFFLE SRCs
        var sources = Data.sources;
        for ( var i = sources.length - 1; i > 0; i-- ) {
            var j = Math.floor(Math.random() * (i + 1));
            var temp = sources[i];
            sources[i] = sources[j];
            sources[j] = temp;
        }

        // LOAD FIRST SRC
        var nextSrc = sources[ Data.nextSrc ];
        $(".layer").eq( Data.nextLayer - 1 ).find("iframe").attr("src", nextSrc);
        // PLACE + ACTIVATE HYPERLINK
        this.placeHyperLink();

    },

    infoReset: function () {

        console.log("Page.infoReset");

        $("#home_wrapper").fadeIn(1000);
        $("#close_button").fadeOut(1000);
        $(".layer").css({
            "opacity" : 0,
            "pointer-events" : "none"
        });
        $("#hyperlink").removeClass("inverted");

    },

    showMore: function ( click ) {

        console.log("Page.showMore");

        var plus = click.parent(".plus");
        // FADE OUT PLUS
        // plus.css("opacity", 0);
        // setTimeout( function(){
        //     plus.remove();
        // }, 1000 );

        plus.hide();
        // CHECK IF LAST PLUS
        if ( plus.hasClass("transmission") ) {
            Transmissions.init();
            return;
        } 
        // FADE IN TEXT
        plus.next(".hidden").css({
            "opacity" : 1,
            "pointer-events" : "auto"
        });
        // SHOW FOLLOWING PLUS
        if ( plus.parent(".info").next(".info").length ) {
            plus.parent(".info").next(".info").fadeIn();
        }

    },

    nextLayerInit: function () {

        console.log("Page.nextLayerInit");

        // GET NEXT IFRAME SRC
        var index = Data.nextSrc;
            nextSrc = Data.sources[index];

        // IF LAST IN ARRAY
        if ( index === Data.sources.length ) {
            Data.nextSrc = 0;
        } else {
            Data.nextSrc++;
        }

        // LOAD NEXT SRC IN IFRAME
        var getNextLayer = Data.nextLayer,
            targetLayer = $(".layer").eq(getNextLayer-1),
            targetFrame = targetLayer.find("iframe");

        targetLayer.css({
            "z-index" : 99,
            "opacity" : 0
        }).hide(); // HIDE TEMPORARILY WHILE LOADING
        targetFrame.attr("src",nextSrc);

        // ON LOAD: PLACE HYPERLINK
        targetFrame.on( "load", function(){
            
            // ACTIVATE HYPERLINK
            Data.hyperLinkActive = true;
            targetLayer.show();

        });

    },

    backgroundChecker: function ( frame ) {

        console.log("Page.backgroundChecker");

        switch ( frame.attr("src") ) {
            case "http://localhost:8888/fredcave/projects/the-wake-of-dust/": 
            case "http://localhost:8888/fredcave/projects/_sublimations/": 
                // INVERT HYPERLINK + CLOSE BUTTON
                $("#hyperlink").addClass("inverted");
                $("#close_button .close_button_black").removeClass("selected");
                $("#close_button .close_button_white").addClass("selected");
                break;
            default:
                // NORMAL HYPERLINK
                $("#hyperlink").removeClass("inverted");
                $("#close_button .close_button_white").removeClass("selected");
                $("#close_button .close_button_black").addClass("selected");
        } 

    },

    placeHyperLink: function () {
    
        console.log("Page.placeHyperLink");

        var cssValues,
            rand = Math.random(),
            initialClass,
            delay = 0;
        if ( rand < 0.33 ) {
            cssValues = {
                "left" : "5%",
                "top" : (Math.random() * 0.5 + 0.1) * 100 + "%"
            };
            initialClass = "bottom_left";
        } else if ( rand < 0.67 ) {
            cssValues = {
                "top" : "5%",
                "left" : (Math.random() * 0.5 + 0.1) * 100 + "%"
            };
            initialClass = "top_left";
        } else {
            cssValues = {
                "top" : "75%",
                "left" : (Math.random() * 0.8 + 0.1) * 100 + "%"
            };
            initialClass = "bottom_right";
        }
        if ( !Data.hyperLinkVisible ) {
            $("#hyperlink").addClass(initialClass);
            // TRANSLATE BOTTOM + RIGHT VALUES TO TOP + LEFT
            var initialTop = $("#hyperlink").offset().top,
                initialLeft = $("#hyperlink").offset().left;
            $("#hyperlink").css({
                "bottom" : "inherit",
                "right" : "inherit",
                "top" : initialTop,
                "left" : initialLeft
            });    
            delay = 1000;
            Data.hyperLinkVisible = true;
        }
        setTimeout( function(){
            $("#hyperlink").css(cssValues); 
            // ACTIVATE HYPERLINK
            Data.hyperLinkActive = true;           
        }, delay );

    },  

    nextFadeIn: function () {

        console.log("Page.nextFadeIn");

        var targetFrame = $(".layer").eq( Data.nextLayer - 1 ); 

        targetFrame.stop();
        targetFrame.animate({
            opacity: 0.6
        }, 2000 );
        $("#caption_wrapper").animate({
            opacity: 0.6
        }, 2000 );

    },

    nextFadeOut: function ( info ) {

        console.log("Page.nextFadeOut", Data.nextLayer);

        var targetFrame = $(".layer").eq( Data.nextLayer - 1 ); 

        targetFrame.stop();
        targetFrame.animate({
            opacity: 0
        }, 2000 );
        $("#caption_wrapper").animate({
            opacity: 0
        }, 2000 );

    },

    closeButtonCheck: function () {

        console.log("Page.closeButtonCheck");

        // IF FIRST TIME: SHOW CLOSE BUTTON
        if ( !$("#close_button").is(":visible") ) {
            $("#close_button").fadeIn();
        } 

    },

    hyperLinkClick: function () {

        console.log("Page.hyperLinkClick");

        // HYPERLINK FUNCTIONS
            // DEACTIVATE + MOVE
        Data.hyperLinkActive = false;
        this.placeHyperLink();

        // LAYER FUNCTIONS
        this.layerLoad();
        // FADE OUT LAYER THEN LOAD NEXT SRC
        var outLayer = $(".layer").eq( Data.nextLayer - 1 ).siblings(".layer");
        outLayer.animate({
            opacity : 0 
        }, 2000, function (){
            Data.nextSrc++;
            Data.nextLayer = Data.nextLayer === 1 ? 2 : 1;
            setTimeout( function(){
                Page.nextLayerInit();            
            }, 500 );            
        });

    },

    layerLoad: function () {

        console.log("Page.layerLoad");

        var targetLayer = $(".layer").eq( Data.nextLayer - 1 ),
            targetFrame = targetLayer.find("iframe"); 

        // FADE OUT INFO + SIBLING
        $("#home_wrapper").fadeOut();

        targetLayer.animate({
            opacity: 1
        }, 2000, function() {
            targetLayer.css({
                "pointer-events" : "auto",
                "z-index" : 9,
                "overflow" : "auto"               
            });
        });

        this.backgroundChecker( targetFrame );

        this.closeButtonCheck();

    },

}


$( document ).ready(function() {

    "use strict";
    Page.init();

});