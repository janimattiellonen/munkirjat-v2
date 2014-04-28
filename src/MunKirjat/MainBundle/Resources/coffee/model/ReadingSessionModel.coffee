$ ->
    "use strict"

    App.ReadingSessionModel = Backbone.Model.extend(
        idAttribute: 'id'
        defaults:
            "_token":     ""
            "title":  ""
            "authors":   ""
            "hasOpenSession": false
            "startingDate": null
            "startingTime": null
            "endingDate": null
            "endingTime": null
            "startingPage": null
            "endingPage": null

        urlRoot: Routing.generate('munkirjat_reading_session_view')
    )