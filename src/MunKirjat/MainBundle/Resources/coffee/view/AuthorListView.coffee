$ ->
    "use strict"

    App.AuthorListView = Backbone.View.extend(
        el:         "#section-list-authors"
        loaded:     false
        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @template = _.template $('#tpl-list-authors').html()
            self = @
            @$ul = $('<ul></ul>')
            options.dispatcher.on "author:add", (author) ->
                console.log "Adding"
                self.$ul.append self.createListItemView(author)

        render: () ->
            self = @

            @model.fetch
                success: () ->
                    _.each self.model.models, ((author) ->
                        self.$ul.append self.createListItemView(author)
                    ), this

                    self.$el.append($(self.template()))

                    self.$el.find('article div').html self.$ul

        show: () ->
            if !@loaded
                @render()
                @loaded = true
            @$el.show()

        hide: () ->
            @$el.hide()

        createListItemView: (author) ->
            console.log "what are we adding? " + JSON.stringify author
            new App.AuthorListItemView(model: author, dispatcher: @options.dispatcher).render().el
    )