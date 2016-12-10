/* global CmsCommon, UrlWorker */

$(function () {
	$(window).on('contentloaded', function () {
		$('.delete-entry-btn').click(function () {
			var data = "table=" + $(this).attr('table') + '&id=' + $(this).attr('entry-id');
			var returnToPage = $(this).attr('return-to-page');
			
			$.ajax({
				type: "POST",
				url: "/manager/php/contentDeleter/deleter.php",
				data: data,
				success: function (msg) {
					if (msg === '1') {
						UrlWorker.AssignNewUrl(['page'], [returnToPage]);
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