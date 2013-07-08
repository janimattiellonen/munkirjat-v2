$ ->
    "use strict"

    App.BookListView = Backbone.View.extend(
        el:         "#section-list-books"
        loaded:     false
        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @template = _.template $('#tpl-list-books').html()
            self = @
            @$ul = $('<ul></ul>')
            options.dispatcher.on "book:add", (book) ->
                self.$ul.append self.createListItemView(book)

        render: (authorId) ->
            self = @

            if(authorId)
                @model.url = 'book/byAuthor/' + authorId

            @model.fetch
                success: () ->
                    _.each self.model.models, ((book) ->
                        self.$ul.append self.createListItemView(book)
                    ), this

                    self.$el.html($(self.template()))

                    self.$el.find('article div').html self.$ul

        show: (authorId) ->
            @render(authorId)

            @$el.show()

        reset: () ->
            @$ul = $('<ul></ul>')
            @

        hide: () ->
            @$el.hide()
            @

        createListItemView: (book) ->
            new App.BookListItemView(model: book, dispatcher: @options.dispatcher).render().el
    )