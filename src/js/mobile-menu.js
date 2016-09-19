/* global ScreenWidth */

var MobileMenu = {
	HandleMenuClick: function () {
		var isOpened = ($('#mobile_menu_btn').attr('is-opened') === 'true');

		if (isOpened) {
			$('#header_content').stop().animate({ left: '-100%' }, 250);
			$('#mobile_menu_btn').attr('is-opened', 'false');
			this.UnbindClickOnPageCloseMenu();
		} else {
			$('#header_content').stop().animate({ left: 0 }, 500);
			$('#mobile_menu_btn').attr('is-opened', 'true');
			this.BindClickOnPageCloseMenu();
		}
	},

	BindClickOnPageCloseMenu: function () {
		var self = this;

		$(document).mouseup(function (e) {
			var container = $("#header");

			if (!container.is(e.target) // if the target of the click isn't the container...
				&& container.has(e.target).length === 0) // ... nor a descendant of the container
			{
				self.HandleMenuClick();
			}
		});
	},

	UnbindClickOnPageCloseMenu: function () {
		$(document).off('mouseup');
	},

	HandleMenuItemClick: function () {
		if (ScreenWidth.currentLayout === 'big') { return; }

		this.HandleMenuClick();
	},

	HandleScreenLayoutChange: function () {
		var self = this;
		
		$(window).on('screenWidthLayoutChanged', function (ev, e) {
			if (e.currentLayout === 'big') {
				$('#header_content').css('display', '');
				self.UnbindClickOnPageCloseMenu();
			} else {
				$('#mobile_menu_btn').attr('is-opened', 'false');
			}
		});
	}
};


$(function () {
	MobileMenu.HandleScreenLayoutChange();

	$('#mobile_menu_btn').click(function () {
		MobileMenu.HandleMenuClick();
	});

	$('.page-link, .view-link, .lang-btn').click(function () {
		MobileMenu.HandleMenuItemClick();
	});
});