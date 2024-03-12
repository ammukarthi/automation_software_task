<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

$routes->get('/', 'Home::login');

$routes->post('user-login', 'Home::postLogin');

$routes->get('products', 'Home::products');

$routes->get('products/list/(:any)/(:any)', 'Home::productData/$1/$2');

$routes->get('logout', 'Home::logout');
