<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Klasifikasi::index');
$routes->get('/deteksi-sampah', 'Klasifikasi::index');
$routes->post('/klasifikasi/proses', 'Klasifikasi::proses');
$routes->post('/deteksi-sampah/proses', 'Klasifikasi::proses');