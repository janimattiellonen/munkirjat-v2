$ ->
    "use strict"

    App.ReadingSessionView = Backbone.View.extend(

        el:         '#section-readingsession'
        loaded:   false

        initialize: (options) ->
            console.log "ReadingSessionView initialized..."
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)
            @template = _.template $('#tpl-readingsession').html()

        render: () ->
            @$el.html @template()

        show: () ->
            @$el.show()

            @render()

        hide: () ->
            @$el.hide()
    )

