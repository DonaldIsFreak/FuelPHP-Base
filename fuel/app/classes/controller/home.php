<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Home extends Controller
{

    public function action_index()
    {
        $view = View::forge('home/index.twig');
        $view->title = 'Index';
        return Response::forge($view);
    }
    
    public function action_contact()
    {
        $view = View::forge('home/contact.twig');
        $view->title = 'Contact';
        return Response::forge($view);
    }
    
    public function action_about()
    {
        $view = View::forge('home/about.twig');
        $view->title = 'About';
        return Response::forge($view);
    }
    public function action_hello()
    {
        $view = ViewModel::forge('home/hello.twig');
        $view->title = 'Hello';
        return Response::forge($view);
    }
    public function action_404()
    {
        return Response::forge(ViewModel::forge('home/404'), 404);
    }
    

}
