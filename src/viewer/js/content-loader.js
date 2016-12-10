/* global UrlWorker, ThumbView */

var ContentLoader = {
	LoadContent: function () {
		var self = this;
		var source = '/contentLoader/loader.php';
		var data = '';

		for (var param in UrlWorker.urlParams) {
			data += UrlWorker.urlParams[param]['name'] + '=' + UrlWorker.urlParams[param]['current'];
			data += '&';
		}

		data = data.substr(0, data.length - 1);

		$('#page_footer').hide();
		$('#page_container').stop().fadeOut(250, function () {
			$(this).load(source, data, function (response, status, xhr) {
				if (xhr.status !== 200) {
					$('#page_container').html('Error loading content!!');
				}

				$(this).stop().fadeIn(500);
				$('#page_footer').show();

				ThumbView.HandleEntryInfoInitialPosition();
				ThumbView.RegisterLinksHoverAction();
				self.RegisterPageListClick();

				$(window).trigger('contentloaded');

				$.ajax({
					type: "POST",
					url: "/manager/login/expire.php",
					data: ''
				});
			});
		});
	},

	RegisterPageListClick: function () {
		$('.text-list-link, .thumb-list-link, .content-loader-link').click(function () {
			var page = $(this).attr('page');
			var id = $(this).attr('entry-id');

			UrlWorker.AssignNewUrl(['page', 'id'], [page, id]);
		});
	}
};


$(function () {
	ContentLoader.LoadContent();

	$(window).on('loadcontent', function () {
		ContentLoader.LoadContent();
	});
});