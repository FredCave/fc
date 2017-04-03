<?php

function bg_image_object( $image ) {
    if( !empty($image) ): 
        $width = $image['sizes'][ 'thumbnail-width' ];
        $height = $image['sizes'][ 'thumbnail-height' ];
        $thumb = $image['sizes'][ "thumbnail" ]; // 300
        $medium = $image['sizes'][ "medium" ]; // 600
        $large = $image['sizes'][ "large" ]; // 900
        $extralarge = $image['sizes'][ "extralarge" ]; // 1200
        $id = $image["id"];

        echo "<li class='image' 
            data-width='" . $width . "' 
            data-height='" . $height . "' 
            data-thm='" . $thumb . "' 
            data-med='" . $medium . "' 
            data-lrg='" . $large . "' 
            data-xlg='" . $extralarge . "' 
            style='background-image:url( " . $thumb . ");' ></li>";
    endif;
}



?>

<!-- STYLES -->

<style>

html, body {
    height: 100%;    
    overflow: hidden;
}

#wrapper {
    height: 101%;
    background: gray;
}

.eden_layer {
/*    border: 1px solid pink;*/
    width: 120%;
    height: 120%;
    position: absolute;
    top: -10%;
    left: -10%;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 30s;
}

#eden_layer_2 {
    mix-blend-mode: overlay;   
}

#eden_layer_3 {
/*    mix-blend-mode: difference;*/
    mix-blend-mode: lighten;    
}

</style>

<!-- SCRIPTS -->

<script>
var EdenSlider = {

    currentSlide: 0,

    winW : $(window).width(),
    
    winH : $(window).height(),

    init: function () {

        // console.log("EdenSlider.init");

        this.bindEvents();

        this.mainLoop();

    },

    bindEvents: function () {

        // console.log("EdenSlider.bindEvents");

        $("html").on( "mousemove", function(e){

            var rotX = (e.pageX/$(window).width()*20) - 10,
                rotY = (e.pageY/$(window).height()*20) - 10

            $(".eden_layer").eq(0).css({
                "transform":"rotateX("+ rotY / 2 +"deg) "+
                            "rotateY("+ rotX / 2 +"deg) "+
                            "translateZ(100px)"
            });

            $(".eden_layer").eq(1).css({
                "transform":"rotateX("+ rotY +"deg) "+
                            "rotateY("+ rotX +"deg) "+
                            "translateZ(10px)"
            });

            $(".eden_layer").eq(2).css({
                "transform":"rotateX("+ rotY * 1.2 +"deg) "+
                            "rotateY("+ rotX * 1.2 +"deg) "+
                            "translateZ(10px)"
            });

        });


    },

    imgCalc: function ( image ) {

        // console.log("EdenSlider.imgCalc");

        var imgW,
            newSrc;

        // GET ACTUAL BG IMAGE WIDTH, NOT WRAPPER WIDTH
        var imgRatio = image.data("width") / image.data("height"),
            winRatio = this.winW / this.winH;
        if ( imgRatio > winRatio ) {                
            imgW = this.winH * imgRatio * 1.2;
        } else {
            imgW = this.winW * 1.2;
        }

        var currSrc = image.css("background-image").split('"')[1];

        // console.log( 122, currSrc, imgW );

        // CHANGE POINTS: THM = 300 / MED = 600 / LRG = 900 / XLG = 1200
        if ( imgW <= 300 ) {
            newSrc = image.attr("data-thm");
            //// console.log(127,newSrc);
        } else if ( imgW > 300 && imgW <= 600 ) {
            newSrc = image.attr("data-med");
            // console.log(130,newSrc);
        } else if ( imgW > 600 && imgW <= 900 ) {
            newSrc = image.attr("data-lrg");
            // console.log(133,newSrc);
        } else {
            newSrc = image.attr("data-xlg");
            // console.log(136,newSrc);
        } 

        // console.log( 135, newSrc );

        // IF NEW SRC DIFFERENT: RENDER 
        if ( newSrc !== currSrc ) {
            return newSrc;
        } else {
            return currSrc;
        }        

    },

    mainLoop: function () {

        // console.log("EdenSlider.mainLoop");

        var slides = $("#images_wrapper li").length,
            slide,
            target;

        if ( this.currentSlide >= slides ) {
            this.currentSlide = 0;
        }

        // GET SRC FOR CURRENT SLIDE
        src = EdenSlider.imgCalc( $("#images_wrapper li").eq( EdenSlider.currentSlide ) );

        // console.log( 144, EdenSlider.currentSlide, src, $("#images_wrapper li").eq( EdenSlider.currentSlide ) );

        if ( EdenSlider.currentSlide % 2 === 0 ) {
            target = $("#eden_layer_1");
        } else {
            target = $("#eden_layer_2");                
        }
        // AFTER LOAD: SET SRC + FADE IN 
        $('<img/>').attr('src', src ).on("load error", function() {

            // console.log("Image loaded.");

            $(this).remove();

            target.css({
                "background-image" : "url(" + src + ")",
                "opacity" : "1"
            });
            target.siblings().css({"opacity":0});

            setTimeout(function(){
                EdenSlider.currentSlide++;
                EdenSlider.mainLoop();
            }, 30000 );

        });

    },

    /*
        INIT:
            BIND MOUSEMOVE EVENT

        SETINTERVAL:

            LOAD ODD IMAGE 
            FADE IN

            LOAD EVEN IMAGE ON SEPARATE LAYER
            FADE IN

    */
}

$(document).on("ready", function(){

    EdenSlider.init();
	
});
</script>

<div id="eden_layer_1" class="eden_layer"></div>

<div id="eden_layer_2" class="eden_layer"></div>

<div id="eden_layer_3" class="eden_layer"></div>

<ul id="images_wrapper">
    <?php
    if ( have_rows("project_images") ) :
        while ( have_rows("project_images") ) : the_row( ("project_images") ); 
            $image = get_sub_field("project_image");
            bg_image_object( $image );
        endwhile;
    endif;
    ?>
</ul>