var app = app || {};

app.AppView = Backbone.View.extend({
	
	initialize: function ( section ) {

		console.log("AppView.initialize");

		this.bindEvents();

		this.loadSources();

	},

	bindEvents: function () {

		console.log("AppView.bindEvents");

		var self = this;

        $("#hyperlink").on("mouseover", function(){
            if ( app.Data.hyperLinkActive ) {
                self.nextFadeIn();
            }
        }).on("mouseout", function(){
            if ( app.Data.hyperLinkActive ) {
                self.nextFadeOut();
            }
        });

        $("#close_button").on("mouseover", function(){
        	self.infoFadeIn();
        }).on("mouseout", function(){
			self.infoFadeOut();
        });

        // $("#hyperlink a").on("click", function (){
        // 	self.linkClick();
        // });

	},

	infoFadeIn: function () {

		console.log("AppView.infoFadeIn");

		$(".info_hidden").css({
			"opacity": 1
		});

		$(".current").css({
			"opacity": 0.6
		});

	},

	infoFadeOut: function () {

		console.log("AppView.infoFadeOut");

		$(".info_hidden").css({
			"opacity": 0
		});

		if ( $("#home_wrapper").hasClass("info_wrapper") ) {
			$(".current").css({
				"opacity": 1
			});
		}

	},	

    loadSources: function () {

        console.log("AppView.loadSources");

        var self = this;

        app.projects = new app.ProjectCollection();
        app.projects.fetch().then( function(){
            
            // LOAD FIRST SRC
            var first = app.projects.at( app.Data.nextProject ),
                firstUrl = first.attributes.url,
                firstTitle = first.attributes.title,
                firstSlug = first.attributes.slug,
                firstDesc = first.attributes.description,
                firstYear = first.attributes.year;

            // UPDATE NEXT PROJECT TO BE LOADED
            app.Data.nextProject++;

            // APPEND NEW LAYER
            $("#layer_wrapper").append("<div id='" + app.Data.zIndex + "' class='layer'><iframe data-slug='" + firstSlug + "' src='" + firstUrl + "'></iframe></div>");
            app.Data.zIndex++;

            // LOAD NEXT CAPTION
            app.AppView.nextCaption = {
                title : firstTitle,
                description: firstDesc,
                year: firstYear
            }

            // ADD LINK TO HYPERLINK
            $("#hyperlink a").attr("href","#" + firstSlug);  
            app.Data.srcLoaded = true;          

            self.updateCaption();
           
            // PLACE HYPERLINK
            self.placeHyperLink();

        });

    },

    linkClick: function () {

    	// console.log("AppView.linkClick");

    	// var self = this;

	    // // DEACTIVATE + MOVE HYPERLINK
    	// app.Data.hyperLinkActive = false;
    	// this.placeHyperLink();

     //    // HIDE CAPTION
     //    $("#caption_wrapper").css({
     //        opacity: 0
     //    });

     //    // FADE IN LAYER
     //    $(".current").removeClass("current");
     //    $(".layer").last().css({
     //        "opacity": 1
     //    }).addClass("current");

        // app.backgroundChecker( $(".layer").eq( app.Data.nextLayer ).find("iframe") );

        // // SHOW CLOSE BUTTON
        // $("#close_button").fadeIn();

        // app.Data.projectVis = true;

        // // LOAD NEXT LAYER
        // setTimeout( function(){
        //     // $(".layer").eq( app.Data.nextLayer ).css("z-index",1);
        //     self.prepNext();
        // }, 1000 );

    },

	backgroundChecker: function ( frame ) {

	    console.log("AppView.backgroundChecker");

	    console.log( 126, frame.attr("data-slug") );

	    switch ( frame.attr("data-slug") ) {
	        case "the-wake-of-dust": 
	        case "_sublimations": 	           
	            // INVERT HYPERLINK + CLOSE BUTTON
	            $("#hyperlink").addClass("inverted");
	            $("#close_button .close_button_black").removeClass("selected");
	            $("#close_button .close_button_white").addClass("selected");
	            break;
	        default:
	            // NORMAL HYPERLINK
	            $("#hyperlink").removeClass("inverted");
	            $("#close_button .close_button_white").removeClass("selected");
	            $("#close_button .close_button_black").addClass("selected");
	    } 

	},

	updateCaption: function () {

        console.log("AppView.updateCaption");

        // LOAD CAPTION DATA
        var caption = app.AppView.nextCaption;
        $("#caption_wrapper .title").html( caption.title );
        $("#caption_wrapper .description").html( caption.description );
        $("#caption_wrapper .year").html( caption.year );

    },

    showProject: function () {

        console.log("AppView.showProject");

	    // DEACTIVATE + MOVE HYPERLINK
    	app.Data.hyperLinkActive = false;
    	this.placeHyperLink();

        var self = this;

        // HIDE CAPTION
        $("#caption_wrapper").css({
            opacity: 0
        });

        // HIDE INFO
        $("#home_wrapper").css({
            opacity: 0
        }).addClass("info_hidden");        

        // FADE IN LAYER
        $(".current").removeClass("current");
        $(".layer").last().css({
            "opacity": 1,
            "pointer-events": "auto"
        }).addClass("current");

		this.backgroundChecker( $(".layer").last().find("iframe") );

        // SHOW CLOSE BUTTON
        $("#close_button").fadeIn();

		app.Data.projectVis = true;

        // LOAD NEXT LAYER
        setTimeout( function(){

            app.Data.hyperLinkActive = true;
            self.prepNext();
            // REMOVE ONE BEFORE LAST
			if ( $("#layer_wrapper .layer").length > 2 ) {
				$(".layer").first().remove();
            }

        }, 1500 );

    },

    prepNext: function () {

        console.log("AppView.prepNext");
       
        // HIDE CAPTION
        $("#caption_wrapper").css({
            opacity: 0
        });

        // UPDATE NEXT PROJECT TO BE LOADED
        console.log( 221, app.Data.nextProject, app.projects.length );
        if ( app.Data.nextProject < app.projects.length - 1 ) {
			app.Data.nextProject++;
        } else {
        	console.log( 225, "Back to the start." );
			app.Data.nextProject = 0;
        }

        // GET NEXT PROJECT
        var nextProject = app.projects.at( app.Data.nextProject ),
            nextUrl = nextProject.attributes.url,
            nextTitle = nextProject.attributes.title,
            nextSlug = nextProject.attributes.slug,
            nextDesc = nextProject.attributes.description,
            nextYear = nextProject.attributes.year;

        console.log( 169, nextTitle );

        // UPDATE NEXT LAYER
        // app.Data.updateNextLayer();

        // APPEND NEW LAYER
        $("#layer_wrapper").append("<div id='" + app.Data.zIndex + "' class='layer'><iframe data-slug='" + nextSlug + "' src='" + nextUrl + "'></iframe></div>");
        app.Data.zIndex++;

        // UPDATE HYPERLINK + CAPTION
        app.AppView.nextCaption = {
            title : nextTitle,
            description: nextDesc,
            year: nextYear
        }
        this.updateCaption();

        $("#hyperlink a").attr("href","#" + nextSlug); 

        // REACTIVATE HYPERLINK
        app.Data.hyperLinkActive = true;

    },

	placeHyperLink: function () {

	    console.log("AppView.placeHyperLink");

	    var cssValues,
	        rand = Math.random(),
	        initialClass,
	        delay = 0;
	    if ( rand < 0.33 ) {
	        cssValues = {
	            "left" : "5%",
	            "top" : (Math.random() * 0.5 + 0.1) * 100 + "%"
	        };
	        initialClass = "bottom_left";
	    } else if ( rand < 0.67 ) {
	        cssValues = {
	            "top" : "5%",
	            "left" : (Math.random() * 0.5 + 0.1) * 100 + "%"
	        };
	        initialClass = "top_left";
	    } else {
	        cssValues = {
	            "top" : "75%",
	            "left" : (Math.random() * 0.8 + 0.1) * 100 + "%"
	        };
	        initialClass = "bottom_right";
	    }
	    
	    // FIRST TIME
	    if ( !app.Data.hyperLinkVisible ) {
	        $("#hyperlink").addClass(initialClass);
	        // TRANSLATE BOTTOM + RIGHT VALUES TO TOP + LEFT
	        var initialTop = $("#hyperlink").offset().top,
	            initialLeft = $("#hyperlink").offset().left;
	        $("#hyperlink").css({
	            "bottom" : "inherit",
	            "right" : "inherit",
	            "top" : initialTop,
	            "left" : initialLeft
	        });    
	        delay = 1000;
	        app.Data.hyperLinkVisible = true;
	    }

	    setTimeout( function(){
	        $("#hyperlink").css(cssValues); 
	        // ACTIVATE HYPERLINK
	        app.Data.hyperLinkActive = true;           
	    }, delay );

	},



	nextFadeIn: function () {

		console.log("AppView.nextFadeIn");

		// SHOW CAPTION
		$("#caption_wrapper").css({
            opacity: 1
        });

		// FADE IN LAYER
		$(".layer").last().css({
            "opacity": 0.6
        });

	},

	nextFadeOut: function () {

		console.log("AppView.nextFadeOut");

		// HIDE CAPTION
		$("#caption_wrapper").css({
            opacity: 0
        });

		// FADE OUT LAYER
		$(".layer").last().not(".current").css({
            "opacity": 0
        });

	}

});