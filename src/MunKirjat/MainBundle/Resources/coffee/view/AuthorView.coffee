$ ->
    "use strict"

    App.AuthorView = Backbone.View.extend(

        el:         '#section-new-author'
        loaded:   false

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

        render: () ->
            if !@loaded
                template = _.template $('#tpl-new-author').html()

                self = @
                $.ajax(
                    url: Routing.getBaseUrl() + '/new-token/new-author',
                    dataType: 'json'
                    success: (data) =>
                        self.$el.html template(csrf_token: data.csrf_token)
                        self.loaded = true
                )

        show: () ->
            @$el.show()

            @render()

        hide: () ->

            @$el.hide()
    )

