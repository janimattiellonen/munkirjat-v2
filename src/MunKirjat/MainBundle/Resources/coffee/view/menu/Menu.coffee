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

            frontPage   = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-frontpage", url: Routing.getBaseUrl() + menuItems['frontpage'], parent: @$el)
            about       = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-about", url: Routing.getBaseUrl() + menuItems['about'], parent: @$el)
            authors     = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-list-authors", url: Routing.getBaseUrl() + menuItems['list-authors'], parent: @$el)
            genres      = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-list-genres", url: Routing.getBaseUrl() + menuItems['list-genres'], parent: @$el)
            search      = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-search", url: Routing.getBaseUrl() + menuItems['search'], parent: @$el)

            @addMenuItem frontPage
            @addMenuItem about
            @addMenuItem authors
            @addMenuItem genres
            @addMenuItem search

            if loggedIn
                newAuthor   = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-new-author", url: Routing.getBaseUrl() + menuItems['add-new-author'], parent: @$el)
                newGenre    = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-new-genre", url: Routing.getBaseUrl() + menuItems['add-new-genre'], parent: @$el)
                newBook     = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-new-book", url: Routing.getBaseUrl() + menuItems['add-new-book'], parent: @$el)
                logout      = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-logout", url: Routing.getBaseUrl() + menuItems['logout'], parent: @$el)

                @addMenuItem newAuthor
                @addMenuItem newGenre
                @addMenuItem newBook
                @addMenuItem logout
            else
                login       = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-login", url: Routing.getBaseUrl() + menuItems['login'], parent: @$el)
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