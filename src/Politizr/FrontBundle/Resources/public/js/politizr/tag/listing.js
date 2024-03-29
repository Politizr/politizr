// beta

/**
 * Loading of top "tag" listing.
 * @param targetElement
 * @param localLoader
 */
function topTagListing(targetElement, localLoader) {
    // console.log('*** topTagListing');
    // console.log(targetElement);
    // console.log(localLoader);
    
    // Tag form filter
    var datas = $('#tagFilter').serializeArray();
    // console.log(datas);
    if ($.isEmptyObject(datas)) {
        datas.push({name: 'tagFilterDate[]', value: 'lastMonth'});
    }
    // console.log(datas);

    var xhrPath = getXhrPath(
        ROUTE_TAG_LISTING_TOP,
        'tag',
        'topTags',
        RETURN_HTML
    );

    return xhrCall(
        document,
        datas,
        xhrPath,
        localLoader
    ).done(function(data) {
        if (data['error']) {
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            targetElement.html(data['html']);
        }
        localLoader.hide();
    });
}

/**
 * Loading of "type" tag listing.
 * @param targetElement
 * @param localLoader
 */
function typeTagListing(targetElement, localLoader) {
    // console.log('*** typeListing');
    // console.log(targetElement);
    // console.log(localLoader);
    
    var xhrPath = getXhrPath(
        ROUTE_TAG_LISTING_TYPE,
        'tag',
        'typeTags',
        RETURN_HTML
    );

    return xhrCall(
        document,
        null,
        xhrPath,
        localLoader
    ).done(function(data) {
        if (data['error']) {
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            targetElement.html(data['html']);
        }
        localLoader.hide();
    });
}

/**
 * Loading of "family" tag listing.
 * @param targetElement
 * @param localLoader
 */
function familyTagListing(targetElement, localLoader) {
    // console.log('*** familyTagListing');
    // console.log(targetElement);
    // console.log(localLoader);
    
    var xhrPath = getXhrPath(
        ROUTE_TAG_LISTING_FAMILY,
        'tag',
        'familyTags',
        RETURN_HTML
    );

    return xhrCall(
        document,
        null,
        xhrPath,
        localLoader
    ).done(function(data) {
        if (data['error']) {
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            targetElement.html(data['html']);
        }
        localLoader.hide();
    });
}

/**
 * Loading of user "tag" listing.
 * @param targetElement
 * @param localLoader
 */
function userTagListing(targetElement, localLoader) {
    // console.log('*** userTagListing');
    // console.log(targetElement);
    // console.log(localLoader);

    var uuid = targetElement.attr('uuid');
    // console.log(uuid);

    if (uuid == undefined) {
        return;
    }

    var xhrPath = getXhrPath(
        ROUTE_TAG_LISTING_USER,
        'tag',
        'userTags',
        RETURN_HTML
    );

    return xhrCall(
        document,
        {'uuid': uuid},
        xhrPath,
        localLoader
    ).done(function(data) {
        if (data['error']) {
            $('#infoBoxHolder .boxError .notifBoxText').html(data['error']);
            $('#infoBoxHolder .boxError').show();
        } else {
            targetElement.html(data['html']);
        }
        localLoader.hide();
    });
}

