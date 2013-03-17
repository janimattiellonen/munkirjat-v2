$ ->
    "use strict"

    App.GenreListView = Backbone.View.extend(
        el:         "#section-list-genres"
        loaded:     false
        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @template = _.template $('#tpl-list-genres').html()
            self = @
            @$ul = $('<ul></ul>')
            options.dispatcher.on "genre:add", (genre) ->
                self.$ul.append self.createListItemView(genre)

        render: () ->
            self = @

            @model.fetch
                success: () ->
                    _.each self.model.models, ((genre) ->
                        self.$ul.append self.createListItemView(genre)
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

        createListItemView: (genre) ->
            new App.GenreListItemView(model: genre, dispatcher: @options.dispatcher).render().el
    )