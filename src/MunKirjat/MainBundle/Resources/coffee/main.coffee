$(document).ready ->
    localizedErrorizer = new App.FatalErrorizer.Default()

    # Ajax forms
    if $.fn.ajaxForm
        App.AjaxForm.Instance = new App.AjaxForm.Default '.ajax-form' , null, [new App.FormErrorizer.Default(), localizedErrorizer]