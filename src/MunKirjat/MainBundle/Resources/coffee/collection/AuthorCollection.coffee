$ ->
    "use strict"

    App.AuthorCollection = Backbone.Collection.extend(
        model:      App.AuthorModel
        url:    Routing.generate('munkirjat_author_list')
    )