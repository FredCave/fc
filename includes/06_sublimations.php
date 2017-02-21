<!-- STYLES -->

<style>
html, body, #wrapper {
    height: 100%;
    background-color: black;
}
iframe {
    width: 100%;
    height: 100%;
    pointer-events: none;
/*    display: none;*/
}

#scroller_wrapper {
/*    border: 1px solid red;*/
    width: 100%;
    height: 100%;
    font-family: times, "Times New Roman", serif;
}

#scroller_wrapper p {
   -webkit-transform: translateZ(0);
   -moz-transform: translateZ(0);
   -ms-transform: translateZ(0);
   -o-transform: translateZ(0);
   transform: translateZ(0);
    font-size: 6em;
    color: blue;
    position: absolute;
    left: 150vh;
    white-space: nowrap;
    transition: left 15s linear;
}

#subtle_text_wrapper {
/*    border: 1px solid red;*/
    color: white;
    text-align: center;
    position: fixed;
    font-family: helvetica;
    font-size: 1.3em;
    width: 100%;
    top: 45%;
    letter-spacing: 0.05em;
    transform: translateY(-50%);
}

#subtle_text_wrapper li {
    display: none;
}

#subtle_text_wrapper span {
    opacity: 0;
    filter: blur(10px);
    transition: opacity 1s ease-in-out, filter 1s linear;
}

</style>

<script src="<?php bloginfo('template_url'); ?>/assets/jquery.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/jquery.lettering.js"></script>
<script>
$(document).on("ready", function(){

var SubtleText = {

        _textBlocks: "",

        _wordDelay: 0,

        _wordPause: 0,

        _letterSpeed: 0,

        _current: 0,

        init: function ( textBlocks, wordDelay, wordPause, letterSpeed ) {

            console.log("SubtleText.init", textBlocks, wordDelay, wordPause, letterSpeed);

            this._textBlocks = textBlocks;
            this._wordDelay = wordDelay;
            this._wordPause = wordPause;
            this._letterSpeed = letterSpeed;

            this.mainLoop();

        },

        mainLoop: function () {

            console.log("SubtleText.mainLoop");

            var block = SubtleText._textBlocks.find("li").eq( this._current );

            if ( block.length === 0 ) {
                this._current = 0;
                block = SubtleText._textBlocks.find("li").eq( this._current );
            }

            block.lettering().show();

            setTimeout( function(){

                SubtleText.fadeIn( block );

            }, SubtleText._wordDelay );

        },

        fadeIn: function ( block ) {

            console.log("SubtleText.fadeIn");

            var letters = block.children("span").length,
                index = 0,
                currentLetter;

            console.log( 80, letters );

            // LOOP THROUGH LETTERS
            var interval = setInterval( function(){

                if ( index < letters ) {

                    currentLetter = block.find("span").eq(index);
                    currentLetter.css({
                        "filter" : "blur(0px)",
                        "opacity" : "1"
                    });
                    index++;

                } else {
                    
                    console.log("Clear interval.");
                    clearInterval(interval);
                    // DELAY AND THEN
                    setTimeout( function(){
                        SubtleText.fadeOut( block, letters );                         
                    }, SubtleText._wordPause );
                  
                }
                
            }, SubtleText._letterSpeed );

        },

        fadeOut: function ( block, letters ) {

            console.log("SubtleText.fadeOut");

            var index = 0;

            // LOOP THROUGH LETTERS
            var interval = setInterval( function(){

                if ( index < letters ) {

                    currentLetter = block.find("span").eq(index);
                    currentLetter.css({
                        "filter" : "",
                        "opacity" : "0"
                    });

                    index++;

                } else {
                    
                    console.log("Clear interval.");
                    clearInterval(interval);
                    block.hide();
                    // WHEN FINISHED RUN MAIN LOOP AGAIN
                    SubtleText._current++;
                    SubtleText.mainLoop();
                  
                }
                
            }, SubtleText._letterSpeed );           

        },

    }

    var subs = [
        "sub-cortical", "sub-critical", "sub-lethal", "sub-orbital" 
    ];

    SubtleText.init( $("#subtle_text_wrapper"), 9000, 6000, 150 );

    function textScroller ( index ) {
        console.log("textScroller");
        
        if ( typeof index === "undefined" ) {
            index = 0;
        }
        console.log( subs[index], index, subs.length );
        // CREATE DOM ELEMENT
        var p = $("<p>" + subs[index] + "</p>"),
            randTop = Math.random() * 50 + 10; // BETWEEN 10 + 60
        // ANIMATE 
        p.appendTo( "#scroller_wrapper" );
        $("#scroller_wrapper p").css({
            "top" : randTop + "%",
             "left" : "150vh"           
        });
        setTimeout( function(){
            $("#scroller_wrapper p").css({
                "left" : "-100vh"           
            }); 
        }, 10 );
        setTimeout( function(){
            // REMOVE
            p.remove();
            // IF NEXT:
            if ( index < subs.length - 1 ) {
                index++;
            } else {
                index = 0;
            }
            textScroller(index); 
        }, 16000 );

    }

    textScroller();

        // IFRAME RESIZE
    // function videoWrapper() {
    //     var winW = $(window).width(); 
    //     var winH = $(window).height();
    //     var winR = winH / winW;
    //     var video = $("#video_wrapper iframe");
    //     // console.log( winW, winH, winR );

    //     // ratio of original video
    //     var vidR = video.attr("height") / video.attr("width");
    //     // ratio of iframe
    //     var ifrR = video.height() / video.width();
    //     // ifrR nedds to be 0.65

    //     //var diff = winW / (winH / vidR);
    //     if ( winR > vidR ) {
    //         // diff between current video height and winH
    //         var diff = winH / (winW * vidR);

    //         var newW = winW * diff;
    //         var newH = winW * diff * 0.65;

    //         video.css({
    //             "width": newW,
    //             "margin-left": 0 - (newW - winW) / 2,
    //             "margin-top": 0 - (newH - winH) / 2,
    //             "height": newH
    //         });
    //     } else {            
    //         video.css({
    //             "width": winW,
    //             "margin-left": "",
    //             "margin-top": 0 - ( (winW * 0.65) - winH ) / 2,
    //             "height": winW * 0.65
    //         });         
    //     }
    // }

    // videoWrapper();


});
</script>


<iframe sandbox="allow-same-origin allow-scripts allow-popups" src="https://player.vimeo.com/video/193055435?autoplay=true&loop=true" loop width="1280" height="720" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

<ul id="subtle_text_wrapper">
    <li>sub-cortical</li> 
    <li>sub-critical</li> 
    <li>sub-lethal</li> 
    <li>sub-orbital</li>   
</ul>

<div id="scroller_wrapper"></div>

