<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//admin routs
$route['user'] = 'user/login';
$route['user/login'] = 'user/login';

$route['user/forget-password'] = 'user/forget_password';

$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;