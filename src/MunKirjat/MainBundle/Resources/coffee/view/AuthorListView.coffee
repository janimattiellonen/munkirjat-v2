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
                self.$ul.append @createListItemView(author)

            @model.fetch
                success: () ->
                    console.log "fetching..."
                    self.render()

        render: () ->
            console.log "Loading..."
            self = @
            _.each @model.models, ((author) ->
                self.$ul.append @createListItemView(author)
            ), this

            @.$el.find('article').html @$ul

        show: () ->
            if !@loaded
                console.log "oooo"
                @render()
                @loaded = true
            @$el.show()

        hide: () ->
            @$el.hide()

        createListItemView: (author) ->
            new App.AuthorListItemView(model: author, dispatcher: @options.dispatcher).render().el
    )

