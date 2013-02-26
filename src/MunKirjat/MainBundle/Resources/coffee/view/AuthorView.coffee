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

            @formErrorizer = new App.FormErrorizer.Default()
            @template = _.template $('#tpl-new-author').html()

        render: () ->
            self = @
            $.ajax(
                url: Routing.getBaseUrl() + '/new-token/new-author',
                dataType: 'json'
                success: (data) ->
                    self.csrf = data.csrf_token

                    self.$el.html self.template(
                            csrf_token: data.csrf_token
                            firstName:  self.model.get("firstName")
                            lastName:   self.model.get("lastName")
                        )
                    self.loaded = true
            )

        save: () ->

            @model.set "author":
                "firstName":    $('#firstName', @$el).val()
                "lastName":     $('#lastName', @$el).val()
                "_token":       @csrf

            self = @

            @model.save {},
                success: (model, response) ->
                    self.formErrorizer.clear($('#new-author-box') )
                    self.formErrorizer.errorize($('#new-author-box'), response);

                    if(response.success)
                        self.model.id = response.success.id

        load: (id) ->


        show: (id) ->
            @$el.show()

            if(id)
                @model.id = id
                self = @
                @model.fetch
                    success: (model, response) ->
                        self.render()
            else
                @render()


        hide: () ->

            @$el.hide()
    )

