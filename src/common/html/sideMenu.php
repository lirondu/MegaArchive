<input type="checkbox" id="burger_btn">
<label for="burger_btn"></label>

<ul class="navigation">
	<li class="nav-item">
		<a href="javascript:void(0)" class="menu-link lang-link" url-name="lang" url-value="en">EN</a>
		<span>/</span>
		<a href="javascript:void(0)" class="menu-link lang-link" url-name="lang" url-value="de">DE</a>
		<span>/</span>
		<a href="javascript:void(0)" class="menu-link lang-link" url-name="lang" url-value="it">IT</a>
	</li>


	<li class="nav-item seperator"></li>


	<li class="nav-item view-options">view</li>
	<li class="nav-item">
		<a href="javascript:void(0)" class="menu-link view-link" url-name="view" url-value="1">text</a>
		<span>/</span>
		<a href="javascript:void(0)" class="menu-link view-link" url-name="view" url-value="2">image</a>
	</li>


	<li class="nav-item seperator"></li>


	<li class="nav-item">search</li>
	<li class="nav-item" id="search_container">
		<input type="text" id="site_search">
		<span id="loading_results"></span>
	</li>


	<li class="nav-item seperator"></li>


	<li class="nav-item order-by">order <span class="order-page-name"></span> by</li>
	<div class="order-by-container"></div>
</ul>