/* global UrlWorker, ScreenWidth */

var PageHeader = {
	SetPagesLinksSpacing: function () {
		var numOfPages = 0;
		var linksWidth = 0;

		$('.page-link').each(function () {
			numOfPages++;
			linksWidth += $(this).width();
			// linksWidth += $(window).width() / 35;
		});

		var emptySpace = $(window).width() - linksWidth;
		var singleSpace = emptySpace / numOfPages - 28;

		$('.page-link').css('margin-right', singleSpace);
		$('.page-link:last').css('margin-right', 0);
	},

	SetTitleLetterSpacing: function () { 
		if ($('#collections_container').offset().top !== $('.title-container').offset().top) {
			$('#collections_container ul').addClass('wide');
		} else {
			$('#collections_container ul').removeClass('wide');
		}

		var letterSpacing = $(window).width() / 200;
		$('#title_container h1').css('letter-spacing', letterSpacing * (letterSpacing / 2));
	},

	SetCollectionsColors: function () { 
		$('#collections_container label').each(function () { 
			$(this).before().css('border-color', $(this).attr('color'));
		});
	},

	SetActiveCollectionsFromUrl: function () {
		var collArr = UrlWorker.urlParams.collection.current.split(',');

		$('#collections_container input').each(function () {
			if (collArr.indexOf($(this).attr('value')) !== -1) {
				$(this).prop('checked', true);
			} else {
				$(this).prop('checked', false);
			}
		});
	},

	SetActivePageAndOrderFromUrl: function () {
		var activePage = UrlWorker.urlParams.page.current;
		var activeOrder = UrlWorker.urlParams.order.current;

		$('.page-url-link').removeClass('active');

		$('.page-link[page=' + activePage + ']').addClass('active');
		$('.page-link[page=' + activePage + ']')
			.siblings('.page-link-submenu')
			.find('a[order=' + activeOrder + ']').addClass('active');
	},

	SetActiveLangFromUrl: function () { 
		var currLang = UrlWorker.urlParams.lang.current;
		
		$('.lang-btn').each(function () {
			if ($(this).attr('value') === currLang) {
				$(this).addClass('active');
			} else {
				$(this).removeClass('active');
			}
		});
	},

	SetActiveView: function () { 
		var currentView = UrlWorker.urlParams.view.current;

		$('.view-link').removeClass('active');

		$('.view-link').each(function () {
			if ($(this).attr('value') === currentView) {
				$(this).addClass('active');
				return false;
			}
		});
	},

	HandleLastCollectionDisabled: function () {
		var numOfActive = 0;
		var activeObj;

		$('#collections_container input').each(function () {
			if ($(this).is(':checked')) {
				activeObj = $(this);
				numOfActive++;
			}
		});

		if (numOfActive < 2) {
			activeObj.attr('disabled', 'disabled');
		} else {
			$('#collections_container input').removeAttr('disabled');
		}
	},

	HandleCollectionChange: function () {
		var newParamValue = '';
		var newPageValue = UrlWorker.urlParams.page.current;
		var newOrderValue = UrlWorker.urlParams.order.current;

		$('#collections_container input').each(function () {
			if ($(this).is(':checked')) {
				newParamValue += $(this).attr('value') + ',';
			}
		});

		this.HandleLastCollectionDisabled();

		newParamValue = newParamValue.substr(0, newParamValue.length - 1);

		if (UrlWorker.urlParams.page.current > 7) {
			newPageValue = '1';
			newOrderValue = '1';
		}	

		UrlWorker.AssignNewUrl(
			['collection', 'page', 'order', 'id'],
			[newParamValue, newPageValue, newOrderValue, '1']
		);
	},

	HandleUrlLinkClick: function (link) {
		var name = $(link).attr('type');
		var value = $(link).attr('value');

		UrlWorker.AssignNewUrl([name, 'id'], [value, '1']);
	},

	HandlePageUrlLinkClick: function (link) {
		var page = $(link).attr('page');
		var order = $(link).attr('order');

		UrlWorker.AssignNewUrl(['page', 'order', 'id'], [page, order, '1']);		
	},

	AnimatePageLinkSubmenu: function (linkContainer) {
		if (ScreenWidth.currentLayout === 'small') { return; }
		var subMenu = $(linkContainer).find('ul.page-link-submenu');
		var stateOpened = subMenu.attr('state') === 'opened';

		if (stateOpened) {
			subMenu.stop().slideUp('200');
			subMenu.attr('state', 'closed');
		} else {
			subMenu.stop().slideDown('200');
			subMenu.attr('state', 'opened');
		}
	}, 

	UpdateContentFromUrl: function () {
		// UrlWorker.ReadParamsFromUrl();
		
		this.SetActiveCollectionsFromUrl();
		this.SetActivePageAndOrderFromUrl();
		this.SetActiveLangFromUrl();
		this.SetActiveView();
		this.HandleLastCollectionDisabled();
	}
};



$(function () {
	PageHeader.SetPagesLinksSpacing();
	PageHeader.SetTitleLetterSpacing();
	// PageHeader.SetCollectionsColors();

	$(window).resize(function () {
		PageHeader.SetPagesLinksSpacing();
		PageHeader.SetTitleLetterSpacing();
	});


	// Handle active links on page load
	PageHeader.UpdateContentFromUrl();

	// Handle active links on url change	
	$(window).on('hashchange', function () {
		PageHeader.UpdateContentFromUrl();
	});

	// Handle collection change
	$('#collections_container input').change(function () {
		PageHeader.HandleCollectionChange();
	});

	// Handle page url links click
	$('.page-url-link').click(function () {
		PageHeader.HandlePageUrlLinkClick(this);
	});

	// Handle url links click
	$('.url-link').click(function () {
		PageHeader.HandleUrlLinkClick(this);
	});

	// Handle pages links hover
	$('.page-link').parent('li').hover(function () {
		PageHeader.AnimatePageLinkSubmenu(this);
	}, function () { 
		PageHeader.AnimatePageLinkSubmenu(this);
	});
});
