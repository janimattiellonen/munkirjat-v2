$ ->
    "use strict"

    App.AuthorListItemView = Backbone.View.extend(

        tagName: "li"

        initialize: (options) ->
            @template = _.template $('#tpl-list-authors-item').html()

        render: () ->
            $(@el).html @template(id: @model.get("id"), name: @model.get("firstName") + " " + @model.get("lastName") )
            @

        show: (id) ->
            @$el.show()

            @render()
    )

