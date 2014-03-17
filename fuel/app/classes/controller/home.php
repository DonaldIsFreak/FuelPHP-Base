<?php

class Controller_Home extends Users\Controller_Base
{

    public function action_index()
    {
        $view        = View::forge('home/index.twig');
        $ctrlName = $this->request->action;
        $view->title = $ctrlName;
        return Response::forge($view);
    }

    public function action_contact()
    {
        $view        = View::forge('home/contact.twig');
        $view->title = 'Contact';
        return Response::forge($view);
    }

    public function action_about()
    {
        $view        = View::forge('home/about.twig');
        $view->title = 'About';
        return Response::forge($view);
    }

    public function action_hello()
    {
        $view        = ViewModel::forge('home/hello.twig');
        $view->title = 'Hello';
        return Response::forge($view);
    }

    public function action_404()
    {
        return Response::forge(ViewModel::forge('home/404'), 404);
    }

}
