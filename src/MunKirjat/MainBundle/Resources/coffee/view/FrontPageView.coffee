$ ->
    "use strict"

    App.FrontPageView = Backbone.View.extend(

        el: '#section-frontpage'

        initialize: (options) ->
            @loaded = false
            _.bindAll @, 'hide'
            options.dispatcher.on("container:hide", @hide)

        render: () ->
            console.log "Wut"
            template = _.template $('#stats-template').html()
            console.log "twat"
            self = @
            $.ajax(
                url: Routing.getBaseUrl() + '/statistics',
                dataType: 'json'
                success: (data) =>
                    console.log "Done reading data"
                    self.$el.html template(data)
            )

        show: () ->
            @$el.show()
            @render()

        hide: () ->
            @$el.hide()

    )
