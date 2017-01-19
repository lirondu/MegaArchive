var SingleView = {
	
	SplitLongTextToReadMore: function () {	
		var regex = /([\s\S]*?)(<br>\s*<br>)([\s\S]*)/;
		var res;

		$('.single-content-main-article').each(function () {
			var readMoreElement = $(this).siblings('.single-content-readmore');

			res = regex.exec($(this).html());
			if (res) {
				$(this).html(res[1]);
				readMoreElement.html(res[2] + res[3]);
			} else {
				$('.single-content-readmore-link').hide(0);
			}
		});
	},

	RegisterReadmoreHandler: function () {
		$('.single-content-readmore-link').click(function () {
			if ($(this).attr('is-open') === 'false') {
				$('.single-content-readmore').slideDown(250);
				$(this).html('less...');
				$(this).attr('is-open', 'true');
			} else {
				$('.single-content-readmore').slideUp(250);
				$(this).html('read more...');
				$(this).attr('is-open', 'false');
			}
		});
	}
};


$(function () {
	$(window).on('contentloaded', function () {
		SingleView.SplitLongTextToReadMore();
		SingleView.RegisterReadmoreHandler();
	});
});