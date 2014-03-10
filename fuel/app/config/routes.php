<?php
return array(
	'_root_'  => 'home/index',  // The default route
	'_404_'   => 'home/404',    // The main 404 route
	'about'   => 'home/about',
    'contact' => 'home/contact',
	':ctrl/hello(/:name)?' => array('home/hello', 'name' => 'hello'),
);