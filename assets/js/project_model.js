var app = app || {};

app.ProjectModel = Backbone.Model.extend({
	
	urlRoot: ROOT + "/wp-json/custom/v1/project",

	initialize: function () {

		console.log("ProjectModel.initialize");

	}

});