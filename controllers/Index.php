<?php

class Index extends Controller {

    /**
     * Index constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     *  Show book view
     */
    public function index() {
        $this->view->render('book/book');
    }

}
?>