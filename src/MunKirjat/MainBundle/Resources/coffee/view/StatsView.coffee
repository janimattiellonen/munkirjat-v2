$ ->
    "use strict"

    App.StatsView = Backbone.View.extend(

        el:         '#section-stats'

        initialize: (options) ->
            _.bindAll this, 'hide'
            options.dispatcher.on("container:hide", @hide)
            @genres = []
            @statsTemplate = _.template $('#tpl-stats').html()

        show: () ->
            @render()
            @$el.show()

        hide: () ->
            @$el.hide()

        render: () ->
            self = @
            $.ajax(
                url: Routing.generate('munkirjat_statistics_charts')
                success: (data) ->
                    window.chartGenres = data.genres
                    window.chartLanguages = data.books_by_languages
                    self.$el.html self.statsTemplate()

                    google.load("maps", "2", {"callback" : self.drawChart})

            )

        drawChart: () ->
            genreArr = [
                ['Task', 'Genres']
            ]

            languageArr = [
                ['Task', 'Languages']
            ]


            i = 0
            while i < window.chartGenres.length
                genreArr.push([window.chartGenres[i].name, parseInt(window.chartGenres[i].amount)])
                i++

            genreData = google.visualization.arrayToDataTable(genreArr);

            i = 0
            while i < window.chartLanguages.length
                languageArr.push([window.chartLanguages[i].language_id, parseInt(window.chartLanguages[i].amount)])
                i++

            languageData = google.visualization.arrayToDataTable(languageArr);


            genreChart = new google.visualization.PieChart(document.getElementById('genres-charts-div'))
            genreChart.draw(genreData, {legendTextStyle: {color: 'white'}, titleTextStyle: {color: 'white'}, width: "50%", height: 350, title: 'Genres', backgroundColor: "transparent", is3D: true})

            languageChart = new google.visualization.PieChart(document.getElementById('languages-charts-div'))
            languageChart.draw(languageData, {legendTextStyle: {color: 'white'}, titleTextStyle: {color: 'white'}, width: "50%", height: 350, title: 'Languages', backgroundColor: "transparent", is3D: true})

    )