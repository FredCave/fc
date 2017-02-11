<?php

// SECURITY: HIDE USERNAMES
add_action(‘template_redirect’, ‘bwp_template_redirect’);
function bwp_template_redirect() {
    if ( is_author() ) {
        wp_redirect( home_url() ); 
        exit;
    }
}

// HIDE VERSION OF WORDPRESS
function wpversion_remove_version() {
    return '';
    }
add_filter('the_generator', 'wpversion_remove_version');

// ENQUEUE CUSTOM SCRIPTS
function enqueue_cpr_scripts() {
  
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js');
    // wp_register_script( 'jquery', get_template_directory_uri() . '/js/_jquery.js');
    wp_enqueue_script( 'jquery' );  
    
    if ( is_home() ) {
        wp_enqueue_script('all-scripts', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'), true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_cpr_scripts');

// ADD CUSTOM POST TYPES
add_action( 'init', 'create_post_types' );
function create_post_types() {
    register_post_type( 'projects',
    array(
        'labels' => array(
            'name' => __( 'Projects' ),
            'singular_name' => __( 'Project' )
        ),
        'public' => true,
        'taxonomies' => array('post_tag'),
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => array('editor','title'),
        'menu_position' => 5
        )
    );
}

// AJAX LAZY LOADING

// add_action( 'wp_ajax_loader', 'ajax_load' );
// add_action( 'wp_ajax_nopriv_loader', 'ajax_load' );

// function ajax_load () {
//     if ( isset($_REQUEST) ) {
//         // THE $_REQUEST CONTAINS ALL THE DATA SENT VIA AJAX
//         $section = $_REQUEST['section'];
//         switch ( $section ) {
//             case "about" : 
//                 $new_data = include( "includes/03_about.php" );
//                 break;
//             case "concerts" : 
//                 $new_data = include( "includes/04_concerts.php" );
//                 break;
//             case "media" : 
//                 $new_data = include( "includes/05_media.php" );
//                 break;
//             case "links" : 
//                 $new_data = include( "includes/06_links.php" );
//                 break;
//             // case "partners" : 
//             //     $new_data = include( "includes/07_partners.php" );
//             //     break;
//             default: 
//                 $new_data = include( "includes/02_news.php" );
//         }
//         echo $new_data;  
//         // FOR DEBUGGING
//         // print_r($_REQUEST);
//     }
//     // ALWAYS DIE IN FUNCTIONS ECHOING AJAX CONTENT
//     wp_die();
// }

// IMAGE OBJECT

    // ADD CUSTOM IMAGE SIZES
add_theme_support( 'post-thumbnails' );
add_image_size( 'extralarge', 1200, 1200 );

function image_object( $image ) {
    if( !empty($image) ): 
        $width = $image['sizes'][ 'thumbnail-width' ];
        $height = $image['sizes'][ 'thumbnail-height' ];
        $thumb = $image['sizes'][ "thumbnail" ]; // 300
        $medium = $image['sizes'][ "medium" ]; // 600
        $large = $image['sizes'][ "large" ]; // 900
        $extralarge = $image['sizes'][ "extralarge" ]; // 1200
        $full = $image['url'];
        $id = $image["id"];
        $class = "landscape";
        if ( $height >= $width ) {
            $class = "portrait";
        }
        echo "<img class='" . $class . " ' 
            alt='" . $image["name"] . "' 
            width='" . $width . "' 
            height='" . $height . "' 
            data-thm='" . $thumb . "' 
            data-med='" . $medium . "' 
            data-lrg='" . $large . "' 
            data-xlg='" . $extralarge . "' 
            data-fll='" . $full . "' 
            src=' " . $thumb . "' />";
    endif;
}

?>