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

                    languages = [
                        {code: 'fi', name: 'Finnish'},
                        {code: 'se', name: 'Swedish'},
                        {code: 'en', name: 'English'}
                    ]

                    self.$el.html self.template(
                            languages:          languages
                            title:              self.model.get("title")
                            language:           self.model.get("language")
                            csrf_token:         data.csrf_token
                            pageCount:          self.model.get("pageCount")
                            isbn:               self.model.get("isbn")
                            startedReading:     self.model.get("startedReading")
                            finishedReading:    self.model.get("finishedReading")
                            bookRead:           self.model.get("bookRead")
                            tags:               self.model.get("tags")
                        )
                    self.loaded = true

                    self.initListeners()
            )

        initListeners: () ->
            $('#languages').buttonset()

            selected = []
            $('.tag_item_selector .item ul li').each (i) ->
                val = $(this).attr 'data-id'
                val = parseInt val
                selected.push val

            options = {
                mainElement:            '.tag_item_selector',
                autoCompleteElement:    '.item_field',
                containerElement:       '.items ul',
                source:                 Routing.generate("xi_tag_search"),
                saveUrl:                Routing.generate("xi_tag_add"),
                selected:               selected,
                canAddNew:              true,
                minLength:              3
            }

            $('.tag_item_selector').on 'click', '.add-item-btn', ->

                tag = $.trim($('.item_field').val() )

                tagComplete.saveItem tag
                return false

            self = @

            $(@el).on "click",  'input[type=radio]', (e) ->
                $('#language', self.el).val $(this).val()

            tagComplete = new App.Selector(options)
            tagComplete.bind()

        reset: () ->
            @model.clear()

        save: () ->
            @model.unset "created"
            @model.unset "updated"
            @model.set "bookRead", if $('#bookRead').is(':checked') then 1 else 0

            tags = []

            $('#book_tags .tag-id').each( (index) ->
                tags.push $(this).attr "value"
            )

            @model.set "book":
                "title":                $('#title', @$el).val()
                "language":             $('#language', @$el).val()
                "pageCount":            $('#pageCount', @$el).val()
                "isbn":                 $('#isbn', @$el).val()
                "startedReading":       $('#startedReading', @$el).val()
                "finishedReading":      $('#finishedReading', @$el).val()
                "bookRead":             if $('#bookRead').is(':checked') then 1 else 0
                "_token":               @csrf
                "tags":                 tags

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
                        self.options.dispatcher.trigger "url:change", "#book/" + self.model.id
                        console.log self.model.isNew()
                        if(isNew)
                            self.options.collection.add self.model
                            self.options.dispatcher.trigger "book:add", self.model


            return false
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

