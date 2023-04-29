<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session');

        //get all users
        $this->data['users'] = $this->users_model->getAllUsers();
	}

	public function index(){
		$this->load->view('register', $this->data);
	}

	public function register(){
		$this->form_validation->set_rules('email', 'Email', 'valid_email|required');
       if ($this->form_validation->run() == FALSE) { 
         	$this->load->view('register', $this->data);
		}
		else{
			//get user inputs
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$mobile = $this->input->post('mobile');
			$this->session->set_flashdata('response',"Verification mail has been sent to your email address. Please verify your account.");

			//simple random code generate
			$set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$code = substr(str_shuffle($set), 0, 12);

			//insert user to users table and get id
			$user['name'] = $name;
			$user['email'] = $email;
			$user['mobile'] = $mobile;
			$user['code'] = $code;
			$user['verification'] = false;
			$id = $this->users_model->insert($user);

			$config = Array(
				'protocol' => 'smtp',
				'smtp_host' => 'ssl://smtp.googlemail.com',
				'smtp_port' => 465,
				'smtp_user' => 'shivisingh2312@gmail.com', // change it to yours
				'smtp_pass' => 'agjwzruuzpavmqxz', // change it to yours
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			  );		  

			$message = 	"
						<html>
						<head>
							<title>Verification Code</title>
						</head>
						<body>
							<h2>Thank you ".$name." for Registering.</h2>
							<p>Please take a look at your account details:</p>
							<p>Name: ".$name."</p>
							<p>Email: ".$email."</p>
							<p>Mobile: ".$mobile."</p>
							<p>Please click the link below to verify your account.</p>
							<h4><a href='".base_url()."user/verify/".$id."/".$code."'>Verify My Account</a></h4>
						</body>
						</html>
						";
	 				
					$this->load->library('email', $config);
					$this->email->set_newline("\r\n");
					$this->email->from('shivisingh2312@gmail.com'); // change it to yours
					$this->email->to($email);// change it to yours
					$this->email->subject('User email verification');
					$this->email->message($message);
					if($this->email->send())
				   {
					echo 'Email sent.';
				   }
				   else
				  {
				   show_error($this->email->print_debugger());
				  }
        	redirect('register');
		}

	}

	public function verify(){
		$id =  $this->uri->segment(3);
		$code = $this->uri->segment(4);

		//fetch user details
		$user = $this->users_model->getUser($id);

		//if code matches
		if($user['code'] == $code){
			//update user verification status
			$data['verification'] = true;
			$query = $this->users_model->verify($data, $id);

			if($query){
				$this->session->set_flashdata('message', 'User verified successfully');
			}
			else{
				$this->session->set_flashdata('message', 'Something went wrong in activating account');
			}
		}
		else{
			$this->session->set_flashdata('message', 'Cannot verify account. Code didnt match');
		}

		redirect('register');

	}

}
