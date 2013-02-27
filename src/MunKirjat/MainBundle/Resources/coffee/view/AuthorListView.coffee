$ ->
    "use strict"

    App.AuthorListView = Backbone.View.extend(
        tagName: "ul"

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @template = _.template $('#tpl-list-authors').html()

            @model.bind("reset", @render, @)
            self = @

            @model.bind "add", (author) ->
                $(self.el).append(new App.AuthorListItemView(model: author, dispatcher: @options.dispatcher).render().el)

            @model.fetch()

        render: () ->
            console.log "rendering"
            _.each @model.models, ((author) ->
                console.log new App.AuthorListItemView(model: author, dispatcher: @options.dispatcher).render().el
                $(@el).append new App.AuthorListItemView(model: author, dispatcher: @options.dispatcher).render().el
            ), this
            this

        show: (id) ->
            @$el.show()

            #@render()

        hide: () ->
            @$el.hide()
    )

