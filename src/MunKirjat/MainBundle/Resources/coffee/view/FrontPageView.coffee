$ ->
    "use strict"

    app.FrontPageView = Backbone.View.extend(

        el: '#frontpage'

        initialize: (options) ->

            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

        render: () ->

            self = @
            $.get 'statistics', (data) ->
                template = _.template(data)
                self.$el.html template(self.model.toJSON() )

        show: () ->
            @$el.show()
            #@render()

        hide: () ->
            @$el.hide()

    )




