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
        $dob=(isset($aryMemberData['dob']) && !empty($aryMemberData['dob']))? date('Y-m-d',strtotime($aryMemberData['dob'])) :NULL;

        $user_email=(isset($aryMemberData['user_email']) && !empty($aryMemberData['user_email']))? addslashes(trim($aryMemberData['user_email'])):'';
        $password=(isset($aryMemberData['password']) && !empty($aryMemberData['password']))? addslashes(trim($aryMemberData['password'])):'';     
		$current_date=date('Y-m-d H:i:s');

		$str_is_approved='Y';
		if($membership_type=="CM")
		{
			$first_name=$church_name;
		}
		elseif($membership_type=="CC")
		{
			$str_is_approved='N';
			$church_id=1;//City Church
			$membership_type='RM';
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
	            'dob'  =>$dob,
	            'membership_type'  =>$membership_type,
	            //'church_id'  =>$church_id,
	            'user_email'  =>$user_email,
	            'password'  =>$password,
	            'is_approved'  =>$str_is_approved,
	            'create_date'  =>$current_date,
	        );

			$lastId = $this->User_Model->addupdatemember(0,$menu_arr);
			$parent_leader_id=$this->User_Model->assign_under_group_admin($lastId);

			if($lastId>0)
			{
				$userLoginData = $this->User_Model->get_member_data($lastId);

				$userLoginData['login']=true;
				$userLoginData['user_auto_id']=$userLoginData['id'];
				$userLoginData['parent_leader_id']=$parent_leader_id;
			 	$userLoginData['user_email']=$userLoginData['user_email'];
			 	$userLoginData['user_full_name']=$userLoginData['first_name']." ".$userLoginData['last_name'];
			 	$userLoginData['email']=$userLoginData['user_email'];
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
		$aryRequestUri=explode("/",$_SERVER['REQUEST_URI']);

		if($this->session->userdata('login'))
		{
			redirect('user/index');
		}
		elseif(!in_array('login', $aryRequestUri))
		{
			redirect('user/login');
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
				$parent_leader_id=$this->User_Model->assign_under_group_admin($userLoginData['id']);
				$memberLevelStandardData=$this->User_Model->get_member_level_standard($userLoginData['id']);

			 	$userLoginData['login']=true;
			 	$userLoginData['user_auto_id']=$userLoginData['id'];
			 	$userLoginData['parent_leader_id']=$parent_leader_id;
			 	$userLoginData['user_email']=$userLoginData['user_email'];
			 	$userLoginData['user_full_name']=$userLoginData['first_name']." ".$userLoginData['last_name'];
			 	
			 	$userLoginData['email']=$userLoginData['user_email'];
			 	$userLoginData['maxmemberlevel']=$memberLevelStandardData['maxmemberlevel'];
			 	$userLoginData['coursename']=$memberLevelStandardData['coursename'];
			 	$userLoginData['totbadge']=$memberLevelStandardData['totbadge'];
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


	


	/*public function get_member_data() 
    {
    	$id=$this->input->get_post('id');
		$memberData = $this->User_Model->get_member_data($id);

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('memberData'=>$memberData);
       
        echo json_encode($returnData);
        exit;
    }*/

	public function ajaxgetPeopleYouMayNowData() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);

    	/*echo "<pre>";
		print_r($aryFriendData);
        exit;*/

        $user_auto_id=(isset($aryFriendData['user_auto_id']) && !empty($aryFriendData['user_auto_id']))? addslashes(trim($aryFriendData['user_auto_id'])):0;
        $clickProfileTab=(isset($aryFriendData['clickProfileTab']) && !empty($aryFriendData['clickProfileTab']))? addslashes(trim($aryFriendData['clickProfileTab'])):'';

		$friendData = $this->User_Model->ajaxgetPeopleYouMayNowData($user_auto_id,$clickProfileTab);

		/*echo "<pre>";
		print_r($friendData);
        exit;*/

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('friendData'=>$friendData);
       
        echo json_encode($returnData);
        exit;
    }

	public function ajaxGetAllFriendRequest() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);

        $user_auto_id=(isset($aryFriendData['user_auto_id']) && !empty($aryFriendData['user_auto_id']))? addslashes(trim($aryFriendData['user_auto_id'])):0;
        $clickProfileTab=(isset($aryFriendData['clickProfileTab']) && !empty($aryFriendData['clickProfileTab']))? addslashes(trim($aryFriendData['clickProfileTab'])):'';

		$friendData = $this->User_Model->ajaxGetAllFriendRequest($user_auto_id,$clickProfileTab);

		/*echo "<pre>";
		print_r($aryFriendData);
        exit;*/

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('friendData'=>$friendData);
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxGetAllFriendList() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);

        $user_auto_id=(isset($aryFriendData['user_auto_id']) && !empty($aryFriendData['user_auto_id']))? addslashes(trim($aryFriendData['user_auto_id'])):0;
        $clickProfileTab=(isset($aryFriendData['clickProfileTab']) && !empty($aryFriendData['clickProfileTab']))? addslashes(trim($aryFriendData['clickProfileTab'])):'';

        $searchFriend=(isset($aryFriendData['searchFriend']) && !empty($aryFriendData['searchFriend']))? addslashes(trim($aryFriendData['searchFriend'])):'';
        $limit=(isset($aryFriendData['limit']) && !empty($aryFriendData['limit']))? addslashes(trim($aryFriendData['limit'])):'';

        $aryArgument['searchFriend']=$searchFriend;
        $aryArgument['limit']=$limit;
        
		$friendListData = $this->User_Model->ajaxGetAllFriendList($user_auto_id,$clickProfileTab,$aryArgument);

		/*echo "ss<pre>";
		print_r($friendListData);
        exit;*/

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('friendListData'=>$friendListData);
       
        echo json_encode($returnData);
        exit;
    }
    public function ajaxGetAllChurchMember() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
		$churchMemberListData = $this->User_Model->ajaxGetAllChurchMember($aryFriendData);
		$allAgeGroupData = $this->User_Model->get_all_age_group_data(0);

		/*echo "ss<pre>";
		print_r($churchMemberListData);
        exit;*/

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('churchMemberListData'=>$churchMemberListData,'allAgeGroupData'=>$allAgeGroupData);
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxSendFriendRequest() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
    	$aryFriendData['tn_member_friends']=0;
        
        //$member_friends_aid=(isset($aryFriendData['member_friends_aid']) && !empty($aryFriendData['member_friends_aid']))? addslashes(trim($aryFriendData['member_friends_aid'])):0;
		$user_auto_id=(isset($aryFriendData['user_auto_id']) && !empty($aryFriendData['user_auto_id']))? addslashes(trim($aryFriendData['user_auto_id'])):0;
        $friend_id=(isset($aryFriendData['friend_id']) && !empty($aryFriendData['friend_id']))? addslashes(trim($aryFriendData['friend_id'])):0;
        $current_date=date('Y-m-d H:i:s');

        $menu_arr = array(
            'member_id' => $user_auto_id,
            'friend_id'  =>$friend_id,
            'request_status'  =>'1', //Requser Send
            'request_date'  =>$current_date
        );

		$member_friends_aid = $this->User_Model->ajaxAddUpdateMemberFriends($menu_arr);

		$returnData=array();
 		if($member_friends_aid>0)
		{
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Request Send';
	        $returnData['data']=array('member_friends_aid'=>$member_friends_aid);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Request Send Failed';
	        $returnData['data']=array();
		}
       
        echo json_encode($returnData);
        exit;
    }

    public function toggleChurchAdmin() 
    {
    	$returnData=array();

    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
  
  		$user_auto_id=(isset($aryFriendData['user_auto_id']) && !empty($aryFriendData['user_auto_id']))? addslashes(trim($aryFriendData['user_auto_id'])):0;
		$adminid=(isset($aryFriendData['adminid']) && !empty($aryFriendData['adminid']))? addslashes(trim($aryFriendData['adminid'])):0;
		$strAdmin=(isset($aryFriendData['strAdmin']) && !empty($aryFriendData['strAdmin']))? addslashes(trim($aryFriendData['strAdmin'])):'N';
		$agegroup_id=(isset($aryFriendData['agegroup_id']) && !empty($aryFriendData['agegroup_id']))? addslashes(trim($aryFriendData['agegroup_id'])):'N';
        $current_date=date('Y-m-d H:i:s');

        $flagAdminExist = $this->User_Model->check_age_group_admin_exist($user_auto_id,$adminid,$agegroup_id);

		if($flagAdminExist==1)
		{
			$returnData['status']='2';
			$returnData['msg']='admin_aleady_exist';
			$returnData['msgstring']='Leader already Exist Of This Age Group';
			$returnData['data']=array();
		}
		else
		{
			$menu_arr = array(
	            'agegroup_id'  =>$agegroup_id,
	            'admin_id'  =>0,
	            'is_admin'  =>$strAdmin,
	            'admin_create_date'  =>$current_date
	        );

			$lastId = $this->User_Model->addupdatemember($adminid,$menu_arr);
		
			if($strAdmin=='Y')
			{
				$ary_member_under_group=$this->User_Model->get_abandon_member_under_church($user_auto_id);
				if(count($ary_member_under_group)>0)
				{
					foreach($ary_member_under_group as $k=>$v)
					{
						$parent_leader_id=$this->User_Model->assign_under_group_admin($v['id']);
					}
				}			
			}
			elseif($strAdmin=='N')
			{
				$ary_member_under_group=$this->User_Model->remove_member_from_group_admin($adminid,$user_auto_id);
			}

	 		if($lastId>0)
			{
		        $returnData['status']='1';
		        $returnData['msg']='success';
		        $returnData['msgstring']='Leader Created Successfully';
		        $returnData['data']=array('userLoginData'=>$userLoginData);
			}
			else
			{
				$returnData['status']='0';
		        $returnData['msg']='error';
		        $returnData['msgstring']='Leader Creation Failed';
		        $returnData['data']=array();
			}
		}
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxRemoveFromSuggestion() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
    	$aryFriendData['tn_member_friends']=0;
        
		$user_auto_id=(isset($aryFriendData['user_auto_id']) && !empty($aryFriendData['user_auto_id']))? addslashes(trim($aryFriendData['user_auto_id'])):0;
        $friend_id=(isset($aryFriendData['friend_id']) && !empty($aryFriendData['friend_id']))? addslashes(trim($aryFriendData['friend_id'])):0;
        $current_date=date('Y-m-d H:i:s');

        $menu_arr = array(
            'member_id' => $user_auto_id,
            'friend_id'  =>$friend_id,
            'request_status'  =>'3', //Requser Send
            'remove_date'  =>$current_date
        );

		$member_friends_aid = $this->User_Model->ajaxAddUpdateMemberFriends($menu_arr);

		$returnData=array();
 		if($member_friends_aid>0)
		{
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Removed From Suggestion';
	        $returnData['data']=array('member_friends_aid'=>$member_friends_aid);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Removal Failed';
	        $returnData['data']=array();
		}
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxConfirmFriendRequest() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
    	$aryFriendData['tn_member_friends']=0;
        
		$member_friends_aid=(isset($aryFriendData['member_friends_aid']) && !empty($aryFriendData['member_friends_aid']))? addslashes(trim($aryFriendData['member_friends_aid'])):0;
        $current_date=date('Y-m-d H:i:s');

        $menu_arr = array(
            'request_status'  =>'2', //Requser Send
            'confirm_date'  =>$current_date
        );

		$member_friends_aid = $this->User_Model->ajaxConfirmDeleteFriendRequest($menu_arr,$member_friends_aid);

		$returnData=array();
 		if($member_friends_aid>0)
		{
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Added As Friend';
	        $returnData['data']=array('member_friends_aid'=>$member_friends_aid);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Confirmation Failed';
	        $returnData['data']=array();
		}
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxDeleteFromFriendRequest() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
    	$aryFriendData['tn_member_friends']=0;
        
		$member_friends_aid=(isset($aryFriendData['member_friends_aid']) && !empty($aryFriendData['member_friends_aid']))? addslashes(trim($aryFriendData['member_friends_aid'])):0;
        $current_date=date('Y-m-d H:i:s');

        $menu_arr = array(
            'request_status'  =>'4', //Requser Send
            'deletion_date'  =>$current_date
        );

		$member_friends_aid = $this->User_Model->ajaxConfirmDeleteFriendRequest($menu_arr,$member_friends_aid);

		$returnData=array();
 		if($member_friends_aid>0)
		{
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Request Deleted';
	        $returnData['data']=array('member_friends_aid'=>$member_friends_aid);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Deletion Failed';
	        $returnData['data']=array();
		}
       
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
        $hidden_image_encode=(isset($aryMemberData['hidden_image_encode']) && !empty($aryMemberData['hidden_image_encode']))? addslashes(trim($aryMemberData['hidden_image_encode'])):'';
        $profile_image=(isset($aryMemberData['profile_image']) && !empty($aryMemberData['profile_image']))? addslashes(trim($aryMemberData['profile_image'])):'';

  
		
		$current_date=date('Y-m-d H:i:s');   

        if($membership_type=="CM")
		{
			$first_name=$church_name;
		}

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

        /*if (!empty($_FILES['file']['name']))
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
        }*/

        $imagename='';
        if(!empty($hidden_image_encode))
        {
        	$hidden_image_encode=str_replace('colone', ';', $hidden_image_encode);
        	$hidden_image_encode=str_replace('comma', ',', $hidden_image_encode);        	
	        $image_array_1 = explode(";", $hidden_image_encode);
	        $image_array_2 = explode(",", $image_array_1[1]);

	        $imagebase64Data = base64_decode($image_array_2[1]);
	        $imagename = time().'.png';

			$image_name_with_path = IMAGE_PATH.'images/members/'.$imagename;
			file_put_contents($image_name_with_path, $imagebase64Data);

			$menu_arr['profile_image']=$imagename;
			$this->session->set_userdata('profile_image',$imagename);


			//Start tracking all Images uploaded by Member
			$menu_arr_post_file = array(
	            'module_id'=>$id,
	            'module_type'=>'members',
	            'member_id'   =>$id,
	            'file_original_name'=>$imagename,
	            'file_name'   =>$imagename,
	            'file_size'   =>'0',        
	            'file_type'   =>'image/png',       
	            'create_date'   =>$current_date       
	        );
			$this->Post_Model->addUpdatPostFile(0,$menu_arr_post_file);
			//End tracking all Images uploaded by Member

			//unlink( IMAGE_PATH.'images/members/'.$profile_image); // correct
		}

        $strstatus="Updated";

        $lastId = $this->User_Model->addupdatemember($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Member '.$strstatus.' Successfully.');
        $returnData['data']=array('id'=>$lastId,'imagename'=>$imagename);

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
	public function logout()
	{
		// unset user data
		$this->session->unset_userdata('login');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('user_auto_id');
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

	function get_next_date($starttime, $interval, $time_frame) {

	   // $now = time();

	    $now=date("Y-m-d",time());
		$now=strtotime($now);

	    //based on the timeframe get the amount since the $startdate
	    switch ($time_frame) {
	        case 'year':
	            $count = date('Y', $now)-date('Y', $starttime);
	            break;
	        case 'month':
	            $count = abs((date('Y', $now) - date('Y', $starttime))*12 + (date('m', $now) - date('m', $starttime)));
	            break;
	        case 'week':
	            $count = floor((abs($now - $starttime)/86400)/7);
	            break;
	        case 'day':
	            $count = floor(abs($now - $starttime)/86400);
	            break;

	        default:
	            //if you have other time frames you should add them here
	            $count = $interval;
	            break;
	    }

	    //how often the interval should get multipled
	    $times = ceil($count/$interval);

	    //get the next date by counting from the starting date up until $now with the calculated interval
	    $nextdate = strtotime(date('d-M-Y', $starttime)." +".($interval*$times)." {$time_frame}");

	    //date is maybe in the past (but in the same year, month or week)
	    if($nextdate - $now < 0){
	        //add an additional interval to the expression
	        $nextdate = strtotime(date('d-M-Y', $starttime)." +".($interval*$times+$interval)." {$time_frame}");
	    }

	    return $nextdate;

	}

	public function index()
	{
		authenticate_user();
		$data=array();
		$msg=$this->input->post_get('msg');
		if(!empty($msg))
		{
			$msg=base64_decode($msg);
			$this->session->set_flashdata('success', $msg);
		}
		$user_auto_id=$this->session->userdata('user_auto_id');
		$friendListData = $this->User_Model->ajaxGetAllFriendList($user_auto_id,'',array());

		$aryUpcomingBirthDay=array();
		if(count($friendListData)>0)
		{
			$incree=0;
			$currentNow=date("Y-m-d",time());
			$currentNow=strtotime($currentNow);

			$withinOneMonthTime = date("Y-m-d",strtotime("+1 months", time()));
			$withinOneMonthTime=strtotime($withinOneMonthTime);

			$addedOneDay = date("Y-m-d",strtotime("+1 day", time()));
			$addedOneDay=strtotime($addedOneDay);
			foreach ($friendListData as $key => $value)
			{
				$birthdayDate= $this->get_next_date(strtotime($value['dob']),1,'year'); //echo "-".
				if($birthdayDate>=$currentNow && $birthdayDate<=$withinOneMonthTime && $value['membership_type']=='RM')
				{
					$incree++;
					$aryUpcomingBirthDay[$incree]=$value;
					if(date("d",strtotime($value['dob']))==date("d"))
					{
						$aryUpcomingBirthDay[$incree]['dispTimeString']='Today';
					}
					elseif(date("d",strtotime($value['dob']))==date("d",$addedOneDay))
					{
						$aryUpcomingBirthDay[$incree]['dispTimeString']='Tomorrow';
					}
					else
					{
						$aryUpcomingBirthDay[$incree]['dispTimeString']=date("jS M",strtotime($value['dob']));
					}
				}
			}
		}
		$data['aryUpcomingBirthDay']=$aryUpcomingBirthDay;

		/*echo "<pre>";
        print_r($aryUpcomingBirthDay);
        exit;
		exit;*/

		$this->load->view('user/header-script');
		$this->load->view('user/header-bottom');
		$this->load->view('user/index', $data);
		$this->load->view('user/footer-top');
		$this->load->view('user/footer');
	}

	public function churchrequest()
	{
		authenticate_user();
		$data=array();

		$membershipType=$this->session->userdata('membership_type');
		if($membershipType=="CM" || $membershipType=="CC")
		{
			$data['profileTab']='churchrequestTab';//$this->input->post_get('tab');
			$msg=$this->input->post_get('msg');
			if(!empty($msg))
			{
				$msg=base64_decode($msg);
				$this->session->set_flashdata('success', $msg);
			}
			$this->load->view('user/header-script');
			$this->load->view('user/header-bottom');
			$this->load->view('user/profile', $data);
			$this->load->view('user/footer-top');
			$this->load->view('user/footer');
		}
		else
		{
			redirect('user/index');
		}
	}

	public function churchlist()
	{
		authenticate_user();
		$data=array();

		$membershipType=$this->session->userdata('membership_type');
		if($membershipType=="CM" || $membershipType=="CC")
		{
			$data['profileTab']='churchlistTab';//$this->input->post_get('tab');
			$msg=$this->input->post_get('msg');
			if(!empty($msg))
			{
				$msg=base64_decode($msg);
				$this->session->set_flashdata('success', $msg);
			}
			$this->load->view('user/header-script');
			$this->load->view('user/header-bottom');
			$this->load->view('user/profile', $data);
			$this->load->view('user/footer-top');
			$this->load->view('user/footer');
		}
		else
		{
			redirect('user/index');
		}
	}

	public function memberrequest()
	{
		authenticate_user();
		$data=array();

		$membershipType=$this->session->userdata('membership_type');
		if($membershipType=="CM" || $membershipType=="CC")
		{

			$data['profileTab']='memberrequestTab';//$this->input->post_get('tab');
			$msg=$this->input->post_get('msg');
			if(!empty($msg))
			{
				$msg=base64_decode($msg);
				$this->session->set_flashdata('success', $msg);
			}
			$this->load->view('user/header-script');
			$this->load->view('user/header-bottom');
			$this->load->view('user/profile', $data);
			$this->load->view('user/footer-top');
			$this->load->view('user/footer');
		}
		else
		{
			redirect('user/index');
		}
	}

	public function memberlist()
	{
		authenticate_user();
		$data=array();

		$membershipType=$this->session->userdata('membership_type');
		if($membershipType=="CM" || $membershipType=="CC")
		{
			$data['profileTab']='memberlistTab';//$this->input->post_get('tab');
			$msg=$this->input->post_get('msg');
			if(!empty($msg))
			{
				$msg=base64_decode($msg);
				$this->session->set_flashdata('success', $msg);
			}
			$this->load->view('user/header-script');
			$this->load->view('user/header-bottom');
			$this->load->view('user/profile', $data);
			$this->load->view('user/footer-top');
			$this->load->view('user/footer');
		}
		else
		{
			redirect('user/index');
		}
	}

	public function friendrequest()
	{
		authenticate_user();
		$data=array();

		$membershipType=$this->session->userdata('membership_type');
		if($membershipType=="RM")
		{
			$data['profileTab']='friendrequestTab';//$this->input->post_get('tab');
			$msg=$this->input->post_get('msg');
			if(!empty($msg))
			{
				$msg=base64_decode($msg);
				$this->session->set_flashdata('success', $msg);
			}
			$this->load->view('user/header-script');
			$this->load->view('user/header-bottom');
			$this->load->view('user/profile', $data);
			$this->load->view('user/footer-top');
			$this->load->view('user/footer');
		}
		else
		{
			redirect('user/index');
		}
	}

	public function friendlist()
	{
		authenticate_user();
		$data=array();

		$membershipType=$this->session->userdata('membership_type');
		if($membershipType=="RM")
		{
			$data['profileTab']='friendlistTab';//$this->input->post_get('tab');
			$msg=$this->input->post_get('msg');
			if(!empty($msg))
			{
				$msg=base64_decode($msg);
				$this->session->set_flashdata('success', $msg);
			}
			$this->load->view('user/header-script');
			$this->load->view('user/header-bottom');
			$this->load->view('user/profile', $data);
			$this->load->view('user/footer-top');
			$this->load->view('user/footer');
		}
		else
		{
			redirect('user/index');
		}
	}

	public function churchmember()
	{
		authenticate_user();
		$data=array();

		$membershipType=$this->session->userdata('membership_type');
		$isAdmin=$this->session->userdata('is_admin');

		if($membershipType=="CM" || $membershipType=="CC" || $isAdmin=="Y")
		{
			$data['profileTab']='churchmemberTab';//$this->input->post_get('tab');
			$msg=$this->input->post_get('msg');
			if(!empty($msg))
			{
				$msg=base64_decode($msg);
				$this->session->set_flashdata('success', $msg);
			}
			$this->load->view('user/header-script');
			$this->load->view('user/header-bottom');
			$this->load->view('user/profile', $data);
			$this->load->view('user/footer-top');
			$this->load->view('user/footer');
		}
		else
		{
			redirect('user/index');
		}
	}

	public function settask($course_id=0,$task_level='')
	{
		authenticate_user();
		$data=array();
		$membershipType=$this->session->userdata('membership_type');
		$isAdmin=$this->session->userdata('is_admin');
		$user_auto_id=$this->session->userdata('user_auto_id');
		$parent_id=$this->session->userdata('parent_id');

		if(!empty($task_level) && ( ($membershipType=="CM" || $membershipType=="CC" || $isAdmin=="Y") || ($membershipType=="RM" && $isAdmin=="N") ) )
		{
			$argument=array();
			$argument['membershipType']=$membershipType;
			$argument['user_auto_id']=$user_auto_id;
			$argument['parent_id']=$parent_id;
			$argument['course_id']=$course_id;
			$argument['task_level']=$task_level;
			$argument['isAdmin']=$isAdmin;
			
			$courseData=$this->User_Model->get_course_data($course_id);
			$course_name=$courseData['course_name'];
			$argument['course_name']=$course_name;
			$argument['leader_id']=0;

			
			/*			
			$argument=array();
			$argument['membershipType']=$membershipType;
			$argument['user_auto_id']=$user_auto_id;
			$argument['parent_id']=$parent_id;
			$argument['task_level']=$task_level;
			*/

			if($membershipType=="CM" || $membershipType=="CC" || $isAdmin=="Y")
			{
				$allChurchAdminData = $this->User_Model->get_all_church_admin($user_auto_id);
				$leader_id=0;
				if(count($allChurchAdminData)>0)
				{
					foreach ($allChurchAdminData as $k => $v)
					{
						if($leader_id==0)
						{
							$leader_id=$v['id'];
							$allChurchAdminData[$k]['leader_id']=$leader_id;
						}
					}
				}
				$data['allChurchAdminData']=$allChurchAdminData;

				/*echo "<pre>";
				print_r($allChurchAdminData);*/				
				
				$argument['leader_id']=$leader_id;
				$taskMin3VideoLevelData = $this->User_Model->get_task_min_three_video_by_level($argument);
				$data['taskMin3VideoLevelData']=json_encode($taskMin3VideoLevelData);

				/*
				echo "ss<pre>";
				print_r($taskMin3VideoLevelData);
				exit;
				*/

				$liveStreamVideoData = $this->User_Model->get_live_stream_video_by_level($argument);
				$data['liveStreamVideoData']=json_encode($liveStreamVideoData);
			}
			elseif($membershipType=="RM" && $isAdmin=="N")
			{
				$argument['leader_id']=$this->session->userdata('admin_id');
				$taskMin3VideoLevelData = $this->User_Model->get_member_watch_task_video_by_level($argument);
				$data['taskMin3VideoLevelData']=json_encode($taskMin3VideoLevelData);

				/*echo "<pre>";
				print_r($argument);
				exit;*/
			
				$liveStreamVideoData = $this->User_Model->get_live_stream_video_by_level($argument);
				$data['liveStreamVideoData']=json_encode($liveStreamVideoData);
				
				/*echo "ss<pre>";
				print_r($liveStreamVideoData);
				exit;		*/		
			}
		
			$data['argument']=$argument;

			/*echo "ss<pre>";
			print_r($argument);
			exit;*/

			$this->load->view('user/header-script');
			$this->load->view('user/header-bottom');
			$this->load->view('user/settask', $data);
			$this->load->view('user/footer-top');
			$this->load->view('user/footer');
		}
		else
		{
			redirect('user/index');
		}
	}

	public function ajaxaddupdatevideo() 
    {
        $taskData = trim($this->input->post('taskData'));
        $aryTaskData=json_decode($taskData, true);

        $user_auto_id=(isset($aryTaskData['user_auto_id']) && !empty($aryTaskData['user_auto_id']))? addslashes(trim($aryTaskData['user_auto_id'])):0;
        $parent_id=(isset($aryTaskData['parent_id']) && !empty($aryTaskData['parent_id']))? addslashes(trim($aryTaskData['parent_id'])):0;
        $course_id=(isset($aryTaskData['course_id']) && !empty($aryTaskData['course_id']))? addslashes(trim($aryTaskData['course_id'])):'';
        $task_level=(isset($aryTaskData['task_level']) && !empty($aryTaskData['task_level']))? addslashes(trim($aryTaskData['task_level'])):'';
        $membership_type=(isset($aryTaskData['membership_type']) && !empty($aryTaskData['membership_type']))? addslashes(trim($aryTaskData['membership_type'])):'';
        $video_number=(isset($aryTaskData['video_number']) && !empty($aryTaskData['video_number']))? addslashes(trim($aryTaskData['video_number'])):1;
        $old_video=(isset($aryTaskData['old_video']) && !empty($aryTaskData['old_video']))? addslashes(trim($aryTaskData['old_video'])):'';
       /* echo "old_video-".$old_video;
        exit;*/

		$current_date=date('Y-m-d H:i:s');   

		$menu_arr = array(
            'course_id' => $course_id,
            'task_level' => $task_level,
            'church_id'  =>$parent_id,
            'church_admin_id'  =>$user_auto_id            
        );

        $task_level_id = $this->User_Model->addUpdateTaskLevel($menu_arr);

        if (!empty($_FILES['file']['name']))
        {
            $videofile = json_encode($_FILES);
        } else {
            $videofile = "";
        }

        $video_name="";
        $task_level_video_id=0;

        if(!empty($videofile))
        {
            $videofile=json_decode($videofile);
            $this->load->library('upload');
            $filename=$videofile->file->name[0];
            $imarr=explode(".",$filename);
            $ext=end($imarr);
          
            if($ext=="mp4" or $ext=="wmv" or $ext=="avi" or $ext=="3gp" or $ext=="mov" or $ext=="mpeg")
            {
                $_FILES['file']['name']=$videofile->file->name[0];
                $_FILES['file']['type']=$video_type=$videofile->file->type[0];
                $_FILES['file']['tmp_name']=$videofile->file->tmp_name[0];
                $_FILES['file']['error']=$videofile->file->error[0];
                $_FILES['file']['size']=$video_size=$videofile->file->size[0];

                $config = array(
                    'file_name' => str_replace(".","",microtime(true)).".".$ext,
                    'allowed_types' => '*',
                    'upload_path' => IMAGE_PATH.'taskvideo/',
                    //'max_size' => 2000
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
                    $video_name=$image_data['file_name'];
                    $menu_arr = array(
			            'task_level_id'=>$task_level_id,
			            'video_number'   =>$video_number,
			            'video_name'   =>$video_name,
			            'video_size'   =>$video_size,        
			            'video_type'   =>$video_type       
			        );

	                $task_level_video_id = $this->User_Model->addUpdatTaskLevelVideo($menu_arr,0);

	                if(!empty($old_video))
	                {
	                	unlink( IMAGE_PATH.'taskvideo/'.$old_video); // correct
	                }
                }                
            }
        }


        $returnData=array();
 		if($task_level_video_id>0)
		{
			$argument=array();
			$argument['membershipType']=$membership_type;
			$argument['user_auto_id']=$user_auto_id;
			$argument['parent_id']=$parent_id;
			$argument['course_id']=$course_id;
			$argument['task_level']=$task_level;
			$taskMin3VideoLevelData = $this->User_Model->get_task_min_three_video_by_level($argument);
			//$data['taskMin3VideoLevelData']=json_encode($taskMin3VideoLevelData);
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Video Added Successfully';
	        $returnData['data']=array('id'=>$task_level_video_id,'video_name'=>$video_name,'taskMin3VideoLevelData'=>$taskMin3VideoLevelData);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Video Set Failed';
	        $returnData['data']=array();
		}

        echo json_encode($returnData);
        exit;
    }

	public function ajaxaddupdatestreamvideo() 
    {

        $LSVideoData = trim($this->input->post('LSVideoData'));
        $aryLSVideoData=json_decode($LSVideoData, true);

        
        $id=(isset($aryLSVideoData['id']) && !empty($aryLSVideoData['id']))? addslashes(trim($aryLSVideoData['id'])):0;
        $user_auto_id=(isset($aryLSVideoData['user_auto_id']) && !empty($aryLSVideoData['user_auto_id']))? addslashes(trim($aryLSVideoData['user_auto_id'])):0;
        $parent_id=(isset($aryLSVideoData['parent_id']) && !empty($aryLSVideoData['parent_id']))? addslashes(trim($aryLSVideoData['parent_id'])):0;
        $course_id=(isset($aryLSVideoData['course_id']) && !empty($aryLSVideoData['course_id']))? addslashes(trim($aryLSVideoData['course_id'])):'';
        $task_level=(isset($aryLSVideoData['task_level']) && !empty($aryLSVideoData['task_level']))? addslashes(trim($aryLSVideoData['task_level'])):'';
        $membership_type=(isset($aryLSVideoData['membership_type']) && !empty($aryLSVideoData['membership_type']))? addslashes(trim($aryLSVideoData['membership_type'])):'';
        $video_title=(isset($aryLSVideoData['video_title']) && !empty($aryLSVideoData['video_title']))? addslashes(trim($aryLSVideoData['video_title'])):'';
        $start_time=(isset($aryLSVideoData['start_time']) && !empty($aryLSVideoData['start_time']))? addslashes(trim($aryLSVideoData['start_time'])):'';
       /* $end_time=(isset($aryLSVideoData['end_time']) && !empty($aryLSVideoData['end_time']))? addslashes(trim($aryLSVideoData['end_time'])):'';*/
        $description=(isset($aryLSVideoData['description']) && !empty($aryLSVideoData['description']))? trim($aryLSVideoData['description']):'';
        //$old_video=(isset($aryLSVideoData['old_video']) && !empty($aryLSVideoData['old_video']))? addslashes(trim($aryLSVideoData['old_video'])):'';

		$current_date=date('Y-m-d H:i:s');   

		$menu_arr = array(
            'course_id' => $course_id,
            'task_level' => $task_level,
            'church_id'  =>$parent_id,
            'church_admin_id'  =>$user_auto_id            
        );

        $task_level_id = $this->User_Model->addUpdateTaskLevel($menu_arr);

        $ls_video_id=0;
        if($task_level_id>0)
        {
	        $menu_arr = array(
	            'task_level_id'=>$task_level_id,
	            'video_title'   =>$video_title,
	            'start_time'   =>date('Y-m-d H:i:s',strtotime($start_time)),
	            'description'   =>$description,            
	            'create_date'   =>$current_date		            
	        );

			/*echo $id."ss<pre>";
			print_r($menu_arr);
			exit;*/

	        $ls_video_id = $this->User_Model->addUpdatLiveStreamVideo($menu_arr,$id);
	    }
        


        $returnData=array();
 		if($ls_video_id>0)
		{
			$argument=array();
			$argument['membershipType']=$membership_type;
			$argument['user_auto_id']=$user_auto_id;
			$argument['parent_id']=$parent_id;
			$argument['course_id']=$course_id;
			$argument['task_level']=$task_level;
			$liveStreamVideoData = $this->User_Model->get_live_stream_video_by_level($argument);

	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Video Added Successfully';
	        $returnData['data']=array('id'=>$ls_video_id,'video_name'=>$video_name,'liveStreamVideoData'=>$liveStreamVideoData);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Live Stream Video Set Failed';
	        $returnData['data']=array();
		}

        echo json_encode($returnData);
        exit;
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

		$this->session->set_userdata('is_approved', $memberData['is_approved']);

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

    public function ajaxActiveInactiveStreamVideo() 
    {

    	$returnData=array();
    	$LSVideoData=$this->input->get_post('LSVideoData');
    	$aryLSVideoData=json_decode($LSVideoData, true);
  
  		$id=(isset($aryLSVideoData['id']) && !empty($aryLSVideoData['id']))? addslashes(trim($aryLSVideoData['id'])):0;
		$strStatus=(isset($aryLSVideoData['strStatus']) && !empty($aryLSVideoData['strStatus']))? addslashes(trim($aryLSVideoData['strStatus'])):'0';
		
		$menu_arr = array(
            'status'  =>$strStatus
        );

		$lastId = $this->User_Model->addUpdatLiveStreamVideo($menu_arr,$id);

 		if($lastId>0)
		{
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Status Changed Successfully';
	        $returnData['data']=array('lastId'=>$lastId);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Status Changed Failed';
	        $returnData['data']=array();
		}
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxStartLeaveLiveStreaming() 
    {
    	$returnData=array();
    	$goliveStreamData=$this->input->get_post('goliveStreamData');
    	$AryGoliveStreamData=json_decode($goliveStreamData, true);
  
  		$id=(isset($AryGoliveStreamData['id']) && !empty($AryGoliveStreamData['id']))? addslashes(trim($AryGoliveStreamData['id'])):0;
  		$is_live=(isset($AryGoliveStreamData['is_live']) && !empty($AryGoliveStreamData['is_live']))? addslashes(trim($AryGoliveStreamData['is_live'])):'N';
  		
  		$user_auto_id=(isset($AryGoliveStreamData['user_auto_id']) && !empty($AryGoliveStreamData['user_auto_id']))? addslashes(trim($AryGoliveStreamData['user_auto_id'])):0;
        $parent_id=(isset($AryGoliveStreamData['parent_id']) && !empty($AryGoliveStreamData['parent_id']))? addslashes(trim($AryGoliveStreamData['parent_id'])):0;
        $course_id=(isset($AryGoliveStreamData['course_id']) && !empty($AryGoliveStreamData['course_id']))? addslashes(trim($AryGoliveStreamData['course_id'])):'';
        $task_level=(isset($AryGoliveStreamData['task_level']) && !empty($AryGoliveStreamData['task_level']))? addslashes(trim($AryGoliveStreamData['task_level'])):'';
        $membership_type=(isset($AryGoliveStreamData['membership_type']) && !empty($AryGoliveStreamData['membership_type']))? addslashes(trim($AryGoliveStreamData['membership_type'])):'';
        $current_date=date('Y-m-d H:i:s');
		
		$argument=array();
		$argument['membershipType']=$membership_type;
		$argument['user_auto_id']=$user_auto_id;
		$argument['parent_id']=$parent_id;
		$argument['course_id']=$course_id;
		$argument['task_level']=$task_level;

		$liveStreamVideoData = $this->User_Model->get_live_stream_video_by_level($argument);
		if(count($liveStreamVideoData)>0)
		{
			foreach($liveStreamVideoData as $k=>$v)
			{
				$menu_arr = array(
		            'is_live'  =>'N'
		        );
				
				$this->User_Model->addUpdatLiveStreamVideo($menu_arr,$v['id']);
			}
		}

		$menu_arr = array(
            'is_live'  =>$is_live
        );
		$lastId = $this->User_Model->addUpdatLiveStreamVideo($menu_arr,$id);

		//Start force do Leave all streaming member
		if($is_live=='N')
		{
			$menu_arr = array(
	            'leave_date'  =>$current_date
	        );
			$this->db->where(array('stream_video_id'=>$id,'leave_date'=>NULL))->update('tn_streaming_member',$menu_arr);
		}
		//End force do Leave all streaming member

 		if($lastId>0)
		{
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Streaming Started Successfully';
	        $returnData['data']=array('lastId'=>$lastId);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Streaming Starting is Failed';
	        $returnData['data']=array();
		}
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxJoinStreaming() 
    {
    	$returnData=array();
    	$goliveStreamData=$this->input->get_post('goliveStreamData');
    	$AryGoliveStreamData=json_decode($goliveStreamData, true);
  
  		$id=(isset($AryGoliveStreamData['id']) && !empty($AryGoliveStreamData['id']))? addslashes(trim($AryGoliveStreamData['id'])):0;
  		
  		$user_auto_id=(isset($AryGoliveStreamData['user_auto_id']) && !empty($AryGoliveStreamData['user_auto_id']))? addslashes(trim($AryGoliveStreamData['user_auto_id'])):0;
  		$join_leave_flag=(isset($AryGoliveStreamData['join_leave_flag']) && !empty($AryGoliveStreamData['join_leave_flag']))? addslashes(trim($AryGoliveStreamData['join_leave_flag'])):'L';
        

		$argu_arr = array(
            'stream_video_id' => $id,
            'member_id'  =>$user_auto_id,
            'join_leave_flag'  =>$join_leave_flag
        );

		$streaming_member_aid = $this->User_Model->ajaxAddUpdateStreamingMember($argu_arr);

 		if($streaming_member_aid>0)
		{
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Streaming Joined Successfully';
	        $returnData['data']=array('lastId'=>$streaming_member_aid);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Streaming Join is Failed';
	        $returnData['data']=array();
		}
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxDeleteStreamVideo() 
    {
    	$returnData=array();
    	$LSVideoData=$this->input->get_post('LSVideoData');
    	$aryLSVideoData=json_decode($LSVideoData, true);
  
  		$id=(isset($aryLSVideoData['id']) && !empty($aryLSVideoData['id']))? addslashes(trim($aryLSVideoData['id'])):0;
		$user_auto_id=(isset($aryLSVideoData['user_auto_id']) && !empty($aryLSVideoData['user_auto_id']))? addslashes(trim($aryLSVideoData['user_auto_id'])):0;
        $parent_id=(isset($aryLSVideoData['parent_id']) && !empty($aryLSVideoData['parent_id']))? addslashes(trim($aryLSVideoData['parent_id'])):0;
        $course_id=(isset($aryLSVideoData['course_id']) && !empty($aryLSVideoData['course_id']))? addslashes(trim($aryLSVideoData['course_id'])):'';
        $task_level=(isset($aryLSVideoData['task_level']) && !empty($aryLSVideoData['task_level']))? addslashes(trim($aryLSVideoData['task_level'])):'';
        $membership_type=(isset($aryLSVideoData['membership_type']) && !empty($aryLSVideoData['membership_type']))? addslashes(trim($aryLSVideoData['membership_type'])):'';

		$menu_arr = array(
            'deleted'  =>'1'
        );
        /*echo $id."ss<pre>";
        print_r($menu_arr);
        exit;*/
		$lastId = $this->User_Model->addUpdatLiveStreamVideo($menu_arr,$id);

 		if($lastId>0)
		{			
			$argument=array();
			$argument['membershipType']=$membership_type;
			$argument['user_auto_id']=$user_auto_id;
			$argument['parent_id']=$parent_id;
			$argument['course_id']=$course_id;
			$argument['task_level']=$task_level;
			$liveStreamVideoData = $this->User_Model->get_live_stream_video_by_level($argument);

	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Deleted Successfully';
	        $returnData['data']=array('lastId'=>$lastId,'liveStreamVideoData'=>$liveStreamVideoData);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Deletion Failed';
	        $returnData['data']=array();
		}
        echo json_encode($returnData);
        exit;
    }

    public function toggleSetMemberLevel() 
    {
    	$returnData=array();

    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
  
  		$member_id=(isset($aryFriendData['member_id']) && !empty($aryFriendData['member_id']))? addslashes(trim($aryFriendData['member_id'])):0;
  		$setlevel=(isset($aryFriendData['setlevel']) && !empty($aryFriendData['setlevel']))? addslashes(trim($aryFriendData['setlevel'])):'N';		
        $current_date=date('Y-m-d H:i:s');
        
       	/*
       	echo "ss<pre>";
		print_r($aryFriendData);
        exit;*/

        if($setlevel=='Y')
        {
        	$flagLevelExist = $this->User_Model->check_member_level_exist($member_id);
        	if($flagLevelExist==1)
			{
				$menu_arr = array(
		            'status'  =>'1'
		        );
				$flagSet = $this->User_Model->revert_assign_member_level($member_id,$menu_arr,'revert');			
			}
			else
			{
				$menu_arr = array(
		            'course_id'  =>1,
		            'task_level'  =>1,
		            'member_id'  =>$member_id,
		            'promote_date'  =>$current_date,
		            'status'  =>'1'
		        );
				$flagSet = $this->User_Model->revert_assign_member_level($member_id,$menu_arr,'insert');	
			}

			$returnData['status']='1';
			$returnData['msg']='success';
			$returnData['msgstring']='Level Set Successfullyh';
			$returnData['data']=array();
        }
        else
        {
        	$menu_arr = array(
		            'status'  =>'0',
		            'remove_date'=>$current_date,
		        );
			$flagSet = $this->User_Model->revert_assign_member_level($member_id,$menu_arr,'revert');

			$returnData['status']='1';
			$returnData['msg']='success';
			$returnData['msgstring']='Remove From Level Successfullyh';
			$returnData['data']=array();
        }       

       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxGetAllNotification() 
    {
    	$notificationData=$this->input->get_post('notificationData');
    	$aryNotificationData=json_decode($notificationData, true);
		$aryLiveStreamScheduleNotification = $this->User_Model->ajaxGetLiveStreamScheduleNotification($aryNotificationData);
		$allNotificationData=array();
		if(count($aryLiveStreamScheduleNotification))
		{
			foreach($aryLiveStreamScheduleNotification as $k=>$v)
			{
				$allNotificationData[$k]['strtext']=$v['video_title']." on ".date('m-d-Y h:i A',strtotime($v['start_time']));
				$allNotificationData[$k]['strcaption']='Live Streaming';
				$allNotificationData[$k]['strdate']=date('m-d-Y h:i A',strtotime($v['create_date']));
				$allNotificationData[$k]['stricon']='ri-broadcast-fill';
			}
		}

		/*echo "ss<pre>";
		print_r($allNotificationData);"Live Streaming on "
        exit;*/

		//$allNotificationData[0]=$aryLiveStreamScheduleNotification;
		/*echo "ss<pre>";
		print_r($allNotificationData);
        exit;*/
		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('allNotificationData'=>$allNotificationData);

        echo json_encode($returnData);
        exit;
    }

    public function ajaxGetAllGroup() 
    {
 		$allGroupData = $this->User_Model->get_group_data();

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('allGroupData'=>$allGroupData);
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxGenerateSetTaskMenu() 
    {
    	$leftMenuData=$this->input->get_post('leftMenuData');
    	$aryLeftMenuData=json_decode($leftMenuData, true);

    	$member_id=$aryLeftMenuData['user_auto_id'];
    	$membership_type=$aryLeftMenuData['membership_type'];
    	$is_admin=$aryLeftMenuData['is_admin'];

    	$allTaskLevelData=array();
    	if($membership_type=='RM' && $is_admin=='N')
    	{
    		$memberMaxLevelData = $this->User_Model->get_member_max_level($member_id);
    		$maxcourseid=$memberMaxLevelData->maxcourseid;
    		$maxmemberlevel=$memberMaxLevelData->maxmemberlevel;

    		
    		$aryAllCourseData = $this->User_Model->get_all_course();
    		$finalAllCourseData=array();
    		if(count($aryAllCourseData)>0)
    		{
    			foreach($aryAllCourseData as $k=>$v)
    			{
    				if($maxcourseid>$v['id'])
    				{
    					$finalAllCourseData[$k]['id']=$v['id'];
    					$finalAllCourseData[$k]['course_name']=$v['course_name'];
    					$finalAllCourseData[$k]['number_of_level']=$v['number_of_level'];
    					for ($x = 1; $x <= $v['number_of_level']; $x++)
	    				{
	    					$finalAllCourseData[$k]['levelData'][$x]['is_disabled']="Y";
	    					$finalAllCourseData[$k]['levelData'][$x]['labelname']="Level ".$x;
	    				}
    				}
    				elseif($maxcourseid==$v['id'])
    				{
    					$finalAllCourseData[$k]['id']=$v['id'];
    					$finalAllCourseData[$k]['course_name']=$v['course_name'];
    					$finalAllCourseData[$k]['number_of_level']=$v['number_of_level'];
    					for ($x = 1; $x <= $maxmemberlevel; $x++)
						{
							$finalAllCourseData[$k]['levelData'][$x]['labelname']="Level ".$x;
							$finalAllCourseData[$k]['levelData'][$x]['is_disabled']="Y";
							if($x==$maxmemberlevel)
							{								
								$finalAllCourseData[$k]['levelData'][$x]['is_disabled']="N";
							}
						}
    				}
    			}
    		}
			
			/*
			echo "ss<pre>";
			print_r($finalAllCourseData);
			//print_r($aryAllCourseData);
			exit;*/

			$allTaskLevelData=$finalAllCourseData;
			
    	}
    	elseif($membership_type=="CM" || $membership_type=="CC" || $is_admin=="Y")
    	{
    		$aryAllCourseData = $this->User_Model->get_all_course();
    		if(count($aryAllCourseData)>0)
    		{
    			foreach($aryAllCourseData as $k=>$v)
    			{
    				for ($x = 1; $x <= $v['number_of_level']; $x++)
    				{
    					$aryAllCourseData[$k]['levelData'][$x]['labelname']="Level ".$x;
    					$aryAllCourseData[$k]['levelData'][$x]['is_disabled']="N";
    				}
    			}
    		}
    		$allTaskLevelData=$aryAllCourseData;
    	}

		/*
		echo "ss<pre>";
		print_r($allTaskLevelData);
        exit;
        */

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('allTaskLevelData'=>$allTaskLevelData);

        echo json_encode($returnData);
        exit;
    }


    public function ajaxGetLeaderWiseLiveStreamVideo() 
    {
    	$returnData=array();
    	$LSVideoData=$this->input->get_post('LSVideoData');
    	$aryLSVideoData=json_decode($LSVideoData, true);
  
		$leader_id=(isset($aryLSVideoData['leader_id']) && !empty($aryLSVideoData['leader_id']))? addslashes(trim($aryLSVideoData['leader_id'])):0;
		$user_auto_id=(isset($aryLSVideoData['user_auto_id']) && !empty($aryLSVideoData['user_auto_id']))? addslashes(trim($aryLSVideoData['user_auto_id'])):0;
        $parent_id=(isset($aryLSVideoData['parent_id']) && !empty($aryLSVideoData['parent_id']))? addslashes(trim($aryLSVideoData['parent_id'])):0;
        $course_id=(isset($aryLSVideoData['course_id']) && !empty($aryLSVideoData['course_id']))? addslashes(trim($aryLSVideoData['course_id'])):'';
        $task_level=(isset($aryLSVideoData['task_level']) && !empty($aryLSVideoData['task_level']))? addslashes(trim($aryLSVideoData['task_level'])):'';
        $membership_type=(isset($aryLSVideoData['membership_type']) && !empty($aryLSVideoData['membership_type']))? addslashes(trim($aryLSVideoData['membership_type'])):'';

		
		$argument=array();
		$argument['membershipType']=$membership_type;
		$argument['user_auto_id']=$user_auto_id;
		$argument['parent_id']=$parent_id;
		$argument['course_id']=$course_id;
		$argument['task_level']=$task_level;
		$argument['leader_id']=$leader_id;

		/*echo "s<pre>";
		print_r($argument);
		exit;*/
		$liveStreamVideoData = $this->User_Model->get_live_stream_video_by_level($argument);

        $returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='Deleted Successfully';
        $returnData['data']=array('lastId'=>$lastId,'liveStreamVideoData'=>$liveStreamVideoData);
		
        echo json_encode($returnData);
        exit;
    }

    public function ajaxGetLeaderWiseMinThreeVideo() 
    {
    	$returnData=array();
    	$LSVideoData=$this->input->get_post('LSVideoData');
    	$aryLSVideoData=json_decode($LSVideoData, true);
  
		$leader_id=(isset($aryLSVideoData['leader_id']) && !empty($aryLSVideoData['leader_id']))? addslashes(trim($aryLSVideoData['leader_id'])):0;
		$user_auto_id=(isset($aryLSVideoData['user_auto_id']) && !empty($aryLSVideoData['user_auto_id']))? addslashes(trim($aryLSVideoData['user_auto_id'])):0;
        $parent_id=(isset($aryLSVideoData['parent_id']) && !empty($aryLSVideoData['parent_id']))? addslashes(trim($aryLSVideoData['parent_id'])):0;
        $course_id=(isset($aryLSVideoData['course_id']) && !empty($aryLSVideoData['course_id']))? addslashes(trim($aryLSVideoData['course_id'])):'';
        $task_level=(isset($aryLSVideoData['task_level']) && !empty($aryLSVideoData['task_level']))? addslashes(trim($aryLSVideoData['task_level'])):'';
        $membership_type=(isset($aryLSVideoData['membership_type']) && !empty($aryLSVideoData['membership_type']))? addslashes(trim($aryLSVideoData['membership_type'])):'';

		
		$argument=array();
		$argument['membershipType']=$membership_type;
		$argument['user_auto_id']=$user_auto_id;
		$argument['parent_id']=$parent_id;
		$argument['course_id']=$course_id;
		$argument['task_level']=$task_level;
		$argument['leader_id']=$leader_id;

		/*echo "s<pre>";
		print_r($argument);
		exit;*/
		$taskMin3VideoLevelData = $this->User_Model->get_task_min_three_video_by_level($argument);

        $returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='Deleted Successfully';
        $returnData['data']=array('lastId'=>$lastId,'taskMin3VideoLevelData'=>$taskMin3VideoLevelData);
		
        echo json_encode($returnData);
        exit;
    }

    public function ajaxTrackMemberWatchTaskVideo() 
    {
    	$returnData=array();
    	$LSVideoData=$this->input->get_post('LSVideoData');
    	$aryLSVideoData=json_decode($LSVideoData, true);

  
		$video_viewed_time=(isset($aryLSVideoData['video_viewed_time']) && !empty($aryLSVideoData['video_viewed_time']))? addslashes(trim($aryLSVideoData['video_viewed_time'])):0;
		$video_ended=(isset($aryLSVideoData['video_ended']) && !empty($aryLSVideoData['video_ended']))? addslashes(trim($aryLSVideoData['video_ended'])):0;
		$task_level_video_id=(isset($aryLSVideoData['task_level_video_id']) && !empty($aryLSVideoData['task_level_video_id']))? addslashes(trim($aryLSVideoData['task_level_video_id'])):0;
		$leader_id=(isset($aryLSVideoData['leader_id']) && !empty($aryLSVideoData['leader_id']))? addslashes(trim($aryLSVideoData['leader_id'])):0;
		$user_auto_id=(isset($aryLSVideoData['user_auto_id']) && !empty($aryLSVideoData['user_auto_id']))? addslashes(trim($aryLSVideoData['user_auto_id'])):0;
        $parent_id=(isset($aryLSVideoData['parent_id']) && !empty($aryLSVideoData['parent_id']))? addslashes(trim($aryLSVideoData['parent_id'])):0;
        $course_id=(isset($aryLSVideoData['course_id']) && !empty($aryLSVideoData['course_id']))? addslashes(trim($aryLSVideoData['course_id'])):'';
        $task_level=(isset($aryLSVideoData['task_level']) && !empty($aryLSVideoData['task_level']))? addslashes(trim($aryLSVideoData['task_level'])):'';
        $membership_type=(isset($aryLSVideoData['membership_type']) && !empty($aryLSVideoData['membership_type']))? addslashes(trim($aryLSVideoData['membership_type'])):'';

		
		$argument=array();
		$argument['video_viewed_time']=$video_viewed_time;
		$argument['video_ended']=$video_ended;
		$argument['task_level_video_id']=$task_level_video_id;
		$argument['leader_id']=$leader_id;
		$argument['user_auto_id']=$user_auto_id;
		$argument['parent_id']=$parent_id;
		$argument['course_id']=$course_id;
		$argument['task_level']=$task_level;
		$argument['membershipType']=$membership_type;

/*		echo "s<pre>";
		print_r($argument);
		exit;
*/
		$task_level_video_viewed_aid = $this->User_Model->addUpdateTaskLevelVideoViewed($argument);

		$taskMin3VideoLevelData = $this->User_Model->get_member_watch_task_video_by_level($argument);

        $returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='Deleted Successfully';
        $returnData['data']=array('video_ended'=>$video_ended,'task_level_video_viewed_aid'=>$task_level_video_viewed_aid,'taskMin3VideoLevelData'=>$taskMin3VideoLevelData);
		
        echo json_encode($returnData);
        exit;
    }


    public function ajaxGetLiveStreamingMember() 
    {
    	$returnData=array();
    	$LSVideoData=$this->input->get_post('LSVideoData');
    	$aryLSVideoData=json_decode($LSVideoData, true);

  		$user_auto_id=(isset($aryLSVideoData['user_auto_id']) && !empty($aryLSVideoData['user_auto_id']))? addslashes(trim($aryLSVideoData['user_auto_id'])):0;
        $parent_id=(isset($aryLSVideoData['parent_id']) && !empty($aryLSVideoData['parent_id']))? addslashes(trim($aryLSVideoData['parent_id'])):0;
        $course_id=(isset($aryLSVideoData['course_id']) && !empty($aryLSVideoData['course_id']))? addslashes(trim($aryLSVideoData['course_id'])):'';
        $task_level=(isset($aryLSVideoData['task_level']) && !empty($aryLSVideoData['task_level']))? addslashes(trim($aryLSVideoData['task_level'])):'';
        $membership_type=(isset($aryLSVideoData['membership_type']) && !empty($aryLSVideoData['membership_type']))? addslashes(trim($aryLSVideoData['membership_type'])):'';

			
		$argument=array();
		$argument['membershipType']=$membership_type;
		$argument['user_auto_id']=$user_auto_id;
		$argument['parent_id']=$parent_id;
		$argument['course_id']=$course_id;
		$argument['task_level']=$task_level;
		$liveStreamMemberData = $this->User_Model->get_live_streaming_member_by_level($argument);

        $returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='Deleted Successfully';
        $returnData['data']=array('liveStreamMemberData'=>$liveStreamMemberData);
	
        echo json_encode($returnData);
        exit;
    }


    public function giveBadgeToMember() 
    {
    	$returnData=array();

    	$goliveStreamData=$this->input->get_post('goliveStreamData');
    	$AryGoliveStreamData=json_decode($goliveStreamData, true);
  		$member_id=(isset($AryGoliveStreamData['member_id']) && !empty($AryGoliveStreamData['member_id']))? addslashes(trim($AryGoliveStreamData['member_id'])):0;
  		$course_id=(isset($AryGoliveStreamData['course_id']) && !empty($AryGoliveStreamData['course_id']))? addslashes(trim($AryGoliveStreamData['course_id'])):0;		
  		$task_level=(isset($AryGoliveStreamData['task_level']) && !empty($AryGoliveStreamData['task_level']))? addslashes(trim($AryGoliveStreamData['task_level'])):0;
  		$no_of_badge=(isset($AryGoliveStreamData['no_of_badge']) && !empty($AryGoliveStreamData['no_of_badge']))? addslashes(trim($AryGoliveStreamData['no_of_badge'])):0;
        $current_date=date('Y-m-d H:i:s');
        
        /*$course_id=4;
        $task_level=6;*/

		$sql="SELECT 
				number_of_level
				FROM tn_task_level_course
				WHERE id='".$course_id."'";
        $query=$this->db->query($sql);
		$rowData=$query->row();
		if(!empty($rowData) && $rowData->number_of_level>0 && $no_of_badge>0)
		{
			$number_of_level=$rowData->number_of_level;

			if($course_id==4) //last semister
			{
				//Start Set Bedge to level
				$menu_arr = array(
		            'no_of_badge'  =>$no_of_badge,
		            'member_id'  =>$member_id,
		            'course_id'  =>$course_id,
		            'task_level'  =>$task_level
		        );
				$flagSet = $this->User_Model->update_member_level($menu_arr);
				//End Set Bedge to level

				if($task_level==$number_of_level)
				{
					$totbadge = $this->User_Model->get_member_total_badge_by_course($member_id,$course_id);
					if($totbadge>49)
					{
						//Start Jump To next course
						$menu_arr = array(
				            'member_id'  =>$member_id,
				            'course_id'  =>$course_id,
				            'task_level'  =>999, // award winner
				            'promote_date'  =>$current_date
				        );
						$flagSet = $this->User_Model->insert_member_level($menu_arr);
						//End Jump To next course
					}
				}
				else
				{
					//Start Jump To next level
					$next_task_level=$task_level+1;
					$menu_arr = array(
			            'member_id'  =>$member_id,
			            'course_id'  =>$course_id,
			            'task_level'  =>$next_task_level,
			            'promote_date'  =>$current_date
			        );
					$flagSet = $this->User_Model->insert_member_level($menu_arr);
					//End Jump To next level
				}
			}
			else
			{
				//Start Set Bedge to level
				$menu_arr = array(
		            'no_of_badge'  =>$no_of_badge,
		            'member_id'  =>$member_id,
		            'course_id'  =>$course_id,
		            'task_level'  =>$task_level
		        );
				$flagSet = $this->User_Model->update_member_level($menu_arr);
				//End Set Bedge to level

				if($task_level==$number_of_level)
				{
					$totbadge = $this->User_Model->get_member_total_badge_by_course($member_id,$course_id);
					if($totbadge>49)
					{
						//Start Jump To next course
						$next_course_id=$course_id+1;
						$menu_arr = array(
				            'member_id'  =>$member_id,
				            'course_id'  =>$next_course_id,
				            'task_level'  =>1
				        );
						$flagSet = $this->User_Model->insert_member_level($menu_arr);
						//End Jump To next course
					}					
				}
				else
				{
					//Start Jump To next level
					$next_task_level=$task_level+1;
					$menu_arr = array(
			            'member_id'  =>$member_id,
			            'course_id'  =>$course_id,
			            'task_level'  =>$next_task_level,
			            'promote_date'  =>$current_date
			        );
					$flagSet = $this->User_Model->insert_member_level($menu_arr);
					//End Jump To next level
				}
			}
		}


		$returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='Badge Give to Member Successfully Done';
        $returnData['data']=array('flagSet'=>$flagSet);
       
        echo json_encode($returnData);
        exit;
    }


    public function ajaxaddupdateexam() 
    {

        $examData = trim($this->input->post('examData'));
        $aryExamData=json_decode($examData, true);
        
        $exam_id=(isset($aryExamData['exam_id']) && !empty($aryExamData['exam_id']))? addslashes(trim($aryExamData['exam_id'])):0;
        $user_auto_id=(isset($aryExamData['user_auto_id']) && !empty($aryExamData['user_auto_id']))? addslashes(trim($aryExamData['user_auto_id'])):0;
        $parent_id=(isset($aryExamData['parent_id']) && !empty($aryExamData['parent_id']))? addslashes(trim($aryExamData['parent_id'])):0;
        $course_id=(isset($aryExamData['course_id']) && !empty($aryExamData['course_id']))? addslashes(trim($aryExamData['course_id'])):'';
        $task_level=(isset($aryExamData['task_level']) && !empty($aryExamData['task_level']))? addslashes(trim($aryExamData['task_level'])):'';
        $membership_type=(isset($aryExamData['membership_type']) && !empty($aryExamData['membership_type']))? addslashes(trim($aryExamData['membership_type'])):'';
        $aryQuestionnaire=(isset($aryExamData['aryQuestionnaire']) && !empty($aryExamData['aryQuestionnaire']))? $aryExamData['aryQuestionnaire']:array();

        $exam_title=(isset($aryExamData['exam_title']) && !empty($aryExamData['exam_title']))? addslashes(trim($aryExamData['exam_title'])):'';
        $start_time=(isset($aryExamData['start_time']) && !empty($aryExamData['start_time']))? addslashes(trim($aryExamData['start_time'])):'';
        $end_time=(isset($aryExamData['end_time']) && !empty($aryExamData['end_time']))? addslashes(trim($aryExamData['end_time'])):'';

       /* echo $exam_id."ss<pre>";
        print_r($aryExamData);
        exit;*/


		$current_date=date('Y-m-d H:i:s');   

		$menu_arr = array(
            'course_id' => $course_id,
            'task_level' => $task_level,
            'church_id'  =>$parent_id,
            'church_admin_id'  =>$user_auto_id            
        );

        $task_level_id = $this->User_Model->addUpdateTaskLevel($menu_arr);

       /* echo $task_level_id."ss<pre>";
        print_r($menu_arr);
        exit;*/

        $ls_exam_id=0;
        if($task_level_id>0)
        {
        	if(count($aryQuestionnaire)>0)
        	{
        		$menu_arr = array(
		            'task_level_id'	=>$task_level_id,
		            'exam_title'   	=>$exam_title,
		            'start_time'   	=>date('Y-m-d H:i:s',strtotime($start_time)),
		            'end_time'     	=>date('Y-m-d H:i:s',strtotime($end_time)),
		            'total_question'=>count($aryQuestionnaire),
		            'create_date'   =>$current_date		            
		        );
		        $ls_exam_id = $this->User_Model->addUpdatExam($menu_arr,$exam_id);
        	}	        
	    }

        $returnData=array();
 		if($ls_exam_id>0)
		{
			/*echo "exam_id".$exam_id;
			exit;*/
			if($exam_id>0)
			{
				$delete_arr = array(
		            'is_deleted'	=>'1'
		        );
		        $this->User_Model->deleteAllExamQuestion($delete_arr,$exam_id);
			}
			
			if(count($aryQuestionnaire)>0)
        	{
        		foreach($aryQuestionnaire as $k=>$v)
        		{
        			$ary_exam_answer_option=array();
        			$ary_exam_answer_option['correct_ans']=$v['correct_ans'];
        			$ary_exam_answer_option['options']=$v['options'];
        			$json_exam_answer_option=json_encode($ary_exam_answer_option);

        			$menu_arr = array(
			            'exam_id'	=>$ls_exam_id,
			            'task_level_id'   	=>$task_level_id,
			            'exam_question'   	=>$v['question'],
			            'exam_answer_option'   	=>$json_exam_answer_option
			        );
			        $this->User_Model->addUpdatExamQuestion($menu_arr,0);
        		}
        	}

			$argument=array();
			$argument['task_level_id']=$task_level_id;
			$allExamListObj = $this->User_Model->get_exam_by_level($argument);
			

	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Exam Set Successfully';
	        $returnData['data']=array('id'=>$ls_exam_id,'allExamListObj'=>$allExamListObj);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Exam Set Failed';
	        $returnData['data']=array();
		}

        echo json_encode($returnData);
        exit;
    }


    public function ajaxActiveInactiveExam() 
    {

    	$returnData=array();
    	$ExamData=$this->input->get_post('ExamData');
    	$aryExamData=json_decode($ExamData, true);
  
  		$id=(isset($aryExamData['id']) && !empty($aryExamData['id']))? addslashes(trim($aryExamData['id'])):0;
		$strStatus=(isset($aryExamData['strStatus']) && !empty($aryExamData['strStatus']))? addslashes(trim($aryExamData['strStatus'])):'0';
		
		$menu_arr = array(
            'status'  =>$strStatus
        );

		$lastId = $this->User_Model->addUpdatExam($menu_arr,$id);

 		if($lastId>0)
		{
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Status Changed Successfully';
	        $returnData['data']=array('lastId'=>$lastId);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Status Changed Failed';
	        $returnData['data']=array();
		}
       
        echo json_encode($returnData);
        exit;
    }


    public function ajaxDeleteExam() 
    {
    	$returnData=array();
    	$examDeleteData=$this->input->get_post('examDeleteData');
    	$aryExamDeleteData=json_decode($examDeleteData, true);
  
  		$id=(isset($aryExamDeleteData['id']) && !empty($aryExamDeleteData['id']))? addslashes(trim($aryExamDeleteData['id'])):0;
  		$task_level_id=(isset($aryExamDeleteData['task_level_id']) && !empty($aryExamDeleteData['task_level_id']))? addslashes(trim($aryExamDeleteData['task_level_id'])):0;

		$menu_arr = array(
            'deleted'  =>'1'
        );
        /*echo $id."ss<pre>";
        print_r($menu_arr);
        exit;*/
		$lastId = $this->User_Model->addUpdatExam($menu_arr,$id);

 		if($lastId>0)
		{			
			$argument=array();
			$argument['task_level_id']=$task_level_id;
			$allExamListObj = $this->User_Model->get_exam_by_level($argument);

	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Deleted Successfully';
	        $returnData['data']=array('lastId'=>$lastId,'allExamListObj'=>$allExamListObj);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Deletion Failed';
	        $returnData['data']=array();
		}
        echo json_encode($returnData);
        exit;
    }

    public function ajaxGetAllTaskLevelExam() 
    {
    	
    	$examListData = trim($this->input->post('examListData'));
        $aryExamListData=json_decode($examListData, true);
  
        $leader_id=(isset($aryExamListData['leader_id']) && !empty($aryExamListData['leader_id']))? addslashes(trim($aryExamListData['leader_id'])):0;
        $course_id=(isset($aryExamListData['course_id']) && !empty($aryExamListData['course_id']))? addslashes(trim($aryExamListData['course_id'])):'';
        $task_level=(isset($aryExamListData['task_level']) && !empty($aryExamListData['task_level']))? addslashes(trim($aryExamListData['task_level'])):'';
        $user_auto_id=(isset($aryExamListData['user_auto_id']) && !empty($aryExamListData['user_auto_id']))? addslashes(trim($aryExamListData['user_auto_id'])):0;
        $parent_id=(isset($aryExamListData['parent_id']) && !empty($aryExamListData['parent_id']))? addslashes(trim($aryExamListData['parent_id'])):0;
        $membership_type=(isset($aryExamListData['membership_type']) && !empty($aryExamListData['membership_type']))? addslashes(trim($aryExamListData['membership_type'])):'';


		$argument=array();
		$argument['membershipType']=$membership_type;
		$argument['user_auto_id']=$user_auto_id;
		$argument['parent_id']=$parent_id;
		$argument['course_id']=$course_id;
		$argument['task_level']=$task_level;
		$argument['leader_id']=$leader_id;


		$allExamListObj = $this->User_Model->get_exam_by_level($argument);
/*
		echo "ss<pre>";
        print_r($allExamListObj);
        exit;*/

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('allExamListObj'=>$allExamListObj);
       
        echo json_encode($returnData);
        exit;
    }

    public function ajaxGetExamData() 
    {
    	$editExamData=$this->input->get_post('editExamData');
        $aryEditExamData=json_decode($editExamData, true);

    	$id=(isset($aryEditExamData['id']) && !empty($aryEditExamData['id']))? addslashes(trim($aryEditExamData['id'])):0;

		$examData = $this->User_Model->GetExamData($id);
		if(count($examData['aryQuestionnaire']))
		{
			$arrayFinal=array();
			foreach($examData['aryQuestionnaire'] as $k=>$v)
			{
				$arrayFinal[$k]=$v;
				$arrayFinal[$k]['given_ans']=0;
			}
			$examData['aryQuestionnaire']=$arrayFinal;
		}

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('id'=>$id,'examData'=>$examData);
       
        echo json_encode($returnData);
        exit;
    }

    public function giveexam($idString=0)
	{
		authenticate_user();
		$data=array();
		$membershipType=$this->session->userdata('membership_type');
		$isAdmin=$this->session->userdata('is_admin');
		$user_auto_id=$this->session->userdata('user_auto_id');
		$parent_id=$this->session->userdata('parent_id');

		if(!empty($idString) && $membershipType=="RM" && $isAdmin=="N")
		{
			$data['idString']=$idString;

			$this->load->view('user/header-script');
			$this->load->view('user/header-bottom');
			$this->load->view('user/giveexam', $data);
			$this->load->view('user/footer-top');
			$this->load->view('user/footer');
		}
		else
		{
			redirect('user/index');
		}
	}


	public function ajaxaddupdateexamgiven() 
    {
        $submitExamData = trim($this->input->post('submitExamData'));
        $arySubmitExamData=json_decode($submitExamData, true);
        
        $exam_id=(isset($arySubmitExamData['exam_id']) && !empty($arySubmitExamData['exam_id']))? addslashes(trim($arySubmitExamData['exam_id'])):0;
        $task_level_id=(isset($arySubmitExamData['task_level_id']) && !empty($arySubmitExamData['task_level_id']))? addslashes(trim($arySubmitExamData['task_level_id'])):0;
        $user_auto_id=(isset($arySubmitExamData['user_auto_id']) && !empty($arySubmitExamData['user_auto_id']))? addslashes(trim($arySubmitExamData['user_auto_id'])):0;
        $percentage_got=(isset($arySubmitExamData['total_percentage_got']) && !empty($arySubmitExamData['total_percentage_got']))? addslashes(trim($arySubmitExamData['total_percentage_got'])):0;
        $is_exam_pass=(isset($arySubmitExamData['is_exam_pass']) && !empty($arySubmitExamData['is_exam_pass']))? addslashes(trim($arySubmitExamData['is_exam_pass'])):'N';
        $allQuestionnaireObj=(isset($arySubmitExamData['allQuestionnaireObj']) && !empty($arySubmitExamData['allQuestionnaireObj']))? $arySubmitExamData['allQuestionnaireObj']:array();
		$current_date=date('Y-m-d H:i:s');   

        /*echo $task_level_id."ss<pre>";
        print_r($allQuestionnaireObj);
        exit;*/

        $sql='SELECT id from tbl_exam_given WHERE exam_id="'.$exam_id.'" AND member_id="'.$user_auto_id.'"';
		$query=$this->db->query($sql);
		$resultGivenExam=$query->result_array();
		if(count($resultGivenExam)<3)
		{
			//Start make previous exam status off
			$ary_exam_give['status']='0';
			$this->db->where(array('exam_id'=>$exam_id,'member_id'=>$user_auto_id))->update('tbl_exam_given',$ary_exam_give);
			//end make previous exam status off


			$ls_exam_given_id=0;
	        if($exam_id>0 && count($allQuestionnaireObj)>0)
	        {
	    		$ary_exam_given = array(
		            'exam_id' => $exam_id,
		            'task_level_id' => $task_level_id,
		            'member_id'  =>$user_auto_id,
		            'percentage_got'  =>$percentage_got,         
		            'is_exam_pass'  =>$is_exam_pass,         
		            'exam_date'  =>$current_date        
		        );
		        $ls_exam_given_id = $this->User_Model->addUpdatExamGiven($ary_exam_given,'');
		    }

	        $returnData=array();
	 		if($ls_exam_given_id>0)
			{			
				if(count($allQuestionnaireObj)>0)
	        	{
	        		foreach($allQuestionnaireObj as $k=>$v)
	        		{
	        			$ary_exam_answer_option=array();
	        			$ary_exam_answer_option['correct_ans']=$v['correct_ans'];
	        			$ary_exam_answer_option['options']=$v['options'];
	        			$ary_exam_answer_option['given_ans']=$v['given_ans'];
	        			$json_exam_answer_option=json_encode($ary_exam_answer_option);

	        			$ary_exam_given_answer = array(
				            'exam_given_id'	=>$ls_exam_given_id,
				            'exam_id'	=>$exam_id,
				            'task_level_id'   	=>$task_level_id,
				            'member_id'   	=>$user_auto_id,
				            'exam_question_id'   	=>$v['questionID'],
				            'exam_answer'   	=>$json_exam_answer_option
				        );
				        $this->User_Model->addUpdatExamGivenAnswer($ary_exam_given_answer,0);
	        		}
	        	}

		        $returnData['status']='1';
		        $returnData['msg']='success';
		        $returnData['msgstring']='Exam Given Successfully';
		        $returnData['data']=array('id'=>$ls_exam_given_id);
			}
			else
			{
				$returnData['status']='0';
		        $returnData['msg']='error';
		        $returnData['msgstring']='Exam Given Failed';
		        $returnData['data']=array();
			}
		}
		else{
			$returnData['status']='2';
	        $returnData['msg']='chance_over';
	        $returnData['msgstring']='You have reached the maximum attempts';
	        $returnData['data']=array();
		}       

        echo json_encode($returnData);
        exit;
    }

    public function ajaxupdateeditcoverimage() 
    {
        $coverImageData = trim($this->input->post('coverImageData'));
        $aryCoverImageData=json_decode($coverImageData, true);

        $id=(isset($aryCoverImageData['id']) && !empty($aryCoverImageData['id']))? addslashes(trim($aryCoverImageData['id'])):0;
        $encode_cover_image=(isset($aryCoverImageData['encode_cover_image']) && !empty($aryCoverImageData['encode_cover_image']))? addslashes(trim($aryCoverImageData['encode_cover_image'])):'';
        $exist_cover_image=(isset($aryCoverImageData['exist_cover_image']) && !empty($aryCoverImageData['exist_cover_image']))? addslashes(trim($aryCoverImageData['exist_cover_image'])):'';
		$current_date=date('Y-m-d H:i:s');   

        $returnData=array();

        /*echo "encode_cover_image".$encode_cover_image;
        exit;*/

        if(!empty($encode_cover_image) && $encode_cover_image!='data:comma' && !empty($id)) //data:comma blank Image
        {
        	$menu_arr=array();

        	$encode_cover_image=str_replace('colone', ';', $encode_cover_image);
        	$encode_cover_image=str_replace('comma', ',', $encode_cover_image);        	
	        $image_array_1 = explode(";", $encode_cover_image);
	        $image_array_2 = explode(",", $image_array_1[1]);

	        $imagebase64Data = base64_decode($image_array_2[1]);
	        $imagename = time().'.png';

			$image_name_with_path = IMAGE_PATH.'images/members/coverimages/'.$imagename;
			file_put_contents($image_name_with_path, $imagebase64Data);

			$menu_arr['cover_image']=$imagename;
			$this->session->set_userdata('cover_image',$imagename);

			//Start tracking all Images uploaded by Member
			$menu_arr_post_file = array(
	            'module_id'=>$id,
	            'module_type'=>'coverimages',
	            'member_id'   =>$id,
	            'file_original_name'=>$imagename,
	            'file_name'   =>$imagename,
	            'file_size'   =>'0',        
	            'file_type'   =>'image/png',       
	            'create_date'   =>$current_date       
	        );
			$this->Post_Model->addUpdatPostFile(0,$menu_arr_post_file);
			//End tracking all Images uploaded by Member

			//unlink( IMAGE_PATH.'images/members/coverimages/'.$exist_cover_image); // correct

			$lastId = $this->User_Model->addupdatemember($id,$menu_arr);

			$returnData['status']='1';
	        $returnData['msg']=base64_encode('Cover Image Updated Successfully.');
	        $returnData['data']=array('id'=>$lastId,'imagename'=>$imagename);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Cover Image Upload Failed';
	        $returnData['data']=array();
		}
        echo json_encode($returnData);
        exit;    	
    }

    public function profile()
	{
		authenticate_user();
		$data=array();
		$data['profileTab']='timelineTab';//$this->input->post_get('tab');
		$this->load->view('user/header-script');
		$this->load->view('user/header-bottom');
		$this->load->view('user/profile', $data);
		$this->load->view('user/footer-top');
		$this->load->view('user/footer');
	}

	public function support()
    {
      authenticate_user();
      $data=array();
      $data['membershipType']=$this->session->userdata('membership_type');
      $data['isAdmin']=$this->session->userdata('is_admin');
      $data['user_auto_id']=$this->session->userdata('user_auto_id');
      $data['parent_id']=$this->session->userdata('parent_id');
      $data['parent_leader_id']=$this->session->userdata('parent_leader_id');

      $msg=$this->input->post_get('msg');
      if(!empty($msg))
      {
        $msg=base64_decode($msg);
        $this->session->set_flashdata('success', $msg);
      }
      //$data['church_id']=$church_id;
      $this->load->view('user/header-script');
      $this->load->view('user/header-bottom');
      $this->load->view('user/support', $data);
      $this->load->view('user/footer-top');
      $this->load->view('user/footer');
    }

    public function ajaxsubmitticket()
    {
        $returnData=array();
        $user_auto_id=$this->session->userdata('user_auto_id');

        $manageSupport = trim($this->input->post('manageSupport'));
        $arySupportData=json_decode($manageSupport, true);

        //print "<pre>"; print_r($arySupportData); print "</pre>";
        $supportTicketId=(isset($arySupportData['id']) && !empty($arySupportData['id']))? $arySupportData['id'] : 0 ;
        $supportParentId=(isset($arySupportData['parent_id']) && !empty($arySupportData['parent_id']))? $arySupportData['parent_id'] : 0 ;
        $responseTo=(isset($arySupportData['report_to']) && !empty($arySupportData['report_to']))? $arySupportData['report_to'] : 0 ;
        $responseSubject=(isset($arySupportData['subject']) && !empty($arySupportData['subject']))? $arySupportData['subject'] : NULL ;
        $responseDescription=(isset($arySupportData['description']) && !empty($arySupportData['description']))? $arySupportData['description'] : NULL ;

        $repArray=array('parent_id'=>$supportParentId, 'response_from'=>$user_auto_id, 'response_to'=>$responseTo, 'subject'=>$responseSubject, 'description'=>$responseDescription, 'created_on'=>date('Y-m-d H:i:s'), 'is_deleted'=>0);

        $retId = $this->User_Model->submit_ticket($repArray, $supportTicketId);
        echo json_encode(array('retId'=>$retId));
        die();
    }

    public function ajaxgetallticket()
    {
      $returnData=array();
      $user_auto_id=$this->session->userdata('user_auto_id');
      $myTickets=array();
      $aTickets=array();
      $sql='SELECT a.id, a.subject, a.description, a.created_on, a.response_to, (SELECT COUNT(id) FROM tn_support_ticket WHERE parent_id=a.id AND is_deleted="0") AS childCount FROM tn_support_ticket AS a WHERE a.parent_id="0" AND a.response_from="'.$user_auto_id.'" AND a.is_deleted="0"';
      $query=$this->db->query($sql);
      $mTickets=$query->result_array();
      // print "<pre>"; print_r($mTickets); print "</pre>";
      // die();
      if (!empty($mTickets)) {
        foreach ($mTickets as $mData) {
          if (!empty($mData['id'])) {
            $myTicketId=$mData['id'];
            $myTicketSubject=(strlen($mData['subject'])>20)? substr($mData['subject'],0, 20) .'...' : $mData['subject'];
            $myTicketDescription=$mData['description'];
            $myTicketRespTo=$mData['response_to'];
            $myTicketCreation=date('m/d/Y H:i', strtotime($mData['created_on']));
            $myTicketChildCount=$mData['childCount'];

            $nmql='SELECT CONCAT(first_name, " ", last_name) AS responseToName FROM tn_members WHERE id="'.$myTicketRespTo.'"';
            $nmquery=$this->db->query($nmql);
            $nmDetails=$nmquery->result_array();
            $responseToName=(isset($nmDetails[0]['responseToName']) && !empty($nmDetails[0]['responseToName']))? $nmDetails[0]['responseToName'] : 'Super Admin';

            $tql='SELECT a.id, a.response_from FROM tn_support_ticket AS a WHERE a.parent_id="'.$myTicketId.'" AND a.is_deleted="0" ORDER BY id DESC LIMIT 1';
            $tquery=$this->db->query($tql);
            $tTickets=$tquery->result_array();

            $lastChildTicket=(isset($tTickets[0]['id']) && !empty($tTickets[0]['id']))? $tTickets[0]['id'] : 0 ;
            $lastResponseFrom=(isset($tTickets[0]['response_from']) && !empty($tTickets[0]['response_from']))? $tTickets[0]['response_from'] : 0 ;
            $lastRespFrom=0;
            $lastResponseFromName='';
            if (!empty($lastChildTicket) && !empty($lastResponseFrom)) {
              if ($lastResponseFrom!=$user_auto_id) {
                $lastRespFrom=$lastResponseFrom;

                $nmlql='SELECT CONCAT(first_name, " ", last_name) AS responseFromName FROM tn_members WHERE id="'.$lastRespFrom.'"';
                $nmlquery=$this->db->query($nmlql);
                $nmlDetails=$nmlquery->result_array();
                $lastResponseFromName=(isset($nmlDetails[0]['responseFromName']) && !empty($nmlDetails[0]['responseFromName']))? $nmlDetails[0]['responseFromName'] : 'Super Admin';
              }
            }
            $myTickets[]=array('myTicketId'=>$myTicketId, 'myTicketSubject'=>$myTicketSubject, 'myTicketDescription'=>$myTicketDescription, 'myTicketCreation'=>$myTicketCreation, 'myTicketChildCount'=>$myTicketChildCount, 'lastRespFrom'=>$lastRespFrom, 'myTicketRespTo'=>$myTicketRespTo, 'responseToName'=>$responseToName, 'lastResponseFromName'=>$lastResponseFromName);
          }
        }
      }
      

      $sql2='SELECT a.id, a.subject, a.description, a.created_on, a.response_from, (SELECT COUNT(id) FROM tn_support_ticket WHERE parent_id=a.id AND is_deleted="0") AS childCount FROM tn_support_ticket AS a WHERE a.parent_id="0" AND a.response_to="'.$user_auto_id.'" AND a.is_deleted="0"';
      $query2=$this->db->query($sql2);
      $assignedTickets=$query2->result_array();
      
      if (!empty($assignedTickets)) {
        foreach ($assignedTickets as $aData) {
          if (!empty($aData['id'])) {
            $assignTicketId=$aData['id'];
            $assignTicketSubject=(strlen($aData['subject'])>20)? substr($aData['subject'],0, 20) .'...' : $aData['subject'];
            $assignTicketDescription=$aData['description'];
            $ticketCameFromId=$aData['response_from'];
            $assignTicketCreation=date('d/m/Y H:i', strtotime($aData['created_on']));
            $assignTicketChildCount=$aData['childCount'];

            $nmaql='SELECT CONCAT(first_name, " ", last_name) AS ticketCameFromName FROM tn_members WHERE id="'.$ticketCameFromId.'"';
            $nmaquery=$this->db->query($nmaql);
            $nmaDetails=$nmaquery->result_array();
            $ticketCameFromName=(isset($nmaDetails[0]['ticketCameFromName']) && !empty($nmaDetails[0]['ticketCameFromName']))? $nmaDetails[0]['ticketCameFromName'] : 'Super Admin';

            $tql='SELECT a.id, a.response_from FROM tn_support_ticket AS a WHERE a.parent_id="'.$myTicketId.'" AND a.is_deleted="0" ORDER BY id DESC LIMIT 1';
            $tquery=$this->db->query($tql);
            $tTickets=$tquery->result_array();

            $lastChildTicket=(isset($tTickets[0]['id']) && !empty($tTickets[0]['id']))? $tTickets[0]['id'] : 0 ;
            $lastResponseFrom=(isset($tTickets[0]['response_from']) && !empty($tTickets[0]['response_from']))? $tTickets[0]['response_from'] : 0 ;
            $lastAssignRespFrom=0;
            $lastResponseAssignFromName='';
            if (!empty($lastChildTicket) && !empty($lastResponseFrom)) {
              if ($lastResponseFrom!=$user_auto_id) {
                $lastAssignRespFrom=$lastResponseFrom;

                $nmlql='SELECT CONCAT(first_name, " ", last_name) AS responseAssignFromName FROM tn_members WHERE id="'.$lastAssignRespFrom.'"';
                $nmlquery=$this->db->query($nmlql);
                $nmlDetails=$nmlquery->result_array();
                $lastResponseAssignFromName=(isset($nmlDetails[0]['responseAssignFromName']) && !empty($nmlDetails[0]['responseAssignFromName']))? $nmlDetails[0]['responseAssignFromName'] : 'Super Admin';
              }
            }

            $aTickets[]=array('assignTicketId'=>$assignTicketId, 'assignTicketSubject'=>$assignTicketSubject, 'assignTicketDescription'=>$assignTicketDescription, 'assignTicketCreation'=>$assignTicketCreation, 'ticketCameFromId'=>$ticketCameFromId, 'assignTicketChildCount'=>$assignTicketChildCount, 'lastAssignRespFrom'=>$lastAssignRespFrom, 'ticketCameFromName'=>$ticketCameFromName, 'lastResponseAssignFromName'=>$lastResponseAssignFromName);
          }
        }
      }
      
      echo json_encode(array('myTickets'=>$myTickets, 'assignedTickets'=>$aTickets));
      die();
    }

    public function ajaxgetticketresponse()
    {
      $returnArray=array();
      $parentTicket = trim($this->input->post('parentTicketId'));
      $parentTicketId=json_decode($parentTicket, true);
      $user_auto_id=$this->session->userdata('user_auto_id');
      
      $tql='SELECT a.id, a.description, a.response_to, a.response_from, a.created_on, (SELECT CONCAT(first_name, " ", last_name) FROM tn_members WHERE id=a.response_to) AS responseToName, (SELECT CONCAT(first_name, " ", last_name) FROM tn_members WHERE id=a.response_from) AS responseFromName FROM tn_support_ticket AS a WHERE a.parent_id="'.$parentTicketId.'" AND a.is_deleted="0" ORDER BY id DESC';
      $tquery=$this->db->query($tql);
      $returnArray=$tquery->result_array();
      $retArray=array();
      if (!empty($returnArray)) {
        foreach ($returnArray as $retData) {
          $responseId=$retData['id'];
          $responseDescription=$retData['description'];
          $responseTo=$retData['response_to'];
          $responseFrom=$retData['response_from'];
          $responseOn=date('d/m/Y H:i', strtotime($retData['created_on']));
          $responseToName=$retData['responseToName'];
          $responseFromName=$retData['responseFromName'];
          $imResponder=0;
          if ($responseFrom==$user_auto_id) {
            $imResponder=1;
          }
          $imReceiver=0;
          if ($responseTo==$user_auto_id) {
            $imReceiver=1;
          }
          $retArray[]=array('responseId'=>$responseId, 'responseDescription'=>$responseDescription, 'responseOn'=>$responseOn, 'imResponder'=>$imResponder, 'imReceiver'=>$imReceiver, 'responseToName'=>$responseToName, 'responseFromName'=>$responseFromName);
        }
      }
      echo json_encode(array('returnval'=>$retArray));
      die();
    }

    public function ajaxsubmitresponse()
    {

      $user_auto_id=$this->session->userdata('user_auto_id');

      $returnArray=array();
      $manageTicket = $this->input->post('manageTicket');
      $manageTicketData=json_decode($manageTicket, true);
      //print $user_auto_id ;
      //print "<pre>"; print_r($manageTicketData); print "</pre>";
      //die();
      $parentTicketId=$manageTicketData['ticketId'];
      $responderId=$user_auto_id;
      $respondTo=$manageTicketData['ticketResponseTo'];
      $responseData=trim(addslashes($manageTicketData['response']));

      $repArray=array('parent_id'=>$parentTicketId, 'response_from'=>$responderId, 'response_to'=>$respondTo, 'description'=>$responseData, 'created_on'=>date('Y-m-d H:i:s'), 'is_deleted'=>0);

      $retId = $this->User_Model->submit_ticket($repArray, 0);
      echo json_encode(array('retId'=>$retId));
      die();
    }

    public function photos()
	{
		authenticate_user();
		$data=array();
		$data['profileTab']='photoTab';//$this->input->post_get('tab');
		$this->load->view('user/header-script');
		$this->load->view('user/header-bottom');
		$this->load->view('user/profile', $data);
		$this->load->view('user/footer-top');
		$this->load->view('user/footer');
	}



}
	




