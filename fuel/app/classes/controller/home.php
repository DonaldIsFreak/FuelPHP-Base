<?php
/**
 *
 *
 * @extends  Controller_Base
 * @author Donald Zhan <donald.zhan1984@gmail.com>
 * @package  app
 */


class Controller_Home extends Controller_Base
{

    /**
     *
     *
     * @return unknown
     */
    public function action_index()
    {

    }



    /**
     *
     *
     * @return unknown
     */
    public function action_contact()
    {

    }



    /**
     *
     *
     * @return unknown
     */
    public function action_about()
    {

    }

    /**
     *
     *
     * @return unknown
     */
    public function action_hello()
    {

    }

    /**
     *
     *
     * @return unknown
     */
    public function action_404()
    {
        return Response::forge(ViewModel::forge('home/404'), 404);
    }


    /**
     *
     *
     * @return unknown
     */
    public function action_login()
    {
        $view = $this->view;

        if (Auth::check()) {
            $this->view_messages[] = 'login aleady logged in';
        }

        if (Input::method() == 'POST') {

            if (Auth::login(Input::param('username'), Input::param('password'))) {
                if (Input::param('remember', false)) {
                    Auth::remember_me();
                }else {
                    Auth::dont_remember_me();
                }
            }else {
                $this->view_messages[] = 'login failure';
            }
        }

    }

    /**
     *
     */
    public function action_logout()
    {
        Auth::dont_remember_me();
        Auth::logout();
        Response::redirect_back();
    }

    /**
     *
     *
     * @return unknown
     */
    public function action_register()
    {
        $view = $this->view;

        $form = Fieldset::forge('registerform');

        $form->form()->add_csrf();
        $form->add_model('Model\\Auth_User');
        $form->field('username')->set_attribute(array('type'=> 'text' ,'class'=> 'form-control'));
        $form->field('password')->add_rule('required')->set_attribute(array('type' => 'password','class'=> 'form-control'));
        $form->field('email')->set_attribute(array('type' => 'text','class'=> 'form-control'));
        $form->add_after('fullname', __('login.form.fullname'), array('type'=>'text','class' => 'form-control'), array(), 'username')->add_rule('required');
        $form->add_after('confirm', __('login.form.confirm'), array('type' => 'password','class'=> 'form-control'), array(), 'password')->add_rule('required');
        $form->disable('group_id');
        $form->field('group_id')->delete_rule('required')->delete_rule('is_numeric');
        $form->add('submit', '', array('type'=>'submit', 'value'=>'Submit','class'=>"btn btn-lg btn-primary btn-block"));

        if (Input::method() == 'POST') {
            $form->validation()->run();

            if ( ! $form->validation()->error()) {
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

                    if ($created) {
                        Response::redirect('home');
                    }
                    else {
                        $this->view_messages[]=__('login.account-creation-failed');
                    }
                }
                catch (SimpleUserUpdateException $e) {
                    switch ($e->getCode()) {
                    case 2:
                        $this->view_messages[] = __('login.email-already-exists');
                        break;
                    case 3:
                        $this->view_messages[]= __('login.username-already-exists');
                        break;
                    default:
                        $this->view_messages[]=$e->getMessage();

                    }
                }
            }else {
                $this->view_messages = $form->validation()->error_message();
            }
            $form->repopulate();
        }
        return $view->set('form', $form, false);
    }

}
