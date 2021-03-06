$ ->
    "use strict"

    App.BookListView = Backbone.View.extend(
        el:         "#section-list-books"
        loaded:     false
        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @template = _.template $('#tpl-list-books').html()
            @showAuthor = false;

        render: () ->
            self = @
            @template = _.template $('#tpl-list-books').html()
            @$ul = $('<ul></ul>')
            @model.reset()

            @model.fetch
                success: () ->
                    amount = self.model.models.length
                    columns = 2

                    if amount % columns != 0
                        blocksInFirstColumn = Math.floor(amount / columns) + 1
                    else
                        blocksInFirstColumn = amount / columns

                    container = '<div class="book-column"><ul>'

                    step = 0
                    _.each self.model.models, ((book) ->
                        container += "<li>" + $(self.createListItemView(book)).html() + "</li>"

                        if(++step == blocksInFirstColumn)
                            container += '</ul></div>'
                            container += '<div class="book-column"><ul>'
                    ), this

                    container += '</ul></div>'

                    self.$el.html($(self.template()))


                    if (self.authorModel && self.showAuthor)
                        self.authorModel.fetch
                            success: (model, response) ->
                                self.$el.find('article div.author h2').html model.get("firstName") + " " + model.get("lastName")
                                self.showAuthor = false;

                    self.$el.find('article div.books').html container

        showBooksByAuthor: (authorId) ->
            @authorModel = new App.AuthorModel();
            @authorModel.id = authorId;
            @showAuthor = true
            @model.url = 'book/byAuthor/' + authorId
            @show()

        showBooks: () ->
            @model.url = 'book'
            @show()

        showUnreadBooks: () ->
            @model.url = 'book/unread'
            @show()

        show: () ->
            @render()

            @$el.show()

        reset: () ->
            @$ul = $('<ul></ul>')
            @$el.find('article div.author h2').html ""
            @

        hide: () ->
            @$el.hide()
            @

        createListItemView: (book) ->
            new App.BookListItemView(model: book, dispatcher: @options.dispatcher).render().el
    )