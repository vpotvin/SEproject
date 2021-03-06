<?php
/**
 * Controller takes information from User Settings page and updates user_data Model
 */

class Config extends CI_Controller {

	    public function __construct()
    {
        parent::__construct();
         $this->load->model('config_model');
         $this->load->library('session');
         $this->load->helper('url');
        //$this->load->model('contacts_model');
        //$this->load->model('group_model'); FOR SEND TO GROUP IF IMPLEMENTED
        //$this->load->library('session');
        //$this->load->library('email'); COMMENTED OUT FOR TEST LOAD CONFIG ARRAY HERE
        //$this->load->helper('form');
    }


    //Determines what to display when the user navigates to the index page
    public function index(){
        if(!$this->session->userdata('logged_in')) {
            redirect('/login/displayform/', 'location');
        } else{
            $data["logged_in"] = true;
        }

        $data['flashMessages'] = [];
        if($messages = $this->session->flashdata('flashMessages')){
            foreach ($messages as $message) {
                array_push($data['flashMessages'], array('message' => $message[0], 'CSS'=>$message[1]));
            }
        }else {
            $data['flashMessages'] = null;
        }




        $config = $this->config_model->get_config();
        $data['settings'] = $config[0];
        $this->load->view('_header', $data);
        $this->load->view('showConfig', $data);
        $this->load->view("_footer");
    }

    //Loads the the system settings view
    public function editConfig(){
        if(!$this->session->userdata('logged_in')) {
            redirect('/login/displayform/', 'location');
        } else{
            $data["logged_in"] = true;
        }


        $data['flashMessages'] = [];
        if($messages = $this->session->flashdata('flashMessages')){
            foreach ($messages as $message) {
                array_push($data['flashMessages'], array('message' => $message[0], 'CSS'=>$message[1]));
            }
        }else {
            $data['flashMessages'] = null;
        }
        $config = $this->config_model->get_config();
        $data['settings'] = $config[0];
        $this->load->view('_header', $data);
        $this->load->view('editConfig', $data);
        $this->load->view("_footer");

    }

    //Edits the user's Email Configuration
    public function editConfigProc(){
        if(!$this->session->userdata('logged_in')) {
            redirect('/login/displayform/', 'location');
        } else{
            $data["logged_in"] = true;
        }
        $server     = $this->input->post('smtpServer');
        $username   = $this->input->post("username");
        $password   = $this->input->post("password");
        $this->config_model->set_config($server, $username, $password);

        header("location: /config");
    }


}