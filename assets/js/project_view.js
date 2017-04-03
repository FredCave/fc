var app = app || {};

app.ProjectView = Backbone.View.extend({
	
	initialize: function ( slug ) {

		console.log("ProjectView.initialize", slug);

		// this.bindEvents();

		// var self = this;

		// // GET SOURCE FROM MODEL
		// var thisModel = new app.ProjectModel();
		// thisModel.fetch({ 
		// 	data: $.param({ name: slug })
		// }).then( function(){

		// 	console.log( 17, thisModel );

		// 	self.src = thisModel.attributes[0].url;

		// 	// LOAD SOURCE TO IFRAME
		// 	$(".layer").eq( app.Data.nextLayer ).find("iframe").attr("src", self.src);

		// 	// SHOW LAYER
		// 	self.showProject();

		// });

	},

	bindEvents: function () {

		console.log("ProjectView.bindEvents");

		$("#close_button a").on("click", function(){
            console.log("Close button clicked.");
        });

	}

	// showProject: function () {

	// 	console.log("ProjectView.showProject");

	// 	console.log( 27, app.Data.nextLayer );

	// 	var targetLayer = $(".layer").eq( app.Data.nextLayer ),
	// 		targetFrame = targetLayer.find("iframe");; 

 //        // FADE OUT INFO + SIBLING
 //        $("#home_wrapper").animate({
 //        	opacity: 0
 //        }, 1000 );

 //        targetLayer.animate({
 //            opacity: 1
 //        }, 2000, function() {
 //            targetLayer.css({
 //                "pointer-events" : "auto"
 //                // "z-index" : 9,
 //                // "overflow" : "auto"               
 //            });
 //        });

 //        console.log(88);
 //        app.backgroundChecker( targetFrame );

 //        // SHOW CLOSE BUTTON
 //        $("#close_button").fadeIn();
 //        // this.closeButtonCheck();

	// }

});