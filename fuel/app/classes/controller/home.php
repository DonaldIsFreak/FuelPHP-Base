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
    
    // create the registration fieldset
    $form = Fieldset::forge('registerform');

    // add a csrf token to prevent CSRF attacks
    $form->form()->add_csrf();

    // and populate the form with the model properties
    $form->add_model('Model\\Auth_User');

    // add the fullname field, it's a profile property, not a user property
    $form->add_after('fullname', __('login.form.fullname'), array(), array(), 'username')->add_rule('required');

    // add a password confirmation field
    $form->add_after('confirm', __('login.form.confirm'), array('type' => 'password'), array(), 'password')->add_rule('required');

    // make sure the password is required
    $form->field('password')->add_rule('required');

    // and new users are not allowed to select the group they're in (duh!)
    $form->disable('group_id');

    // since it's not on the form, make sure validation doesn't trip on its absence
    $form->field('group_id')->delete_rule('required')->delete_rule('is_numeric');

    // was the registration form posted?
    if (Input::method() == 'POST')
    {
        // validate the input
        $form->validation()->run();

        // if validated, create the user
        if ( ! $form->validation()->error())
        {
            try
            {
                // call Auth to create this user
                $created = \Auth::create_user(
                    $form->validated('username'),
                    $form->validated('password'),
                    $form->validated('email'),
                    \Config::get('application.user.default_group', 1),
                    array(
                        'fullname' => $form->validated('fullname'),
                    )
                );

                // if a user was created succesfully
                if ($created)
                {
                    // inform the user
                    

                    // and go back to the previous page, or show the
                    // application dashboard if we don't have any
                  
                }
                else
                {
                    // oops, creating a new user failed?
                    $form->vali->set_message(__('login.account-creation-failed'));
                }
            }

            // catch exceptions from the create_user() call
            catch (\SimpleUserUpdateException $e)
            {
                // duplicate email address
                if ($e->getCode() == 2)
                {
                    \Messages::error(__('login.email-already-exists'));
                }

                // duplicate username
                elseif ($e->getCode() == 3)
                {
                    \Messages::error(__('login.username-already-exists'));
                }

                // this can't happen, but you'll never know...
                else
                {
                    \Messages::error($e->getMessage());
                }
            }
        }else{
            $view->messages = $form->validation()->error();
        }

        // validation failed, repopulate the form from the posted data
        $form->repopulate();
    }
    $form->add('submit','',array('type'=>'submit','value'=>'Submit'));
    // pass the fieldset to the form, and display the new user registration view
    return $view->set('form', $form, false);
}

}
