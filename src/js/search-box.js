/* global Bloodhound, Handlebars, UrlWorker */

var SearchBox = {
	CreateBloodhoundSource: function (t) {
		return new Bloodhound({
			sufficient: 10,
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('id'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,

			remote: {
				url: './../php/search/search.php?t=' + t + '&q=%QUERY',
				wildcard: '%QUERY'
			}
		});
	},

	CreateTypeaheadDataset: function (name, disTemplate, sugTemplate) {
		return {
			limit: 10,
			hint: false,
			name: name,
			display: Handlebars.compile(disTemplate),
			source: SearchBox.CreateBloodhoundSource(name),
			templates: {
				header: function () {
					return '<p class="tt-dataset-header">-- ' + name + ' --</p>';
				},
				suggestion: Handlebars.compile(sugTemplate)
			}
		};
	},

	CustomizeTypeaheadMenu: function () {
		$('.tt-menu').prepend('<div id="empty_results"><strong>No results found</strong></div>');
	},

	RegisterTypeaheadEvents: function () {
		// on asyncreceive - end loading gif and handle empty results
		$('#site_search').on('typeahead:asyncreceive', function () {
			$('#loading_results').hide();

			if ($(this).data('tt-typeahead').menu._allDatasetsEmpty()) {
				$('.tt-menu').find('#empty_results').show();
				$('.tt-menu.tt-empty').show();
			} else {
				$('.tt-menu').find('#empty_results').hide();
			}
		});

		// on asyncrequest start loading gif		
		$('#site_search').on('typeahead:asyncrequest', function () {
			$('#loading_results').show();
		});

		// on select change URL
		$('#site_search').on('typeahead:select', function (ev, obj) {
			UrlWorker.AssignNewUrl(['page', 'id'], ['1', '11']);
		});
	}
};



$(function () {
	$('#site_search').typeahead(
		{
			hint: true,
			highlight: true,
			minLength: 1
		},
		SearchBox.CreateTypeaheadDataset(
			'artists',
			'{{{full_name}}}',
			'<div>' +
			'<p>{{{full_name}}}</p>' +
			'<p>{{{city_of_birth}}}, {{{country_of_birth}}}, {{{year_of_birth}}}</p>' +
			'<p>{{{city_of_residence}}}, {{{country_of_residence}}}</p>' +
			'</div >'
		),
		SearchBox.CreateTypeaheadDataset(
			'artworks',
			'{{{title}}}',
			'<div>' +
			'<p>{{{title}}}, {{{location}}}</p>' +
			'<p>By, {{{first_name}}} {{{last_name}}}</p>' +
			'</div > '
		)
	);


	SearchBox.CustomizeTypeaheadMenu();
	SearchBox.RegisterTypeaheadEvents();
});