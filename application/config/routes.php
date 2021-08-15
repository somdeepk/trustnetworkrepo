<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//admin routs
$route['administrator'] = 'administrator/view';
$route['administrator/home'] = 'administrator/home';
$route['administrator/index'] = 'administrator/view';
$route['administrator/forget-password'] = 'administrator/forget_password';
$route['administrator/dashboard'] = 'administrator/dashboard';
/*
$route['administrator/change-password'] = 'administrator/get_admin_data';
$route['administrator/update-profile'] = 'administrator/update_admin_profile';
*/

/*$route['administrator/addchurch'] = 'administrator/addchurch';
$route['administrator/submitchurch'] = 'administrator/submitchurch';*/
/*$route['administrator/addchurch(:any)'] = 'administrator/addchurch/$1';/*
$route['administrator/churchlist'] = 'administrator/churchlist';
$route['administrator/ajaxGetChurchList'] = 'administrator/ajaxGetChurchList';*/

$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;