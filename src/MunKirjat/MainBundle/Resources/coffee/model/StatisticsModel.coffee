$ ->
    "use strict"

    app.StatisticsModelModel = Backbone.Model.extend(
        defaults:
            book_count: ""
            author_count: ""
            unread_book_count: ""
            read_page_count: ""
            unrated_book_count: ""
            fastest_pace: ""
            average_pace: ""
            estimated_time_to_read_all: ""
            average_rating: ""
    )