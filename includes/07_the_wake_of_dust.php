<!-- STYLES -->

<style>

body {
	background-color: black;
	overflow: hidden;
	}

canvas {
	position: fixed;
	top: 0;
	left: 50%;
	margin-left: -800px;
	background: transparent;
}
	
#image_wrapper {
/*	border: 1px solid pink;*/
	position: absolute;
	width: 80%;
	height: 80%;
	top: 0;
	margin: 5% 10%;
	background-size: contain;
	background-repeat: no-repeat;
	background-position: center;
/*	filter: hue-rotate(90deg);*/
}
	
#image_wrapper img {
	display: none;
}

#text_wrapper {
/*	border: 1px solid pink;*/
	position: absolute;
	top: 45%;
	left: 0;
	transform: translateY(-50%);
	z-index: 9999;
	width: 80%;
	height: auto;
	margin: 3vh 10%;
	color: white;
	font-size: 4em;
	font-size: 5.3vw;
	transition: all 0.5s;
	line-height: 1.5;
}

	@media ( min-width: 1050px ) {
		#text_wrapper {
			font-size: 5vw;
			line-height: 1.45;
		}		
	}

	@media ( min-width: 1200px ) {
		#text_wrapper {
			font-size: 4.8vw;
			line-height: 1.4;
		}		
	}

	@media ( min-width: 1300px ) {
		#text_wrapper {
			font-size: 4.6vw;
			line-height: 1.35;
		}		
	}

#text_wrapper a {
	color: white;
	text-decoration: none;
	border-bottom: 0px;
}

#text_wrapper a:hover {
	color: transparent;
	color: rgba("255,255,255,0");
	border-bottom: 0px;
}

#text_wrapper form {
	display: inline;
}

::selection {
	color: rgba(255,255,255,0);
}
::-moz-selection {
	color: rgba(255,255,255,0);
}
	
a, a:visited, a:active {
	color: black;
	position: relative;
	}

.link {
	width: 70px;
	width: 5vw;
	position: absolute;
	top: 2px;
	display: inline-block !important;
	left: -40px;
	z-index: 99;
}
</style>

<!-- SCRIPTS -->

<script src="<?php bloginfo('template_url'); ?>/assets/matter.js"></script>
<script src="<?php bloginfo('template_url'); ?>/assets/perlin.js"></script>

<script>
$(document).ready(function(){	
	var WIDTH = 1600,
		HEIGHT = 1500,
		HALFWIDTH = WIDTH / 2,
		win = $(window),
		mx = 0,
		my = 0,
		mWind = 0,
		lastMx = 0,
		lastMy = 0,
		viewWidth,
		viewWidthBytes,
		viewHeight,
		dustLeft,
		showWind = false;				
	noise.seed(0.4382650712504983);
	var rsTimer;
	win.on('resize', function(){
		rsTimer = clearTimeout(rsTimer);
		viewHeight = win.height();
		viewWidth = Math.min(win.width(), WIDTH);
		viewWidthBytes = viewWidth * 4;
		dustLeft = Math.max((WIDTH - viewWidth) / 2, 0);
		rsTimer = setTimeout(function(){					
			numDust = viewWidth * viewHeight * 0.02;
			makeDust();
		}, 200)
	}).trigger('resize').on('click', function(){
	});
	var Engine = Matter.Engine,
	    World = Matter.World,
	    Body = Matter.Body,
	    Bodies = Matter.Bodies,
	    Constraint = Matter.Constraint,
	    Composite = Matter.Composite,
	    Composites = Matter.Composites,
	    MouseConstraint = Matter.MouseConstraint,
	    Events = Matter.Events;
	var engine = Engine.create(document.body, {
	  render: {
	    options: {
	      showAngleIndicator: false,
	      wireframes: false,
	      width: WIDTH,
	      height: HEIGHT
	    }
	  }
	});		
	var mouseConstraint = MouseConstraint.create(engine, {
		constraint: {
			stiffness: 0.01,
			render: {
				visible: false
			}
		}
	});
	World.add(engine.world, mouseConstraint);	
	var topOffset = 175,
		stringLength = 300,
		objs = [];
	var offset = 500;
	options = { 
		isStatic: true,
		render: {
			visible: false
		}
	};		
    World.add(engine.world, [
        Bodies.rectangle(HALFWIDTH, top - stringLength - offset / 2, WIDTH, offset, options),
    ]);
	World.add(engine.world, objs);
	var maxVol = 1/6;		
	var all = Composite.allBodies(engine.world),
		windStrength = 0.0005	
	var bg = document.getElementById("back").getContext('2d'),
		dusts = [],
		deadDust = [],
		numDust = 20000,
		tog = 0,
		MAX_COL = 150,
		MIN_COL = 75,
		MAX_X = 0.5,
		MAX_Y = 2,
		FALLOFF = 0.5,
		BROWNIAN = 0.2,
		i, //Iterator
		j, //Iterator
		p, //Current particle
		l, //Current letter
		a, //Image data
		b, //Image data data
		n, //Particle position
		vx,
		vy;				
	function Dust(){
		this.init = function(atTop){											
			this.x = Math.floor(Math.random() * viewWidth);
			this.y = atTop ? 0 : Math.floor(Math.random() * viewHeight);
			this.vx = 0;
			this.vy = 0;
			this.speed = Math.random() * 1.75 + .25;
			this.col = MIN_COL;
			this.maxcol = Math.random() > .95 ? 255 : MAX_COL;
			this.dir = Math.random() * 30 - 15;
			this.r = (Math.random() * .1 + .9) * 255;
			this.g = (Math.random() * .1 + .85) * 255;
			this.b = (Math.random() * .2 + .7) * 255;
			this.active = true;
			var rand = Math.random();				
			if(rand > .9) {
				this.glow = 2;
			} else if (rand > .7) {
				this.glow = 1;
			} else {
				this.glow = 0;
			}
		}		
		this.init();
	}
	function makeDust(){
		dusts = [];
		var d;
		for(i = 0; i < numDust; i++){		
			dusts.push(new Dust());
		}
	}		
	makeDust();	
	function fillPixel(data, n, r, g, b, a){
		data[n] += r,
		data[n+1] += g,
		data[n+2] += b,
		data[n+3] += a || 255;
	}			
	function dustStep(){
	    for ( i = 0; i < numDust; ++i) {
	      p = dusts[i];
		  var q = (~~((p.x + dustLeft) / WIND_SPACING) * XWINDS) + (~~(p.y / WIND_SPACING));
		  if(q<0) q = 0;
		  if(q>NUMWINDS-1) q = NUMWINDS-1;
	      var w = winds[q];
	      p.vx *= .9;
	      p.vy *= .9;   
			  p.vx += w.vx * 8;
			  p.vy += w.vy * 8;
	      p.x += p.vx;
	      p.y += p.vy + p.speed;  		      
	      if(p.y > viewHeight){
			 p.y = p.vx = p.vy = 0;
			 p.active = true;		      
			 }
	      if (p.x < 0 || p.x > viewWidth) p.init(true);
		  if(p.col > p.maxcol || p.col < MIN_COL) p.dir = -p.dir;
		  p.col += p.dir;
		  if(p.y > 600) continue;
	    }
	}	
	function dustCollide(){		
	  for(i = 0; i < numDust; ++i){
		  p = dusts[i];
		  if(p.y > 600) continue;
		  for(j = 0; j < numLetters; ++j){  
			  l = letters[j];
			  if(Matter.Bounds.contains(l.bounds, {x: p.x + dustLeft, y: p.y}) && Matter.Vertices.contains(l.vertices, {x: p.x + dustLeft, y: p.y})){
				  p.active = false;
			  } 
		  } 
	  }	  
	}
	function prepDust(){
		wind();
		dustStep();
	}
	function dustDraw(){
	    b = ( a = bg.createImageData( viewWidth, viewHeight ) ).data;			
	    for ( i = 0; i < numDust; ++i ) {
	      p = dusts[i];
	      if(!p.active) continue;
	      d = 1 - ((Math.abs(p.x + dustLeft - (viewWidth / 2)) / (viewWidth / 2)) * 0.7);  		      
	      var alpha = p.col * d; 
	      n = ( ~~p.x + ( ~~p.y * viewWidth ) ) * 4;    		      
	 	fillPixel(b, n, p.r, p.g, p.b, alpha);
	      if(p.glow){		      
		      alpha *= 0.5;
			  fillPixel(b, n - 4, p.r, p.g * d, p.b * d, alpha);
			  fillPixel(b, n + 4, p.r * d, p.g, p.b, alpha);
			  fillPixel(b, n - viewWidthBytes, p.r, p.g, p.b, alpha);
			  fillPixel(b, n + viewWidthBytes, p.r, p.g, p.b, alpha);
			  if(p.glow === 2){		  
			      alpha *= 0.8;    
				  fillPixel(b, n - viewWidthBytes - 4, p.r, p.g * d, p.b * d, alpha);
				  fillPixel(b, n - viewWidthBytes + 4, p.r * d, p.g, p.b, alpha);
				  fillPixel(b, n + viewWidthBytes - 4, p.r, p.g * d, p.b * d, alpha);
				  fillPixel(b, n + viewWidthBytes + 4, p.r * d, p.g, p.b, alpha);
			  }
	      }
	    }
	    bg.putImageData( a, dustLeft, 0 );
	}	
	var winds = [],
		WIND_SPACING = 30,
		XWINDS = Math.ceil(WIDTH / WIND_SPACING),
		YWINDS = Math.ceil(HEIGHT / WIND_SPACING),
		NUMWINDS = XWINDS * YWINDS,
		neighbs = [],
		avgX,
		avgY;
	for (i = 0; i < NUMWINDS; i++) {
		winds.push({
			y: i % XWINDS * WIND_SPACING,
			x: ~~(i / XWINDS) * WIND_SPACING,
			vx: 0,
			vy: 0,
			isEdge: (i % XWINDS === 0 || i % XWINDS === XWINDS - 1),
			nx: Math.random(),
			ny: Math.random()
		});
	}
	var noiseCount = 0;
	var dotCount = 0;
	function windPush(w1,w2){
		dotCount++;
		var posVector = Matter.Vector.normalise({x: w1.x - w2.x, y: w1.y - w2.y});
		var dot = Matter.Vector.dot(posVector, Matter.Vector.normalise({x: w2.vx, y: w2.vy}));
		dot = Math.max(0, dot);
		return {x: w2.vx * dot, y: w2.vy * dot};
	}
	function wind(){
		if(lastMx){
			var mDeltaX = mx - lastMx;
			var mDeltaY = my - lastMy;
		} else {
			var mDeltaX = 0;
			var mDeltaY = 0;
		}			
		if(mWind >= 0 && mWind < NUMWINDS - 1){
			winds[mWind].vx += mDeltaX * .02;
			winds[mWind].vy += mDeltaY * .02;
		}
		lastMx = mx;
		lastMy = my;
		for(i = 0; i < NUMWINDS; i++){
			p = winds[i];
			neighbs = [];
			avgX = avgY = 0;	
			if(winds[i+1]) neighbs.push(winds[i+1]);
			if(winds[i-1]) neighbs.push(winds[i-1]);
			if(winds[i+XWINDS]) neighbs.push(winds[i+XWINDS]);
			if(winds[i-XWINDS]) neighbs.push(winds[i-XWINDS]);
			if(winds[i+XWINDS + 1]) neighbs.push(winds[i+XWINDS + 1]);
			if(winds[i+XWINDS - 1]) neighbs.push(winds[i+XWINDS - 1]);
			if(winds[i-XWINDS + 1]) neighbs.push(winds[i-XWINDS + 1]);
			if(winds[i-XWINDS - 1]) neighbs.push(winds[i-XWINDS - 1]);				
			for(j = 0; j < neighbs.length; j++){
				var push = windPush(p, neighbs[j]);
				avgX += push.x;
				avgY += push.y;
			}
			p.vx += avgX;
			p.vy += avgY;
			p.vx *= .2;
			p.vy *= .2;
			if((p.nx += 0.01) > 1) p.nx -= 1;
			if((p.ny += 0.01) > 1) p.ny -= 1;
			nx = noise.perlin2(p.nx, 0.5) * .02;
			ny = noise.perlin2(p.ny, 0.5) * .02;
			p.vx += nx;
			p.vy += ny;
			if(showWind){
				bg.beginPath();
				bg.moveTo(p.x, p.y);
				bg.lineTo(p.x + p.vx * 100, p.y + p.vy * 100);
				bg.strokeStyle = 'white';
				bg.stroke();
			}
		}
		// console.timeEnd('dust');						
	}
	togs = [prepDust, dustDraw];
	var bod = $('body');
	var perfCounter = 0;
	Events.on(engine, 'tick', function(){
		// mx = engine.input.mouse.position.x;
		// my = engine.input.mouse.position.y;
		// var pointed = false;
		// mWind = (~~((mx + dustLeft) / WIND_SPACING) * XWINDS) + (~~(my / WIND_SPACING));
		// if(mouseConstraint.constraint.bodyB){
		// 	bod.addClass('grabbing');
		// } else if(pointed) {
		// 	bod.addClass('grab');
		// } else {
		// 	bod.removeClass('grab grabbing');
		// }
		if(++tog === 2) tog = 0;
		togs[tog]();			
	});
	engine.render.options.background = 'transparent';
	Engine.run(engine);	

	function imageSize () {
		console.log("imageSize");
		// GET WRAPPER WIDTH
		var wrapperW = $("#image_wrapper").width(),
			vis = $("#image_wrapper").find(".visible");
		if ( wrapperW >= 1400 ) {
            // FULL
            url = vis.attr("data-fll");
        } else if ( wrapperW < 1400 && wrapperW >= 1000 ) {
            // EXTRA LARGE
            url = vis.attr("data-xlg");
        } else if ( wrapperW < 1000 && wrapperW >= 700 ) {
            // LARGE
            url = vis.attr("data-lrg");
        } else if ( wrapperW < 700 && wrapperW >= 300 ) {
            // MEDIUM
            url = vis.attr("data-med");
        } else {
            // THUMB
            url = vis.attr("data-tmb");
        }
        document.getElementById("image_wrapper").style.backgroundImage = "url('" + url + "')";
	}
	
	function imagesInit () {
		console.log("imagesInit");
		$("#image_wrapper img:first").addClass("visible");
		imageSize();
		setInterval( imgSlide, 7000);
	}

	function imgSlide () {
		if ( !$(".visible").next().length ) {
			$("#image_wrapper img:first").addClass("visible");
			imageSize();
		} else {
			$(".visible").removeClass("visible").next().addClass("visible");
			imageSize();
		}	
	}
	
	$(window).on("load", function(){
		imagesInit();
	}).resize( _.throttle(function() {
		imageSize();
    }, 500 ) );
		
});		
</script>

<canvas id="back" width="1500" height="1500"></canvas>

<div id="image_wrapper">
	<?php
	if ( have_rows("project_images") ) {
		while ( have_rows("project_images") ) : the_row("project_images");
			$image = get_sub_field("project_image");
			image_object($image);
		endwhile;
	}
	?>
</div>

<div id="text_wrapper">
	<a target="_blank" href="http://thomashauser.fr/the-wake-of-dust">
		<img class="link" src="<?php bloginfo('template_url'); ?>/assets/img/arrow.png" />
		The Wake of Dust.
	</a> 
	Images: <a target="_blank" href="http://thomashauser.fr">
		<img class="link" src="<?php bloginfo('template_url'); ?>/assets/img/arrow.png" />
		Thomas Hauser.
		</a>
	Design: Fred Cave. 
	Printed at Werkplaats Typografie, Arnhem, NL; Plaatsmaaken, Arnhem, NL; Drukkerij Wihabo, Geffen, NL, and bound at Handboekbinderij Geertsen, Nijmegen, NL, in an edition of 200 copies. 
	© Thomas Hauser 2015
</div>
