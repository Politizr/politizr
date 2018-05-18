// toggle table on AriegeTHD
$('.linkHideGrpTable').hide(); 
$("body").on("click", "[action='showGrpTable']", function() {
    $('.grpTable').hide();
    $(this).parent().next('.grpTable').show();
    $('.linkShowGrpTable').show()
    $(this).hide();
    $('.linkHideGrpTable').hide();
    $(this).next('.linkHideGrpTable').show().stop();
});
$("body").on("click", "[action='hideGrpTable']", function() {
    $('.grpTable').hide();
    $(this).parent().next('.grpTable').hide();
    $(this).hide();
    $('.linkHideGrpTable').hide();
    $('.linkShowGrpTable').show().stop();
});