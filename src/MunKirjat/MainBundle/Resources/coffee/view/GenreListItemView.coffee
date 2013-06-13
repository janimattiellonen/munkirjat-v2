$ ->
    "use strict"

    App.GenreListItemView = Backbone.View.extend(

        tagName: "li"

        initialize: (options) ->
            @template = _.template $('#tpl-list-genres-item').html()

        render: () ->
            $(@el).html @template(id: @model.get("id"), name: @model.get("name"))
            @

        show: (id) ->
            @$el.show()

            @render()
    )

