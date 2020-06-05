(function ($) {
	$(document).ready(() => {
		$(".ishat_list_wrapper").slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: true,
			dots: true,
			autoplay: true,
			autoplaySpeed: 5000,
			prevArrow: false,
			nextArrow: false,
		});
	});
})(jQuery);
