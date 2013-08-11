$ ->
    "use strict"

    App.GenreModel = Backbone.Model.extend(
        idAttribute: 'id'
        defaults:
            "_token":     ""
            "name":   ""

        urlRoot: Routing.generate('munkirjat_book_genres')

        parse: (response, options) ->
            console.log "parsing: " + JSON.stringify(response)
            return response unless response.success
    )