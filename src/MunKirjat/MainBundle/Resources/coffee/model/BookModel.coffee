$ ->
    "use strict"

    App.BookModel = Backbone.Model.extend(
        idAttribute: 'id'
        defaults:
            "_token":           ""
            "title":            ""
            "language":         ""
            "pageCount":        ""
            "isbn":             ""
            "created":          ""
            "updated":          ""
            "startedReading":   ""
            "finishedReading":  ""
            "isRead":           ""

        urlRoot: Routing.generate('munkirjat_book_create')
    )