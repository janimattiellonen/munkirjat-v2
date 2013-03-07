$ ->
    "use strict"

    App.BookModel = Backbone.Model.extend(
        idAttribute: 'id'
        defaults:
            "_token":       ""
            "title":        ""
            "pageCOunt":    ""
            "isbn":         ""
            "created":      ""
            "updated":      ""

        urlRoot: Routing.generate('munkirjat_book_create')
    )