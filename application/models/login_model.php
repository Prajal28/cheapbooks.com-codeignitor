<?php 

/**
* 
*/
class Login_Model extends CI_Model
{
	
	public function getuser()
	{
		$data = $this->db->get('customers');
			return $data->result();
	}
}

 ?>