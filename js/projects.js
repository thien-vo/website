var arr_length = [];
$(document).ready( function () {
	$(".news-one-wthree-agile").each(function(i, obj) {
		var newsRight = $(obj).find(".news-right");
		var height2 = $(newsRight).outerHeight();
		arr_length[i] = height2;
	});
	res_news_right();
});
function res_news_right () {
	// alert ("calling resize");
	if ($(window).width() >= 992) {
		$(".news-one-wthree-agile").each(function(i, obj) {
			var img = $(obj).find(".lightbox img");
			var newsRight = $(obj).find(".news-right");
			var height = $(img).height();
			var height2 = $(newsRight).outerHeight();
			
			$(newsRight).outerHeight(height);

		});
	} else {
		$(".news-one-wthree-agile").each(function(i, obj) {
			var newsRight = $(obj).find(".news-right");
			var height2 = $(newsRight).outerHeight();
			var pright = $(obj).find(".para-w3-agile");
			var h = $(pright).height();
			// alert (arr_length[i]);
			$(newsRight).outerHeight(arr_length[i]);
			$(newsRight).height(h+20);
		});
	}
}

// $(document).ready(res_news_right());
// $(window).after("resize", res_news_right);
var resizeTimer;

$(window).on('resize', function(e) {

  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {

    res_news_right();

  }, 250);

});
