$ ->
    "use strict"

    App.GenreModel = Backbone.Model.extend(
        idAttribute: 'id'
        defaults:
            "_token":     ""
            "name":   ""

        urlRoot: Routing.generate('munkirjat_genre_create')

        parse: (response, options) ->
            console.log "parsing: " + JSON.stringify(response)
            return response unless response.success
    )