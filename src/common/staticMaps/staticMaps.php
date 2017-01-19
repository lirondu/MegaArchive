<?php

class StaticMaps
{
    public static $pages;
    public static $pagesSubMenus;
    public static $orders;
    public static $orderFieldPerPage;
	public static $artistsInfoPerLang;
	public static $gender;
	public static $contentCreatorsMap;
	public static $contentDeletersMap;
}


StaticMaps::$pages = [
    1 => [
		'table' => 'artists',
		'name' => 'Artists',
		'content_loader' => 'ContentLoaderArtists',
		'show_in_menu' => true,
		'is_public' => true,
		'link_to_page' => 21
	],
    2 => [
		'table' => "artworks",
		'name' => 'Artworks',
		'content_loader' => 'ContentLoaderArtworks',
		'show_in_menu' => true,
		'is_public' => true,
		'link_to_page' => 22
	],
    3 => [
		'table' => "galleries",
		'name' => 'Galleries',
		'content_loader' => 'ContentLoaderGalleries',
		'show_in_menu' => true,
		'is_public' => false,
		'link_to_page' => 23
	],
    4 => [
		'table' => "exhibitions",
		'name' => 'Exhibitions',
		'content_loader' => 'ContentLoaderExhibitions',
		'show_in_menu' => true,
		'is_public' => true,
		'link_to_page' => 24
	],
    5 => [
		'table' => "locations",
		'name' => 'Locations',
		'content_loader' => 'ContentLoaderLocations',
		'show_in_menu' => true,
		'is_public' => true,
		'link_to_page' => 25
	],
    6 => [
		'table' => "publications",
		'name' => 'Publications',
		'content_loader' => 'ContentLoaderPublications',
		'show_in_menu' => true,
		'is_public' => true,
		'link_to_page' => 26
	],
    7 => [
		'table' => "contributors",
		'name' => 'Contributors',
		'content_loader' => 'ContentLoaderContributers',
		'show_in_menu' => true,
		'is_public' => true,
		'link_to_page' => 27
	],

	// Single Pages - also have ADMIN version
	21 => [
		'table' => 'artists',
		'name' => 'Artist',
		'content_loader' => 'ContentLoaderArtist',
		'content_loader_admin' => 'ContentLoaderArtistAdmin',
		'show_in_menu' => false,
		'is_public' => true
	],
	22 => [
		'table' => 'artworks',
		'name' => 'Artwork',
		'content_loader' => 'ContentLoaderArtwork',
		'content_loader_admin' => 'ContentLoaderArtworkAdmin',
		'show_in_menu' => false,
		'is_public' => true
	],

	// Table Pages - ADMIN only
	41 => [
		'table' => 'artists',
		'name' => 'Artist',
		'content_loader_admin' => 'ContentLoaderArtistsTable',
		'show_in_menu' => false,
		'is_public' => false
	]
];


StaticMaps::$orders = [
    1 => ['name' => 'A-Z', 					'is_public' => true],
    2 => ['name' => 'Country', 				'is_public' => true],
	3 => ['name' => 'Lives &amp; Works', 	'is_public' => true],
    4 => ['name' => 'Year of Birth', 		'is_public' => true],
    5 => ['name' => 'Gender', 				'is_public' => true],
	6 => ['name' => 'Count', 				'is_public' => false],
	7 => ['name' => 'Title', 				'is_public' => true],
	8 => ['name' => 'Artist', 				'is_public' => true],
	9 => ['name' => 'Medium', 				'is_public' => true],
	10 => ['name' => 'Year of Production',	'is_public' => true],
	11 => ['name' => 'Year of Purchase', 	'is_public' => false],
	12 => ['name' => 'Gallery', 			'is_public' => false],
	13 => ['name' => 'Collection', 			'is_public' => true],
	14 => ['name' => 'Location', 			'is_public' => false],
	15 => ['name' => 'Size', 				'is_public' => false],
	16 => ['name' => 'Type', 				'is_public' => true],
	17 => ['name' => 'Profession', 			'is_public' => true]
];


StaticMaps::$pagesSubMenus = [
    'artists' => [1, 2, 3, 4, 5, 6],
    'artworks' => [7, 8, 9, 10, 11, 12, 13, 14, 15],
    'galleries' => [1, 2, 6],
    'exhibitions' => [7, 2, 13],
	'locations' => [1, 6, 13],
    'publications' => [1, 13, 16],
    'contributors' => [1, 17, 2, 4, 6]
];


StaticMaps::$orderFieldPerPage = [
    'artists' => [
        1 => 'last_name',
        2 => 'cob',
        3 => 'cor',
        4 => 'year_of_birth',
		5 => 'sex',
		6 => 'count'
	],
	'artworks' => [
        7 => 'title',
        8 => 'artist_name',
		9 => 'medium_name',
		10 => 'year_start',
		11 => 'year_of_purchase',
		12 => 'gallery_name',
		13 => 'collection_name',
		14 => 'location_name',
		15 => 'size_name'
	],
	'galleries' => [
		1 => 'name',
		2 => 'country_name',
		6 => 'count'
	],
	'exhibitions' => [
		7 => 'name',
		2 => 'country_name',
		13 => 'collection_name'
	],
	'locations' => [
		1 => 'name',
		6 => 'count',
		13 => 'collection_name'
	],
	'publications' => [
		1 => 'title',
		13 => 'collection_name',
		16 => 'type'
	],
	'contributors' => [
		1 => 'last_name',
		17 => 'type',
		2 => 'cob',
		4 => 'year_of_birth',
		6 => 'count'
	]
];


StaticMaps::$artistsInfoPerLang = [
	'en' => ['Born in', 'at', 'Lives and works at', 'Died in' , 'at', 'Photographer', 'Source', 'Writer'],
	'de' => ['Geboren', 'in', 'Lebt und arbeitet in', 'Gestorben', 'In', 'Photograph', 'Quelle', 'Author'],
	'it' => ['Nato a', 'a', 'Vive e lavora a', 'Morto', 'a', 'Fotografo', 'Fonte', 'Scrittore']
];


StaticMaps::$gender = [1 => 'Female', 2 => 'Male'];


StaticMaps::$contentCreatorsMap = [
	'artists' => 'ContentCreatorArtist'
];

StaticMaps::$contentDeletersMap = [
	'artists' => 'ContentDeleterArtist'
];