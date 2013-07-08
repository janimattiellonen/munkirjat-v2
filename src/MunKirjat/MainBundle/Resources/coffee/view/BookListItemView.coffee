$ ->
    "use strict"

    App.BookListItemView = Backbone.View.extend(

        tagName: "li"

        initialize: (options) ->
            @template = _.template $('#tpl-list-books-item').html()

        render: () ->
            $(@el).html @template(@model.toJSON())
            @

        show: (id) ->
            @$el.show()

            @render()
    )

