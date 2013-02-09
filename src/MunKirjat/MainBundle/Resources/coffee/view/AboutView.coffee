$ ->
    "use strict"

    app.AboutView = Backbone.View.extend(

        el: '#about'

        initialize: (options) ->

            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

        render: () ->

        show: () ->

            @$el.show()

        hide: () ->

            @$el.hide()


    )


