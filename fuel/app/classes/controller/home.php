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
    
    public function action_register()
    {
        $view = View::forge('home/register.twig');
        $view->messages = array();
        
        $form = Fieldset::forge('registerform');

        $form->form()->add_csrf();
        $form->add_model('Model\\Auth_User');
        $form->add_after('fullname', __('login.form.fullname'), array(), array(), 'username')->add_rule('required');
        $form->add_after('confirm', __('login.form.confirm'), array('type' => 'password'), array(), 'password')->add_rule('required');
        $form->field('password')->add_rule('required');
        $form->disable('group_id');
        $form->field('group_id')->delete_rule('required')->delete_rule('is_numeric');

        if (Input::method() == 'POST')
        {
            $form->validation()->run();

            if ( ! $form->validation()->error())
            {
                try
                {
                    $created = Auth::create_user(
                        $form->validated('username'),
                        $form->validated('password'),
                        $form->validated('email'),
                        Config::get('application.user.default_group', 1),
                        array(
                            'fullname' => $form->validated('fullname'),
                        )
                    );
                
                    if ($created)
                    {
                        Response::redirect('home');
                    }
                    else
                    {
                        $view->messages[]=__('login.account-creation-failed');
                    }
                }
                catch (SimpleUserUpdateException $e)
                {      
                    if ($e->getCode() == 2)
                    {
                        $view->messages[] = __('login.email-already-exists');
                    }
                    elseif ($e->getCode() == 3)
                    {
                        $view->messages[]= __('login.username-already-exists');
                    }
                    else
                    {
                        $view->messages[]=$e->getMessage();
                    }
                }
            }else{
                $view->messages = $form->validation()->error_message();
            }
            $form->repopulate();
        }
        $form->add('submit','',array('type'=>'submit','value'=>'Submit'));
        return $view->set('form', $form, false);
    }

}
