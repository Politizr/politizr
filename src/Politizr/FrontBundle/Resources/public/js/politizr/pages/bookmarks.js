// beta
$(function() {
    myBookmarksByUserListing();

    $.when(
        typeTagListing(
            $('.sidebarTypeTags').find('.tagList').first(),
            $('.sidebarTypeTags').find('.ajaxLoader').first()
        ),
        topTagListing(
            $('.sidebarTopTags').find('.tagList').first(),
            $('.sidebarTopTags').find('.ajaxLoader').first()
        ),
        userTagListing(
            $('.sidebarFollowedTags').find('.tagList').first(),
            $('.sidebarFollowedTags').find('.ajaxLoader').first()
        ),
        topDocumentListing(
            $('.sidebarTopPosts').find('.documentList').first(),
            $('.sidebarTopPosts').find('.ajaxLoader').first()
        )
    ).done(function(r1, r2, r3, r4) {
        stickySidebar();
    });
});
