/* global UrlWorker, ScreenWidth */

var Collections = {

	StyleSelectedCollectionLink: function (link) {
		var color = $(link).attr('color');
		$(link).css('color', color);
	},

	UnStyleSelectedCollectionLink: function (link) {
		$(link).css('color', 'initial');
	},

	SetActiveCollectionsFromUrl: function () {
		if (UrlWorker.urlParams.collection.current === '0') {
			$('#collections_links a').each(function () {
				$(this).addClass('selected');
				Collections.StyleSelectedCollectionLink(this);
			});
		} else {
			var collArr = UrlWorker.urlParams.collection.current.split(',');

			$('#collections_links a').each(function () {
				if (collArr.indexOf($(this).attr('value')) !== -1) {
					$(this).addClass('selected');
					Collections.StyleSelectedCollectionLink(this);
				} else {
					$(this).removeClass('selected');
					Collections.UnStyleSelectedCollectionLink(this);
				}
			});
		}
	},

	HandleLastCollectionDisabled: function () {
		var numOfActive = 0;
		var activeObj;

		$('#collections_links a').each(function () {
			if ($(this).hasClass('selected')) {
				activeObj = $(this);
				numOfActive++;
			}
		});

		if (numOfActive === 1) {
			activeObj.parent('li').addClass('disabled');
		} else {
			$('#collections_links li').removeClass('disabled');
		}
	},

	HandleCollectionChange: function () { //TODO
		var newCollValue = '';
		var newPageValue = UrlWorker.urlParams.page.current;
		var newOrderValue = UrlWorker.urlParams.order.current;

		if ($('#collections_links a:first').hasClass('selected')) {
			newCollValue = '0';
		} else {
			$('#collections_links a').each(function () {
				if ($(this).hasClass('selected')) {
					newCollValue += $(this).attr('value') + ',';
				}
			});
			newCollValue = newCollValue.substr(0, newCollValue.length - 1);
		}	

		if (UrlWorker.urlParams.page.current > 20) {
			newPageValue = UrlWorker.urlParams.page.current - 20;
			newOrderValue = UrlWorker.pageIdDefaultOrder[newPageValue];
		}

		UrlWorker.AssignNewUrl(
			['collection', 'page', 'order', 'id'],
			[newCollValue, newPageValue, newOrderValue, '1']
		);

		this.HandleLastCollectionDisabled();
	},

	CheckIfAllCollectionsSelected: function () {
		var allSelected = true;
		var isFirst = true;
		$('#collections_links a').each(function () {
			if (isFirst) {
				isFirst = false;
				return true;
			}

			if (!$(this).hasClass('selected')) {
				allSelected = false;
			}
		});

		if (allSelected) {
			$('#collections_links a:first').addClass('selected');
			Collections.StyleSelectedCollectionLink($('#collections_links a:first'));
		} else {
			$('#collections_links a:first').removeClass('selected');
			Collections.UnStyleSelectedCollectionLink($('#collections_links a:first'));
		}
	},

	HandleCollectionClick: function (link) {
		if ($(link).hasClass('selected')) {
			if ($(link).attr('value') === '0') {
				$('#collections_links a').each(function () {
					$(this).removeClass('selected');
					Collections.UnStyleSelectedCollectionLink(this);
				});

				var first = $('#collections_links a')[1];
				$(first).addClass('selected');
				Collections.StyleSelectedCollectionLink(first);
			} else {
				$(link).removeClass('selected');
				Collections.UnStyleSelectedCollectionLink(link);
			}
		} else {
			if ($(link).attr('value') === '0') {
				$('#collections_links a').each(function () {
					$(this).addClass('selected');
					Collections.StyleSelectedCollectionLink(this);
				});
			} else {
				$(link).addClass('selected');
				Collections.StyleSelectedCollectionLink(link);
			}
		}

		Collections.CheckIfAllCollectionsSelected();
		Collections.HandleCollectionChange();
	}
};



$(function () {

	// Handle selected collections on page load and url change
	Collections.SetActiveCollectionsFromUrl();
	$(window).on('hashchange', function () {
		Collections.SetActiveCollectionsFromUrl();
	});

	// Handle last active collection on page load
	Collections.HandleLastCollectionDisabled();

	// Handle collection change
	$('#collections_links a').click(function () {
		Collections.HandleCollectionClick(this);
	});

});
