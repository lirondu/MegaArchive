var UrlWorker = {
	urlParams: {
		collection: { name: 'collection', default: '1', current: null },
		page: { name: 'page', default: '1', current: null },
		order: { name: 'order', default: '1', current: null },
		lang: { name: 'lang', default: 'en', current: null },
		view: { name: 'view', default: '1', current: null },
		id: { name: 'id', default: '1', current: null }
	},

	pageIdToName: {
		1: 'artists',
		2: 'artworks',
		3: 'galleries',
		4: 'exhibitions',
		5: 'publications',
		6: 'locations',
		7: 'contributors'
	},

	GetParameterByName: function (name, url) {
		if (!url) {
			url = location.href;
		}

		var regex = new RegExp("[#&]" + name + "=([^&#]*)");
		var results = regex.exec(url);

		return results === null ? false : decodeURIComponent(results[1].replace(/\+/g, " "));
	},

	ReadParamsFromUrl: function () {
		var changed = false;

		for (var param in this.urlParams) {
			var currentValue = this.GetParameterByName(this.urlParams[param]['name']);

			if (!currentValue) {
				currentValue = this.urlParams[param]['default'];
			}

			if (currentValue !== this.urlParams[param]['current']) {
				this.urlParams[param]['current'] = currentValue;

				if (this.urlParams[param]['name'] !== 'view') {
					changed = true;
				}
			}
		}

		if (changed) { $(window).trigger('loadcontent'); }
	},

	GetParamValueToUrl: function (name) {
		for (var param in this.urlParams) {
			if (name === this.urlParams[param]['name']) {
				if (this.urlParams[param]['current'] !== this.urlParams[param]['default']) {
					return this.urlParams[param]['name'] + '=' + this.urlParams[param]['current'];
				} else {
					return false;
				}
			}
		}

		return false;
	},

	AssignNewUrl: function (namesArr, valuesArr) {
		var newUrl = '#';
		var needAmp = false;

		for (var param in this.urlParams) {
			var idx = namesArr.indexOf(this.urlParams[param]['name']);
			if (idx !== -1) {
				if (valuesArr[idx] !== this.urlParams[param]['default']) {
					if (needAmp) {
						newUrl += '&';
					}

					newUrl += this.urlParams[param]['name'] + '=' + valuesArr[idx];
					needAmp = true;
				}
			} else {
				var currParamValue = this.GetParamValueToUrl(this.urlParams[param]['name']);

				if (currParamValue) {
					if (needAmp) {
						newUrl += '&';
					}

					newUrl += currParamValue;
					needAmp = true;
				}
			}
		}

		newUrl.replace('&&', '&').replace('##', '#');

		location.assign(newUrl);
	}

};


$(function () {
	UrlWorker.ReadParamsFromUrl();

	$(window).on('hashchange', function () {
		UrlWorker.ReadParamsFromUrl();
	});
});