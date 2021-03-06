$ ->
    "use strict"

    App.AboutView = Backbone.View.extend(

        el:         '#section-about'
        loaded:   false

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

        render: () ->
            if !@loaded
                self = @
                $.get @options.url, (data) ->
                    self.$el.html data
                    self.loaded = true

        show: () ->
            @$el.show()

            @render()

        hide: () ->

            @$el.hide()
    )

