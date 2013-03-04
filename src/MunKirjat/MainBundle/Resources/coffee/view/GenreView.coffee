$ ->
    "use strict"

    App.GenreView = Backbone.View.extend(

        el:         '#section-new-genre'
        loaded:     false
        csrf:       ""
        formErrorizer: null
        events:
            'click #_submit': 'save'

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @formErrorizer = new App.FormErrorizer.Custom()
            @template = _.template $('#tpl-new-genre').html()

        render: () ->
            self = @
            $.ajax(
                url: Routing.getBaseUrl() + '/new-token/new-genre',
                dataType: 'json'
                success: (data) ->
                    self.csrf = data.csrf_token

                    id = self.model.get "id"

                    title = if id then 'genre.edit' else 'genre.addNew'

                    self.$el.html self.template(
                        title:      title
                        csrf_token: data.csrf_token
                        name:  self.model.get("name")
                    )
                    self.loaded = true
            )

        save: () ->
            @model.set
                "name":    $('#name', @$el).val()
                "_token":       @csrf

            self = @
            @model.save {
                _token: @csrf
                name: $('#name', @$el).val()
            },
                success: (model, response) ->
                    self.formErrorizer.clear($('#new-genre-box') )
                    self.formErrorizer.errorize($('#new-genre-box'), response);

                    if(response.success)
                        alert "OK"

        show: (id) ->
            @$el.show()

            @render()

        hide: () ->
            @$el.hide()
    )

