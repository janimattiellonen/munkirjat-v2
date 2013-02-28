$ ->
    "use strict"

    App.AuthorListView = Backbone.View.extend(
        #tagName:   "ul"
        el:         "#section-list-authors"
        loaded:     false
        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @template = _.template $('#tpl-list-authors').html()

            self = @
            @$ul = $('<ul></ul>')
            @model.bind "add", (author) ->
                self.$ul.append(new App.AuthorListItemView(model: author, dispatcher: @options.dispatcher).render().el)

            @model.fetch
                success: () ->
                    console.log "fetching..."
                    self.model.bind("reset", self.render, self)
                    self.render()

        render: () ->
                console.log "Loading..."
                self = @
                _.each @model.models, ((author) ->
                    self.$ul.append new App.AuthorListItemView(model: author, dispatcher: @options.dispatcher).render().el
                ), this

                @.$el.find('article').html @$ul

            #this

        show: () ->
            @render()

            @$el.show()

        hide: () ->
            @$el.hide()
    )

