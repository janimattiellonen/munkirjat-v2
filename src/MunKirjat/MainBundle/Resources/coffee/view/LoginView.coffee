$ ->
    "use strict"

    App.LoginView = Backbone.View.extend(

        el: '#section-login'

        initialize: (options) ->
            _.bindAll @, 'hide'
            options.dispatcher.on("container:hide", @hide)

        render: () ->
            template = _.template $('#tpl-login').html()
            self = @

            $.ajax(
                url: Routing.getBaseUrl() + '/new-token/authentication',
                dataType: 'json'
                success: (data) =>
                    self.$el.html template(csrf_token: data.csrf_token)
            )

        show: () ->
            @$el.show()
            @render()

        hide: () ->
            @$el.hide()

    )
