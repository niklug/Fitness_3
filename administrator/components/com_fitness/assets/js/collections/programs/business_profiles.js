define([
    'underscore',
    'backbone',
    'app'
], function ( _, Backbone, app, model) {
    var collection = Backbone.Collection.extend({
        url : app.options.ajax_call_url + '&format=text&view=exercise_library&task=business_profiles&id=',
    });
    
    return collection;
});