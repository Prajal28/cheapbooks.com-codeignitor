<?php 
/**
* 
*/
class Search extends CI_Controller
{
	
	public function index()
	{
		$this->load->view('search_header_view');
		$this->load->view('search_view');
		$this->load->view('footer');
	}
}



 ?>