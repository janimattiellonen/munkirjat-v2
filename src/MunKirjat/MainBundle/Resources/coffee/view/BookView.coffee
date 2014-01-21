$ ->
    "use strict"
    App.BookView = Backbone.View.extend(

        events:
            'click #startReading': 'startReading'
            'click #finishReading': 'finishReading'

        el:         '#section-view-book'
        loaded:     false
        csrf:       ""
        formErrorizer: null

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @formErrorizer = new App.FormErrorizer.Custom()
            @template = _.template $('#tpl-view-book').html()
            @router = new Backbone.Router()

        render: () ->
            self = @
            $.ajax(
                url: Routing.getBaseUrl() + '/new-token/new-book',
                dataType: 'json'
                success: (data) ->
                    self.csrf = data.csrf_token

                    id = self.model.get "id"

                    title = if id then 'book.edit' else 'book.addNew'

                    languages = [
                        {code: 'fi', name: 'Finnish'},
                        {code: 'se', name: 'Swedish'},
                        {code: 'en', name: 'English'}
                    ]

                    self.$el.html self.template(
                            id:                 id
                            languages:          languages
                            title:              self.model.get("title")
                            language:           self.model.get("language")
                            csrf_token:         data.csrf_token
                            pageCount:          self.model.get("pageCount")
                            isbn:               self.model.get("isbn")
                            startedReading:     self.model.get("startedReading")
                            finishedReading:    self.model.get("finishedReading")
                            isRead:             self.model.get("isRead")
                            tags:               self.model.get("tags")
                            authors:            self.model.get("authors")
                            price:              self.model.get("price")
                        )
                    self.loaded = true
            )

        show: (id) ->
            @$el.show()

            if(id)
                @model.id = id
                self = @
                @model.fetch
                    success: (model, response) ->
                        self.render()
            else
                @model.id = null
                @render()

        hide: () ->

            @$el.hide()

        setTitle: (title) ->
            @$el.find('h1').html Translator.get title

        startReading: (e) ->
            @model.set "startedReading", moment().format('DD.MM.YYYY')

            @populateModel()

            self = @

            @model.save {},
                success: (data) ->
                    self.router.navigate "#/book/" + self.model.get("id"),
                        trigger: true

        finishReading: (e) ->
            @model.set
                "finishedReading": moment().format('DD.MM.YYYY')
                isRead: true

            @populateModel()

            self = @

            @model.save {},
                success: (data) ->
                    self.router.navigate "#/book/" + self.model.get("id"),
                        trigger: true

        populateModel: () ->
            tags = []

            _.each(@model.get("tags"), (obj) ->
                tags.push obj.name
            )

            authors = []

            _.each(@model.get("authors"), (obj) ->
                authors.push obj.id
            )

            @model.set "book":
                "title":                @model.get("title")
                "language":             @model.get("language")
                "pageCount":            @model.get("pageCount")
                "isbn":                 @model.get("isbn")
                "startedReading":       @model.get("startedReading")
                "finishedReading":      @model.get("finishedReading")
                "isRead":               @model.get("isRead")
                "_token":               @csrf
                "tags":                 tags
                "authors":              authors
                "price":                @model.get("price")
    )

