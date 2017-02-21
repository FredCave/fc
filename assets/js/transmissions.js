var Transmissions = {

    init: function () {

        console.log("Transmissions.TransmissionsToggle");

        this.textInit();

    },

    textInit: function () {

        console.log("Transmissions.textInit");

        var blocks;

        // LOADING BLOCK
        $("#text_wrapper").append("<div class='text_block'><p class='loading'>receiving</p></div>");

        // INSERT CONTENTS OF NARCISSUS JSON INTO CONVERSATION
        setTimeout( function(){
            Transmissions.conversation( narcissus, 0 );
        }, 3000 );

    },

    parseForBot: function ( string ) {

        console.log("Transmissions.parseForBot");

        str = string.replace( " ", "+" );
        return str;

    },

    ajaxCall: function ( text, object ) {

        console.log("Transmissions.ajaxCall");

        $.ajax( {
            method: "GET",
            dataType: "text",
            url: "http://www.botlibre.com/rest/botlibre/form-chat?application=_4581146104707647883&instance=15464920&message=" + Transmissions.parseForBot(text),
            success: function ( data ) {
                                
                // PARSE RESULT
                var replyXML = $.parseXML( data ),
                    replyText = $(replyXML).find("message").html();

                Transmissions.responseParse( replyText, object );

            },
            error: function () {

                console.log( 274, "Error receiving from server." );

                // ECHO STORED RESPONSE
                Transmissions.responseParse( object[Data.currentTextBlock][1], object );

            }, 
            complete: function () {
  
            }
        });        

    },

    conversation: function ( object, instance ) {

        console.log("Transmissions.conversation");

        // IF FIRST TIME : HIDE FIRST BLOCK
        if ( Data.currentTextBlock === 0 ) {
            setTimeout( function(){
                Transmissions.hideFirstBlock();                
            }, 500 );
        }

        console.log( Data.currentTextBlock, Object.keys(object).length );

        if ( Data.currentTextBlock < Object.keys(object).length ) {

            // DELAY OF 2 SECONDS
            setTimeout( function(){
                // PRINT LOCAL BLOCK
                Transmissions.appendWordByWord( object[Data.currentTextBlock][0], object, false );
            }, 2000 ); // 2000

        } else {

            // PRINT CREDITS

            console.log("Print credits");

            var credits = "H. C. Andersen, M. Blanchot, J. B. van Helmont, E. Hemingway, B. Lee, H. Melville, H. J. Newell,T. Vesaas in conversation with Tarjei the bot.";
            Transmissions.appendWordByWord( credits, object, false );
            
        }

    }, 

    heightChecker: function () {

        console.log("Transmissions.heightChecker");

        // GET HEIGHT OF ELEMENTS IN TEXT WRAPPER
        var wrapperH = $("#Transmissions").height(),
            elemsH = $("#text_wrapper").height();

        if ( elemsH > wrapperH * 0.6 || Data.currentTextBlock === 47 ) {

            console.log(331);

            // IF NO MORE BLOCKS
            var blocksLeft = $("#text_wrapper").children().length;
            console.log( blocksLeft, " blocks left." );
            if ( blocksLeft == 0 ) {
                
                // MOVE THIS TO OWN FUNCTION: 

                Transmissions.TransmissionsToggle();
                $("#squiggle").fadeOut(1000);
                return;
            }

            Transmissions.hideFirstBlock();
            // RUN AGAIN TO CHECK
            setTimeout( function(){
                Transmissions.heightChecker();
            }, 1200 );
        }


    },

    responseParse: function ( response, object ) {

        console.log("Transmissions.responseParse");

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

        Transmissions.appendWordByWord( responseParsed, object, true );
       
    },

    appendWordByWord: function ( text, object, response ) {

        console.log("Transmissions.appendWordByWord");

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
                Transmissions.heightChecker();
                
                // IF NO MORE BLOCKS
                if ( Data.currentTextBlock >= Object.keys(object).length ) {
                    // HIDE ALL REMAINING BLOCKS
                    Transmissions.heightChecker();
                    return;
                }

                // IF LOCAL
                if ( !response ) {
                    // SEND LOCAL BLOCK TO BOT + WHOLE OBJECT
                    Transmissions.ajaxCall( object[Data.currentTextBlock][0], object );
                } else {
                    // RUN FUNCTION AGAIN (INSTANCE++)
                    Data.currentTextBlock++;
                    Transmissions.conversation( object, Data.currentTextBlock );                     
                }
            }
        }, 250 ); // 250

    },

    hideFirstBlock: function () {

        console.log("Transmissions.hideFirstBlock");

        var firstBlock = $("#text_wrapper .text_block").eq(0),
            blockH = firstBlock.height() * 2;
        // TRANSLATEY ON TEXT                
        firstBlock.find("p").css({
            // "transform" : "translateY(-" + blockH + "px)",
            "opacity" : 0
        });
        // 500 + 500 DELAY
        setTimeout( function(){
            // $("#text_wrapper .text_block").eq(0).slideUp(500);
            setTimeout( function(){
                $("#text_wrapper .text_block").eq(0).remove();
            }, 500 );
        }, 500 );
                
    }

}