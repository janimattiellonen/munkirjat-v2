$ ->
    "use strict"

    App.SearchView = Backbone.View.extend(

        el:         '#section-search'

        events:
            'click #_submit': 'search'

        initialize: (options) ->
            @template = _.template $('#tpl-search').html()

            #alert  _.template $('#tpl-search').html()

        show: () ->
            @render()

        render: () ->
            @$el.html @template()


            $('#searchvalue'', @el).autocomplete(
                source: Route.generate()

            )

        search: () ->
            alert "searching..."
            return false

    )