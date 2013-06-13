$ ->
    "use strict"

    App.AuthorModel = Backbone.Model.extend(
        idAttribute: 'id'
        defaults:
            "_token":     ""
            "firstName":  ""
            "lastName":   ""

        urlRoot: Routing.generate('munkirjat_author_create')
    )