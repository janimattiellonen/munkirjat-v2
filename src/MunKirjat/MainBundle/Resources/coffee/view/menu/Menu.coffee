$ ->
    "use strict"

    App.Menu = Backbone.View.extend(

        initialize: (options) ->
            @$el            = options.el
            #@router        = options.router
            @dispatcher    = options.dispatcher
            @menuItems      = []

            _.bindAll this, 'deselectAllMenuItems'
            @dispatcher.on "menu:selected", @deselectAllMenuItems

        addMenuItem: (menuItem) ->
            @menuItems.push menuItem

        # convenience method for bootstrapping the menu right away
        buildMenu: (loggedIn, menuItems) ->

            frontPage   = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-frontpage", url: Routing.getBaseUrl() + menuItems['frontpage'], parent: @$el)
            about       = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-about", url: Routing.getBaseUrl() + menuItems['about'], parent: @$el)

            @addMenuItem frontPage
            @addMenuItem about

            if loggedIn
                logout      = new App.MenuItem(dispatcher: @dispatcher, id: "primary-menu-logout", url: Routing.getBaseUrl() + menuItems['logout'], parent: @$el)
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