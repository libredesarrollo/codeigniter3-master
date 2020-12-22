<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */

$route['blog/tema/(:num)'] = 'blog/tema/$1';
$route['sitemap.xml'] = 'sitemap/index';
$route['acerca-de'] = 'index/acerca_de';

$route['default_controller'] = 'index';
$route['blog/categorias'] = 'blog/categories';
$route['blog/rss'] = 'blog/rss';
$route['blog/search'] = 'blog/search';
$route['blog/(:num)'] = 'blog/index/$1';
$route['blog/(:any)'] = 'blog/category_detail/$1';
$route['blog/(:any)/(:num)'] = 'blog/category/$1/$2';
$route['trabajos'] = 'index/trabajos';
$route['cursos'] = 'index/cursos';
$route['blog'] = 'blog/index';
$route['admin'] = 'admin/index';
$route['blog/tags/(:any)'] = 'blog/tags/$1/';
$route['blog/tags/(:any)/(:num)'] = 'blog/tags/$1/$2';
$route['blog/(:any)/(:any)'] = 'blog/post_view/$1/$2';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route[LOGIN_PAGE] = 'app/login';
$route['register'] = 'app/register';
$route['(:any)'] = 'blog/category_detail/$1';
