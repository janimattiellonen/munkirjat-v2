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

        render: () ->
            if !@loaded
                template = _.template $('#tpl-new-author').html()

                self = @
                $.ajax(
                    url: Routing.getBaseUrl() + '/new-token/new-author',
                    dataType: 'json'
                    success: (data) =>

                        self.csrf = data.csrf_token
                        #self.model.set "author":
                        #    "_token": data.csrf_token

                        self.$el.html template(csrf_token: data.csrf_token)
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

        show: () ->
            @$el.show()

            @render()

        hide: () ->

            @$el.hide()
    )

