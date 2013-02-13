$ ->
    "use strict"

    app.MenuItem = Backbone.View.extend(

        initialize: (options) ->
            @id         = options.id
            @url        = options.url
            @$parent    = options.parent

        render: () ->
            template = _.template('<li id="<%= id %>"><a href="<%= url %>"></a></li>')

            @$parent.find('ul').append template(id: @id, url: @url)
    )