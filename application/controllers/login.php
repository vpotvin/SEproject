<?php
class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('session');
		$this->load->helper('url');
	}

	public function displayform() {
 		$data['flashMessages'] = [];
		if($messages = $this->session->flashdata('flashMessages')){
			foreach ($messages as $message) {
				array_push($data['flashMessages'], array('message' => $message[0], 'CSS'=>$message[1]));
			}
		}else {
			$data['flashMessages'] = null;
		}

		$this->load->view('_header', $data);
		$this->load->view('loginForm');
		$this->load->view("_footer");
	}

	public function processLogin(){
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		$login_result = $this->user_model->login($username, $password);
		if($login_result){

			$sess_array = array(
         		'uid' => $login_result[0]->uid,
         		'username' => $login_result[0]->username
       		);

       		$this->session->set_userdata('logged_in', $sess_array);

       		$fMessages = array(
				array('Successful Login', 'success')
			);

			$this->session->set_flashdata('flashMessages', $fMessages);

       		// CHANGE TO REDIRECT TO HOME, THEN PREVIEOUS PAGE
       		redirect('/contacts/listcontacts/', 'refresh');


		} else {
			$fMessages = array(
				array('Incorrect Credentials', 'danger')
			);

			$this->session->set_flashdata('flashMessages', $fMessages);
			redirect('/login/displayform/', 'refresh');
		}
	}


	public function logout() {
		$this->session->unset_userdata('logged_in');

		$fMessages = array(
			array('Successful Logout', 'success')
		);

		$this->session->set_flashdata('flashMessages', $fMessages);

		redirect('/contacts/listcontacts/', 'refresh');
	}



}
?>