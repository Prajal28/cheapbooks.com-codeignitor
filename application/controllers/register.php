<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* First page or login form 
	*/
	class Register extends CI_Controller
	{
		
		public function index()
		{
			# code...
			$this->load->view('header');
			$this->load->view('register_view');
			$this->load->view('footer');
		}

		public function login_validation()
		{
			$this->load->model('Login_model');
			$data = $this->Login_model->getuser();

			foreach ($data as $row) {
				if ($row->username == $this->input->post('username') && $row->password == md5($this->input->post('password'))){
					redirect('search');
				}else
				{
					$this->load->view('header');
					$this->load->view('invalid');
					$this->load->view('footer');
					
					}
				}
			}
		


}
	



 ?>