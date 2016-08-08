// beta

// auto resize text area
autosize($('.formBlock textarea'));

/**
 * Auto save
 * Event = keyup + 2sec
 * http://stackoverflow.com/questions/9966394/can-i-delay-the-keyup-event-for-jquery
 */

/**
 *
 */
function dataRequest() {
    return triggerSaveDocument();
}

$('#debate_title, #reaction_title, #debate_copyright, #reaction_copyright, .editable.description').on('keyup', delayRequest);

/**
 *
 */
function delayRequest(ev) {
    // console.log('*** autoSaveDelay');
    $('.actionSave').removeClass('saved');

    if(delayRequest.timeout) {
        clearTimeout(delayRequest.timeout);
    }
    var target = this;
    delayRequest.timeout = setTimeout(function() {
        dataRequest.call(target, ev);
    }, 5000); // 5s
}

/**
 * Auto save
 * Event = mouseup
 */
$('.editable.description').on('dblclick', function() {
    // console.log('dblclick event');
    $('.actionSave').removeClass('saved');
    // delayRequest(this);
});

$('.editable.description').on('mouseup', function() {
    // console.log('mouseup event');
    $('.actionSave').removeClass('saved');
    // delayRequest(this);
});


function triggerSaveDocument()
{
    // console.log('*** triggerSaveDocument');

    var documentSave = $('.actionSave').find('a').attr('action');
    return $('[action="'+documentSave+'"]').trigger('click');
}


/**
 *
 */
 function deleteDocumentPhoto(uuid, type)
 {
     console.log('*** deleteDocumentPhoto');
     console.log(uuid);
     console.log(type);

    var localLoader = $('.actionSave').find('.ajaxLoader').first();

    var xhrPath = getXhrPath(
        ROUTE_DOCUMENT_PHOTO_DELETE,
        'document',
        'documentPhotoDelete',
        RETURN_BOOLEAN
    );

    return xhrCall(
        document,
        {'uuid': uuid, 'type': type},
        xhrPath,
        localLoader
    ).done(function(data) {
        if (data['error']) {
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            // update & imgLiquid uploaded photo
            $('#uploadedPhoto').html('');
            $('.postIllustration').attr('style', '');

            $('#debate_file_name').val(null);
            $('#reaction_file_name').val(null);

            triggerSaveDocument();
        }
        localLoader.hide();
    });   
 }

/**
 *
 */
function saveDebate()
{
    // console.log('*** saveDebate');

    var description = descriptionEditor.serialize();
    // console.log(description['element-0']['value']);

    $('#debate_description').val(description['element-0']['value']);

    var localLoader = $('.actionSave').find('.ajaxLoader').first();

    var xhrPath = getXhrPath(
        ROUTE_DEBATE_UPDATE,
        'document',
        'debateUpdate',
        RETURN_BOOLEAN
        );

    return xhrCall(
        document,
        $("#formDebateUpdate").serialize(),
        xhrPath,
        localLoader
    ).done(function(data) {
        if (data['error']) {
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            $('.actionSave').addClass('saved');
        }
        localLoader.hide();
    });
}

/**
 *
 */
function saveReaction()
{
    // console.log('*** saveReaction');

    var description = descriptionEditor.serialize();
    // console.log(description['element-0']['value']);

    $('#reaction_description').val(description['element-0']['value']);

    var localLoader = $('.actionSave').find('.ajaxLoader').first();

    var xhrPath = getXhrPath(
        ROUTE_REACTION_UPDATE,
        'document',
        'reactionUpdate',
        RETURN_BOOLEAN
        );
    
    return xhrCall(
        document,
        $("#formReactionUpdate").serialize(),
        xhrPath,
        localLoader
    ).done(function(data) {
        if (data['error']) {
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            $('.actionSave').addClass('saved');
        }
        localLoader.hide();
    });
}

/**
 *
 */
function publishDebate(uuid)
{
    // console.log('*** publishDebate');
    // console.log(uuid);

    var xhrPath = getXhrPath(
        ROUTE_DEBATE_PUBLISH,
        'document',
        'debatePublish',
        RETURN_URL
        );

    return xhrCall(
        document,
        { 'uuid': uuid },
        xhrPath,
        1
    ).done(function(data) {
        if (data['error']) {
            $('#ajaxGlobalLoader').hide();
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            // redirection
            window.location = data['redirectUrl'];
        }
    });
}


/**
 *
 */
function publishReaction(uuid)
{
    // console.log('*** publishReaction');
    // console.log(uuid);

    var xhrPath = getXhrPath(
        ROUTE_REACTION_PUBLISH,
        'document',
        'reactionPublish',
        RETURN_URL
        );
    
    return xhrCall(
        document,
        { 'uuid': uuid },
        xhrPath,
        1
    ).done(function(data) {
        if (data['error']) {
            $('#ajaxGlobalLoader').hide();
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            // redirection
            window.location = data['redirectUrl'];
        }
    });
}

/**
 *
 */
function deleteDebate(uuid)
{
    // console.log('*** deleteDebate');
    // console.log(uuid);

    var xhrPath = getXhrPath(
        ROUTE_DEBATE_DELETE,
        'document',
        'debateDelete',
        RETURN_URL
        );

    return xhrCall(
        document,
        { 'uuid': uuid },
        xhrPath,
        1
    ).done(function(data) {
        if (data['error']) {
            $('#ajaxGlobalLoader').hide();
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            // redirection
            window.location = data['redirectUrl'];
        }
    });
}

/**
 *
 */
function deleteReaction(uuid)
{
    // console.log('*** deleteReaction');
    // console.log(uuid);

    var xhrPath = getXhrPath(
        ROUTE_REACTION_DELETE,
        'document',
        'reactionDelete',
        RETURN_URL
        );

    return xhrCall(
        document,
        { 'uuid': uuid },
        xhrPath,
        1
    ).done(function(data) {
        if (data['error']) {
            $('#ajaxGlobalLoader').hide();
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            // redirection
            window.location = data['redirectUrl'];
        }
    });
}

/**
 * Initialize medium insert plugin
 *
 * @param editor medium-editor instance
 */
function initMediumInsert(editor)
{
    $('.editable').mediumInsert({
        editor: editor, // (MediumEditor) Instance of MediumEditor
        enabled: true, // (boolean) If the plugin is enabled
        addons: { // (object) Addons configuration
            images: { // (object) Image addon configuration
                label: '<span class="fa fa-camera"></span>', // (string) A label for an image addon
                uploadScript: null, // DEPRECATED: Use fileUploadOptions instead
                deleteScript: 'delete.php', // (string) A relative path to a delete script
                deleteMethod: 'POST',
                fileDeleteOptions: {}, // (object) extra parameters send on the delete ajax request, see http://api.jquery.com/jquery.ajax/
                preview: true, // (boolean) Show an image before it is uploaded (only in browsers that support this feature)
                captions: true, // (boolean) Enable captions
                captionPlaceholder: 'Type caption for image (optional)', // (string) Caption placeholder
                autoGrid: 3, // (integer) Min number of images that automatically form a grid
                formData: {}, // DEPRECATED: Use fileUploadOptions instead
                fileUploadOptions: { // (object) File upload configuration. See https://github.com/blueimp/jQuery-File-Upload/wiki/Options
                    url: 'upload.php', // (string) A relative path to an upload script
                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i // (regexp) Regexp of accepted file types
                },
                styles: { // (object) Available image styles configuration
                    wide: { // (object) Image style configuration. Key is used as a class name added to an image, when the style is selected (.medium-insert-images-wide)
                        label: '<span class="fa fa-align-justify"></span>', // (string) A label for a style
                        added: function ($el) {}, // (function) Callback function called after the style was selected. A parameter $el is a current active paragraph (.medium-insert-active)
                        removed: function ($el) {} // (function) Callback function called after a different style was selected and this one was removed. A parameter $el is a current active paragraph (.medium-insert-active)
                    },
                    left: {
                        label: '<span class="fa fa-align-left"></span>'
                    },
                    right: {
                        label: '<span class="fa fa-align-right"></span>'
                    },
                    grid: {
                        label: '<span class="fa fa-th"></span>'
                    }
                },
                actions: { // (object) Actions for an optional second toolbar
                    remove: { // (object) Remove action configuration
                        label: '<span class="fa fa-times"></span>', // (string) Label for an action
                        clicked: function ($el) { // (function) Callback function called when an action is selected
                            var $event = $.Event('keydown');

                            $event.which = 8;
                            $(document).trigger($event);   
                        }
                    }
                },
                messages: {
                    acceptFileTypesError: 'This file is not in a supported format: ',
                    maxFileSizeError: 'This file is too big: '
                },
                uploadCompleted: function ($el, data) {} // (function) Callback function called when upload is completed
            },
            embeds: { // (object) Embeds addon configuration
                label: '<span class="fa fa-youtube-play"></span>', // (string) A label for an embeds addon
                placeholder: 'Paste a YouTube, Vimeo, Facebook, Twitter or Instagram link and press Enter', // (string) Placeholder displayed when entering URL to embed
                captions: true, // (boolean) Enable captions
                captionPlaceholder: 'Type caption (optional)', // (string) Caption placeholder
                oembedProxy: 'http://medium.iframe.ly/api/oembed?iframe=1', // (string/null) URL to oEmbed proxy endpoint, such as Iframely, Embedly or your own. You are welcome to use "http://medium.iframe.ly/api/oembed?iframe=1" for your dev and testing needs, courtesy of Iframely. *Null* will make the plugin use pre-defined set of embed rules without making server calls.
                styles: { // (object) Available embeds styles configuration
                    wide: { // (object) Embed style configuration. Key is used as a class name added to an embed, when the style is selected (.medium-insert-embeds-wide)
                        label: '<span class="fa fa-align-justify"></span>', // (string) A label for a style
                        added: function ($el) {}, // (function) Callback function called after the style was selected. A parameter $el is a current active paragraph (.medium-insert-active)
                        removed: function ($el) {} // (function) Callback function called after a different style was selected and this one was removed. A parameter $el is a current active paragraph (.medium-insert-active)
                    },
                    left: {
                        label: '<span class="fa fa-align-left"></span>'
                    },
                    right: {
                        label: '<span class="fa fa-align-right"></span>'
                    }
                },
                actions: { // (object) Actions for an optional second toolbar
                    remove: { // (object) Remove action configuration
                        label: '<span class="fa fa-times"></span>', // (string) Label for an action
                        clicked: function ($el) { // (function) Callback function called when an action is selected
                            var $event = $.Event('keydown');

                            $event.which = 8;
                            $(document).trigger($event);   
                        }
                    }
                }
            }
        }
    });
}