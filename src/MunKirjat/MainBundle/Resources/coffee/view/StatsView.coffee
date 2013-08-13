$ ->
    "use strict"

    App.StatsView = Backbone.View.extend(

        el:         '#section-stats'

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @statsTemplate = _.template $('#tpl-stats').html()

        show: () ->
            @render()
            @$el.show()

        hide: () ->
            @$el.hide()

        render: () ->
            self = @
            $.ajax(
                url: Routing.generate('munkirjat_statistics_charts')
                success: (data) ->
                    console.log JSON.stringify(data)
                    self.$el.html self.statsTemplate()
            )
    )