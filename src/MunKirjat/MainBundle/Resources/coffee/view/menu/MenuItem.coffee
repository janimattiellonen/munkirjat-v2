$ ->
    "use strict"

    App.MenuItem = Backbone.View.extend(

        initialize: (options) ->
            @id         = options.id
            @title      = options.title
            @url        = options.url
            @$parent    = options.parent
            @el         = null
            @dispatcher = options.dispatcher
            @clz        = if options.clz then options.clz else ""

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
            $('#' + @id).addClass "selected white"

        deselect: () ->
            $('#' + @id).removeClass "selected white"

        render: () ->

            $(document).on "mouseover", "#" + @id, () ->
                $(this).addClass("white")

            $(document).on "mouseout", "#" + @id, () ->
                $(this).removeClass("white")

            template = _.template('<a href="<%= url %>"><i class="<%= clz %>" id="<%= id %>"></i><span><%= title %></span></a>')

            @el = template(id: @id, title: @title, url: @url, clz: @clz)

            @$parent.find('ul').append @el
    )