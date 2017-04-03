<?php get_header(); ?>

<script type="text/javascript">
    // if (frameElement == null) {
    //     window.location = "<?php bloginfo('url'); ?>";
    //     // or window.close();
    // }
</script>

<?php
// EXHIBITION
if ( has_tag("exhibition") ) {
	include("includes/01_exhibition.php");
}
// ONCE REMOVED
else if ( $post->post_name == "an-image-once-removed" ) {
	include("includes/02_once_removed.php");
}
// NIGHT LIGHT
else if ( strpos( $post->post_name, "night-light" ) !== false ) {
	include("includes/03_night_light.php");
}
// ALL THAT IS SOLID
else if ( $post->post_name == "all-that-is-solid-melts-into-aether" ) {
	include("includes/04_all_that_is_solid.php");
}
// SUBLIMATIONS
else if ( $post->post_name == "_sublimations" ) {
	include("includes/06_sublimations.php");
}
// THE WAKE OF DUST
else if ( $post->post_name == "the-wake-of-dust" ) {
	include("includes/07_the_wake_of_dust.php");
}
// EDEN BOOK
else if ( $post->post_name == "eden" ) {
	include("includes/08_eden_book.php");
}

?>

<?php get_footer(); ?>