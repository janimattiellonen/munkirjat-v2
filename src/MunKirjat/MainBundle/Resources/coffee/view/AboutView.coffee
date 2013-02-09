$ ->
    "use strict"

    app.AboutView = Backbone.View.extend(

        el:         '#about'
        rendered:   false

        initialize: (options) ->

            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

        render: () ->
            if !@rendered
                self = @
                $.get @options.url, (data) ->
                    self.$el.html data
                    @rendered = true

        show: () ->
            @$el.show()

            @render()

        hide: () ->

            @$el.hide()


    )


