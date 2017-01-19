/* global UrlWorker */

var Pages = {

	HandlePageUrlLinkClick: function (link) {
		var page = $(link).attr('page');
		var order = $(link).attr('order');

		UrlWorker.AssignNewUrl(['page', 'order', 'id'], [page, order, '1']);		
	},

	SetActivePageFromUrl: function () {
		var activePage = UrlWorker.urlParams.page.current;

		$('.page-url-link').removeClass('active');
		$('.page-link[page=' + activePage + ']').addClass('active');
	}

};

$(function () {
	// Handle page url links click
	$('.page-url-link').click(function () {
		Pages.HandlePageUrlLinkClick(this);
	});

	// Handle active page on load and url change
	Pages.SetActivePageFromUrl();
	$(window).on('hashchange', function () {
		Pages.SetActivePageFromUrl();
	});
});