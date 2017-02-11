<?php 

function get_extra ( $postdata ) {

    // IF 93 TO INFINITY
    if ( $postdata->post_name === "93-to-infinity" ) { ?>
        <div class="extra">
            <video width="320" height="240" autoplay loop>
                <source src="<?php bloginfo('template_url'); ?>/assets/img/pantin_video.mp4" type="video/mp4">
            </video>
        </div>
        <?php
    }
    // IF THE ELECTRONIC COTTAGE
    if ( $postdata->post_name === "the-electronic-cottage" ) { 

        ?>

        <div class="extra">
            <?php 
            $images = get_field("exhib_extra_images");
            $img_1 = $images[0]["exhib_extra_image"]["url"];
            ?>
            <img src="<?php echo $img_1; ?>" />
        </div>
        <?php
    }// END OF GET_EXTRA

}
?>

<!-- STYLES -->

<style>

.exhibition_wrapper img {
    width: 50%;
    height: auto;
    margin-bottom: 24px;
    display: block;
    position: relative;
/*    z-index: 9;*/
}

.exhibition_text {
/*    border: 1px solid purple;*/
    width: 50%;
}

.extra {
    position: fixed;  
}

.extra video {
    position: fixed; 
    top: 20%;
    left: 60%;
    height: auto;
    margin-top: 0px;
    box-shadow: 5px 5px 20px #8B4513;
}

#the-electronic-cottage .extra {
    right: 25%;
    top: 25%;
}

#the-electronic-cottage .extra img {
    width: 100%;
    max-width: 800px;
}

</style>

<!-- SCRIPTS -->

<script>
$(document).on( "ready", function(){

    function imageSize () {
        console.log("imageSize");
        $("img").each( function(){
            var wrapper = $(this).width(),
                url = "";
            if ( $(this).hasClass("portrait") ) {
                wrapper = $(this).height();
            }
            if ( wrapper >= 1400 ) {
                // FULL
                url = $(this).attr("data-fll");
            } else if ( wrapper < 1200 && wrapper >= 900 ) {
                // EXTRA LARGE
                url = $(this).attr("data-xlg");
            } else if ( wrapper < 900 && wrapper >= 600 ) {
                // LARGE
                url = $(this).attr("data-lrg");
            } else if ( wrapper < 600 && wrapper >= 300 ) {
                // MEDIUM
                url = $(this).attr("data-med");
            } else {
                // THUMB
                url = $(this).attr("data-tmb");
            }
            // console.log(80, wrapperH, url);
            $(this).attr("src",url);       
        });   
       
    } 

    $(window).on("load", function(){
        imageSize();
    }).resize( _.throttle(function() {
        imageSize();
    }, 500 ) );

});    

</script>

<div id="<?php echo $post->post_name; ?>" class="exhibition_wrapper wrapper">
    
	<!-- IMAGES -->
    <?php 
	if( have_rows("project_images") ):
    	while ( have_rows("project_images") ) : the_row();
        	$image = get_sub_field("project_image");
        	image_object( $image );
    	endwhile;
    endif;
	?>

    <!-- TEXT -->
    <div class="exhibition_text">
        <?php 
        if( have_rows("project_texts") ):
            while ( have_rows("project_texts") ) : the_row();
                the_sub_field("project_text");
            endwhile;
        endif;
        ?>
    </div>

    <?php get_extra($post); ?>

</div><!-- END OF #PROJECT_WRAPPER -->