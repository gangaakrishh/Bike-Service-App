<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// user routes
$routes->post('/api/register', 'Auth::Register');
$routes->post('/api/login', 'Auth::Login');

// Admin routes
$routes->post('/api/admin/login', 'Auth::Adminlogin');


//Common Listing Data's

$routes->get('api/service','Services::getService');
$routes->post('api/service/create','Services::addService');
$routes->delete('api/service/delete/(:any)','Services::deleteService/$1');


$routes->get('api/status','Services::getServiceStatus');
$routes->post('api/status/create','Services::addServiceStatus');
$routes->delete('api/status/delete/(:any)','Services::deleteServiceStatus/$1');


//service Booking
$routes->get('api/booking', 'ServiceBooking::getserviceBook');
$routes->post('api/booking/create', 'ServiceBooking::serviceBook', ['filter' => 'authFilter']);
$routes->post('api/booking/update', 'ServiceBooking::statusUpdate');
$routes->get('api/bookings', 'ServiceBooking::userBookings', ['filter' => 'authFilter']);


