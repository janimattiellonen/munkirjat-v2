$(document.body).on "click", ".datepicker", ->
    unless $(this).hasClass("hasDatepicker")
        $(this).datepicker
            showButtonPanel:    true
            dateFormat:         "dd.mm.yy"

        $(this).datepicker "show"