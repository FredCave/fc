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

    sidebarText: false,

    currentTextBlock: 0,

    nextLayerPrimed: false

}

/*****************************************************************************

*****************************************************************************/

var Page = {

    init: function () {

        console.log("Page.init");

        this.bindEvents();

        this.srcInit();

        // PLACES HYPERLINK AFTER IFRAME HAS LOADED
        this.nextLayerInit();

        Transmissions.init();

    },

    bindEvents: function () {

        console.log("Page.bindEvents");

        $("#hyperlink").on("mouseover", function(){
            if ( Page.hyperLinkActive ) {
                Page.nextFadeIn();                
            }
        }).on("mouseout", function(){
            // IF NEXT LAYER PRIMED
            if ( Data.nextLayerPrimed ) {
                console.log(65);
                // ALLOW TIME FOR OUTGOING LAYER TO FADE OUT
                setTimeout( function (){
                    Page.nextLayerInit();           
                }, 1000 );
                Data.nextLayerPrimed = false; 
            } else {
                Page.nextFadeOut();                
            }
        }).on("click", function(){
            if ( Page.hyperLinkActive ) {
                Page.hyperLinkClick();
            }
        });

        // $("#close_button").on("mouseover", function(){
        //     console.log("Close hover.");
        //     Page.nextFadeIn(true);
        // }).on("mouseout", function(){
        //     console.log("Close hover off.");
        //     Page.nextFadeOut(true);                
        // });

        $("#close_button").on("click", function(){
            Page.infoReset();
        });

        $("#squiggle").on("click", function(){
            Sidebar.sidebarToggle();
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

        console.log( 50, nextSrc, Data.nextSrc );

        // LOAD NEXT SRC IN IFRAME
        var getNextLayer = Data.nextLayer,
            targetLayer = $(".layer").eq(getNextLayer-1),
            targetFrame = targetLayer.find("iframe");

        console.log( 129, targetLayer.css("opacity") );

        // targetLayer.css({
        //     "z-index" : 99
        // });
        targetFrame.attr("src",nextSrc);

        // ON LOAD: PLACE HYPERLINK
        targetFrame.on( "load", function(){
            
            console.log( 120, "iframe loaded" );
            
            // ACTIVATE HYPERLINK
            Page.hyperLinkActive = true;
            Page.placeHyperLink();
        });

    },

    backgroundChecker: function ( frame ) {

        console.log("Page.backgroundChecker");

        switch ( frame.attr("src") ) {
            case "http://localhost:8888/fredcave/projects/the-wake-of-dust/": 
            case "http://localhost:8888/fredcave/projects/_sublimations/": 
                // INVERT HYPERLINK + CLOSE BUTTON
                console.log("Invert hyperlink.");
                $("#hyperlink").addClass("inverted");
                $("#close_button .close_button_black").removeClass("selected");
                $("#close_button .close_button_white").addClass("selected");
                break;
            default:
                // NORMAL HYPERLINK
                console.log("Normal hyperlink.");
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
            delay = 500;
            Data.hyperLinkVisible = true;
        }
        setTimeout( function(){
            $("#hyperlink").css(cssValues);            
        }, delay );

    },  

    // placeHyperLinkFirstTime: function () {

    //     console.log("Page.placeHyperLinkFirstTime");

    //     var delay = Math.random() * 2 + 1000, // INITIAL DELAY OF BETWEEN 1 & 3 SEC
    //         corners = [
    //             ["top_left","top","left"],
    //             // ["top_right","top","right"],
    //             ["bottom_right","bottom","right"],
    //             ["bottom_left","bottom","left"]
    //         ],
    //         pick = Math.ceil( Math.random() * 4 ) - 1, // MINUS 1 BECAUSE ZERO-INDEXED ARRAY
    //         gutter_1,
    //         gutter_2,
    //         rand = Math.floor( Math.random() ) + 1,
    //         other = 3 - rand,
    //         value = "50px",
    //         randValue = Math.random() * $(window).height() * 0.8;

    //     $("#hyperlink").addClass( corners[pick][0] );
        // EX: IF TOP_LEFT COULD BE TOP OR LEFT GUTTERS
        // switch ( pick ) {
        //     case 0 :
        //         gutter_1 = corners[pick][rand];
        //         gutter_2 = corners[pick][other];
        //         break;
        //     case 1 :
        //         gutter_1 = corners[pick][rand];
        //         gutter_2 = corners[pick][other];
        //         break;
        //     case 2 :
        //         gutter_1 = corners[pick][rand];
        //         gutter_2 = corners[pick][other];
        //         break;
        //     case 3 :
        //         gutter_1 = corners[pick][rand];
        //         gutter_2 = corners[pick][other];
        //         break;
        // }
    //     gutter_1 = corners[pick][rand];
    //     gutter_2 = corners[pick][other];

    //     console.log( gutter_1, gutter_2 );

    //     setTimeout( function(){
    //         $("#hyperlink").css(gutter_1,value);  
    //         $("#hyperlink").css(gutter_2,randValue);            
    //     }, delay );

    // },

    nextFadeIn: function ( info ) {

        console.log("Page.nextFadeIn",info);

        var targetFrame;
        if ( !info ) {
            console.log("Not info.");
            targetFrame = $(".layer").eq( Data.nextLayer - 1 ); 
        } 
        // else {
        //     targetFrame = $("#home_wrapper");
        //     console.log("Info.", targetFrame);
        // }
        targetFrame.css({
            "opacity" : 0.6,
            "z-index" : 99
        });  

    },

    nextFadeOut: function ( info ) {

        console.log("Page.nextFadeOut");

        var targetFrame;
        if ( !info ) {
            targetFrame = $(".layer").eq( Data.nextLayer - 1 ); 
        } else {
            targetFrame = $("#home_wrapper");
        }
        targetFrame.css({
            "opacity" : "",
            "z-index" : ""
        });   

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

        // DEACTIVATE HYPERLINK
        Page.hyperLinkActive = false;
        // MOVE HYPERLINK
        this.placeHyperLink();
        // LOAD NEXT SRC
        // this.nextLayerInit();

    },

    layerLoad: function () {

        console.log("Page.layerLoad");

        var targetLayer = $(".layer").eq( Data.nextLayer - 1 ),
            targetFrame = targetLayer.find("iframe"); 

        // FADE OUT INFO + SIBLING
        $("#home_wrapper").fadeOut();

        targetLayer.css({
            "opacity": 1,
            "pointer-events" : "auto",
            "z-index" : 9
        }).siblings(".layer").css({
            "pointer-events" : "",
            "opacity" : 0          
        });  
        targetLayer.css({"overflow":"auto"});
        // TOGGLE NEXT LAYER
        Data.nextLayer = Data.nextLayer === 1 ? 2 : 1;

        this.backgroundChecker( targetFrame );

        this.closeButtonCheck();

        // PRIME NEXT SRC – TO BE LOADED ON MOUSEOUT
        Data.nextLayerPrimed = true;

    },

}


$( document ).ready(function() {

    "use strict";
    Page.init();

});