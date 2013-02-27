$ ->
    "use strict"

    App.AuthorListItemView = Backbone.View.extend(

        tagName: "li"

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @template = _.template $('#tpl-list-authors-item').html()

        render: () ->
            console.log "fn: " + @model.get("firstName") + " " + @model.get("lastName") + ", id: " + @model.get("id")

            $(@el).html @template(id: @model.get("id"), name: @model.get("firstName") + " " + @model.get("lastName") )
            @

        show: (id) ->
            @$el.show()

            @render()

        hide: () ->
            @$el.hide()
    )

