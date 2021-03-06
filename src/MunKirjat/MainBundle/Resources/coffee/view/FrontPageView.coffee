$ ->
    "use strict"

    App.FrontPageView = Backbone.View.extend(

        el: '#section-frontpage'

        initialize: (options) ->
            @loaded = false
            _.bindAll @, 'hide'
            options.dispatcher.on("container:hide", @hide)

        render: () ->

            if @loaded == false
                template = _.template $('#stats-template').html()

                self = @
                $.ajax(
                    url: Routing.getBaseUrl() + '/statistics',
                    dataType: 'json'
                    success: (data) =>
                        self.$el.html template(data)
                        self.loaded = true
                )

        show: () ->
            @$el.show()
            @render()

        hide: () ->
            @$el.hide()

    )
