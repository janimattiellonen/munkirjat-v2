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
            @model.bind "add", (author) ->
                self.$ul.append @createListItemView(author)

        render: () ->
            self = @

            @model.fetch
                success: () ->
                    _.each self.model.models, ((author) ->
                        self.$ul.append self.createListItemView(author)
                    ), this

                    self.$el.find('article').html self.$ul

        show: () ->
            if !@loaded
                @render()
                @loaded = true
            @$el.show()

        hide: () ->
            @$el.hide()

        createListItemView: (author) ->
            new App.AuthorListItemView(model: author, dispatcher: @options.dispatcher).render().el
    )