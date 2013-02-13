$ ->
    "use strict"

    app.Menu = Backbone.View.extend(

        initialize: (options) ->
            @$el            = options.el
            #@router        = options.router
            #@dispatcher    = options.dispatcher
            @menuItems      = []

        addMenuItem: (menuItem) ->
            @menuItems.push menuItem

        # convenience method for bootstrapping the menu right away
        buildMenu: () ->
            frontPage   = new app.MenuItem(id: "primary-menu-frontpage", url: Routing.getBaseUrl() + '/#frontpage', parent: @$el)
            about       = new app.MenuItem(id: "primary-menu-about", url: Routing.getBaseUrl() + '/#about', parent: @$el)

            @addMenuItem frontPage
            @addMenuItem about

        setSelectedMenuItem: () ->

        deselectAllMenuItems: () ->

        render: () ->
            for menuItem in @menuItems
                do (menuItem) ->
                    menuItem.render()

            @$el.show()
    )