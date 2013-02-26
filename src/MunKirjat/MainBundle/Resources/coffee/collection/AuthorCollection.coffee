$ ->
    "use strict"

    App.AuthorCollection = Backbone.Collection.extend(
        model:      App.AuthorModel
        url:    Routing.generate('munkirjat_author_list')
    )


# follow http://coenraets.org/blog/2011/12/backbone-js-wine-cellar-tutorial-part-2-crud/