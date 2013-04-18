App.Translate =

    translate: (str, placeholder, count) ->

        placeholder = placeholder || {}

        if not Translator.has str
            str
        else if count
            Translator.get str, placeholder, count
        else
            Translator.get str, placeholder


String::t = (placeholder, count) ->
    App.Translate.translate @toString(), placeholder, count

class App.FormErrorizer.Custom extends App.AbstractErrorizer
    constructor: (@errorizeClass = 'errorized', @messageClass = 'error', @errorGroupClass = 'error-group') ->
        @formErrorPosition = 'top'
        @formErrorFadeOutTime = null

    # Errorizes a form
    errorize: ($form, response) ->
        if response.failure && response.failure.formErrors
            formName = getFormName response.failure.formErrors

            # General errors
            if response.failure.formErrors[formName].errors
                @displayFormErrors $form, response.failure.formErrors[formName].errors

            # Child (= input) specific errors
            if response.failure.formErrors[formName].childErrors
                @_errorizeChildren $form, response.failure.formErrors[formName].childErrors, formName
            true
        else
            false

    # Clears form of errors
    clear: ($form) ->
        $form.find(".#{@errorizeClass}")
            .removeClass(".#{@errorizeClass}")
            .filter(".#{@messageClass}")
            .remove();

    # Display general form errors.
    displayFormErrors: ($form, messages) ->
        $(messages).each (i, message) =>
            element = @getErrorElement()

            if @formErrorPosition is 'bottom'
                $form.append element.text(message)
            else
                $form.prepend element.text(message)

            if (@formErrorFadeOutTime > 0)
                element.delay(@formErrorFadeOutTime).fadeOut();

    # Display an error next to a field.
    displayFieldError: (fieldId, errors) ->

        $field = $('[name^="' + fieldId + '"]').first()
        # grouped errors
        if $field.closest(".#{@errorGroupClass}").length
            $field = $field.closest(".#{@errorGroupClass}")
            $field.addClass @errorizeClass
            $.each errors, (i, message) =>
                $field.after @getWrappedError(message)

        else
            $field.addClass @errorizeClass
            $.each errors, (i, message) =>
                $field.after @getErrorElement().text message

    # Form may need some extra elements as wrapper...
    getWrappedError: (message) ->
        @getErrorElement().text message


    # Get error element for display.
    getErrorElement: ->
        $('<div/>', {'class': "#{@errorizeClass} #{@messageClass}"})

    # set form error position
    # 'top' OR 'bottom'
    setFormErrorPosition: (@formErrorPosition) ->

        # set form error fade out time
        # 'null OR amount in milliseconds
    setFormErrorFadeOutTime: (@formErrorFadeOutTime) ->

        # Errorizes children recursively.
    _errorizeChildren: ($form, childErrors, path) ->

        $(childErrors).each (i, child) =>
            $.each child, (inputId, errors) =>
                if  errors.errors
                    if typeof inputId =='string'
                        @displayFieldError(resolvePath(path, inputId), errors.errors)
                        @displayFormErrors $form, errors.errors

                if errors.childErrors
                    @_errorizeChildren $form, errors.childErrors, resolvePath(path, inputId)

                if $.isArray errors
                    @displayFieldError(resolvePath(path, inputId), errors)

    # Gets form name by extracting the key of given object.
    # For example { "my_form": { "errors": [...] } } returns "my_form".
    getFormName = (form) ->
        for k of form
            key = k

        key

    resolvePath = (path, inputId) ->
        if(path == 'defaultForm')
            return inputId

        path + '[' + inputId + ']'


$(document).ready ->
    localizedErrorizer = new App.FatalErrorizer.Default()

    # Ajax forms
    if $.fn.ajaxForm
        App.AjaxForm.Instance = new App.AjaxForm.Default '.ajax-form' , null, [new App.FormErrorizer.Custom(), localizedErrorizer]

    $(document).ajaxStart(() ->
        $('body').append $('<div></div>').addClass("ajax-loader")
    )

    $(document).ajaxStop(() ->
        $('.ajax-loader').remove()
    )