class App.Container

    addContainer: (container) ->


    showContainer: (container) ->

        dispatcher = _.clone(Backbone.Events)

        dispathcer.trigger "container:hide"