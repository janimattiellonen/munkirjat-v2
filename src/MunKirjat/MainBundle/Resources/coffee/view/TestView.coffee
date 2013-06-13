$ ->
    "use strict"

    App.TestView = Backbone.View.extend(

        el: '#foo'

        render: () ->

            self = @
            $.get 'tpl', (data) ->
                template = _.template(data)
                self.$el.html template(self.model.toJSON() )

    )