$ ->
    "use strict"

    App.GenreCollection = Backbone.Collection.extend(
        model:  App.GenreModel
        url:    Routing.generate('munkirjat_book_genres')
    )