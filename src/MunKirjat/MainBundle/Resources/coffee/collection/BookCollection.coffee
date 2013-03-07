$ ->
    "use strict"

    App.BookCollection = Backbone.Collection.extend(
        model:  App.BookModel
        url:    Routing.generate('munkirjat_book_list')
    )