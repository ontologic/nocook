<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//Dash routes (this is horrible..surely there is a better way..)
$route['dash/restaurant/index'] = 'dashrestaurant';
$route['dash/restaurant/create'] = 'dashrestaurant/create';
$route['dash/restaurant/edit/(:any)'] = 'dashrestaurant/edit/$1';
$route['dash/restaurant/zip/index/(:any)'] = 'dashrestaurant/zip/$1';
$route['dash/restaurant/zip/delete/(:any)'] = 'dashrestaurant/delete_zip/$1/$2';
$route['dash/manage/index'] = 'dashmanage';
$route['dash/manage/create'] = 'dashmanage/create';
$route['dash/manage/edit/(:any)'] = 'dashmanage/edit/$1';

$route['dash/menu'] = 'dashmenu';
$route['dash/menuitem/create/(:any)'] = 'dashmenuitem/create/$1/$2';
$route['dash/menuitem/edit/(:any)'] = 'dashmenuitem/edit/$1';
$route['dash/menuitem/delete/(:any)'] = 'dashmenuitem/delete/$1';

$route['default_controller'] = "home";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */