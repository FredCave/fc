<!-- STYLES -->

<style>

#narc_bg {
	width: 100%;
	height: 100%;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	position: fixed;
	z-index: 9999;
/*	background: url("content/1.projects/1.narcissus-dissolve/sea_bw.jpg") no-repeat center center;*/
	background-size: 33%;
	opacity: 1;
	pointer-events: none;
}
  
.narc_wrapper {
 	position: absolute;
 	top: 0;
 	width: 100%;
 	height: 100%;
 } 
   
.narc_image_wrapper {
	width: 100%;
	top: 0;
	left: 0;
	position: absolute;
	pointer-events: none;
	}

.narc_text_wrapper {
   	font-family: "cmr", "Johnson", "Times New Roman", Times, serif;
   	font-size: 1em;
   	width: 43%;
   	margin: 4px 12px 120px 5%;
   	display: inline-block;
   	top: 0;
   	position: relative;
   	padding-top: 24px;
   }
	   
.narc_text_wrapper span {
   	display: inline-block;
   	width: 400px;
   }
   	
.img {
	cursor: move;
	position: absolute;
	position: fixed;
	pointer-events: auto;
	display: none;
	}

.img_fix {
	position: fixed;
}

.img00 { 
	position: fixed;
	top: 48%;
		-ms-transform: translateY(-50%);
	-webkit-transform: translateY(-50%);
			transform: translateY(-50%);
	right: 12%;
	width: 32%;
	max-width: 640px;
	z-index: 5;
	opacity: 1;
	box-shadow: 5px 5px 20px #8B4513;
	display: block;
	}

.img01 { /* O MER OS */
	bottom: 4%;
	right: 20%;
	width: 32%;
	max-width: 640px;
	z-index: 5;
	opacity: 1;
	}	

.img02 { /* FABRIC */
	top: 3%;
	right: 3%;
	margin-right: 3%;
	width: 32%;
	max-width: 640px;
	opacity: 0.8;
	z-index: 2;
	display: block;
	}
	
.img03 { /* DUST */
	top: 14%;
    left: 10%;
	width: 30%;
	max-width: 580px;
	z-index: 2;
	display: block;
	}
	
.img04 { /* SQUIGGLE */
	top: 42%;
	right: 8%;
	margin-right: 8%;
	width: 15%;
	max-width: 500px;
	z-index: 4;	
	display: block;		
	}

.img05 { /* CROP */
	top: 12%;
	right: 18%;
	width: 50%;
	max-width: 800px;
	opacity: 0.8;
	z-index: 1;
	}

.img06 { /* SHADOW */
	top: 12%;		
	right: 28%;
	width: 800px;
	opacity: 1;
	z-index: 1;
	}

#gradient {
	height: 100%;
	height: 100vh;
	width: 50%;
	position: fixed;
	right: 0;
	top: 0;
	background: linear-gradient(to right, #FFFFFF 0%, rgba(0,0,0,0.5));
	opacity: 0;
	pointer-events: none;
}

</style> 

<!-- SCRIPTS -->
	
<script>
	$(document).ready(function() {				
		
		var text = $(".main_text").text();
		var charCount = text.length;
		var currentLetterCount = 0;
		var speed = 70; // lower = faster
		var $input = $(".narc_text_wrapper");			
		var p = 0;
		
		function writeLetter() {
			var currentText = $input.html();
			var currentLetter = text.charAt(currentLetterCount);	
			currentLetterCount++;
			if ( currentLetterCount <= charCount) { 
				if ( currentLetter == "." ) {																		
					p++;		
					if ( p <= 1 ) {
						var $longSpace = "." + "</p><p>";
					} else if ( p == 2  ) {
						var $longSpace = "." + "</p><br><p>";
					} else {
						var random = Math.floor(Math.random() * 10);
						if ( random < 3 ) {
							var $longSpace = "." + "</p><br><br><p>";
						} else if ( random >= 3 && random < 6 ) {
							var $longSpace = "." + "</p><br><p>";
						} else {
							var $longSpace = "." + "</p><p>";
						}
					}												
					$input.html(currentText + $longSpace);
				} else {
					$input.html(currentText + currentLetter);
				}		
			} else {
				clearInterval(timerId);
			}			
			var pc = parseInt( (currentLetterCount / charCount) * 100 );
			if ( pc === 22 ) {
				$(".img06").fadeIn(10000);
			} 
			$("#gradient").css("opacity", pc / 100 );

		}		
		var timerId = setInterval(writeLetter, speed);	

		$(".img").draggable({
			containment: "document"
		});		
	});
</script>
    	
<div id="narc_bg" class="img"></div>
	
<div class="narc_wrapper">
	<div class="narc_text_wrapper"><p></p></div>
	<div class="narc_image_wrapper">
		<?php 
		$images = get_field("nd_images");
		$img_1 = $images[0]["nd_image"]["url"]; // DUST
		$img_2 = $images[1]["nd_image"]["url"]; // M
		$img_3 = $images[2]["nd_image"]["url"]; // SCAN
		$img_4 = $images[3]["nd_image"]["url"]; // SHADOW
		$img_5 = $images[4]["nd_image"]["url"]; // SEA FLASH
		?>

		<img class="img03 img parallax" src="<?php echo $img_1; ?>">
		<!--
		<img class="img02 img parallax" src="<?php //echo $img_3; ?>">
		<img class="img04 img parallax" src="<?php //echo $img_2; ?>">
		<img class="img06 img parallax" src="<?php //echo $img_4; ?>">
		-->

		<img class="img00" src="<?php echo $img_5; ?>">

	</div>
</div>

<div class="main_text" style="display: none;">
	<?php the_field("nd_text"); ?>
</div>
	
<div id="gradient"></div>
