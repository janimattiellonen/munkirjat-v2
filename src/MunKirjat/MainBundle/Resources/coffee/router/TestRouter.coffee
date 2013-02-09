
app.TestRouter = Backbone.Router.extend(
    routes:
        "frontpage":        "frontpage"
        "about":            "about"

    initialize: (options) ->
        _.extend @, Backbone.Events

        @dispatcher = _.extend({}, Backbone.Events)

        @frontPageView = new app.FrontPageView({dispatcher: @dispatcher});
        @aboutView = new app.AboutView({dispatcher: @dispatcher});

    frontpage: () ->

        @dispatcher.trigger "container:hide"

        @frontPageView.show()

    about: () ->

        @dispatcher.trigger "container:hide"

        @aboutView.show()

        #model = new app.TestModel(
        #    name: query
        #    age: 32
        #)

        #view = new app.TestView(model: model)
        #view.render()

)