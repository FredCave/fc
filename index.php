<?php get_header(); ?>

    <div id="home_wrapper" class="wrapper">

        <div id="left_wrapper">
            <?php 
            $info_query = new WP_Query( "name=info" );
            if ( $info_query->have_posts() ) :
                while ( $info_query->have_posts() ) : $info_query->the_post(); ?>

                    <!-- MAIN TEXT -->
                    <div class="info_main">
                        <?php the_field("info_intro"); ?>
                    </div>

                    <div id="text_wrapper"></div>

                    <?php /*
                    <hr>

                    <!-- PROJECT INDEX -->
                    <div class="project_index">
                        <a href='<?php bloginfo("url") ?>/projects/'>Index of Project Pages</a>
                    </div> 

                    <hr>

                    <!-- PROJECTS -->
                    <div class="info_projects">
                        <?php the_field("info_projects"); ?>
                    </div> 

                    <hr>

                    <!-- EDUCATION -->
                    <div class="info_education">
                        <?php the_field("info_education"); ?>
                    </div>
                     */ ?>

                <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <div id="right_wrapper">
            <?php /* $project_query = new WP_Query("post_type=projects");
            if ( $project_query->have_posts() ) :
                while ( $project_query->have_posts() ) : $project_query->the_post(); ?>
                    <p><?php the_title(); ?></p>
                <?php
                endwhile;  
            endif; */ ?>
        </div>

    </div>

    <div id="layer_one" class="layer">
        <iframe></iframe>
    </div>

    <div id="layer_two" class="layer">
        <iframe></iframe>
    </div>   

    <div id="hyperlink">
    </div>

    <div id="close_button">
        <img src="<?php bloginfo( 'template_url' ); ?>/img/close.svg" class="close_button_black selected" />
        <img src="<?php bloginfo( 'template_url' ); ?>/img/close_white.svg" class="close_button_white" />
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