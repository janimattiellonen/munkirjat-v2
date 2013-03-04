
App.TestRouter = Backbone.Router.extend(
    routes:
        "frontpage":        "frontpage"
        "about":            "about"
        "login":            "login"
        "author":           "author"
        "author/:id":       "getAuthor"
        "authors":          "listAuthors"
        "genre":            "genre"
        "genres":           "listGenres"

    initialize: (options) ->
        @dispatcher     = options.dispatcher
        self            = @

        @dispatcher.on "url:change", (msg) ->
            self.navigate msg

        @dispatcher.on "change", (data) ->
            alert "author changed"

        @dispatcher.on "save", (data) ->
            alert "author saved"

        @dispatcher.on "add", (data) ->
            alert "author added"

        @authorCollection   = new App.AuthorCollection()
        @genreCollection   = new App.GenreCollection()
        @frontPageView      = new App.FrontPageView({dispatcher: @dispatcher} )
        @aboutView          = new App.AboutView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/about'} )
        @loginView          = new App.LoginView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/login'} )
        @authorView         = new App.AuthorView({model: new App.AuthorModel(), collection: @authorCollection, dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/author/create'} )
        @authorListView     = new App.AuthorListView({model: @authorCollection, dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/authors'} )
        @genreView          = new App.GenreView({model: new App.GenreModel(), dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/genre/create'} )
        @genreListView     = new App.GenreListView({model: @genreCollection, dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/genres'} )

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

    author: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-new-author'
        @authorView.reset()
        @authorView.show()

    getAuthor: (id) ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-new-author'
        @authorView.show(id)

    listAuthors: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-list-authors'

        @authorListView.show()
        #$('#section-list-authors article').html(@authorListView.render().el)
        #$('#section-list-authors').show()

    genre: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-new-genre'
        @genreView.show()

    listGenres: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-list-genres'
        @genreListView.show()
)