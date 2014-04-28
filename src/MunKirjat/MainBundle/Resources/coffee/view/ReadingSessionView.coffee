$ ->
    "use strict"

    App.ReadingSessionView = Backbone.View.extend(

        el:       '#section-readingsession'
        loaded:   false
        events:
            'click #new-session': 'newSession',
            'click #stop-reading': 'stopReading'
            'click #end-session': 'endSession'


        initialize: (options) ->
            console.log "ReadingSessionView initialized..."
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)
            @template = _.template $('#tpl-readingsession').html()

        render: () ->
            @$el.html @template(
                title: @model.get "title"
                authors: @model.get "authors"
                hasOpenSession: @model.get "hasOpenSession"
                startingDate: @model.get "startingDate"
                startingTime: @model.get "startingTime"
                startingPage: @model.get "startingPage"
                endingDate: @model.get "endingDate"
                endingTime: @model.get "endingTime"
                endingPage: @model.get "endingPage"
            )

        show: () ->
            @$el.show()
            self = @

            @model.fetch
                success: (model, response) ->
                    self.render()

        hide: () ->
            @$el.hide()

        newSession: (e) ->
            e.preventDefault()
            self = @
            @model.save {},
                success: (model, response) ->
                    self.$el.html self.template(
                        title: model.get "title"
                        authors: model.get "authors"
                        hasOpenSession: model.get "hasOpenSession"
                        startingDate: model.get "startingDate"
                        startingTime: model.get "startingTime"
                        startingPage: model.get "startingPage"
                        endingDate: model.get "endingDate"
                        endingTime: model.get "endingTime"
                        endingPage: model.get "endingPage"
                    )

        stopReading: (e) ->
            e.preventDefault()

            $('#ending_date').val moment().format('DD.MM.YYYY')
            $('#ending_time').val moment().format('HH:mm')
            $('.end-session').show()
            $('#ending_page').focus()

        endSession: (e) ->
            e.preventDefault()

            @model.set "startingDate", $('#starting_date').val()
            @model.set "startingTime", $('#starting_time').val()
            @model.set "startingPage", $('#starting_page').val()
            @model.set "endingDate", $('#ending_date').val()
            @model.set "endingTime", $('#ending_time').val()
            @model.set "endingPage", $('#ending_page').val()

            @model.save {},
                success: (model, response) ->
                    alert "Stopped session"
    )

