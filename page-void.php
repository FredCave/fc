<!DOCTYPE html>
<html style="margin-top: 0px !important" data-scroll="0">

<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <title>Fred Cave</title>
    <meta name="description" content="Website development by Fred Cave">

    <meta property="og:url" content="http://void.xxx" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="Fred Cave" />
    <meta property="og:description" content="Website development by Fred Cave" />
    <meta property="og:image" content="" />

    <!-- TWITTER -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="http://void.xxx">
    <meta name="twitter:description" content="Website development by Fred Cave">
    <meta name="twitter:title" content="Fred Cave">
    <meta name="twitter:image" content="">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-194x194.png" sizes="194x194">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/mstile-310x310.png">
    <meta name="theme-color" content="#ffffff">
    -->
   
    <style>

        @font-face {
            font-family: "cmr";
            src: url('../wp-content/themes/fredcave/assets/fonts/cmr10-webfont.eot');
            src: url('../wp-content/themes/fredcave/assets/fonts/cmr10-webfont.eot?#iefix') format('embedded-opentype'),
                 url('../wp-content/themes/fredcave/assets/fonts/cmr10-webfont.woff2') format('woff2'),
                 url('../wp-content/themes/fredcave/assets/fonts/cmr10-webfont.woff') format('woff'),
                 url('../wp-content/themes/fredcave/assets/fonts/cmr10-webfont.ttf') format('truetype'),
                 url('../wp-content/themes/fredcave/assets/fonts/cmr10-webfont.svg#cmr10regular') format('svg');
            font-weight: normal;
            font-style: normal;
        }

        body {
            background-color: beige;
            margin: 0;
            width: 100%;
            height: 100%;
/*            color: white;*/
            font-family: cmr, serif;
            font-size: 1.1em;
            line-height: 1.7;
        }

        ul, li {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        a, a:visited {
            color: beige;
            text-decoration: none;
        }

        a:hover {
            color: yellow;
        }

        .wrapper {
/*            border: 1px solid green;*/
            background-color: black;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%; 
            mix-blend-mode: multiply;
            color: beige;
/*-webkit-text-fill-color: transparent;
    -webkit-text-stroke-width: 0.1px;
    -webkit-text-stroke-color: transparent;*/

        }

        .wrapper > div {
            margin: 2.5% 3% 64px 2.5%;
            vertical-align: top;   
        }

        .wrapper > div p {
            margin: 0;  
        }

        .wrapper ul p {
            display: inline; 
        }

/*        #video_wrapper {
            width: 100%;
            height: 100vh;
            position: fixed;
            z-index: -1;
            top: 0;
            left: 0;
            margin: 0;
            
        }*/

        video {
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 15s;
        }


    </style>

    <script>
        // FIX IE CONSOLE ERRORS
        if (!window.console) console = {log: function() {}}; 
    </script>

</head>

<body>

    <video loop>
        <source src="../wp-content/themes/fredcave/assets/img/pantin_video.mp4" type="video/mp4">
    </video>

    <div id="void_wrapper" class="wrapper">

        <div class="info">
  
            <p>Fred Cave</p>

            <p>Website development</p>

            <p><a href="">info@void.xxx</a></p>
            
        </div>

        <div class="info">

            <ul>
                <li>
                    <a href="http://lola-hakimian.com" target="blank">http://lola-hakimian.com</a>
                    <p>– Design: Fred Cave</p>
                </li>
                <li>
                    <a href="http://couzinetjacques.com" target="blank">http://couzinetjacques.com</a>
                    <p>– Design: Fred Cave</p>
                </li>
                <li>
                    <a href="http://geoffroygesser.fr" target="blank">http://geoffroygesser.fr</a>
                    <p>– Design: Fred Cave</p>
                </li> 
                <li>
                    <a href="http://joeplangeinstitute.org" target="blank">http://joeplangeinstitute.org</a>
                    <p>– Design: Mevis & Van Deursen</p>
                </li>
                <li>
                    <a href="http://xbank.amsterdam" target="blank">http://xbank.amsterdam</a>
                    <p>– Design: Mevis & Van Deursen with Virginie Gauthier and Kévin Bray</p>
                </li>
                <li>
                    <a href="http://werkplaatstypografie.org/info" target="blank">http://werkplaatstypografie.org/info</a>
                    <p>– Design: Fred Cave</p>
                </li>
                <li>
                    <a href="http://canpeprey.com" target="blank">http://canpeprey.com</a>
                    <p>– Design: Caroline Wolewinski</p>
                </li>
                <li>
                    <a href="http://letonvertical.fr" target="blank">http://letonvertical.fr</a>
                    <p>– Design: Fred Cave</p>
                </li>
                <li>
                    <a href="http://gabrielemiseikyte.com" target="blank">http://gabrielemiseikyte.com</a>
                    <p>– Design: Fred Cave</p>
                </li>
                <li>
                    <a href="http://proyectobachue.org" target="blank">http://proyectobachue.org</a>
                    <p>– Design: María Jimena Sánchez Zambrano</p>
                </li>
                <li>
                    <a href="http://biekedepoorter.com" target="blank">http://biekedepoorter.com</a>
                    <p>– Design: Fred Cave</p>
                </li>               
                <li>
                    <a href="http://joecave.net" target="blank">http://joecave.net</a>
                    <p>– Design: Fred Cave</p>
                </li>
                <li>
                    <a href="http://nalebinding.be" target="blank">http://nalebinding.be</a>
                    <p>– Design: Caroline Wolewinski</p>
                </li>
                <li>
                    <a href="http://publishingclass.dutchartinstitute.eu" target="blank">http://publishingclass.dutchartinstitute.eu</a>
                    <p>– Design: Laura Pappa and Fred Cave</p>
                </li>
            </ul>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script>

        $(document).on("ready", function(){

            // AFTER 30 SECONDS LOOP STARTS
            setTimeout( function(){

                setInterval( function(){

                   $("video").css("opacity","0.5").get(0).play();
                   
                    setTimeout( function(){

                        $("video").css("opacity","0");    

                    }, 30000 ); 

                }, 60000 );
                
            }, 30000 );

        });

        </script>

    </div>

</body>
</html>