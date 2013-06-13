class App.Notifier

    @information: (message) ->
        @createMessage message, 'information'

    @success: (message) ->
        @createMessage message, 'success'

    @alert: (message) ->
        @createMessage message, 'alert'

    @error: (message) ->
        @createMessage message, 'error'

    @warning: (message) ->
        @createMessage message, 'warning'

    @notification: (message) ->
        @createMessage message, 'notification'

    @createMessage: (message, type) ->
        noty(
                text: message,
                type: type,
                timeout: 1000,
                dismissQueue: true,
                layout: 'center',
                theme: 'defaultTheme'
            )