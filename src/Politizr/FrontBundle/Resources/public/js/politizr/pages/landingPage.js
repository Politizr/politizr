$(function(){
    // img liquid
    $(".publicCard a.publicCardImg").imgLiquid({
        fill: true,
        horizontalAlign: "center",
        verticalAlign: "center"
    });
});

// form contact
$("body").on("click", "button[action='submitDirectMessage']", function(e) {
    // console.log('click submitDirectMessage');

    // GTM
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
        'event': 'directMessage'
    });

    var form = $(this).closest('form');
    var localLoader = $(this).closest('.formBlock').find('.ajaxLoader').first();

    return sendDirectMessage(form, localLoader);
});
