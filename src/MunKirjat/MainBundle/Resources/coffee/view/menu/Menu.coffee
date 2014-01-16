$ ->
    "use strict"

    App.Menu = Backbone.View.extend(

        initialize: (options) ->
            @$el            = options.el
            @dispatcher     = options.dispatcher
            @menuItems      = []

            _.bindAll this, 'deselectAllMenuItems'
            @dispatcher.on "menu:selected", @deselectAllMenuItems

        addMenuItem: (menuItem) ->
            @menuItems.push menuItem

        # convenience method for bootstrapping the menu right away
        buildMenu: (loggedIn, menuItems) ->

            frontPage   = new App.MenuItem(title: Translator.get("menu.home"), dispatcher: @dispatcher, clz: "home", id: "primary-menu-frontpage", url: Routing.getBaseUrl() + menuItems['frontpage'], parent: @$el)
            about       = new App.MenuItem(title: Translator.get("menu.about"), dispatcher: @dispatcher, clz: "circle_info", id: "primary-menu-about", url: Routing.getBaseUrl() + menuItems['about'], parent: @$el)
            books       = new App.MenuItem(title: Translator.get("menu.books"), dispatcher: @dispatcher, clz: "list", id: "primary-menu-books", url: Routing.getBaseUrl() + menuItems['list-books'], parent: @$el)

            authors     = new App.MenuItem(title: Translator.get("menu.authors"), dispatcher: @dispatcher, clz: "parents", id: "primary-menu-list-authors", url: Routing.getBaseUrl() + menuItems['list-authors'], parent: @$el)
            genres      = new App.MenuItem(title: Translator.get("menu.genres"), dispatcher: @dispatcher, clz: "tags", id: "primary-menu-list-genres", url: Routing.getBaseUrl() + menuItems['list-genres'], parent: @$el)
            search      = new App.MenuItem(title: Translator.get("menu.search"), dispatcher: @dispatcher, clz: "search", id: "primary-menu-search", url: Routing.getBaseUrl() + menuItems['search'], parent: @$el)
            stats       = new App.MenuItem(title: Translator.get("menu.stats"), dispatcher: @dispatcher, clz: "charts", id: "primary-menu-stats", url: Routing.getBaseUrl() + menuItems['stats'], parent: @$el)

            @addMenuItem frontPage
            @addMenuItem about
            @addMenuItem books
            @addMenuItem authors
            @addMenuItem genres
            @addMenuItem search
            @addMenuItem stats

            if loggedIn
                newAuthor   = new App.MenuItem(title: Translator.get("menu.new-author"), dispatcher: @dispatcher, clz: "user_add", id: "primary-menu-new-author", url: Routing.getBaseUrl() + menuItems['add-new-author'], parent: @$el)
                newBook     = new App.MenuItem(title: Translator.get("menu.new-book"), dispatcher: @dispatcher, clz: "circle_plus", id: "primary-menu-new-book", url: Routing.getBaseUrl() + menuItems['add-new-book'], parent: @$el)
                logout      = new App.MenuItem(title: Translator.get("menu.logout"), dispatcher: @dispatcher, clz: "eye_close", id: "primary-menu-logout", url: Routing.getBaseUrl() + menuItems['logout'], parent: @$el)

                @addMenuItem newAuthor
                @addMenuItem newBook
                @addMenuItem logout
            else
                login       = new App.MenuItem(title: Translator.get("menu.login"), dispatcher: @dispatcher, clz: "eye_open", id: "primary-menu-login", url: Routing.getBaseUrl() + menuItems['login'], parent: @$el)
                @addMenuItem login

        setSelectedMenuItem: (id) ->
            @deselectAllMenuItems()

            for menuItem in @menuItems
                if menuItem.getId() == id
                    menuItem.select()
                    break

        deselectAllMenuItems: () ->
            _.each @menuItems, (menuItem) ->
                menuItem.deselect()

        render: () ->
            @$el.show()
    )