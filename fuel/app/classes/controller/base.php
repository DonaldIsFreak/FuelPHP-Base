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
    public $viewFolder = null;

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
        $currentCtrlName = substr(strtolower($this->request->controller), 11) ;
        $patternStr = '_';
        $replaceStr = DIRECTORY_SEPARATOR;
        $this->viewFolder = str_replace($patternStr, $replaceStr, $currentCtrlName) ;
    }

    /**
     *
     *
     * @return unknown
     */
    public function getViewFilePath()
    {
        $action = $this->request->action;
        return $this->viewFolder.DIRECTORY_SEPARATOR.$action.'.twig';
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
}
