$ ->
    "use strict"

    App.BookModel = Backbone.Model.extend(
        idAttribute: 'id'
        defaults: "book":
            "_token":           ""
            "title":            ""
            "language":         ""
            "pageCount":        ""
            "isbn":             ""
            "created":          ""
            "updated":          ""
            "startedReading":   ""
            "finishedReading":  ""
            "bookRead":         ""
            "price":            ""

        urlRoot: Routing.generate('munkirjat_book_create')
    )