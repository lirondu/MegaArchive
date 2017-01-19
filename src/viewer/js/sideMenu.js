/* global UrlWorker */

var SideMenu = {

	SetActiveLinksFromUrl: function () {
		// Language
		var currLang = UrlWorker.urlParams.lang.current;
		$('.lang-link').removeClass('active');
		$('.lang-link[url-value=' + currLang + ']').addClass('active');

		// View
		var currView = UrlWorker.urlParams.view.current;
		$('.view-link').removeClass('active');
		$('.view-link[url-value=' + currView + ']').addClass('active');

		// Order
		var currOrder = UrlWorker.urlParams.order.current;
		$('.order-link').removeClass('active');
		$('.order-link[url-value=' + currOrder + ']').addClass('active');
	},

	HandleMenuLinkClick: function (link) {
		var name = $(link).attr('url-name');
		var value = $(link).attr('url-value');

		UrlWorker.AssignNewUrl([name], [value]);
	},

	RegisterMenuLinkHandler: function () {
		$('.menu-link').click(function () {
			SideMenu.HandleMenuLinkClick(this);
			SideMenu.CloseSideMenu();
		});
	},

	HandleViewSwitch: function () {
		$('#page_container').stop().fadeOut(250, function () {
			if (UrlWorker.urlParams.view.current === '1') {
				// text
				$('.thumb-entry-container').addClass('text-entry-container')
					.removeClass('thumb-entry-container');
				$('.thumb-list-link').addClass('text-list-link')
					.removeClass('thumb-list-link');
			} if (UrlWorker.urlParams.view.current === '2') {
				// thumb
				$('.text-entry-container').addClass('thumb-entry-container')
					.removeClass('text-entry-container');
				$('.text-list-link').addClass('thumb-list-link')
					.removeClass('text-list-link');
			}

			$('#page_container').stop().fadeIn(250);
		});
	},

	CloseSideMenu: function () {
		$('#burger_btn').removeAttr('checked');
	},

	LoadOrderBy: function () { //TODO
		if (parseInt(UrlWorker.urlParams.page.current) > 7) {
			$('.nav-item.order-by').hide();
			$('.order-by-container').hide();
			return;
		}

		var self = this;
		var source = '/common/orderByLoader/orderByLoader.php';
		var pageName = UrlWorker.pageIdToName[UrlWorker.urlParams.page.current];
		var data = 'page-name=' + pageName;

		$('.order-page-name').html(pageName);

		$('.order-by-container').stop().fadeOut(250, function () {
			$(this).load(source, data, function (response, status, xhr) {
				if (xhr.status !== 200) {
					$('.order-by-container').html('Error loading content!!');
				}

				$(this).stop().fadeIn(250);
				$('.nav-item.order-by').show(300);

				self.RegisterMenuLinkHandler();
				self.SetActiveLinksFromUrl();
			});
		});
	}
};



$(function () {
	// Set active links on load and content load
	SideMenu.SetActiveLinksFromUrl();
	$(window).on('hashchange', function () {
		SideMenu.SetActiveLinksFromUrl();
	});

	// Change view on 'changeview' event
	$(window).on('changeview', function () {
		SideMenu.HandleViewSwitch();
	});

	// Register menu link click handler on load
	SideMenu.RegisterMenuLinkHandler();

	// Close menu if clicking outside the menu
	$('#site_container').click(function () {
		SideMenu.CloseSideMenu();
	});

	// Load order-by on load and loadcontent event
	SideMenu.LoadOrderBy();
	$(window).on('loadcontent', function () {
		SideMenu.LoadOrderBy();
	});
});