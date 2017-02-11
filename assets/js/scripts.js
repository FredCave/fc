/*****************************************************************************

*****************************************************************************/

var Data = {

    // HOW TO GET SOURCES FROM PHP??

    sources : ["http://localhost:8888/fredcave/projects/the-electronic-cottage/",
                "http://localhost:8888/fredcave/projects/dogwood-ii/",
                "http://localhost:8888/fredcave/projects/once-removed/",
                "http://localhost:8888/fredcave/projects/night-light-1/",
                "http://localhost:8888/fredcave/projects/night-light-2/",
                "http://localhost:8888/fredcave/projects/night-light-3/",
                "http://localhost:8888/fredcave/projects/all-that-is-solid/",
                "http://localhost:8888/fredcave/projects/narcissus-dissolve/",
                "http://localhost:8888/fredcave/projects/the-wake-of-dust/",
                "http://localhost:8888/fredcave/projects/eden-book/"],

    nextLayer : 1,

    hyperLinkVisible: false,

    sidebarText: false,

    currentTextBlock: 0

}


/*****************************************************************************

*****************************************************************************/

var Page = {

    init: function () {

        console.log("Page.init");

        this.bindEvents();

        // THIS PLACES HYPERLINK AFTER IFRAME HAS LOADED
        this.nextLayerInit();

    },

    bindEvents: function () {

        console.log("Page.bindEvents");

        $("#hyperlink").on("mouseover", function(){
            Page.nextFadeIn();
        }).on("mouseout", function(){
            Page.nextFadeOut();
        }).on("click", function(){
            Page.layerLoad();
        });

        $("#close_button").on("click", function(){
            Page.infoReset();
        });

        $("#squiggle").on("click", function(){
            Page.sidebarToggle();
        });      

    },

    infoReset: function () {

        console.log("Page.infoReset");

        $("#home_wrapper").fadeIn(1000);

        $("#close_button").fadeOut(1000);
        $(".layer").css({"opacity":0});

    },

    nextLayerInit: function () {

        console.log("Page.nextLayerInit");

        // GET NEXT IFRAME SRC
        var index = Math.floor( Math.random() * Data.sources.length ),
            nextSrc = Data.sources[index];

        console.log( 50, nextSrc );

        // LOAD NEXT SRC IN IFRAME
        var getNextLayer = Data.nextLayer,
            targetFrame = $(".layer").eq(getNextLayer-1).find("iframe");
        targetFrame.attr("src",nextSrc);

        // ON LOAD: PLACE HYPERLINK
        targetFrame.on( "load", function(){
            
            console.log( 120, "iframe loaded" );
            
            Page.placeHyperLink();
        });

    },

    placeHyperLink: function () {

        console.log("Page.placeHyperLink");

        // CHECK IF HYPERLINK IS NOT VISIBLE
        if ( !Data.hyperLinkVisible ) {
            this.placeHyperLinkFirstTime();
        }

    },  

    placeHyperLinkFirstTime: function () {

        console.log("Page.placeHyperLinkFirstTime");

        var delay = ( Math.random() * 2 ) * 1000 + 2000, // INITIAL DELAY OF BETWEEN 2 & 4 SEC
            corners = [
                ["top_left","top","left"],
                ["top_right","top","right"],
                ["bottom_right","bottom","right"],
                ["bottom_left","bottom","left"]
            ],
            pick = Math.ceil( Math.random() * 4 ) - 1, // MINUS 1 BECAUSE ZERO-INDEXED ARRAY
            gutter_1,
            gutter_2,
            rand = Math.floor( Math.random() * 2 ) + 1,
            other = 3 - rand,
            value = "50px",
            randValue = Math.random() * $(window).height() * 0.8;

        $("#hyperlink").addClass( corners[pick][0] );
        // EX: IF TOP_LEFT COULD BE TOP OR LEFT GUTTERS
        switch ( pick ) {
            case 0 :
                gutter_1 = corners[pick][rand];
                gutter_2 = corners[pick][other];
                break;
            case 1 :
                gutter_1 = corners[pick][rand];
                gutter_2 = corners[pick][other];
                break;
            case 2 :
                gutter_1 = corners[pick][rand];
                gutter_2 = corners[pick][other];
                break;
            case 3 :
                gutter_1 = corners[pick][rand];
                gutter_2 = corners[pick][other];
                break;
        }
        setTimeout( function(){
            $("#hyperlink").css(gutter_1,value);  
            $("#hyperlink").css(gutter_2,randValue);            
        }, delay );

    },

    nextFadeIn: function () {

        console.log("Page.nextFadeIn");

        var targetFrame = $(".layer").eq( Data.nextLayer - 1 ); 
        targetFrame.css({"opacity":0.5});  

    },

    nextFadeOut: function () {

        console.log("Page.nextFadeOut");

        var targetFrame = $(".layer").eq( Data.nextLayer - 1 ); 
        targetFrame.css({"opacity":""});   

    },

    closeButtonCheck: function () {

        console.log("Page.closeButtonCheck");

        // IF FIRST TIME: SHOW CLOSE BUTTON
        if ( !$("#close_button").is(":visible") ) {
            $("#close_button").fadeIn();
        } 

    },

    layerLoad: function () {

        console.log("Page.layerLoad");

        var targetFrame = $(".layer").eq( Data.nextLayer - 1 ); 
        targetFrame.css({"opacity":1});  
        // TOGGLE NEXT LAYER
        Data.nextLayer = Data.nextLayer === 1 ? 2 : 1;

        this.closeButtonCheck();

        // FADE OUT INFO
        $("#home_wrapper").fadeOut(1000);

        // LOAD NEXT SRC + PLACE HYPERLINK
        // THIS ONLY ON MOUSEOUT
        this.nextLayerInit();

    },

    sidebarToggle: function () {

        console.log("Page.sidebarToggle");

        if ( !$("#sidebar").hasClass("visible") ) {
            $("#sidebar").css({"right":0}).addClass("visible");
            // IF FIRST TIME
            if ( !Data.sidebarText ) {
                this.textInit();
            } 
        } else {
            $("#sidebar").css({"right":""}).removeClass("visible");           
        }

    },

    textInit: function () {

        console.log("Page.textInit");

        var blocks;

        // LOADING BLOCK
        $("#text_wrapper").append("<div class='text_block'><p class='loading'>Receiving</p></div>");

        // LOAD EXTERNAL SCRIPTS HERE

        // 2000 DELAY
        setTimeout( function () {
            // GET STATIC TEXT
            $.ajax({
                url: "wp-json/wp/v2/projects/112",
                success: function ( data ) {
                    // PARSE BLOCK BY BLOCK
                    blocks = Page.textParse(data.acf.project_texts[0]["project_text"]);
                    // START CONVERSATION
                    Page.conversation( blocks, 0 );
                }
            });
        }, 2000 );

        // LOOP THROUGH BLOCKS
            // FOR EACH:
                // APPEND TO PAGE
                // SEND TO BOT 
                // ECHO RESPONSE
                // RUN HEIGHT CHECKER 
                    // IF TOO HIGH:
                        // SHIFT FIRST ELEMENT






    },

    parseForBot: function ( string ) {

        console.log("Page.parseForBot", string);

        str = string.replace( " ", "+" );
        return str;

    },

    conversation: function ( array, instance ) {

        console.log("Page.conversation");

        // PRINT LOCAL BLOCK
        var newElem = "<div class='text_block'>" + textArray[Data.currentTextBlock] + "</div>";
        $("#text_wrapper").append(newElem);
        // IF FIRST TIME : HIDE FIRST BLOCK
        if ( Data.currentTextBlock === 0 ) {
            setTimeout( function(){
                Page.hideFirstBlock();                
            }, 500 );
        }
        // PARSE BLOCK
        cleanText = textArray[Data.currentTextBlock].replace(/<\/?[^>]+(>|$)/g, "");

        console.log( 283, Page.parseForBot(cleanText) );

        // SEND LOCAL BLOCK TO BOT
        // DELAY OF 2 SECONDS
        setTimeout( function(){
            $.ajax( {
                method: "GET",
                dataType: "text",
                url: "http://www.botlibre.com/rest/botlibre/form-chat?application=4581146104707647883&instance=15464920&message=" + Page.parseForBot(cleanText),
                success: function ( data ) {
                    
                    console.log( 300, data );
                    
                    // PARSE RESULT
                    var replyXML = $.parseXML( data ),
                        replyText = $(replyXML).find("message").html(),
                        replyElem = "<div class='text_block'><p>" + replyText + "</p></div>";

                    // PRINT RESPONSE
                    $("#text_wrapper").append(replyElem);

                    // RUN HEIGHT CHECKER
                    Page.heightChecker();

                    // RUN FUNCTION AGAIN (INSTANCE++)
                    Data.currentTextBlock++;
                    Page.conversation( array, Data.currentTextBlock );

                }
            });
        }, 2000 );

    }, 

    heightChecker: function () {

        console.log("Page.heightChecker");

        // GET HEIGHT OF ELEMENTS IN TEXT WRAPPER
        var wrapperH = $("#sidebar").height(),
            elemsH = $("#text_wrapper").height();

        if ( elemsH > wrapperH * 0.5 ) {
            Page.hideFirstBlock();
        }


    },

    textParse: function ( data ) {

        console.log("Page.textParse");

        // SPLIT AT LINE BREAKS
        textArray = data.split("\n");
        // RETURN ARRAY
        return textArray;

    },

    hideFirstBlock: function () {

        console.log("Page.hideFirstBlock");

        var firstBlock = $("#text_wrapper .text_block").eq(0),
            blockH = firstBlock.height() * 2;

        // TRANSLATEY ON TEXT                
        firstBlock.find("p").css({"transform":"translateY(-" + blockH + "px)"});
        // 500 DELAY
        setTimeout( function(){
            $("#text_wrapper .text_block").eq(0).slideUp(500);
            setTimeout( function(){
                $("#text_wrapper .text_block").eq(0).remove();
            }, 500 );
        }, 500 );
                
    },

    textInject: function ( textArray ) {

        console.log("Page.textInject", Data.currentTextBlock );

        // setTimeout( function (){
        //     if ( Data.currentTextBlock < textArray.length ) {
        //         if ( Data.currentTextBlock > 3 ) {
        //             Page.hideFirstBlock();
        //         }
        //         var newElem = "<div class='text_block'>" + textArray[Data.currentTextBlock] + "</div>";
        //         $("#text_wrapper").append(newElem);
        //         Page.textInject( textArray );
        //     }
        //     Data.currentTextBlock++;
        // }, 3000 );

    }

}

/*****************************************************************************
    
	2. EVENTS

*****************************************************************************/

$( document ).ready(function() {

	//	WINDOW EVENTS
	$(window).on( "load", function(){

        Page.init();

	});

});