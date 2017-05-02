<?php

namespace Calendar;


class Controller
{
    /**
     * Base Class for controllers
     * Controller constructor
     * @param Site $site The site Object
     * @param $session  Session array by reference
     * @param $post post array
     */

    protected $site;
    //protected $session;
    protected $post;
    protected $redirect;

    public function __construct(Site $site, $post){
        $this->site = $site;

        //$this->session = &$session;
        //TODO: ensure no error is et in the session using unset
        $this->post = $post;

    }

    /**
     * Get the redirect location link
     * @return page directing to
     */
    public function getRedirect(){
        return $this->redirect;
    }




}