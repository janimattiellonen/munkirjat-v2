$ ->
    "use strict"

    App.AuthorListView = Backbone.View.extend(

        el:         '#section-list-authors'

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @template = _.template $('#tpl-list-authors').html()

        render: () ->
            @model.fetch()
            $('#section-list-authors').html @template()

        show: (id) ->
            @$el.show()

            @render()

        hide: () ->
            @$el.hide()
    )

