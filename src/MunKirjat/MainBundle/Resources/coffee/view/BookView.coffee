$ ->
    "use strict"
    App.BookView = Backbone.View.extend(

        el:         '#section-view-book'
        loaded:     false
        csrf:       ""
        formErrorizer: null

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @formErrorizer = new App.FormErrorizer.Custom()
            @template = _.template $('#tpl-view-book').html()

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
                        )
                    self.loaded = true

                    self.initListeners()
            )

        initListeners: () ->
            $('#languages').buttonset()

            selected = []

            authorOptions = {
                mainElement:            '.author_item_selector',
                autoCompleteElement:    '.item_field',
                containerElement:       '.items ul',
                source:                 Routing.generate("munkirjat_author_search"),
                selected:               selected,
                canAddNew:              false,
                minLength:              3
            }

            authorComplete = new App.Selector(authorOptions)
            authorComplete.bind()

            selected = []
            $('.tag_item_selector .item ul li').each (i) ->
                val = $(this).attr 'data-id'
                val = parseInt val
                selected.push val

            tagOptions = {
                mainElement:            '.tag_item_selector',
                autoCompleteElement:    '.item_field',
                containerElement:       '.items ul',
                source:                 Routing.generate("xi_tag_search"),
                saveUrl:                Routing.generate("xi_tag_add"),
                selected:               selected,
                canAddNew:              true,
                minLength:              3
            }

            self = @

            $(@el).on "click",  'input[type=radio]', (e) ->
                $('#language', self.el).val $(this).val()

            tagComplete = new App.Selector(tagOptions)
            tagComplete.bind()

            $('.tag_item_selector').on 'click', '.add-item-btn', ->

                tag = $.trim($('.tag_item_selector .item_field').val() )
                tagComplete.saveItem tag
                return false

            $('#author-list').sortable()

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

