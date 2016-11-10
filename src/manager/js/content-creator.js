/* global CmsCommon, ContentLoader */

$(function () {
	$(window).on('contentloaded', function () {
		$('.manage-new-btn').click(function () {
			var data = "table=" + $(this).attr('table');

			$.ajax({
				type: "POST",
				url: "/manager/php/content-creator/creator.php",
				data: data,
				success: function (msg) {
					if (msg === '1') {
						ContentLoader.LoadContent();
					} else {
						CmsCommon.ShowResponseMessage(msg);
					}
				},
				fail: function () {
					CmsCommon.ShowResponseMessage('0');
				}
			});
		});
	});
});