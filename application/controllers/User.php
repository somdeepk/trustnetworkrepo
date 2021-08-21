<?php 
class User extends CI_Controller
{
	public function signup()
	{
		if($this->session->userdata('login'))
		{
			redirect('user/index');
		}

		$all_church_data = $this->User_Model->get_all_church();

		$data['all_church_data'] = $all_church_data;
		$data['title'] = ucfirst($page);
		$this->load->view('user/header-script');
		$this->load->view('user/signup', $data);
		$this->load->view('user/footer');
	}

	public function ajaxsubmitsignup() 
    {
    	$returnData=array();
        $signupData = trim($this->input->post('signupData'));
        $aryMemberData=json_decode($signupData, true);

        $membership_type=(isset($aryMemberData['membership_type']) && !empty($aryMemberData['membership_type']))? addslashes(trim($aryMemberData['membership_type'])):'';

        $church_id=(isset($aryMemberData['church_id']) && !empty($aryMemberData['church_id']))? addslashes(trim($aryMemberData['church_id'])):0;

       
        $church_name=(isset($aryMemberData['church_name']) && !empty($aryMemberData['church_name']))? addslashes(trim($aryMemberData['church_name'])):'';

        $first_name=(isset($aryMemberData['first_name']) && !empty($aryMemberData['first_name']))? addslashes(trim($aryMemberData['first_name'])):'';

        $last_name=(isset($aryMemberData['last_name']) && !empty($aryMemberData['last_name']))? addslashes(trim($aryMemberData['last_name'])):'';
        $gender=(isset($aryMemberData['gender']) && !empty($aryMemberData['gender']))? addslashes(trim($aryMemberData['gender'])):'';

        $user_email=(isset($aryMemberData['user_email']) && !empty($aryMemberData['user_email']))? addslashes(trim($aryMemberData['user_email'])):'';
        $password=(isset($aryMemberData['password']) && !empty($aryMemberData['password']))? addslashes(trim($aryMemberData['password'])):'';     
		$current_date=date('Y-m-d H:i:s');

		if($membership_type=="CM")
		{
			$first_name=$church_name;
		}

        $flagDupEmail = $this->User_Model->check_dup_email($user_email);
     
		if($flagDupEmail==1)
		{
			$returnData['status']='2';
			$returnData['msg']='email_aleady_exist';
			$returnData['msgstring']='This Email already Exist';
			$returnData['data']=array();
		}
		else
		{
			$menu_arr = array(
	            'first_name' => $first_name,
	            'last_name'  =>$last_name,
	            'parent_id'  =>$church_id,
	            'gender'  =>$gender,
	            'marital_status'  =>'',
	            'membership_type'  =>$membership_type,
	            'church_id'  =>$church_id,
	            'user_email'  =>$user_email,
	            'password'  =>$password,
	            'is_approved'  =>'N',
	            'create_date'  =>$current_date,
	        );

			$lastId = $this->User_Model->addupdatemember($id,$menu_arr);

			if($lastId>0)
			{
				$userLoginData = $this->User_Model->ajaxcheckuserlogin($email, $encrypt_password);

				$userLoginData['login']=true;
			 	$userLoginData['user_email']=$user_email;
			 	$userLoginData['email']=$user_email;
				$this->session->set_userdata($userLoginData);

		        $returnData['status']='1';
		        $returnData['msg']='success';
		        $returnData['msgstring']='Register Successfully';
		        $returnData['data']=array('userLoginData'=>$userLoginData);
			}
			else
			{
				$returnData['status']='0';
		        $returnData['msg']='error';
		        $returnData['msgstring']='Register Failed';
		        $returnData['data']=array();
			}
		}

        echo json_encode($returnData);
        exit;    	
    }

	public function login()
	{
		if($this->session->userdata('login'))
		{
			redirect('user/index');
		}

		if (!file_exists(APPPATH.'views/user/login.php'))
		{
			show_404();
		}
		$data['title'] = ucfirst($page);
		$this->load->view('user/header-script');
		$this->load->view('user/login', $data);
		$this->load->view('user/footer');
	}

	public function ajaxcheckuserlogin()
	{
		$returnData=array();

		$loginData = trim($this->input->post('loginData'));
        $aryLoginData=json_decode($loginData, true);

		$email = $aryLoginData['email'];
		$password = $aryLoginData['password'];
		$encrypt_password = $password;

		if(!empty(trim($email)) && !empty(trim($password)))
		{
			$userLoginData = $this->User_Model->ajaxcheckuserlogin($email, $encrypt_password);

			if(count($userLoginData))
			{			 	
			 	$userLoginData['login']=true;
			 	$userLoginData['user_email']=$userLoginData['user_email'];
			 	$userLoginData['email']=$userLoginData['user_email'];

			 	$this->session->set_userdata($userLoginData);
			 	
			 	$returnData['status']='1';
				$returnData['msg']='success';
				$returnData['data']=array('userLoginData'=>$userLoginData);
			}
			else
			{
				$returnData['status']='0';
				$returnData['msg']='Login Credential in invalid!';
				$returnData['data']=array();
			}
		}
		else
		{
			$returnData['status']='0';
			$returnData['msg']='Email or Password is not found!';
			$returnData['data']=array();
		}
       
        echo json_encode($returnData);
        exit;	

	}

	// log admin out
	public function logout(){
		// unset user data
		$this->session->unset_userdata('login');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('role_id');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('image');
		$this->session->unset_userdata('site_logo');

		//Set Message
		$this->session->set_flashdata('success', 'You are logged out.');
		redirect(base_url().'user/login');
	}

	public function forget_password($page = 'forget-password')
	{
		if (!file_exists(APPPATH.'views/user/'.$page.'.php')) {
			show_404();
		}
		$data['title'] = ucfirst($page);
		$this->load->view('user/header-script');
		$this->load->view('user/'.$page, $data);
		$this->load->view('user/footer');
	}

	public function index($church_id = 0)
	{
		$data=array();

		$msg=$this->input->post_get('msg');
		if(!empty($msg))
		{
			$msg=base64_decode($msg);
			$this->session->set_flashdata('success', $msg);
		}
		$data['church_id']=$church_id;
		$this->load->view('user/header-script');
		$this->load->view('user/header-bottom');
		$this->load->view('user/index', $data);
		$this->load->view('user/footer-top');
		$this->load->view('user/footer');
	}


	public function profileedit($member_id = 0)
	{
		$data=array();

		$msg=$this->input->post_get('msg');
		if(!empty($msg))
		{
			$msg=base64_decode($msg);
			$this->session->set_flashdata('success', $msg);
		}

		$data['member_id']=$member_id;
		$this->load->view('user/header-script');
		$this->load->view('user/header-bottom');
		$this->load->view('user/profileedit', $data);
		$this->load->view('user/footer-top');
		$this->load->view('user/footer');
	}
	
    public function getstatedata() 
    {
    	$countryId=$this->input->get_post('countryId');
		$stateData = $this->user_Model->getstatedata($countryId);

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('stateData'=>$stateData);
       
        echo json_encode($returnData);
        exit;
    }

    public function getcitydata() 
    {
    	$stateId=$this->input->get_post('stateId');
		$cityData = $this->user_Model->getcitydata($stateId);

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('cityData'=>$cityData);
       
        echo json_encode($returnData);
        exit;
    }

}
	




