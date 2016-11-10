/* global UrlWorker */

$(function () {
	// Add admin message to the top of the page
	$('body').prepend($(
		'<div class="manager-alert alert alert-danger">' +
		'Pay attention!! You are in manager mode!!' +
		'<a class="log-out btn btn-danger btn-xs" href="/manager/login/logout.php">' +
		'Log Out' +
		'</a > ' +
		'</div >'
	));


	// Add 'Manage' button to each menu item
	$('.page-link-container .page-link').each(function () {
		var page = parseInt($(this).attr('page')) + 14;
		var button = $('<li><button page="' + page + '" class="manage-table-btn btn btn-sm btn-primary">Manage</button></li>');

		$(this).siblings('ul').prepend(button);
	});


	// Register 'Manage' button action	
	$('.manage-table-btn').click(function () {
		var page = $(this).attr('page');
		// var id = $(this).attr('entry-id');

		UrlWorker.AssignNewUrl(['page'], [page]);
	});


	// Change main site-link target to /manager
	$('.title-container a').attr('href', '/manager');
});