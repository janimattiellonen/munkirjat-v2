$ ->
    "use strict"

    App.BookListView = Backbone.View.extend(
        el:         "#section-list-books"
        loaded:     false
        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @template = _.template $('#tpl-list-books').html()

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

                        console.log(book.get("title"))

                        container += "<li>" + $(self.createListItemView(book)).html() + "</li>"

                        if(++step == blocksInFirstColumn)
                            container += '</ul></div>'
                            container += '<div class="book-column"><ul>'
                    ), this

                    container += '</ul></div>'

                    self.$el.html($(self.template()))

                    self.$el.find('article div').html container

        showBooksByAuthor: (authorId) ->
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
            @

        hide: () ->
            @$el.hide()
            @

        createListItemView: (book) ->
            new App.BookListItemView(model: book, dispatcher: @options.dispatcher).render().el
    )