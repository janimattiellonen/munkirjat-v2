$ ->
    "use strict"

    App.MenuItem = Backbone.View.extend(

        initialize: (options) ->
            @id         = options.id
            @url        = options.url
            @$parent    = options.parent
            @el         = null
            @dispatcher = options.dispatcher

            _.bindAll this
            @dispatcher.on "url:changed", @urlChangeEvent

            @render()

        urlChangeEvent: (id) ->
            if id == @id
                @select()

        getId: () ->
            return @id

        select: () ->
            @dispatcher.trigger('menu:selected')
            $('#' + @id).addClass "selected"

        deselect: () ->
            $('#' + @id).removeClass "selected"

        render: () ->
            template = _.template('<li id="<%= id %>"><a href="<%= url %>"></a></li>')

            @el = template(id: @id, url: @url)

            @$parent.find('ul').append @el
    )