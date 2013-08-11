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
                self.$ul.append self.createListItemView(author)

        render: () ->
            self = @

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
                    _.each self.model.models, ((author) ->

                        container += "<li>" + $(self.createListItemView(author)).html() + "</li>"

                        if(++step == blocksInFirstColumn)
                            container += '</ul></div>'
                            container += '<div class="author-column"><ul>'
                    ), this

                    container += '</ul></div>'

                    self.$el.html($(self.template()))

                    self.$el.find('article div').html container

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