// beta
// paginated listing method variables
var paginatedFunctions = {};

/**
 * Timeline's next page
 */
$("body").on("click", "[action='listingNext']", function(e, waypoint) {
    // console.log('timelinePaginatedNext next');

    var key = $('#moreResults').attr('key');
    // console.log(key);

    // destroyAll to avoid infinite loading but breaks stickySidebar
    // cf. https://github.com/Politizr/Politizr/issues/353 & https://github.com/Politizr/Politizr/issues/356
    if (waypoint) {
        waypoint.destroy();
        // console.log('destroy waypoint instance');
    }
    // Waypoint.refreshAll();
    // Waypoint.destroyAll();

    paginatedFunctions[key](
        false,
        $(this).attr('offset')
    );
});

/**
 * Init a waypoint for paginate next
 */
function initPaginateNextWaypoint() {
    // console.log('initTimelinePaginateNextWaypoint');
    // console.log('create waypoint instance');

    var waypoints = $('#moreResults').waypoint({
        handler: function(direction) {
            // console.log('Hit moreResults');
            // console.log(direction);

            if (direction == 'down') {
                $("[action='listingNext']").trigger( "click", this );
            }
        },
        offset: 'bottom-in-view'
    });
}

