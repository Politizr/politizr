$(function() {
	// sticky timeline dates for browser
	$('body.css .timelineDayContainer, body.css960 .timelineDayContainer').stickyHeader({stickyClass : 'timelineDay'});
	// sticky timeline dates for mobile
	$('body.css760 .timelineDayContainer').stickyHeaderMobile({stickyClass : 'timelineDay'});
});