<?php

class StaticMaps
{
    public static $pages;
    public static $pagesSubMenus;
    public static $orders;
    public static $orderFieldPerPage;
	public static $artistsInfoPerLang;
	public static $gender;
}


StaticMaps::$pages = [
    1 => [
		'table' => 'artists',
		'name' => 'Artists',
		'content_loader' => 'ContentLoaderArtists',
		'show_in_menu' => true,
		'link_to_page' => 8
	],
    2 => [
		'table' => "artworks",
		'name' => 'Artworks',
		'content_loader' => 'ContentLoaderArtworks',
		'show_in_menu' => true,
		'link_to_page' => 9
	],
    3 => [
		'table' => "galleries",
		'name' => 'Galleries',
		'content_loader' => 'ContentLoaderGalleries',
		'show_in_menu' => true,
		'link_to_page' => 10
	],
    4 => [
		'table' => "exhibitions",
		'name' => 'Exhibitions',
		'content_loader' => 'ContentLoaderExhibitions',
		'show_in_menu' => true,
		'link_to_page' => 11
	],
    5 => [
		'table' => "locations",
		'name' => 'Locations',
		'content_loader' => 'ContentLoaderLocations',
		'show_in_menu' => true,
		'link_to_page' => 12
	],
    6 => [
		'table' => "publications",
		'name' => 'Publications',
		'content_loader' => 'ContentLoaderPublications',
		'show_in_menu' => true,
		'link_to_page' => 13
	],
    7 => [
		'table' => "contributors",
		'name' => 'Contributors',
		'content_loader' => 'ContentLoaderContributers',
		'show_in_menu' => true,
		'link_to_page' => 14
	],
	8 => [
		'table' => 'artists',
		'name' => 'Artist',
		'content_loader' => 'ContentLoaderArtist',
		'show_in_menu' => false
	],
	9 => [
		'table' => 'artworks',
		'name' => 'Artwork',
		'content_loader' => 'ContentLoaderArtwork',
		'show_in_menu' => false
	]
];


StaticMaps::$orders = [
    1 => 'A-Z',
    2 => 'Country',
	3 => 'Lives &amp; Works',
    4 => 'Year of Birth',
    5 => 'Gender',
	6 => 'Count',
	7 => 'Title',
	8 => 'Artist',
	9 => 'Medium',
	10 => 'Year of Production',
	11 => 'Year of Purchase',
	12 => 'Gallery',
	13 => 'Collection',
	14 => 'Location',
	15 => 'Size',
	16 => 'Type',
	17 => 'Profession'
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
	'en' => ['Born in', 'at', 'Lives and work at', 'Died in' , 'at'],
	'de' => ['Geboren', 'in', 'Lebt und arbeitet in', 'Gestorben', 'In'],
	'it' => ['Born in', 'at', 'Lives and work at', 'Morto', 'a']
];


StaticMaps::$gender = [1 => 'Female', 2 => 'Male'];