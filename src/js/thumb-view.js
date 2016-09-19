/* global UrlWorker */

var ThumbView = {
	captionInitialBottom: null,
	currentView: null,

	RegisterLinksHoverAction: function () {
		var self = this;

		$('.thumb-entry-container a').hover(function () {
			$(this).find('.entry-info').stop().animate({ bottom: 0 });
		}, function () {
			$(this).find('.entry-info').animate({ bottom: self.captionInitialBottom });
		});
	},

	HandleEntryInfoInitialPosition: function () {
		this.captionInitialBottom = 0 - $('.entry-info').first().height() + 20;
		
		$('.entry-info').css('bottom', this.captionInitialBottom);
	},

	HandleViewSwitch: function (clickedLink) {
		if (clickedLink.attr('value') === UrlWorker.urlParams.view.current) { return; }

		var self = this;

		$('#page_container').stop().fadeOut(250, function () {
			if (clickedLink.attr('value') === '1') {
				// text
				$('.thumb-entry-container').addClass('text-entry-container')
					.removeClass('thumb-entry-container');
				$('.thumb-list-link').addClass('text-list-link')
					.removeClass('thumb-list-link');
			} else {
				// thumb
				$('.text-entry-container').addClass('thumb-entry-container')
					.removeClass('text-entry-container');
				$('.text-list-link').addClass('thumb-list-link')
					.removeClass('text-list-link');
				
				self.RegisterLinksHoverAction();
			}
			
			$('#page_container').stop().fadeIn(250);
		});
	}
};


$(function () {
	$('.view-link').click(function () {
		ThumbView.HandleViewSwitch($(this));
	});
});