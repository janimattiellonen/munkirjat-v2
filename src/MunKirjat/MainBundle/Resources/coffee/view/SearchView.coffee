$ ->
    "use strict"

    App.SearchView = Backbone.View.extend(

        el:         '#section-search'

        events:
            'click #_submit': 'search'

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)

            @searchTemplate = _.template $('#tpl-search').html()
            @searchResultsTemplate = _.template $('#tpl-search-results').html()

        show: () ->
            @render()
            @$el.show()

        hide: () ->
            @$el.hide()

        render: () ->
            $('#search-box', @$el).html @searchTemplate()

            $('#search-results-box', @$el).html @searchResultsTemplate(authors: [], books: [])

            $('#languages').buttonset()

        search: () ->

            self = @

            languages = []

            $('#languages input[type=checkbox]:checked').each () ->
                languages.push $(this).val()

            $.ajax(
                url: Routing.generate('munkirjat_search')
                #data: 'term=' + $('#searchvalue', @el).val()
                data:
                    term: $('#searchvalue', @el).val()
                    languages: languages
                success: (data) ->
                    $('#search-results-box', self.$el).html self.searchResultsTemplate(authors: data.authors, books: data.books)
                    $('#search-results-box', self.$el).show()
            )

            return false

    )