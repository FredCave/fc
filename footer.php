        </div><!-- END OF #WRAPPER -->

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
        
    </body>
</html>