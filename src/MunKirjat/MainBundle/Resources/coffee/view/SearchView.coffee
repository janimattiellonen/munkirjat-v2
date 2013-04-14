$ ->
    "use strict"

    App.SearchView = Backbone.View.extend(

        el:         '#section-search'

        events:
            'click #_submit': 'search'

        initialize: (options) ->
            @searchTemplate = _.template $('#tpl-search').html()
            @searchResultsTemplate = _.template $('#tpl-search-results').html()

            #alert  _.template $('#tpl-search').html()

        show: () ->
            @render()

        render: () ->
            $('#search-box', @$el).html @searchTemplate()

            $('#search-results-box', @$el).html @searchResultsTemplate(authors: [], books: [])

            $('#searchvalue', @el).autocomplete(
            )

        search: () ->

            self = @
            $.ajax(
                url: Routing.generate('munkirjat_search')
                data: 'term=' + $('#searchvalue', @el).val()
                success: (data) ->
                    $('#search-results-box', self.$el).html self.searchResultsTemplate(authors: data.authors, books: data.books)
            )

            return false

    )