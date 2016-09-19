var ScreenWidth = {
	wideScreen: 850,
	currentLayout: null,
	lastLayout: null,

	CheckCurrentLayout: function () {
		if ($(window).width() >= this.wideScreen) {
			this.currentLayout = 'big';
		} else {
			this.currentLayout = 'small';
		}

		if (this.currentLayout !== this.lastLayout) {
			this.lastLayout = this.currentLayout;

			var e = {};
			e.currentLayout = this.currentLayout;
			$(window).trigger('screenWidthLayoutChanged', e);
		}
	}
};


$(function () {
	ScreenWidth.CheckCurrentLayout();
	$(window).resize(function () {
		ScreenWidth.CheckCurrentLayout();
	});
});