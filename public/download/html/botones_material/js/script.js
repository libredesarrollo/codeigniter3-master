$(function () {
 $('.toggle-btn').click(function(){
	$('.filter-btn').toggleClass('open');

 });
 $('.filter-btn a').click(function(){
	$('.filter-btn').removeClass('open');
 });
});
		   