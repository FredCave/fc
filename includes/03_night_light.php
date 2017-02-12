<!-- STYLES -->

<style>		
	#wrapper {
/*		border: 1px solid red;*/
		margin-left: 25%;
		width: 55%;
		position: relative;
		z-index: 99;
		padding-bottom: 120px;
	}

		@media ( max-width: 1280px ) {
			#wrapper {
				width: 78%;
				margin-left: 10%;
			}	
		}
	section {
		/*border: 1px solid red;*/
		margin-bottom: 36px;
	}

	.pdf {
		margin: 35px 90px 14px 90px;
		display: inline-block;
		width: 150px;
		height: auto;
		vertical-align: top;
		border-bottom: 2px solid transparent;
		position: relative;
		}
		
	.pdf a {
		text-decoration: none;
		}

	.pdf a:hover {
		border-bottom: 1px solid transparent;
		}
		
	.pdf img {
	/*	border: 1px solid black;*/
		width: 100%;
		height: auto;
		margin-bottom: 12px;
		}
		
	.pdf:hover {
		border-bottom: 2px solid black;
		}
		
	.text {
	    width: 100%;
	    max-width: 1200px;
	    font-family: "Johnson", serif;
	    font-size: 1.1em;
	    line-height: 1.25;
	    padding: 8px;
	    overflow-x: hidden;
/*	    margin-bottom: 120px;*/
		}
		
	.text p {
	    margin-bottom: 12px;
		}
		
	.text p:nth-child(1) {
	    font-size: 4em;
	    line-height: 1.1;
		}
		
	.text p:nth-child(2) {
	    font-size: 2.2em;
	    line-height: 1;
	    margin-bottom: 18px;
		}

	.black_arrow {
		position: absolute;
		left: -90px;
		width: 70px !important;
	}
			
</style>

<?php
// LOOP THROUGH NIGHT LIGHT PROJECTS
$i = 0;
while ( $i < 3 ) { ?>
	<section>		
		<div class="pdf">
			<img src="<?php bloginfo('template_url'); ?>/assets/img/black_arrow.png" class="black_arrow"/>
			
			<?php $file = get_field("project_files")[$i]["project_file"]; ?>
			<a href="<?php echo $file["url"]; ?>" target="_blank">
				<?php 
				$image = get_field("project_images")[$i]["project_image"]; 
				image_object($image);
				?>
			</a>

		</div>

		<!-- TEXT -->
		<div class="text">
			<?php $text = get_field("project_texts")[$i]["project_text"];
			echo $text; ?>	
		</div>
	</section>
	<?php
	$i++;
}


?>




