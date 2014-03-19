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
     */
    public function action_login()
    {


    }

    /**
     *
     */
    public function action_logout()
    {

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
        $form->add_after('fullname', __('login.form.fullname'), array(), array(), 'username')->add_rule('required');
        $form->add_after('confirm', __('login.form.confirm'), array('type' => 'password'), array(), 'password')->add_rule('required');
        $form->field('password')->add_rule('required');
        $form->disable('group_id');
        $form->field('group_id')->delete_rule('required')->delete_rule('is_numeric');
        $form->add('submit', '', array('type'=>'submit', 'value'=>'Submit'));

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
                        $view->messages[]=__('login.account-creation-failed');
                    }
                }
                catch (SimpleUserUpdateException $e) {
                    switch ($e->getCode()) {
                    case 2:
                        $view->messages[] = __('login.email-already-exists');
                        break;
                    case 3:
                        $view->messages[]= __('login.username-already-exists');
                        break;
                    default:
                        $view->messages[]=$e->getMessage();

                    }
                }
            }else {
                $view->messages = $form->validation()->error_message();
            }
            $form->repopulate();
        }
        return $view->set('form', $form, false);
    }

}
