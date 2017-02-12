/*****************************************************************************

*****************************************************************************/

var Data = {

    // HOW TO GET SOURCES FROM PHP??

    sources : ["http://localhost:8888/fredcave/projects/the-electronic-cottage/",
                "http://localhost:8888/fredcave/projects/dogwood-ii/",
                "http://localhost:8888/fredcave/projects/once-removed/",
                "http://localhost:8888/fredcave/projects/night-light/",
                "http://localhost:8888/fredcave/projects/all-that-is-solid/",
                "http://localhost:8888/fredcave/projects/the-wake-of-dust/",
                "http://localhost:8888/fredcave/projects/eden-book/"],

    nextSrc : 0,

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

        this.srcInit();

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
        $(".layer").css({"opacity":0});

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
                Data.sidebarText = true;
            } 
        } else {
            $("#sidebar").css({"right":""}).removeClass("visible");           
        }

    },

    textInit: function () {

        console.log("Page.textInit");

        var blocks;

        // LOADING BLOCK
        $("#text_wrapper").append("<div class='text_block'><p class='loading'>receiving</p></div>");

        // INSERT CONTENTS OF NARCISSUS JSON INTO CONVERSATION
        setTimeout( function(){
            Page.conversation( narcissus, 0 );
        }, 2000 );

    },

    parseForBot: function ( string ) {

        console.log("Page.parseForBot");

        str = string.replace( " ", "+" );
        return str;

    },

    ajaxCall: function ( text, object ) {

        console.log("Page.ajaxCall");

        $.ajax( {
            method: "GET",
            dataType: "text",
            url: "http://www.botlibre.com/rest/botlibre/form-chat?application=_4581146104707647883&instance=15464920&message=" + Page.parseForBot(text),
            success: function ( data ) {
                                
                // PARSE RESULT
                var replyXML = $.parseXML( data ),
                    replyText = $(replyXML).find("message").html();

                Page.responseParse( replyText, object );

            },
            error: function () {

                console.log( 274, "Error receiving from server." );

                // ECHO STORED RESPONSE
                Page.responseParse( object[Data.currentTextBlock][1], object );

            }, 
            complete: function () {
  
            }
        });        

    },

    conversation: function ( object, instance ) {

        console.log("Page.conversation");

        // IF FIRST TIME : HIDE FIRST BLOCK
        if ( Data.currentTextBlock === 0 ) {
            setTimeout( function(){
                Page.hideFirstBlock();                
            }, 500 );
        }

        console.log( Data.currentTextBlock, Object.keys(object).length );

        if ( Data.currentTextBlock < Object.keys(object).length ) {

            // DELAY OF 2 SECONDS
            setTimeout( function(){
                // PRINT LOCAL BLOCK
                Page.appendWordByWord( object[Data.currentTextBlock][0], object, false );
            }, 0 ); // 2000

        } else {

            // PRINT CREDITS

            console.log("Print credits");

            var credits = "H. C. Andersen, M. Blanchot, J. B. van Helmont, E. Hemingway, B. Lee, H. Melville, H. J. Newell,T. Vesaas in conversation with Tarjei the bot.";
            Page.appendWordByWord( credits, object, false );
            
        }

    }, 

    heightChecker: function () {

        console.log("Page.heightChecker");

        // GET HEIGHT OF ELEMENTS IN TEXT WRAPPER
        var wrapperH = $("#sidebar").height(),
            elemsH = $("#text_wrapper").height();

        if ( elemsH > wrapperH * 0.6 || Data.currentTextBlock === 47 ) {

            console.log(331);

            // IF NO MORE BLOCKS
            var blocksLeft = $("#text_wrapper").children().length;
            console.log( blocksLeft, " blocks left." );
            if ( blocksLeft == 0 ) {
                
                // MOVE THIS TO OWN FUNCTION: 

                Page.sidebarToggle();
                $("#squiggle").fadeOut(1000);
                return;
            }

            Page.hideFirstBlock();
            // RUN AGAIN TO CHECK
            setTimeout( function(){
                Page.heightChecker();
            }, 1200 );
        }


    },

    responseParse: function ( response, object ) {

        console.log("Page.responseParse");

        // SPLIT INTO ARRAY       
        var sentences = response.split("."),
            responseParsed = "",
            str;
        // LOOP THROUGH SENTENCES
        for ( var i = 0; i < sentences.length; i++ ) {
            // IF "THE" OR IT AT END OF SENTENCE
            if ( sentences[i].length <= 3 ) {
                sentences[i] = ""; 
            }
            // IF NOT EMPTY STRING
            if ( sentences[i] !== "" ) {
                str = sentences[i].trim().toLowerCase();
                str = str[0].toUpperCase() + str.substring(1) + ". ";
                responseParsed += str;
            }
        }

        Page.appendWordByWord( responseParsed, object, true );
       
    },

    appendWordByWord: function ( text, object, response ) {

        console.log("Page.appendWordByWord");

        // CREATE + APPEND WRAPPER WITH ID OF CURRENT TEXT BLOCK
        var id = Data.currentTextBlock,
            wrapper,
            words = text.split(" "),
            currentWord = 0;
        if ( response ) {
            id = Data.currentTextBlock + "_response";
        }
        wrapper = "<div class='text_block'><p id='" + id + "'></p></div>";
        $("#text_wrapper").append(wrapper);
  
        // SETINTERVAL
        var interval = setInterval( function(){
            // APPEND WORD TO WRAPPER
            $("#" + id).text( $("#" + id).text() + " " + words[currentWord] );
            currentWord++;
            // WHEN NO MORE WORDS
            if ( words.length - currentWord <= 0 ) {
                clearInterval(interval);
                // RUN HEIGHT CHECKER
                Page.heightChecker();
                
                // IF NO MORE BLOCKS
                if ( Data.currentTextBlock >= Object.keys(object).length ) {
                    // HIDE ALL REMAINING BLOCKS
                    Page.heightChecker();
                    return;
                }

                // IF LOCAL
                if ( !response ) {
                    // SEND LOCAL BLOCK TO BOT + WHOLE OBJECT
                    Page.ajaxCall( object[Data.currentTextBlock][0], object );
                } else {
                    // RUN FUNCTION AGAIN (INSTANCE++)
                    Data.currentTextBlock++;
                    Page.conversation( object, Data.currentTextBlock );                     
                }
            }
        }, 0 ); // 250

    },

    hideFirstBlock: function () {

        console.log("Page.hideFirstBlock");

        var firstBlock = $("#text_wrapper .text_block").eq(0),
            blockH = firstBlock.height() * 2;
        // TRANSLATEY ON TEXT                
        firstBlock.find("p").css({"transform":"translateY(-" + blockH + "px)"});
        // 500 + 500 DELAY
        setTimeout( function(){
            $("#text_wrapper .text_block").eq(0).slideUp(500);
            setTimeout( function(){
                $("#text_wrapper .text_block").eq(0).remove();
            }, 500 );
        }, 500 );
                
    }

}

$( document ).ready(function() {

	//	WINDOW EVENTS
	$(window).on( "load", function(){

        Page.init();

	});

});