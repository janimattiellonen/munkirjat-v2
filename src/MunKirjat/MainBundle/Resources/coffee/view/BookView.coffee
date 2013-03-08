$ ->
    "use strict"

    App.BookView = Backbone.View.extend(

        el:         '#section-new-book'
        loaded:     false
        csrf:       ""
        formErrorizer: null
        events:
            'click #_submit': 'save'

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @formErrorizer = new App.FormErrorizer.Custom()
            @template = _.template $('#tpl-new-book').html()

        render: () ->
            self = @
            $.ajax(
                url: Routing.getBaseUrl() + '/new-token/new-book',
                dataType: 'json'
                success: (data) ->
                    self.csrf = data.csrf_token

                    id = self.model.get "id"

                    title = if id then 'book.edit' else 'book.addNew'

                    self.$el.html self.template(
                            title:              self.model.get("title")
                            csrf_token:         data.csrf_token
                            pageCount:          self.model.get("pageCount")
                            isbn:               self.model.get("isbn")
                            startedReading:     self.model.get("startedReading")
                            finishedReading:    self.model.get("finishedReading")
                            isRead:             self.model.get("isRead")
                        )
                    self.loaded = true
            )

        reset: () ->
            @model.clear()

        save: () ->

            @model.set "book":
                "title":                $('#title', @$el).val()
                "pageCount":            $('#pageCount', @$el).val()
                "isbn":                 $('#isbn', @$el).val()
                "startedReading":       $('#startedReading', @$el).val()
                "finishedReading":      $('#finishedReading', @$el).val()
                "isRead":               $('#isRead', @$el).val()
                "_token":               @csrf

            self = @

            isNew = @model.isNew()

            @model.save {},
                success: (model, response) ->
                    self.formErrorizer.clear($('#new-book-box') )
                    self.formErrorizer.errorize($('#new-book-box'), response);

                    if(response.success)

                        self.model.id = response.success.id
                        self.setTitle 'book.edit'
                        # update url
                        self.options.dispatcher.trigger "url:change", "#author/" + self.model.id
                        console.log self.model.isNew()
                        if(isNew)
                            self.options.collection.add self.model
                            self.options.dispatcher.trigger "book:add", self.model

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

    )

