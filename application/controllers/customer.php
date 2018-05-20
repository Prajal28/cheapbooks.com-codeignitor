<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');

	/**
	* First page or login form 
	*/
	class Customer extends CI_Controller
	{
	
		
		public function index()
		{
			# code...
			$this->load->view('header');
			$this->load->view('customer_view');
			$this->load->view('footer');
		}

		public function login_validation()
		{
			$this->load->model('Login_model');
			$data = $this->Login_model->getuser();
			$flag = 0;
			
			foreach ($data as $row) {
				if ($row->username == $this->input->post('username') && $row->password == md5($this->input->post('password'))){
					$_SESSION['user_session'] = $row->username;
					redirect('Search');

					$flag = 0;
					break;
				}else
				{
					$flag = 1;
					
				}
				

			}

			if ($flag == 1){
					$this->load->view('header');
					$this->load->view('invalid');
					$this->load->view('footer');
					
				}
		


}
	


}
 ?>