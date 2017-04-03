<?php get_header(); ?>

    <div id="home_wrapper" class="wrapper">

        <div id="left_wrapper">
            <?php 
            $info_query = new WP_Query( "name=info" );
            if ( $info_query->have_posts() ) :
                while ( $info_query->have_posts() ) : $info_query->the_post(); ?>

                    <!-- MAIN TEXT -->
                    <div class="info_main info visible">
                        <?php the_field("info_intro"); ?>
                    </div>

                    <?php /* 
                    <!-- PROJECTS -->
                    <div class="info_projects info">
                        <!-- <span class="plus"><a href="">+</a></span> -->
                        <div class=""><?php the_field("info_projects"); ?></div>
                    </div>

                    <!-- EDUCATION -->
                    <div class="info_education info visible">
                        <!-- <span class="plus"><a href="">+</a></span> -->
                        <div class=""><?php the_field("info_education"); ?></div>
                    </div>
      
                    <?php /* 
                    <!-- LOADS TRANSMISSIONS -->
                    <div class="info">
                        <span class="plus transmission"><a href="">+</a></span>
                    </div>

                    <hr>
                    <!-- PROJECT INDEX -->
                    <div class="project_index">
                        <a href='<?php bloginfo("url") ?>/projects/'>Index of Project Pages</a>
                    </div> 
                    */ ?>

                <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <div id="right_wrapper">

            <div id="text_wrapper"></div>

            <?php /* $project_query = new WP_Query("post_type=projects");
            if ( $project_query->have_posts() ) :
                while ( $project_query->have_posts() ) : $project_query->the_post(); ?>
                    <p><?php the_title(); ?></p>
                <?php
                endwhile;  
            endif; */ ?>
        </div>

    </div>

    <div id="layer_wrapper" class="">
    </div>

    <div id="hyperlink">
        <a href=""></a>
    </div>

    <div id="close_button">
        <a href="#">
            <img src="<?php bloginfo( 'template_url' ); ?>/img/close.svg" class="close_button_black selected" />
            <img src="<?php bloginfo( 'template_url' ); ?>/img/close_white.svg" class="close_button_white" />
        </a>
    </div>  

        <!-- TMP CAPTION -->
    <div id="caption_wrapper">
        <p class="title">The Electronic Cottage</p>
        <p class="description">Exhibition</p>
        <p class="year">2015</p>
    </div>

    <?php /*
    <div id="sidebar">
        <div id="text_wrapper"></div>
    </div>    

    <div id="squiggle">
        <img src="<?php bloginfo( 'template_url' ); ?>/img/squiggle.svg" />
    </div> 
    */ ?>

<?php get_footer(); ?>