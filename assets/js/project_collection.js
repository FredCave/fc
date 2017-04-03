var app = app || {};

app.ProjectCollection = Backbone.Collection.extend({
	
	url: ROOT + "/wp-json/custom/v1/projects"

});