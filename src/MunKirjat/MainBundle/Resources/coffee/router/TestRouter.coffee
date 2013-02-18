
App.TestRouter = Backbone.Router.extend(
    routes:
        "frontpage":        "frontpage"
        "about":            "about"
        "login":            "login"

    initialize: (options) ->
        @dispatcher     = options.dispatcher

        @frontPageView  = new App.FrontPageView({dispatcher: @dispatcher} );
        @aboutView      = new App.AboutView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/about'} );
        @loginView      = new App.LoginView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/login'} );

    preDispatch: () ->
        @dispatcher.trigger "container:hide"

    frontpage: () ->
        @preDispatch()
        @frontPageView.show()
        @dispatcher.trigger "url:changed", 'primary-menu-frontpage'

    about: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-about'

        @aboutView.show()

    login: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-login'
        @loginView.show()


)