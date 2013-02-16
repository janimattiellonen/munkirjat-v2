$ ->
    "use strict"

    app.Menu = Backbone.View.extend(

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
        buildMenu: () ->
            frontPage   = new app.MenuItem(dispatcher: @dispatcher, id: "primary-menu-frontpage", url: Routing.getBaseUrl() + '/#frontpage', parent: @$el)
            about       = new app.MenuItem(dispatcher: @dispatcher, id: "primary-menu-about", url: Routing.getBaseUrl() + '/#about', parent: @$el)

            @addMenuItem frontPage
            @addMenuItem about

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