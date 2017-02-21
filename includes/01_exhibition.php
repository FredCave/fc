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
    
    if ( $postdata->post_name === "the-electronic-cottage" ) { ?>

        <div class="extra">
            <?php 
            $image = get_field("project_images");
            $img_1 = $image[1]["project_image"]["url"];
            ?>
            <img src="<?php echo $img_1; ?>" />
        </div>
        <?php
    } // END OF GET_EXTRA

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

    @media ( max-width: 600px ) {
        .exhibition_wrapper img {
            width: 98%;
        }

        .exhibition_text {
            width: 98%;
        }       
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
    -webkit-filter: blur(5px);
            filter: blur(5px);
    transition: -webkit-filter 2s, filter 2s;
}

#the-electronic-cottage .extra:hover {
    -webkit-filter: blur(0px);
            filter: blur(0px);
}


#the-electronic-cottage .extra img {
    width: 100%;
    max-width: 800px;
}

</style>

<div id="<?php echo $post->post_name; ?>" class="exhibition_wrapper wrapper">
    
	<!-- IMAGES -->
    <?php if ( $post->post_name === "the-electronic-cottage" ) {
        $image = get_field("project_images");
        $img = $image[0]["project_image"];
        image_object( $img );
        ?>
    <?php 
    } else {
    	if( have_rows("project_images") ):
        	while ( have_rows("project_images") ) : the_row();
            	$image = get_sub_field("project_image");
            	image_object( $image );
        	endwhile;
        endif;
	} ?>

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