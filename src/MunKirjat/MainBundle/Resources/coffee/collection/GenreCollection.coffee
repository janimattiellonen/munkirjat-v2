$ ->
    "use strict"

    App.GenreCollection = Backbone.Collection.extend(
        model:  App.GenreModel
        url:    Routing.generate('munkirjat_genre_list')
    )