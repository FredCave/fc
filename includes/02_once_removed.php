<?php

// PHP FUNCTIONS

function bgImage ( $image, $bg ) {
    if( !empty($image) ): 
        $thumb = $image['sizes'][ "thumbnail" ]; // 300
        $medium = $image['sizes'][ "medium" ]; // 600
        $large = $image['sizes'][ "large" ]; // 900
        $extralarge = $image['sizes'][ "extralarge" ]; // 1200
        $full = $image["url"];
        $id = $image["id"];
        if ( $bg ) {
            $id = "bg_image";
            $class = "resize";
        }
        ?>
        <div id="<?php echo $id; ?>" 
            class="<?php echo $class; ?>" 
            data-thm="<?php echo $thumb; ?>" 
            data-med="<?php echo $medium; ?>" 
            data-lrg="<?php echo $large; ?>" 
            data-xlg="<?php echo $extralarge; ?>" 
            data-fll="<?php echo $full; ?>" 
            style="background-image:url('<?php echo $thumb; ?>')">
        </div>
    <?php
    endif;
}

function get_images ( $side ) {

    $images_left = [];
    $images_right = [];

    // LOOP THROUGH ROWS
    if ( have_rows("project_images") ) {
        $i = 1;
        while ( have_rows("project_images") ) : the_row("project_images");
            $single_image = get_sub_field("project_image");
            if ( $i > 1 ) {    
                if ( $i % 2 === 0 ) {
                    $images_left[] = $single_image;
                } else {
                    $images_right[] = $single_image;
                }
            }
            $i++;
        endwhile;
    } // END OF IF HAVE_ROWS
    // SHUFFLE ARRAYS
    shuffle($images_left);
    shuffle($images_right);

    if ( $side === "left" ) {
        foreach ( $images_left as $image_left ) {
            bgImage( $image_left );
        }
    } else {
        foreach ( $images_right as $image_right ) {
            bgImage( $image_right );
        }
    }
   
}

?>

<!-- STYLES -->

<style>
html, body {
/*    overflow-y: auto; */
}          
#bg_image {
    width: 100%;
    height: 100vh;   
    position: fixed;
    top: 0;
    z-index: -1;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    -webkit-filter: blur(5px); 
            filter: blur(5px);
    transition: all 2s;
}
#text_wrapper {
/*    border: 1px solid green;*/
    position: fixed;
    z-index: 99;
    top: 0;
    width: 100%;
    height: 100%;
    text-align: center;
/*    opacity: 0.5;*/
    display: none;
}
#text_wrapper img {
    position: absolute;
    height: 80%;
    top: 50%;
        -ms-transform: translateY(-50%) translateX(-50%);
    -webkit-transform: translateY(-50%) translateX(-50%);
            transform: translateY(-50%) translateX(-50%);
}
.wrapper {
/*    border: 1px solid green;*/
    position: fixed;
    top: 4%;
    height: 90vh;
    width: 48%;
    left: 0%;
    padding: 0;
    margin: 0;
}
#right {
    left: inherit;
    right: 0%;
}
.wrapper > div {
/*    border: 1px solid red;*/
    position: absolute;
    top: 0%;
    right: 0;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    width: 80%;
    height: 100%;
    text-align: center;
    -webkit-filter: blur(5px); 
            filter: blur(5px);
    display: none;
}
#right > div {
    left: 0;
    right: inherit;
}
.wrapper .visible {
    display: block;
}



</style>

<!-- SCRIPTS -->

<script type="text/javascript">
    $(document).on("ready", function(){
        // BACKGROUND IMAGE SIZING
        function bgImageSize () {
            // console.log("bgImageSize");
            $(".resize, .visible").each( function(){
                var thisId = $(this).attr("id"),
                    wrapperW = $(".wrapper").height(),
                    url = "";
                if ( thisId === "bg_image" ) {    
                    wrapperW = $(window).width();
                }
                if ( wrapperW >= 1200 ) {
                    // FULL
                    url = $(this).attr("data-fll");
                } else if ( wrapperW < 1400 && wrapperW >= 900 ) {
                    // EXTRA LARGE
                    url = $(this).attr("data-xlg");
                } else if ( wrapperW < 1000 && wrapperW >= 600 ) {
                    // LARGE
                    url = $(this).attr("data-lrg");
                } else if ( wrapperW < 700 && wrapperW >= 300 ) {
                    // MEDIUM
                    url = $(this).attr("data-med");
                } else {
                    // THUMB
                    url = $(this).attr("data-tmb");
                }
                // console.log(80, thisId, wrapperW, url);
                document.getElementById(thisId).style.backgroundImage = "url('" + url + "')";
            });

        } 
        // IMAGES INIT
        function imagesInit () {
            // console.log("imagesInit");
            $(".wrapper div:first-child").addClass("resize");
            $(".wrapper div").css({
                "-webkit-filter" : "blur(0px)", 
                        "filter" : "blur(0px)"
            });
            // $("#bg_image").addClass("visible").css({
            //     "-webkit-filter" : "blur(0px)", 
            //             "filter" : "blur(0px)"
            // });
            // bgImageSize();
        }
        // SLIDESHOW
        function imageChange ( wrapper ) {
            // console.log("imageChange");
            var vis = wrapper.find(".visible");
            // IF NEXT
            if ( vis.next().length ) {
                vis.removeClass("visible").next().addClass("visible");  
            } else {
                // ELSE BACK TO START  
                vis.removeClass("visible");
                wrapper.find("div:first-child").addClass("visible");  
            }
            // LOAD NEXT
            wrapper.find(".resize").removeClass("resize");
            $(".visible").next().addClass("resize");
            bgImageSize();  
        }
        function slideShow ( s_show ) {
            // console.log("slideShow");
            // RANDOM DELAY
            var delay = Math.random() * 8 + 3; // BETWEEN 3 & 12 seconds
            // console.log(202, s_show, delay);
            imageChange( s_show );
            setTimeout( function(){
                slideShow(s_show);
            }, delay * 1000 );
        }
        function slideInit() {
            // console.log("slideInit");
            $(".wrapper").each( function(){
                slideShow( $(this) );
            });
        }

        $(window).on("load", function(){
            imagesInit();
            slideInit();
        }).on( "resize", _.throttle(function() {
            // bgImageSize();
        }, 500 ) );
    }); // END OF DOCUMENT READY
</script>

<!-- BACKGROUND IMAGE -->
<?php 
    // $images = get_field("project_images");
    // $bg_image = $images[0]["project_image"];
    // bgImage( $bg_image, true ); 
?>

<!-- TEXT -->
<div id="text_wrapper">
    <img src="<?php bloginfo('template_url'); ?>/assets/img/once_removed.svg" />
</div>

<ul id="left" class="wrapper">
    <?php get_images("left"); ?>
</ul>

<ul id="right" class="wrapper">
    <?php get_images("right"); ?>
</ul>
