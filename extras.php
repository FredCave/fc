<?php

// PANTIN VIDEO
if ( $page->title() == "93 to Infinity" ) { 
	// GET FILES ASSOCIATED TO PROJECT
	$project_files = $page->files();
	foreach ( $project_files as $project_file ) {
		// $PROJECT_FILE RETURNS A STRING
		if ( strpos( $project_file, "mp4" ) !== false ) { 
			// REPLACE FIRST PART OF STRING WITH SITE URL
			$str_end = explode ( "content/" , $project_file )[1];
			?>
			<div class="extra">
				<video width="320" height="240" autoplay loop>
					<source src="<?php echo $site->url([$lang=false]) . "/content/" . $str_end; ?>" type="video/mp4">
				</video>
			</div>
	<?php }
	}
	?>

<?php }
?>