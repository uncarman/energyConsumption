$(function () {
	var pageName = location.pathname.split("/").pop().split(".")[0];
	$("."+pageName).addClass("active");
	$("."+pageName).parent().parent().addClass("active");
});