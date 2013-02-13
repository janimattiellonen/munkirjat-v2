$ ->
    "use strict"

    app.MenuItem = Backbone.View.extend(

        initialize: (options) ->
            @id         = options.id
            @url        = options.url
            @$parent    = options.parent
            @el        = null

        getId: () ->
            return @id

        select: () ->
            $('#' + @id).addClass "selected"

        deselect: () ->
            $('#' + @id).removeClass "selected"

        render: () ->
            template = _.template('<li id="<%= id %>"><a href="<%= url %>"></a></li>')

            @el = template(id: @id, url: @url)

            @$parent.find('ul').append @el
    )