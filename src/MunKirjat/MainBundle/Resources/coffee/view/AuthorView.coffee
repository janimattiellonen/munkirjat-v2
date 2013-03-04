$ ->
    "use strict"

    App.AuthorView = Backbone.View.extend(

        el:         '#section-new-author'
        loaded:     false
        csrf:       ""
        formErrorizer: null
        events:
            'click #_submit': 'save'

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @formErrorizer = new App.FormErrorizer.Custom()
            @template = _.template $('#tpl-new-author').html()

        render: () ->
            self = @
            $.ajax(
                url: Routing.getBaseUrl() + '/new-token/new-author',
                dataType: 'json'
                success: (data) ->
                    self.csrf = data.csrf_token

                    id = self.model.get "id"

                    title = if id then 'author.edit' else 'author.addNew'

                    self.$el.html self.template(
                            title:      title
                            csrf_token: data.csrf_token
                            firstName:  self.model.get("firstName")
                            lastName:   self.model.get("lastName")
                        )
                    self.loaded = true
            )

        reset: () ->
            @model.clear()

        save: () ->

            @model.set "author":
                "firstName":    $('#firstName', @$el).val()
                "lastName":     $('#lastName', @$el).val()
                "_token":       @csrf

            self = @

            isNew = @model.isNew()

            @model.save {},
                success: (model, response) ->
                    self.formErrorizer.clear($('#new-author-box') )
                    self.formErrorizer.errorize($('#new-author-box'), response);

                    if(response.success)

                        self.model.id = response.success.id
                        self.setTitle 'author.edit'
                        # update url
                        self.options.dispatcher.trigger "url:change", "#author/" + self.model.id
                        console.log self.model.isNew()
                        if(isNew)
                            console.log "RAI RSI: " + JSON.stringify(response)
                            self.options.collection.add self.model
                            self.options.dispatcher.trigger "author:add", self.model

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

