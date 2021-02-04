<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller 
{
	public function __construct()
	{
        parent::__construct();
        
        $level = $this->session->userdata('level'); 
        if ($level !== 'admin') 
        {
            redirect(base_url());
            return;
        }
    }
}