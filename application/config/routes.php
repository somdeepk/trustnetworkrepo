<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//admin routs
$route['administrator'] = 'administrator/view';
$route['administrator/home'] = 'administrator/home';
$route['administrator/index'] = 'administrator/view';
$route['administrator/forget-password'] = 'administrator/forget_password';
$route['administrator/dashboard'] = 'administrator/dashboard';

$route['administrator/change-password'] = 'administrator/get_admin_data';

$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;