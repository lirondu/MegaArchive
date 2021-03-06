/* global CmsParams */

var CmsCommon = {
	globalOkMessageBox: false,
	globalErrorMessageBox: false,

	GetParameterByName: function (name, url) {
		if (!url) {
			url = location;
		}
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(url);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	},

	DbModifierAjaxPost: function (data, modData, callback) {
		if (modData === undefined) {
			return;
		}

		var tmpData = data + '&mod_data=' + modData;

		if (CmsParams.SHOW_DEBUG_MESSAGES) {
			console.log(tmpData);
		}

		$.ajax({
			type: "POST",
			url: "/manager/php/contentModifier/modifier.php",
			data: tmpData,
			success: function (msg) {
				if (callback) {
					callback(msg);
				} else {
					CmsCommon.ShowResponseMessage(msg);
				}
			},
			fail: function () {
				CmsCommon.ShowResponseMessage('0');
			},
			error: function () {
				CmsCommon.ShowResponseMessage('0');
			}
		});
	},

	DebugPrintObject: function (obj) {
		var out;
		if (typeof obj === 'string') {
			out = obj;
		} else {
			out = '';
			for (var i in obj) {
				out += i + ": " + obj[i] + "\n";
			}
		}

		console.log(out);

		var pre = document.createElement('pre');
		pre.innerHTML = out;
		document.body.appendChild(pre);
	},

	insertPreviewButton: function () {
		var replace;
		var replaceElem;

		if (CmsParams.objectToRemoveForPreviewBtn !== '') {
			replace = true;
			replaceElem = $(CmsParams.objectToRemoveForPreviewBtn);

			if (replaceElem.length === 0) {
				throw new Error('Please check "objectToRemoveForPreviewBtn" in "/admin/params/parameters.js"');
			}
		} else {
			replace = false;
			replaceElem = $('#logout_btn');
		}

		var btn = $('#preview_btn');

		replaceElem.after(btn);

		if (replace) {
			replaceElem.remove();
		}
	},

	ShowResponseMessage: function (retCode) {
		if (CmsParams.SHOW_DEBUG_MESSAGES && retCode !== '1') {
			console.log(retCode);
		}

		if (retCode === '1') {
			CmsCommon.globalOkMessageBox.stop().fadeIn('slow', function () {
				$(this).delay(1500).fadeOut('slow');
			});
		} else {
			CmsCommon.globalErrorMessageBox.stop().fadeIn('slow', function () {
				$(this).delay(4000).fadeOut('slow');
			});
		}
	},

	InsertLogoutButton: function () {
		var replace;
		var replaceElem;

		if (CmsParams.objectToRemoveForLogoutBtn !== '') {
			replace = true;
			replaceElem = $(CmsParams.objectToRemoveForLogoutBtn);
		} else {
			replace = false;
			replaceElem = $(document.body).children().first();
		}

		if (replaceElem.length === 0) {
			throw new Error('Please check "objectToRemoveForLogoutBtn" in "/admin/params/parameters.js"');
		}

		var btn = $('#logout_btn');

		replaceElem.before(btn);

		if (replace) {
			replaceElem.remove();
		}
	},

	RegisterExpirationWatcher: function () {
		setInterval(function () {
			$.ajax({
				type: "POST",
				url: "/manager/login/expire.php",
				data: 'only-check=1',
				
				success: function (msg) {
					if (msg === 'expired') {
						location.assign('login');
					}
				}
			});
		}, 3000);
	}
};

$(function () {

	CmsCommon.globalOkMessageBox = $('div#ok-message-box');
	CmsCommon.globalErrorMessageBox = $('div#error-message-box');

	CmsCommon.RegisterExpirationWatcher();

	// CmsCommon.InsertLogoutButton();
	// CmsCommon.insertPreviewButton();

	// Show/Hide sidebar on hover
	var sbInitLeftPos = $('#admin_sidebar').css('left');
	$('#admin_sidebar').hover(function () {
		$(this).stop().animate({
			left: 0
		}, 200);
	}, function () {
		$(this).stop().animate({
			left: sbInitLeftPos
		}, 200);
	});

});