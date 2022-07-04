<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RFLController extends MY_Controller
{
    public $userData;
    public function __construct()
    {
        parent::__construct();           
    }

    protected function loadViewBack($view = NULL, $local_data = array(), $asData = FALSE)
    {
        if (!file_exists(APPPATH . "views/$view" . ".php")) {
            show_404();
        }

        $this->loadView("template/header", $local_data, $asData);
        $this->loadView("template/sidebar", $local_data, $asData);
        $this->loadView($view, $local_data, $asData);
        $this->loadView("template/footer", $local_data, $asData);
    }
}
