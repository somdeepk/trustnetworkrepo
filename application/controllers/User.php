<?php 
class User extends CI_Controller
{
	public function signup()
	{
		if($this->session->userdata('login'))
		{
			redirect('user/index');
		}

		$all_church_data = $this->User_Model->get_all_approve_church();

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
				$userLoginData['user_auto_id']=$userLoginData['id'];
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

		$ary_cockie['trust_member_remember_me'] = $_COOKIE["trust_member_remember_me"];
		$jsonCookieRememberMe = json_encode($ary_cockie);
		$data['jsonCookieRememberMe'] = $jsonCookieRememberMe;

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
		$remember_me = (isset($aryLoginData['remember_me']) && !empty($aryLoginData['remember_me']))? $aryLoginData['remember_me']:false;
		$encrypt_password = $password;

		if(!empty(trim($email)) && !empty(trim($password)))
		{
			$userLoginData = $this->User_Model->ajaxcheckuserlogin($email, $encrypt_password);

			if(count($userLoginData))
			{			 	
			 	$userLoginData['login']=true;
			 	$userLoginData['user_auto_id']=$userLoginData['id'];
			 	$userLoginData['user_email']=$userLoginData['user_email'];
			 	$userLoginData['email']=$userLoginData['user_email'];

			 	$this->session->set_userdata($userLoginData);

			 	// Start Remember Me block
			 	if($remember_me){
					setcookie("trust_member_remember_me",$userLoginData['email'],time()+ (10 * 365 * 24 * 60 * 60));
				}else{
					if(isset($_COOKIE["trust_member_remember_me"])){
						setcookie ("trust_member_remember_me","");
					}
				}
				// END Remember Me block


			 	
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

	public function get_member_data() 
    {
    	$id=$this->input->get_post('id');
		$memberData = $this->User_Model->get_member_data($id);

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('memberData'=>$memberData);
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxupdateeditprofile() 
    {
        $memberData = trim($this->input->post('memberData'));
        $aryMemberData=json_decode($memberData, true);

        $id=(isset($aryMemberData['id']) && !empty($aryMemberData['id']))? addslashes(trim($aryMemberData['id'])):0;
        $membership_type=(isset($aryMemberData['membership_type']) && !empty($aryMemberData['membership_type']))? addslashes(trim($aryMemberData['membership_type'])):'';

        $first_name=(isset($aryMemberData['first_name']) && !empty($aryMemberData['first_name']))? addslashes(trim($aryMemberData['first_name'])):'';

        $last_name=(isset($aryMemberData['last_name']) && !empty($aryMemberData['last_name']))? addslashes(trim($aryMemberData['last_name'])):'';

        $type=(isset($aryMemberData['type']) && !empty($aryMemberData['type']))? addslashes(trim($aryMemberData['type'])):'';

        $church_name=(isset($aryMemberData['church_name']) && !empty($aryMemberData['church_name']))? addslashes(trim($aryMemberData['church_name'])):'';
        $gender=(isset($aryMemberData['gender']) && !empty($aryMemberData['gender']))? addslashes(trim($aryMemberData['gender'])):'';
        $marital_status=(isset($aryMemberData['marital_status']) && !empty($aryMemberData['marital_status']))? addslashes(trim($aryMemberData['marital_status'])):'';
     
        $dob=(isset($aryMemberData['dob']) && !empty($aryMemberData['dob']))? date('Y-m-d',strtotime($aryMemberData['dob'])) :NULL;
       	$trustee_board=(isset($aryMemberData['trustee_board']) && !empty($aryMemberData['trustee_board']))? addslashes(trim($aryMemberData['trustee_board'])):'';

        $address=(isset($aryMemberData['address']) && !empty($aryMemberData['address']))? addslashes(trim($aryMemberData['address'])):'';
        $city=(isset($aryMemberData['city']) && !empty($aryMemberData['city']))? addslashes(trim($aryMemberData['city'])):'';
        $country=(isset($aryMemberData['country']) && !empty($aryMemberData['country']))? addslashes(trim($aryMemberData['country'])):0;
        $state=(isset($aryMemberData['state']) && !empty($aryMemberData['state']))? addslashes(trim($aryMemberData['state'])):0;
        $postal_code=(isset($aryMemberData['postal_code']) && !empty($aryMemberData['postal_code']))? addslashes(trim($aryMemberData['postal_code'])):'';
		
		$current_date=date('Y-m-d H:i:s');   

        if($membership_type=="CM")
		{
			$first_name=$church_name;
		}
/*
		echo IMAGE_PATH;
		exit;*/

       	$menu_arr = array(
            'first_name' => $first_name,
            'last_name'  =>$last_name,
            'type'  =>$type,
            'trustee_board'  =>$trustee_board,
            'gender'  =>$gender,
            'marital_status'  =>$marital_status,
            'dob'  =>$dob,
            'address'  =>$address,
            'city'  =>$city,
            'country'  =>$country,
            'state'  =>$state,
            'postal_code'  =>$postal_code,
            'update_date'  =>$current_date,
        );

        if (!empty($_FILES['file']['name']))
        {
            $profilepic = json_encode($_FILES);
        } else {
            $profilepic = "";
        }

        $imagename="";
        if(!empty($profilepic))
        {
            $profilepic=json_decode($profilepic);
            $this->load->library('upload');
            $filename=$profilepic->file->name[0];
            $imarr=explode(".",$filename);
            $ext=end($imarr);
          
            if($ext=="jpg" or $ext=="jpeg" or $ext=="png" or $ext=="gif" or $ext=="bmp" or $ext=="tiff" or $ext=="exif")
            {
                $_FILES['file']['name']=$profilepic->file->name[0];
                $_FILES['file']['type']=$profilepic->file->type[0];
                $_FILES['file']['tmp_name']=$profilepic->file->tmp_name[0];
                $_FILES['file']['error']=$profilepic->file->error[0];
                $_FILES['file']['size']=$profilepic->file->size[0];

                $config = array(
                    'file_name' => str_replace(".","",microtime(true)).".".$ext,
                    'allowed_types' => '*',
                    'upload_path' => IMAGE_PATH.'images/members',
                    'max_size' => 2000
                );

                $this->upload->initialize($config);
                
                if (!$this->upload->do_upload('file'))
                {
                    $errormsg=$this->upload->display_errors();
                    $arr=array('error'=>1,'success'=>'','errormsg'=>strip_tags($errormsg));
                }
                else
                {
                    $image_data = $this->upload->data();
                    $imagename=$image_data['file_name'];
                }
                $menu_arr['profile_image']=$imagename;
            }
        }

       /* echo FCPATH.$ext.$filename."<pre>";
		print_r($profilepic);
		exit;*/


        $strstatus="Updated";

        $lastId = $this->User_Model->addupdatemember($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Member '.$strstatus.' Successfully.');
        $returnData['data']=array('id'=>$lastId);

        echo json_encode($returnData);
        exit;    	
    }



    public function ajaxupdatecontactinfo() 
    {
        $memberData = trim($this->input->post('memberData'));
        $aryMemberData=json_decode($memberData, true);

        $id=(isset($aryMemberData['id']) && !empty($aryMemberData['id']))? addslashes(trim($aryMemberData['id'])):0;
        $membership_type=(isset($aryMemberData['membership_type']) && !empty($aryMemberData['membership_type']))? addslashes(trim($aryMemberData['membership_type'])):'';

        $contact_person=(isset($aryMemberData['contact_person']) && !empty($aryMemberData['contact_person']))? addslashes(trim($aryMemberData['contact_person'])):'';
        $contact_mobile=(isset($aryMemberData['contact_mobile']) && !empty($aryMemberData['contact_mobile']))? addslashes(trim($aryMemberData['contact_mobile'])):'';
        $contact_alt_mobile=(isset($aryMemberData['contact_alt_mobile']) && !empty($aryMemberData['contact_alt_mobile']))? addslashes(trim($aryMemberData['contact_alt_mobile'])):'';
        $alt_email=(isset($aryMemberData['alt_email']) && !empty($aryMemberData['alt_email']))? addslashes(trim($aryMemberData['alt_email'])):'';
        $website=(isset($aryMemberData['website']) && !empty($aryMemberData['website']))? addslashes(trim($aryMemberData['website'])):'';

       	$menu_arr = array(
            'contact_person' => $contact_person,
            'contact_mobile'  =>$contact_mobile,
            'contact_alt_mobile'  =>$contact_alt_mobile,
            'alt_email'  =>$alt_email,
            'website'  =>$website,
        );

        
        $strstatus="Updated";

        $lastId = $this->User_Model->addupdatemember($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Contact '.$strstatus.' Successfully.');
        $returnData['data']=array('id'=>$lastId);

        echo json_encode($returnData);
        exit;    	
    }

    public function ajaxupdatenotification() 
    {
        $memberData = trim($this->input->post('memberData'));
        $aryMemberData=json_decode($memberData, true);

       /* echo "<pre>";
        print_r($aryMemberData);
        exit;*/

        $id=(isset($aryMemberData['id']) && !empty($aryMemberData['id']))? addslashes(trim($aryMemberData['id'])):0;
   
        $ary_notify['email_notify']=(isset($aryMemberData['email_notify']) && !empty($aryMemberData['email_notify']))? $aryMemberData['email_notify']:false;
        $ary_notify['sms_notify']=(isset($aryMemberData['sms_notify']) && !empty($aryMemberData['sms_notify']))? $aryMemberData['sms_notify']:false;
        $ary_notify['email_on_new_notify']=(isset($aryMemberData['email_on_new_notify']) && !empty($aryMemberData['email_on_new_notify']))? $aryMemberData['email_on_new_notify']:false;
        $ary_notify['email_on_direcr_msg']=(isset($aryMemberData['email_on_direcr_msg']) && !empty($aryMemberData['email_on_direcr_msg']))? $aryMemberData['email_on_direcr_msg']:false;
        $ary_notify['email_on_add_cnction']=(isset($aryMemberData['email_on_add_cnction']) && !empty($aryMemberData['email_on_add_cnction']))? $aryMemberData['email_on_add_cnction']:false;
        $ary_notify['escalate_email_on_new_order']=(isset($aryMemberData['escalate_email_on_new_order']) && !empty($aryMemberData['escalate_email_on_new_order']))? $aryMemberData['escalate_email_on_new_order']:false;
        $ary_notify['escalate_email_on_new_member_approval']=(isset($aryMemberData['escalate_email_on_new_member_approval']) && !empty($aryMemberData['escalate_email_on_new_member_approval']))? $aryMemberData['escalate_email_on_new_member_approval']:false;

        $ary_notify['escalate_email_on_member_registration']=(isset($aryMemberData['escalate_email_on_member_registration']) && !empty($aryMemberData['escalate_email_on_member_registration']))? $aryMemberData['escalate_email_on_member_registration']:false;

       	$menu_arr = array(
            'notification_data' => json_encode($ary_notify),
        );

        
        $strstatus="Updated";

        $lastId = $this->User_Model->addupdatemember($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Notification '.$strstatus.' Successfully.');
        $returnData['data']=array('id'=>$lastId);

        echo json_encode($returnData);
        exit;    	
    }

    public function ajaxupdatechangepassword() 
    {
    	$returnData=array();
        $memberData = trim($this->input->post('memberData'));
        $aryMemberData=json_decode($memberData, true);

        $id=(isset($aryMemberData['id']) && !empty($aryMemberData['id']))? addslashes(trim($aryMemberData['id'])):0;
        $current_password=(isset($aryMemberData['current_password']) && !empty($aryMemberData['current_password']))? addslashes(trim($aryMemberData['current_password'])):'';
       	$encrypt_password = $current_password;

        $new_password=(isset($aryMemberData['new_password']) && !empty($aryMemberData['new_password']))? addslashes(trim($aryMemberData['new_password'])):'';

        $verify_password=(isset($aryMemberData['verify_password']) && !empty($aryMemberData['verify_password']))? addslashes(trim($aryMemberData['verify_password'])):'';

        $flagPasswordCheck = $this->User_Model->check_current_password($id,$encrypt_password);

            
		if($flagPasswordCheck==0)
		{
			$returnData['status']='2';
			$returnData['msg']='old_password_doesnt_match';
			$returnData['msgstring']='Old Password doesnt match!';
			$returnData['data']=array();
		}
		else
		{
			$menu_arr = array(
	            'password' => $new_password
	        );

			$lastId = $this->User_Model->addupdatemember($id,$menu_arr);

			if($lastId>0)
			{
		        $returnData['status']='1';
		        $returnData['msg']='success';
		        $returnData['msgstring']='Password Changed Successfully';
		        $returnData['data']=array();
			}
			else
			{
				$returnData['status']='0';
		        $returnData['msg']='error';
		        $returnData['msgstring']='Password Changed Failed';
		        $returnData['data']=array();
			}
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


	public function profileedit()
	{
		$data=array();

		$msg=$this->input->post_get('msg');
		if(!empty($msg))
		{
			$msg=base64_decode($msg);
			$this->session->set_flashdata('success', $msg);
		}
		//$data['member_id']=$member_id;

		$churchTypeData = $this->User_Model->get_church_type();

		$user_auto_id=$this->session->userdata('user_auto_id');
		$memberData = $this->User_Model->get_member_data($user_auto_id);
		$jsonMemberData = json_encode($memberData);

		/*echo "ss<pre>";
		print_r($memberData);
		exit;*/

		$data['churchTypeData'] = $churchTypeData;
		$data['jsonMemberData'] = $jsonMemberData;

		$this->load->view('user/header-script');
		$this->load->view('user/header-bottom');
		$this->load->view('user/profileedit', $data);
		$this->load->view('user/footer-top');
		$this->load->view('user/footer');
	}
	
    public function getcountrydata() 
    {
		$countryData = $this->User_Model->getcountrydata();
		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('countryData'=>$countryData);
       
        echo json_encode($returnData);
        exit;
    }

    public function getstatedata() 
    {
    	$countryId=$this->input->get_post('countryId');
		$stateData = $this->User_Model->getstatedata($countryId);

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
		$cityData = $this->User_Model->getcitydata($stateId);

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('cityData'=>$cityData);
       
        echo json_encode($returnData);
        exit;
    }

}
	




