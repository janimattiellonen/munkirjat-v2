
App.TestRouter = Backbone.Router.extend(
    routes:
        "frontpage":        "frontpage"
        "about":            "about2"
        "login":            "login"
        "author":   "author"

    initialize: (options) ->
        @dispatcher     = options.dispatcher

        @frontPageView  = new App.FrontPageView({dispatcher: @dispatcher} );
        @aboutView      = new App.AboutView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/about'} );
        @loginView      = new App.LoginView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/login'} );
        @authorView     = new App.AuthorView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/author/create'} );

    preDispatch: () ->
        @dispatcher.trigger "container:hide"

    frontpage: () ->
        @preDispatch()
        @frontPageView.show()
        @dispatcher.trigger "url:changed", 'primary-menu-frontpage'

    about2: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-about'

        @aboutView.show()

    login: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-login'
        @loginView.show()

    author: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-new-author'
        @authorView.show()



)