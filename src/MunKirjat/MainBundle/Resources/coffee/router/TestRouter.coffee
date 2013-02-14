
app.TestRouter = Backbone.Router.extend(
    routes:
        "frontpage":        "frontpage"
        "about":            "about"

    initialize: (options) ->
        @dispatcher     = options.dispatcher

        @frontPageView  = new app.FrontPageView({dispatcher: @dispatcher} );
        @aboutView      = new app.AboutView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/about'} );

    frontpage: () ->
        @dispatcher.trigger "container:hide"

        @frontPageView.show()
        @dispatcher.trigger "url:changed", 'primary-menu-frontpage'

    about: () ->
        @dispatcher.trigger "container:hide"
        @dispatcher.trigger "url:changed", 'primary-menu-about'

        @aboutView.show()

)