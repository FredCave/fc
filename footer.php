        </div><!-- END OF #WRAPPER -->

        <?php if ( is_home() ) { ?>
        	<?php /*
	        <script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/narcissus.json"></script>
	        <script type="text/javascript" src="http://www.botlibre.com/scripts/sdk.js"></script>
			<script type="text/javascript">
				SDK.applicationId = "4581146104707647883"; // You can obtain one from your user page.
				var sdk = new SDKConnection();
				var web = new WebChatbotListener();
				web.connection = sdk;
				web.instance = "15464920"; 
				web.instanceName = "Tarjei"; 
				web.userName = "You";
				web.speak = false;
				// web.greet();
			</script>
			*/ ?>
		<? } else { ?>
			<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/underscore-min.js"></script>
			<script>
			$(document).on( "ready", function(){

				// console.log("Project footer ready.");

			 //    $("html,body").on("scroll", function(){

			 //        console.log( $(this), " scrolling.");

			 //    });

			    function imageSize () {
			        // console.log("imageSize");
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
			            // console.log(48, wrapper, url);
			            $(this).attr("src",url);       
			        });   
			       
			    } 

			    $(window).on("load", function(){
			        imageSize();
			    }).resize( _.throttle(function() {
			        imageSize();
			    }, 1000 ) );

			});    
			</script>

		<?php } ?>
        
    </body>
</html>