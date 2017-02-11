<?php

// PHP FUNCTIONS

function bgImage ( $image, $bg ) {
    if( !empty($image) ): 
        $thumb = $image['sizes'][ "thumbnail" ]; // 300
        $medium = $image['sizes'][ "medium" ]; // 600
        $large = $image['sizes'][ "large" ]; // 900
        $extralarge = $image['sizes'][ "extralarge" ]; // 1200
        $full = $image["url"];
        $id = $image["id"];
        if ( $bg ) {
            $id = "bg_image";
            $class = "resize";
        }
        ?>
        <div id="<?php echo $id; ?>" 
            class="<?php echo $class; ?>" 
            data-thm="<?php echo $thumb; ?>" 
            data-med="<?php echo $medium; ?>" 
            data-lrg="<?php echo $large; ?>" 
            data-xlg="<?php echo $extralarge; ?>" 
            data-fll="<?php echo $full; ?>" 
            style="background-image:url('<?php echo $thumb; ?>')">
        </div>
    <?php
    endif;
}

function get_images ( $side ) {
    $images_left = [];
    $images_right = [];
    // LOOP THROUGH ROWS
    if ( have_rows("or_images") ) {
        $i = 1;
        while ( have_rows("or_images") ) : the_row("or_image");
            $single_image = get_sub_field("or_image");
            if ( $i % 2 === 0 ) {
                $images_left[] = $single_image;
            } else {
                $images_right[] = $single_image;
            }
            $i++;
        endwhile;
    } // END OF IF HAVE_ROWS
    // SHUFFLE ARRAYS
    shuffle($images_left);
    shuffle($images_right);

    if ( $side === "left" ) {
        foreach ( $images_left as $image_left ) {
            bgImage( $image_left );
        }
    } else {
        foreach ( $images_right as $image_right ) {
            bgImage( $image_right );
        }
    }
   
}

?>

<!-- STYLES -->

<style>
body {
    background-color: black;
}            
#bg_image {
    width: 100%;
    height: 100vh;   
    position: fixed;
    top: 0;
    z-index: -1;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    -webkit-filter: blur(5px); 
            filter: blur(5px);
    transition: all 2s;
}
#text_wrapper {
/*    border: 1px solid green;*/
    position: fixed;
    z-index: 99;
    top: 0;
    width: 100%;
    height: 100%;
    text-align: center;
/*    opacity: 0.5;*/
    display: none;
}
#text_wrapper img {
    position: absolute;
    height: 80%;
    top: 50%;
        -ms-transform: translateY(-50%) translateX(-50%);
    -webkit-transform: translateY(-50%) translateX(-50%);
            transform: translateY(-50%) translateX(-50%);
}
.wrapper {
/*    border: 1px solid green;*/
    position: fixed;
    top: 4%;
    height: 90vh;
    width: 48%;
    left: 0%;
    padding: 0;
    margin: 0;
}
#right_wrapper {
    left: inherit;
    right: 0%;
}
.wrapper > div {
/*    border: 1px solid red;*/
    position: absolute;
    top: 0%;
    right: 0;
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    width: 80%;
    height: 100%;
    text-align: center;
    -webkit-filter: blur(5px); 
            filter: blur(5px);
    display: none;
}
#right_wrapper > div {
    left: 0;
    right: inherit;
}
.wrapper .visible {
    display: block;
}

#drawing_board {
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: white;
    opacity: 0.1;
    display: none;
}

#record {
    border: 1px solid black;
    background-color: white;
    height: 100%;
    width: 25%;
    position: fixed;
    z-index: 99999;
    top: 0;
    right: 0;
    font-size: 0.8em;
    display: none;
}

#once {
/*    border: 1px solid red;*/
    position: fixed;
    z-index: 99;
/*    top: -10px;
    left: -135px;*/
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

#once .point {
/*    background-color: white;*/
    border-radius: 8px;
    width: 16px;
    height: 16px;
    position: absolute;
    box-shadow: 5px 5px 20px #8B4513;
    transition: all 5s;
/*    background-image: url("http://localhost:8888/fredcave/wp-content/uploads/2017/01/Fred-Cave-Once-Removed.jpg");
    background-position: center;*/

}

</style>

<!-- SCRIPTS -->

<script type="text/javascript">
    $(document).on("ready", function(){
        // BACKGROUND IMAGE SIZING
        function bgImageSize () {
            console.log("bgImageSize");
            $(".resize, .visible").each( function(){
                var thisId = $(this).attr("id"),
                    wrapperW = $(".wrapper").height(),
                    url = "";
                if ( thisId === "bg_image" ) {    
                    wrapperW = $(window).width();
                }
                if ( wrapperW >= 1200 ) {
                    // FULL
                    url = $(this).attr("data-fll");
                } else if ( wrapperW < 1400 && wrapperW >= 900 ) {
                    // EXTRA LARGE
                    url = $(this).attr("data-xlg");
                } else if ( wrapperW < 1000 && wrapperW >= 600 ) {
                    // LARGE
                    url = $(this).attr("data-lrg");
                } else if ( wrapperW < 700 && wrapperW >= 300 ) {
                    // MEDIUM
                    url = $(this).attr("data-med");
                } else {
                    // THUMB
                    url = $(this).attr("data-tmb");
                }
                // console.log(80, thisId, wrapperW, url);
                document.getElementById(thisId).style.backgroundImage = "url('" + url + "')";
            });

        } 
        // IMAGES INIT
        function imagesInit () {
            console.log("imagesInit");
            $(".wrapper div:first-child").addClass("resize");
            $(".wrapper div").css({
                "-webkit-filter" : "blur(0px)", 
                        "filter" : "blur(0px)"
            });
            $("#bg_image").addClass("visible").css({
                "-webkit-filter" : "blur(0px)", 
                        "filter" : "blur(0px)"
            });
            bgImageSize();
        }
        // SLIDESHOW
        function imageChange ( wrapper ) {
            console.log("imageChange");
            var vis = wrapper.find(".visible");
            // IF NEXT
            if ( vis.next().length ) {
                vis.removeClass("visible").next().addClass("visible");  
            } else {
                // ELSE BACK TO START  
                vis.removeClass("visible");
                wrapper.find("div:first-child").addClass("visible");  
            }
            // LOAD NEXT
            wrapper.find(".resize").removeClass("resize");
            $(".visible").next().addClass("resize");
            bgImageSize();  
        }
        function slideShow ( s_show ) {
            // console.log("slideShow");
            // RANDOM DELAY
            var delay = Math.random() * 8 + 3; // BETWEEN 3 & 12 seconds
            // console.log(202, s_show, delay);
            imageChange( s_show );
            setTimeout( function(){
                slideShow(s_show);
            }, delay * 1000 );
        }
        function slideInit() {
            console.log("slideInit");
            $(".wrapper").each( function(){
                slideShow( $(this) );
            });
        }

        // DRAW EVENT
        $("#drawing_board").on("click", function(e){
            var drawX = e.clientX,
                drawY = e.clientY;
            console.log(235, drawX, drawY);
            //var point = [drawX, drawY];
            //holes.push(point);
            $("#record").append("[[" + drawX + "], [" + drawY + "]],");
            //console.log(holes);
        });

        // PRINT FROM COORDINATES
        var anImage = [[[359], [196]],[[369], [185]],[[369], [175]],[[369], [173]],[[372], [158]],[[375], [147]],[[382], [136]],[[384], [131]],[[387], [127]],[[389], [124]],[[402], [125]],[[400], [142]],[[409], [155]],[[409], [165]],[[398], [165]],[[393], [165]],[[389], [165]],[[383], [165]],[[409], [182]],[[423], [186]],[[423], [194]],[[446], [190]],[[446], [178]],[[447], [168]],[[447], [156]],[[447], [149]],[[447], [142]],[[447], [135]],[[447], [123]],[[462], [148]],[[466], [157]],[[474], [172]],[[483], [170]],[[483], [188]],[[483], [144]],[[483], [130]],[[483], [123]],[[483], [119]],[[551], [195]],[[569], [189]],[[584], [194]],[[571], [170]],[[570], [164]],[[570], [158]],[[569], [145]],[[569], [141]],[[569], [133]],[[567], [120]],[[552], [120]],[[582], [124]],[[616], [189]],[[614], [179]],[[614], [164]],[[614], [148]],[[612], [121]],[[612], [126]],[[623], [133]],[[633], [143]],[[643], [151]],[[652], [142]],[[656], [132]],[[666], [127]],[[666], [139]],[[665], [155]],[[671], [171]],[[671], [184]],[[690], [193]],[[689], [177]],[[699], [172]],[[705], [170]],[[702], [156]],[[704], [144]],[[709], [137]],[[712], [133]],[[716], [128]],[[717], [121]],[[729], [132]],[[731], [142]],[[739], [158]],[[743], [170]],[[747], [183]],[[726], [166]],[[723], [166]],[[720], [167]],[[707], [167]],[[811], [132]],[[804], [126]],[[793], [124]],[[783], [133]],[[777], [151]],[[777], [164]],[[787], [178]],[[801], [183]],[[810], [183]],[[815], [162]],[[806], [155]],[[819], [155]],[[822], [155]],[[825], [155]],[[900], [125]],[[886], [125]],[[875], [123]],[[862], [123]],[[861], [138]],[[861], [145]],[[873], [157]],[[879], [157]],[[885], [157]],[[861], [167]],[[859], [187]],[[859], [197]],[[882], [196]],[[890], [196]],[[894], [196]],[[902], [196]],[[910], [181]]],
            oncePoints = [[[442], [326]],[[425], [328]],[[413], [341]],[[410], [360]],[[410], [379]],[[416], [394]],[[433], [412]],[[480], [338]],[[475], [354]],[[475], [364]],[[475], [376]],[[481], [392]],[[492], [403]],[[505], [406]],[[508], [401]],[[521], [395]],[[521], [381]],[[521], [374]],[[521], [367]],[[521], [356]],[[520], [338]],[[506], [333]],[[491], [332]],[[482], [337]],[[561], [403]],[[561], [383]],[[559], [369]],[[559], [359]],[[560], [347]],[[560], [333]],[[570], [341]],[[587], [349]],[[588], [369]],[[599], [380]],[[600], [391]],[[609], [396]],[[611], [375]],[[611], [366]],[[611], [363]],[[611], [358]],[[613], [344]],[[613], [329]],[[654], [384]],[[655], [361]],[[655], [345]],[[664], [335]],[[677], [334]],[[692], [336]],[[701], [343]],[[707], [385]],[[692], [405]],[[674], [405]],[[667], [402]],[[654], [386]],[[782], [331]],[[771], [330]],[[760], [330]],[[745], [330]],[[740], [332]],[[776], [361]],[[758], [361]],[[751], [361]],[[745], [361]],[[737], [357]],[[737], [372]],[[743], [387]],[[739], [399]],[[753], [404]],[[761], [404]],[[773], [403]],[[781], [398]],[[784], [395]],[[783], [383]],[[781], [383]]],
            removed = [[[361], [659]],[[360], [648]],[[359], [633]],[[359], [617]],[[359], [603]],[[359], [589]],[[359], [571]],[[371], [571]],[[388], [574]],[[397], [583]],[[403], [597]],[[399], [611]],[[394], [614]],[[377], [614]],[[366], [619]],[[391], [626]],[[398], [642]],[[401], [652]],[[487], [568]],[[480], [568]],[[474], [568]],[[455], [568]],[[444], [570]],[[445], [583]],[[446], [599]],[[446], [618]],[[465], [609]],[[474], [609]],[[477], [609]],[[484], [609]],[[448], [632]],[[448], [643]],[[447], [656]],[[465], [661]],[[477], [661]],[[493], [659]],[[498], [657]],[[501], [653]],[[529], [653]],[[529], [637]],[[525], [614]],[[526], [605]],[[526], [586]],[[526], [580]],[[534], [576]],[[546], [585]],[[551], [598]],[[553], [606]],[[573], [603]],[[573], [591]],[[575], [579]],[[582], [574]],[[592], [582]],[[594], [595]],[[594], [605]],[[594], [624]],[[594], [637]],[[594], [657]],[[634], [640]],[[626], [631]],[[625], [616]],[[625], [606]],[[625], [593]],[[636], [585]],[[646], [578]],[[661], [576]],[[673], [585]],[[673], [596]],[[674], [607]],[[678], [622]],[[674], [635]],[[671], [651]],[[656], [656]],[[641], [656]],[[705], [574]],[[710], [589]],[[717], [606]],[[724], [622]],[[725], [637]],[[729], [651]],[[739], [635]],[[753], [622]],[[753], [607]],[[759], [593]],[[765], [571]],[[843], [578]],[[828], [575]],[[807], [575]],[[792], [575]],[[794], [591]],[[832], [612]],[[814], [610]],[[798], [610]],[[798], [619]],[[800], [631]],[[800], [642]],[[800], [653]],[[812], [654]],[[831], [657]],[[840], [657]],[[852], [649]],[[885], [661]],[[885], [645]],[[885], [635]],[[881], [619]],[[881], [607]],[[879], [592]],[[879], [582]],[[879], [572]],[[892], [571]],[[910], [576]],[[917], [585]],[[929], [599]],[[929], [612]],[[923], [630]],[[919], [653]],[[906], [661]],[[942], [687]],[[958], [677]],[[968], [662]],[[978], [648]],[[981], [626]],[[991], [612]],[[990], [601]],[[981], [580]],[[974], [565]],[[960], [554]]];
        var allPoints = anImage.concat( oncePoints, removed );

        console.log(allPoints);



        $.randomize = function(arr) {
            for(var j, x, i = arr.length; i; j = parseInt(Math.random() * i), x = arr[--i], arr[i] = arr[j], arr[j] = x);
            return arr;  
        };

        var allPoints = $.randomize(allPoints);

        // for (var i = 0; i < allPoints.length; i++) {
        var i = 0;
        var printer = setInterval( function(){
            var thisX = allPoints[i][0][0] / $(window).width() * 100,
                thisY = allPoints[i][1][0] / $(window).height() * 100,
                random = Math.random() * 5;
            var newPoint = $("<div class='point'></div>").css({
                "top" : thisY + "%",
                "left" : thisX + "%",
                "transition" : "all " + random + "s"
            });
            $("#once").append(newPoint);
            // console.log( oncePoints[i][0][0], oncePoints[i][1][0] );   
            i++; 
            if ( i === allPoints.length ) {
                console.log("no more points.");
                clearInterval(printer);
            }     
        }, 100 );
        //};

        // function movePoints () {
        //     console.log("movePoints");
        //     $(".point").each(function(){
        //         var randX = Math.random() * 4 + 1,
        //             randY = Math.random() * 4 + 1;
        //         $(this).css({
        //             "transform" : "translateX(" + randX + "px) translateY(" + randY + "px)"
        //         });
        //     });
        // }

        function collectPoints(){
            console.log("collectPoints");
            if ( !$("#once").hasClass("collected") ) {
                // COLLECT
                $(".point").each(function(){
                    // RECORD CURRENT POSITION
                    $(this).attr({
                        "data-x" : $(this).css("left"),
                        "data-y" : $(this).css("top")
                    }).css({
                        "top" : 0,
                        "left" : 0
                    });
                });
                $("#once").addClass("collected");
            } else {
                // DISPERSE
                $(".point").each(function(){
                    // RECORD CURRENT POSITION
                    $(this).css({
                        "top" : parseInt ( $(this).attr("data-y") ),
                        "left" : parseInt ( $(this).attr("data-x") )
                    });
                });
                $("#once").removeClass("collected");
            }
            
        }

        $(window).on("load", function(){
            imagesInit();
            slideInit();
            // setTimeout( function(){
            //     setInterval( function(){
            //         collectPoints();
            //     }, 8000 );                
            // }, 10000 );
        }).on( "resize", _.throttle(function() {
            bgImageSize();
        }, 500 ) );
    }); // END OF DOCUMENT READY
</script>

<!-- BACKGROUND IMAGE -->
<?php 
    $images = get_field("project_images");
    $bg_image = $images[0]["project_image"];
    bgImage( $bg_image, true ); 
?>

<!-- TEXT -->
<div id="text_wrapper">
    <img src="<?php bloginfo('template_url'); ?>/assets/img/once_removed.svg" />
</div>

<ul id="left_wrapper" class="wrapper">
    <?php // get_images("left"); ?>
</ul>

<ul id="right_wrapper" class="wrapper">
    <?php // get_images("right"); ?>
</ul>

<div id="drawing_board"></div>

<div id="record" class="">

</div>

<div id="once">

</div>

