
app.TestRouter = Backbone.Router.extend(
    routes:
        "help":             "help"
        "search/:query":    "search"


    help: () ->
        model = new app.TestModel(
            name: "Janimatti Ellonen"
            age: 32
        )

        view = new app.TestView(model: model)
        view.render()

    search: (query) ->

        model = new app.TestModel(
            name: query
            age: 32
        )

        view = new app.TestView(model: model)
        view.render()

)