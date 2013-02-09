$ ->
    "use strict"

    app.FrontPageView = Backbone.View.extend(

        el: '#frontpage'

        initialize: (options) ->

            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

        render: () ->


        show: () ->
            @$el.show()

        hide: () ->
            @$el.hide()


    )


