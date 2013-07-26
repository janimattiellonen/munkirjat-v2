$ ->
    "use strict"

    App.AuthorListItemView = Backbone.View.extend(

        tagName: "li"

        initialize: (options) ->
            @template = _.template $('#tpl-list-authors-item').html()

        render: () ->
            $(@el).html @template(id: @model.get("author").id, name: @model.get("author").firstName + " " + @model.get("author").lastName, amount: @model.get("amount") )
            @

        show: (id) ->
            @$el.show()

            @render()
    )

