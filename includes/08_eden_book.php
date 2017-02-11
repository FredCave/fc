<!-- STYLES -->

<style>
#canvas {
/*	border: 1px solid blue;*/
}

</style>

<!-- SCRIPTS -->

<script>
$(document).on("ready", function(){
	var c = document.querySelector("#canvas"),
    	ctx = c.getContext("2d"); 
    var image = new Image();
    	image.src = "http://localhost:8888/fredcave/wp-content/uploads/2017/01/623808696.jpg";

    image.onload = function () {
        console.log("Image loaded.");
        
        ctx.drawImage(image, 0, 0, c.width, c.height);

        var imageData = ctx.getImageData(0,0,800,600);
        console.log(imageData.data);
        makeRed();

        function makeRed () {
        	console.log("makeRed");
        	var numPixels = imageData.data.length / 4;
        	console.log(32, numPixels);
        	var i = 0;
        	var wave = setInterval( function(){
        		if ( i < numPixels ) {
					imageData.data[ i * 4 + 2 ] = 255 - imageData.data[ i * 4 + 2 ];
					ctx.putImageData(imageData, 0, 0);
        		} else {
        			clearInterval(wave);
        		}
        		i++;
        	}, 0.0000001 );

        	// LOOP THROUGH PIXELS
    //     	for ( var i = 0; i < numPixels; i++ ) {
    //     		imageData.data[ i * 4 + 0 ] = 0;
				// // imageData.data[ i * 4 + 1 ] = avg;
				// // imageData.data[ i * 4 + 2 ] = avg;
    //     	}
    //     	ctx.putImageData(imageData, 0, 0);
        }

        // function grayscale (imageData) {
        //     var numPixels = imageData.data.length / 4;
        //     console.log("numPixels = ", numPixels);

        //     for ( var i = 0; i < numPixels; i++ ) {
        //         // GET AVERAGE OF RGB
        //         var avg = ( imageData.data[ i * 4 + 1 ] + imageData.data[ i * 4 + 2 ] + imageData.data[ i * 4 + 3 ] ) / 3;
        //         imageData.data[ i * 4 + 0 ] = avg;
        //         imageData.data[ i * 4 + 1 ] = avg;
        //         imageData.data[ i * 4 + 2 ] = avg;
        //     }
        //     ctx.putImageData(imageData, 0, 0);
        // }
    }	
});
</script>

<canvas id="canvas" width="800" height="600"></canvas>