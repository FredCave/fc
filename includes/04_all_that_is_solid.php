<!-- STYLES -->

<style>

#page {
/*	border: 1px solid red;*/
	width: 100%;
	text-align: center;
	}
	
#page img {
	width: 100%;
	height: auto;
	opacity: 0;
	transition: opacity 1s;
	}	

#audio_controls {
	position: fixed;
	z-index: 99;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	width: 100%;
	height: 100%;
	text-align: center;
	display: table;
	margin-top: -25px;
	}
	
#audio_controls div {
	display: table-cell;
    vertical-align: middle;
    font-size: 4em;
    font-family: arial;
    text-transform: uppercase;
    text-shadow: 0px 0px 50px rgba(255,255,255,0.6);
}

#audio_controls p {
	display: inline;
	cursor: pointer;	
}

@media (min-width: 1275px) {
	#audio_controls div {
		font-size: 5vw;
	}
}
</style>

<!-- SCRIPTS -->

<script>
	$(document).ready(function() {				
		
		$("#audio_controls p").hover(function(){
			$(this).find("span").css("border-bottom", "5px solid black");
		}, function(){
			$(this).find("span").css("border-bottom", "");
		});
		
		$("#audio_controls p").on("click", function(){
			var audio = $("#audio")[0];					
			if ( !$(this).hasClass("playing") ) { // stopped
				audio.volume = 0;
				$(this).addClass("playing");
				$(this).find("span").text("off");
				if ( !$(this).hasClass("init") ) {
					$(this).addClass("init");
					var start = parseInt( Math.random() * 2068 );												
					audio.currentTime = start;
					audio.play();							
					$("#audio").animate({volume: 1.0}, 2000);
				} else {
					audio.play();
					$("#audio").animate({volume: 1.0}, 2000);
				}	
			} else { // playing
				audio.volume = 1;
				$(this).removeClass("playing"); 
				$(this).find("span").text("on");
				$("#audio").animate({volume: 0}, 500, function() {
					audio.pause();
					});						
			}					
		});

		function bgImageSize () {
            console.log("bgImageSize");
            var elem = $("#page img"),
                wrapperW = $(document).height(),
                url = "";
            if ( wrapperW >= 1400 ) {
                // FULL
                url = elem.attr("data-fll");
            } else if ( wrapperW < 1200 && wrapperW >= 900 ) {
                // EXTRA LARGE
                url = elem.attr("data-xlg");
            } else if ( wrapperW < 900 && wrapperW >= 600 ) {
                // LARGE
                url = elem.attr("data-lrg");
            } else if ( wrapperW < 600 && wrapperW >= 300 ) {
                // MEDIUM
                url = elem.attr("data-med");
            } else {
                // THUMB
                url = elem.attr("data-tmb");
            }
            console.log(80, wrapperW, url);
            elem.attr("src",url);
        } 

		$(window).on("load", function(){
			bgImageSize();
			$("#page img").css("opacity","1");
		}).on("resize", function(){
			bgImageSize();
		});
									
	});
</script> 

<div id="page">
	<div class="image">
		<?php 
		$image = get_field("atis_image");
		image_object($image); 
		?>
	</div>
</div>

<div id="audio_controls">
	<div>
		<p>Audio <span>on</span></p>
	</div>		
</div>

<?php 
$file_mp3 = get_field("atis_mp3"); 
$file_ogg = get_field("atis_ogg");
?>

<audio id="audio" loop>
	<source src="<?php echo $file_mp3['url']; ?>" type="audio/mpeg">
	<source src="<?php echo $file_ogg['url']; ?>" type="audio/ogg">
</audio>