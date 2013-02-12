
app.TestRouter = Backbone.Router.extend(
    routes:
        "frontpage":        "frontpage"
        "about":            "about"

    initialize: (options) ->
        @dispatcher     = _.extend({}, Backbone.Events)

        @frontPageView  = new app.FrontPageView({dispatcher: @dispatcher} );
        @aboutView      = new app.AboutView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/about'} );

    frontpage: () ->
        @dispatcher.trigger "container:hide"
        @frontPageView.show()

    about: () ->
        @dispatcher.trigger "container:hide"
        @aboutView.show()

)