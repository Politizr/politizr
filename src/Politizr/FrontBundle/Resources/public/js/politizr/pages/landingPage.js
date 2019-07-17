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
    gtag_report_conversion();

    var form = $(this).closest('form');
    var localLoader = $(this).closest('.formBlock').find('.ajaxLoader').first();

    return sendDirectMessage(form, localLoader);
});
