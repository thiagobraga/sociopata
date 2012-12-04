<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{

	/**
	 * Carrega a página inicial do site
     * @since 1.0
	 */
	public function index()
	{
		$data = new stdClass();
		$data->css = array('mods/home');
		$data->js = array('plugins/stratus/stratus', 'mods/home');
		$data->content = 'home';

		$this->load->view('base', $data);
	}

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */