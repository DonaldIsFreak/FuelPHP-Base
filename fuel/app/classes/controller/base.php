<?php
/**
 *
 *
 * @extends  Controller_Base
 * @author Donald Zhan <donald.zhan1984@gmail.com>
 * @package  app
 */


class Controller_Base extends Controller
{
    public $view = null;
    public $viewTitle = null;
    public $viewFolder = null;
    public $view_messages = array();

    /**
     *
     *
     * @param object  $request
     */
    public function __construct( Request $request )
    {
        parent::__construct( $request );
        $this->setDefaultViewFolder();
    }

    /**
     *
     *
     * @return string
     */
    public function getViewFolder()
    {
        return $this->viewFolder;
    }

    /**
     *
     *
     * @param string  $folder
     */
    public function setViewFolder($folder='')
    {
        $this->viewFolder = $folder;
    }


    /**
     *
     */
    public function setDefaultViewFolder()
    {
        $currentCtrlName = $this->getCtrlName();
        $patternStr = '_';
        $replaceStr = DIRECTORY_SEPARATOR;
        $this->viewFolder = str_replace($patternStr, $replaceStr, $currentCtrlName) ;
    }

    /**
     * Default the view title is action name.
     */
    public function setDefaultViewTitle()
    {
        $this->viewTitle = $this->request->action;
    }

    /**
     *
     *
     * @return unknown
     */
    public function getDefaultViewTitle()
    {
        if (is_null($this->viewTitle)) {
            $this->setDefaultViewTitle();
        }
        return $this->viewTitle;

    }

    /**
     *
     *
     * @return string
     */
    public function getViewFilePath()
    {
        $action = $this->request->action;
        return $this->viewFolder.DIRECTORY_SEPARATOR.$action.'.twig';
    }

    /**
     *
     *
     * @param boolean $withoutCtrlWord (optional)
     * @return string
     */
    public function getCtrlName($withoutCtrlWord=TRUE)
    {
        $ctrlName = strtolower($this->request->controller);

        if ($withoutCtrlWord) {
            // 'Controller_' length is 11
            $ctrlName= substr($ctrlName, 11);
        }

        return $ctrlName;
    }


    /**
     *
     */
    public function before()
    {
        if (is_null($this->view)) {
            $this->view = View::forge($this->getViewFilePath());
        }
    }

    /**
     *
     *
     * @param object  $response
     * @return unknown
     */
    public function after($response)
    {
        if (!isset($this->view->title)) {
            $this->view->title = $this->getDefaultViewTitle();
        }
        $this->view->messages = $this->view_messages;
        if ( ! $response instanceof Response) {
            $response = \Response::forge($this->view, $this->response_status);
        }
        return parent::after($response);
    }
}
