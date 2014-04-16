<?php

return array(
    '_root_'               => 'home/index', // The default route
    '_404_'                => 'home/404', // The main 404 route
    'about'                => 'home/about',
    'contact'              => 'home/contact',
    'login'                => 'home/login',
    'logout'               => 'home/logout',
    'register'             => 'home/register',
    ':ctrl/hello(/:name)?' => array('home/hello', 'name' => 'hello'),
);
