
App.Router = Backbone.Router.extend(
    routes:
        "":                     "frontpage"
        "frontpage":            "frontpage"
        "frontpage/redirect":   "redirectToFrontpage"
        "about":                "about"
        "login":                "login"
        "logout":               "logout"
        "author":               "author"
        "author/:id":           "getAuthor"
        "authors":              "listAuthors"
        "genre":                "genre"
        "genre/:id":            "getGenre"
        "genres":               "listGenres"
        "book":                 "book"
        "book/:id":             "viewBook"
        "book/:id/edit":        "editBook"
        "books(/:authorId)":    "listBooks"
        "search":               "search"
        "stats":                "stats"

    initialize: (options) ->
        @dispatcher     = options.dispatcher

        @authorCollection   = new App.AuthorCollection()
        @genreCollection    = new App.GenreCollection()
        @bookCollection     = new App.BookCollection()
        @frontPageView      = new App.FrontPageView({dispatcher: @dispatcher} )
        @aboutView          = new App.AboutView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/about'} )
        @loginView          = new App.LoginView({dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/login'} )
        @authorView         = new App.AuthorView({model: new App.AuthorModel(), collection: @authorCollection, dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/author/create'} )
        @authorListView     = new App.AuthorListView({model: @authorCollection, dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/authors'} )
        @genreView          = new App.GenreView({model: new App.GenreModel(), dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/genre/create'} )
        @genreListView      = new App.GenreListView({model: @genreCollection, dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/genres'} )
        @bookView           = new App.BookView({model: new App.BookModel(), collection: @bookCollection, dispatcher: @dispatcher} )
        @bookEditView       = new App.BookEditView({model: new App.BookModel(), collection: @bookCollection, dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/book/create'} )
        @bookListView       = new App.BookListView({model: @bookCollection, dispatcher: @dispatcher, url: Routing.getBaseUrl() + '/books'} )
        @searchView         = new App.SearchView({dispatcher: @dispatcher})
        @statsView          = new App.StatsView({dispatcher: @dispatcher})

    preDispatch: () ->
        @dispatcher.trigger "container:hide"

    redirectToFrontpage: () ->
        window.location.href = Routing.getBaseUrl() + "/"

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

    logout: () ->
        window.location.href = Routing.getBaseUrl() + "/logout"

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

    genre: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-new-genre'
        @genreView.reset()
        @genreView.show()

    getGenre: (id) ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-new-genre'
        @genreView.show(id)

    listGenres: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-list-genres'
        @genreListView.show()

    book: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-new-book'
        @bookEditView.show()

    viewBook: (id) ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-view-book'
        @bookView.show(id)

    editBook: (id) ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-new-book'
        @bookEditView.show(id)

    listBooks: (authorId) ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-list-books'
        @bookListView.reset().show(authorId)

    search: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-search'
        @searchView.show()

    stats: () ->
        @preDispatch()
        @dispatcher.trigger "url:changed", 'primary-menu-stats'
        #@statsView.show()
)