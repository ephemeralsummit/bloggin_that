<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'PostController::index'); // main page shows all posts
$routes->get('/login', 'AuthController::login');
$routes->post('/login/post', 'AuthController::loginPost');
$routes->get('/register', 'AuthController::register');
$routes->post('/register/post', 'AuthController::registerPost');
$routes->get('/logout', 'AuthController::logout');




$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('posts', 'PostController::index');
    $routes->get('posts', 'PostController::store');
    $routes->get('posts/create', 'PostController::create');
    $routes->post('posts/store', 'PostController::store');
    $routes->get('posts/edit/(:num)', 'PostController::edit/$1');
    $routes->post('posts/update/(:num)', 'PostController::update/$1');
    $routes->get('posts/delete/(:num)', 'PostController::delete/$1');
    $routes->get('posts/view/(:num)', 'PostController::view/$1');
    $routes->get('posts/liked', 'PostController::likedPosts');
    // like
    $routes->post('like/toggle/(:num)', 'LikeController::toggle/$1');

    $routes->get('users', 'UserController::index');
    $routes->get('users/create', 'UserController::create');
    $routes->post('users', 'UserController::store');
    $routes->put('users/(:num)', 'UserController::update/$1');
    $routes->get('users/edit/(:num)', 'UserController::edit/$1');
    $routes->post('users/update/(:num)', 'UserController::update/$1');
    $routes->get('users/delete/(:num)', 'UserController::delete/$1');
    $routes->get('users/profile/(:num)', 'UserController::profile/$1');
    $routes->get('profile/liked', 'UserController::likedPosts');
    $routes->get('profile/liked/(:num)', 'UserController::likedPosts/$1');
    $routes->get('users/view/(:num)', 'UserController::view/$1');
    $routes->delete('users/(:num)', 'UserController::delete/$1');
    $routes->delete('posts/(:num)', 'PostController::delete/$1');

});
