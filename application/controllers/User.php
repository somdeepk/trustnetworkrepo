<?php 
class User extends CI_Controller
{
	public function signup()
	{
		if($this->session->userdata('login'))
		{
			redirect('user/index');
		}

		$data['title'] = ucfirst($page);
		$data['ignoreHeadFoot'] = true;
		$data['content'] = 'user/signup';
		$this->load->view('layout/template', $data);
	}

	public function ajaxsubmitsignup() 
    {
    	$returnData=array();
        $signupData = trim($this->input->post('signupData'));
        $aryMemberData=json_decode($signupData, true);

        $membership_type=(isset($aryMemberData['membership_type']) && !empty($aryMemberData['membership_type']))? addslashes(trim($aryMemberData['membership_type'])):'';

        $membership_option=(isset($aryMemberData['membership_option']) && !empty($aryMemberData['membership_option']))? addslashes(trim($aryMemberData['membership_option'])):'';
        $church_type=(isset($aryMemberData['church_type']) && !empty($aryMemberData['church_type']))? addslashes(trim($aryMemberData['church_type'])):'';
      
        $church_name=(isset($aryMemberData['church_name']) && !empty($aryMemberData['church_name']))? addslashes(trim($aryMemberData['church_name'])):'';

        $first_name=(isset($aryMemberData['first_name']) && !empty($aryMemberData['first_name']))? addslashes(trim($aryMemberData['first_name'])):'';

        $last_name=(isset($aryMemberData['last_name']) && !empty($aryMemberData['last_name']))? addslashes(trim($aryMemberData['last_name'])):'';

        $mobile=(isset($aryMemberData['mobile']) && !empty($aryMemberData['mobile']))? addslashes(trim($aryMemberData['mobile'])):'';

        $dob=(isset($aryMemberData['dob']) && !empty($aryMemberData['dob']))? date('Y-m-d',strtotime($aryMemberData['dob'])) :NULL;

        $user_email=(isset($aryMemberData['user_email']) && !empty($aryMemberData['user_email']))? addslashes(trim($aryMemberData['user_email'])):'';
        $password=(isset($aryMemberData['password']) && !empty($aryMemberData['password']))? addslashes(trim($aryMemberData['password'])):'';     
		$current_date=date('Y-m-d H:i:s');

		$str_is_approved='Y';
		if($membership_type=="PM")
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
				'membership_type'  =>$membership_type,
	            'membership_option'  =>$membership_option,
	            'church_type'  =>$church_type,	            
	            'first_name' => $first_name,
	            'last_name'  =>$last_name,
	            'mobile'  =>$mobile,
	            'dob'  =>$dob,
	            'user_email'  =>$user_email,
	            'password'  =>$password,
	            'is_approved'  =>$str_is_approved,
	            'create_date'  =>$current_date,
	        );

			$lastId = $this->User_Model->addupdatemember(0,$menu_arr);

			if($lastId>0)
			{
				$userLoginData = $this->User_Model->get_member_data($lastId);

				$userLoginData['login']=true;
				$userLoginData['user_auto_id']=$userLoginData['id'];
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

		$ary_cockie['christtube_remember_me'] = $_COOKIE["christtube_remember_me"];
		$jsonCookieRememberMe = json_encode($ary_cockie);
		$data['jsonCookieRememberMe'] = $jsonCookieRememberMe;

		$data['ignoreHeadFoot'] = true;
		$data['content'] = 'user/login';
		$this->load->view('layout/template', $data);
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
			 	$userLoginData['user_full_name']=$userLoginData['first_name']." ".$userLoginData['last_name'];			 	
			 	$userLoginData['email']=$userLoginData['user_email'];
			 	$this->session->set_userdata($userLoginData);

			 	// Start Remember Me block
			 	if($remember_me){
					setcookie("christtube_remember_me",$userLoginData['email'],time()+ (10 * 365 * 24 * 60 * 60));
				}else{
					if(isset($_COOKIE["christtube_remember_me"])){
						setcookie ("christtube_remember_me","");
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

	public function index()
	{
		authenticate_user();

		$data=array();
		$user_auto_id=$this->session->userdata('user_auto_id');
		$data['content'] = 'user/index';
		$this->load->view('layout/template', $data);
	}

	public function viewProfileSetting()
	{
		$data=array();
		$profileSettingData=array();

		$user_auto_id=$this->session->userdata('user_auto_id');
		$memberData = $this->User_Model->get_member_data($user_auto_id);
		$profileSettingData['memberData']=$memberData;

		$data['profileSettingData'] = $profileSettingData;
		$data['hideLayout'] = true;

        $data['content'] = 'user/viewprofilesetting';
		$this->load->view('layout/template', $data);
	}

	public function getLoggedUserData()
	{
		$data=array();

		$profileSettingData = trim($this->input->post('profileSettingData'));
        $profileSettingData=json_decode($profileSettingData, true);
        $loggedUserId=(isset($profileSettingData['loggedUserId']) && !empty($profileSettingData['loggedUserId']))? addslashes(trim($profileSettingData['loggedUserId'])):0;

		$memberData = $this->User_Model->get_member_data($loggedUserId);
		$memberData['GroupData'] = $this->User_Model->get_group_data($loggedUserId);
		$memberData['ChurchData'] = $this->User_Model->get_all_approve_church();
		$memberData['PageData'] = $this->User_Model->get_page_data($loggedUserId);

		$flagBlurMenu=0;
		if(trim($memberData['first_name'])=="" || (trim($memberData['last_name'])=="" && $memberData['membership_type']=='RM') || trim($memberData['user_email'])==""  || empty($memberData['profile_question']) || $memberData['is_pass_changed']=='N' || ($memberData['membership_type']=='RM' && $memberData['parent_id']==0) || trim($memberData['profile_image'])=="" || trim($memberData['cover_image'])=="") //
		{
			//$flagBlurMenu=1;
		}

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Profile Setting Successfully Checked.');
        $returnData['data']=array('memberData'=>base64_encode(json_encode($memberData)),'flagBlurMenu'=>$flagBlurMenu);
        echo json_encode($returnData);
        exit; 
	}

	public function ajaxGetAllChurches()
	{
		$data=array();

		$srchChurchData = trim($this->input->post('srchChurchData'));
        $srchChurchData=json_decode($srchChurchData, true);
        $searchChurch=(isset($srchChurchData['searchChurch']) && !empty($srchChurchData['searchChurch']))? addslashes(trim($srchChurchData['searchChurch'])):'';
		$churchData = $this->User_Model->get_all_approve_church($searchChurch);
		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Profile Setting Successfully Checked.');
        $returnData['data']=array('churchData'=>$churchData);
        echo json_encode($returnData);
        exit; 
	}

	public function ajaxupdateeditgeneraldata() 
    {
        $generalData = trim($this->input->post('generalData'));
        $aryMemberData=json_decode($generalData, true);

        $id=(isset($aryMemberData['id']) && !empty($aryMemberData['id']))? addslashes(trim($aryMemberData['id'])):0;
        $first_name=(isset($aryMemberData['first_name']) && !empty($aryMemberData['first_name']))? addslashes(trim($aryMemberData['first_name'])):'';
        $last_name=(isset($aryMemberData['last_name']) && !empty($aryMemberData['last_name']))? addslashes(trim($aryMemberData['last_name'])):'';
        $assignParentId=(isset($aryMemberData['assignParentId']) && !empty($aryMemberData['assignParentId']))? $aryMemberData['assignParentId']:0;
        $denomination=(isset($aryMemberData['denomination']) && !empty($aryMemberData['denomination']))? addslashes(trim($aryMemberData['denomination'])):'';
        $about_church=(isset($aryMemberData['about_church']) && !empty($aryMemberData['about_church']))? addslashes(trim($aryMemberData['about_church'])):'';
        $address=(isset($aryMemberData['address']) && !empty($aryMemberData['address']))? addslashes(trim($aryMemberData['address'])):'';
        $city=(isset($aryMemberData['city']) && !empty($aryMemberData['city']))? addslashes(trim($aryMemberData['city'])):'';
        $country=(isset($aryMemberData['country']) && !empty($aryMemberData['country']))? addslashes(trim($aryMemberData['country'])):0;
        $state=(isset($aryMemberData['state']) && !empty($aryMemberData['state']))? addslashes(trim($aryMemberData['state'])):0;
        $postal_code=(isset($aryMemberData['postal_code']) && !empty($aryMemberData['postal_code']))? addslashes(trim($aryMemberData['postal_code'])):'';
	
		$current_date=date('Y-m-d H:i:s');   

       	$menu_arr = array(
            'parent_id'  =>$assignParentId,
            'first_name' => $first_name,
            'last_name'  =>$last_name,
            'denomination'  =>$denomination,
            'about_church'  =>$about_church,
            'address'  =>$address,
            'city'  =>$city,
            'country'  =>$country,
            'state'  =>$state,
            'postal_code'  =>$postal_code,
            'update_date'  =>$current_date,
        );

        $lastId = $this->User_Model->addupdatemember($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Member Updated Successfully.');
        $returnData['data']=array('id'=>$lastId);

        echo json_encode($returnData);
        exit;    	
    }

    public function ajaxupdateeditquestiondata() 
    {
        $questionData = trim($this->input->post('questionData'));
        $questionData=json_decode($questionData, true);

        $id=(isset($questionData['id']) && !empty($questionData['id']))? addslashes(trim($questionData['id'])):0;

        $q1=(isset($questionData['q1']) && !empty($questionData['q1']))? addslashes(trim($questionData['q1'])):'';
        $q2=(isset($questionData['q2']) && !empty($questionData['q2']))? addslashes(trim($questionData['q2'])):'';
        $q3=(isset($questionData['q3']) && !empty($questionData['q3']))? addslashes(trim($questionData['q3'])):'';
        $q4=(isset($questionData['q4']) && !empty($questionData['q4']))? addslashes(trim($questionData['q4'])):'';
        $q5=(isset($questionData['q5']) && !empty($questionData['q5']))? addslashes(trim($questionData['q5'])):'';
        $q6=(isset($questionData['q6']) && !empty($questionData['q6']))? addslashes(trim($questionData['q6'])):'';
        $q7=(isset($questionData['q7']) && !empty($questionData['q7']))? addslashes(trim($questionData['q7'])):'';
           
		$aryProfileQuestion['q1']=$q1;
		$aryProfileQuestion['q2']=$q2;
		$aryProfileQuestion['q3']=$q3;
		$aryProfileQuestion['q4']=$q4;
		$aryProfileQuestion['q5']=$q5;
		$aryProfileQuestion['q6']=$q6;
		$aryProfileQuestion['q7']=$q7;

		$strProfileQuestion=json_encode($aryProfileQuestion);

       	$menu_arr = array(
            'profile_question' => $strProfileQuestion
        );

        $lastId = $this->User_Model->addupdatemember($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Question Answer Updated Successfully.');
        $returnData['data']=array('id'=>$lastId);

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
		redirect(base_url().'user/login');
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
	            'password' => $new_password,
	            'is_pass_changed' => 'Y'
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

    public function viewConnection()
	{
		$data=array();
		$profileSettingData=array();

		$data['hideLayout'] = true;

        $data['content'] = 'user/viewconnection';
		$this->load->view('layout/template', $data);
	}

	public function ajaxgetPeopleYouMayNowData() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);

        $loggedUserId=(isset($aryFriendData['loggedUserId']) && !empty($aryFriendData['loggedUserId']))? addslashes(trim($aryFriendData['loggedUserId'])):0;
        $sgtnType=(isset($aryFriendData['sgtnType']) && !empty($aryFriendData['sgtnType']))? addslashes(trim($aryFriendData['sgtnType'])):'';

		$friendData = $this->User_Model->ajaxgetPeopleYouMayNowData($loggedUserId,$sgtnType);

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

    public function ajaxSendFriendRequest() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
    	$aryFriendData['tn_member_friends']=0;
        
        //$member_friends_aid=(isset($aryFriendData['member_friends_aid']) && !empty($aryFriendData['member_friends_aid']))? addslashes(trim($aryFriendData['member_friends_aid'])):0;
		$loggedUserId=(isset($aryFriendData['loggedUserId']) && !empty($aryFriendData['loggedUserId']))? addslashes(trim($aryFriendData['loggedUserId'])):0;
        $friend_id=(isset($aryFriendData['friend_id']) && !empty($aryFriendData['friend_id']))? addslashes(trim($aryFriendData['friend_id'])):0;
        $current_date=date('Y-m-d H:i:s');

        $menu_arr = array(
            'member_id' => $loggedUserId,
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

    public function ajaxRemoveFromSuggestion() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
    	$aryFriendData['tn_member_friends']=0;
        
		$loggedUserId=(isset($aryFriendData['loggedUserId']) && !empty($aryFriendData['loggedUserId']))? addslashes(trim($aryFriendData['loggedUserId'])):0;
        $friend_id=(isset($aryFriendData['friend_id']) && !empty($aryFriendData['friend_id']))? addslashes(trim($aryFriendData['friend_id'])):0;
        $current_date=date('Y-m-d H:i:s');

        $menu_arr = array(
            'member_id' => $loggedUserId,
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
    public function ajaxGetAllFriendRequest() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);

        $loggedUserId=(isset($aryFriendData['loggedUserId']) && !empty($aryFriendData['loggedUserId']))? addslashes(trim($aryFriendData['loggedUserId'])):0;
        $sgtnType=(isset($aryFriendData['sgtnType']) && !empty($aryFriendData['sgtnType']))? addslashes(trim($aryFriendData['sgtnType'])):'';

		$friendData = $this->User_Model->ajaxGetAllFriendRequest($loggedUserId,$sgtnType);

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

    public function viewFriends()
	{
		$data=array();
		$profileSettingData=array();

		$data['hideLayout'] = true;

        $data['content'] = 'user/viewfriends';
		$this->load->view('layout/template', $data);
	}

    public function viewPostPages()
	{
		$data=array();
		$profileSettingData=array();

		$data['hideLayout'] = true;

        $data['content'] = 'user/viewpostpages';
		$this->load->view('layout/template', $data);
	}

	public function ajaxGetAllFriendList() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);

        $loggedUserId=(isset($aryFriendData['loggedUserId']) && !empty($aryFriendData['loggedUserId']))? addslashes(trim($aryFriendData['loggedUserId'])):0;
        $sgtnType=(isset($aryFriendData['sgtnType']) && !empty($aryFriendData['sgtnType']))? addslashes(trim($aryFriendData['sgtnType'])):'';

        $searchFriend=(isset($aryFriendData['searchFriend']) && !empty($aryFriendData['searchFriend']))? addslashes(trim($aryFriendData['searchFriend'])):'';

        $aryArgument['searchFriend']=$searchFriend;
        
		$friendListData = $this->User_Model->ajaxGetAllFriendList($loggedUserId,$sgtnType,$aryArgument);

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

    public function ajaxDeleteMyFriend() 
    {
    	$friendData=$this->input->get_post('friendData');
    	$aryFriendData=json_decode($friendData, true);
    	$aryFriendData['tn_member_friends']=0;
        
		$loggedUserId=(isset($aryFriendData['loggedUserId']) && !empty($aryFriendData['loggedUserId']))? addslashes(trim($aryFriendData['loggedUserId'])):0;
		$myFriendId=(isset($aryFriendData['myFriendId']) && !empty($aryFriendData['myFriendId']))? addslashes(trim($aryFriendData['myFriendId'])):0;
        //$current_date=date('Y-m-d H:i:s');

        /*$menu_arr = array(
            'request_status'  =>'4', //Requser Send
            'deletion_date'  =>$current_date
        );*/

		$deleteFlag = $this->User_Model->ajaxDeleteMyFriend($loggedUserId,$myFriendId);

		$returnData=array();
 		if($deleteFlag>0)
		{
	        $returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Friend Deleted';
	        $returnData['data']=array('deleteFlag'=>$deleteFlag);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Friend Deletion Failed';
	        $returnData['data']=array();
		}
       
        echo json_encode($returnData);
        exit;
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
			$this->User_Model->addUpdatPostFile(0,$menu_arr_post_file);
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

    public function ajaxupdateeditgroupdata() 
    {
    	$groupData = trim($this->input->post('groupData'));
        $aryGroupData=json_decode($groupData, true);

        $id = NULL;
        $member_id=(isset($aryGroupData['loggedUserId']) && !empty($aryGroupData['loggedUserId']))? addslashes(trim($aryGroupData['loggedUserId'])):0;
        $group_name=(isset($aryGroupData['group_name']) && !empty($aryGroupData['group_name']))? addslashes(trim($aryGroupData['group_name'])):'';        
        $group_description=(isset($aryGroupData['group_description']) && !empty($aryGroupData['group_description']))? addslashes(trim($aryGroupData['group_description'])):'';
        $current_date=date('Y-m-d H:i:s');  

        $menu_arr = array(
            'member_id' => $member_id,
            'name' => $group_name,
            'group_desc'  =>$group_description,            
            'is_editable'  =>'Y',
            'create_date'  =>$current_date,
        );

        $lastId = $this->User_Model->addupdategroup($id, $menu_arr);

    	$returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Group Created Successfully.');
        $returnData['data']=array('id'=>$lastId);

        echo json_encode($returnData);
        exit;  
    }

    public function ajaxupdatesecuritydata() 
    {
        $securityData = trim($this->input->post('securityData'));
        $aryMemberData=json_decode($securityData, true);

        $id=(isset($aryMemberData['loggedUserId']) && !empty($aryMemberData['loggedUserId']))? addslashes(trim($aryMemberData['loggedUserId'])):0;   
        $ary_security['who_can_follow_me']=(isset($aryMemberData['who_can_follow_me']) && !empty($aryMemberData['who_can_follow_me']))? $aryMemberData['who_can_follow_me']:false;
        $ary_security['show_my_activities']=(isset($aryMemberData['show_my_activities']) && !empty($aryMemberData['show_my_activities']))? $aryMemberData['show_my_activities']:false;
        $ary_security['encrypted_notification_emails']=(isset($aryMemberData['encrypted_notification_emails']) && !empty($aryMemberData['encrypted_notification_emails']))? $aryMemberData['encrypted_notification_emails']:false;
        $ary_security['allow_commenting']=(isset($aryMemberData['allow_commenting']) && !empty($aryMemberData['allow_commenting']))? $aryMemberData['allow_commenting']:false;

       	$menu_arr = array(
            'security_data' => json_encode($ary_security),
        );
        
        $strstatus="Updated";
        $lastId = $this->User_Model->addupdatemember($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Security '.$strstatus.' Successfully.');
        $returnData['data']=array('id'=>$lastId);

        echo json_encode($returnData);
        exit;    	
    }

    public function ajaxupdatenotificationdata() 
    {
        $notificationData = trim($this->input->post('notificationData'));
        $aryMemberData=json_decode($notificationData, true);

        $id=(isset($aryMemberData['loggedUserId']) && !empty($aryMemberData['loggedUserId']))? addslashes(trim($aryMemberData['loggedUserId'])):0; 

        $ary_notification['comment_email']=(isset($aryMemberData['comment_email']) && !empty($aryMemberData['comment_email']))? $aryMemberData['comment_email']:false;
        $ary_notification['comment_push']=(isset($aryMemberData['comment_push']) && !empty($aryMemberData['comment_push']))? $aryMemberData['comment_push']:false;
        $ary_notification['comment_sms']=(isset($aryMemberData['comment_sms']) && !empty($aryMemberData['comment_sms']))? $aryMemberData['comment_sms']:false;

        $ary_notification['people_email']=(isset($aryMemberData['people_email']) && !empty($aryMemberData['people_email']))? $aryMemberData['people_email']:false;
        $ary_notification['people_push']=(isset($aryMemberData['people_push']) && !empty($aryMemberData['people_push']))? $aryMemberData['people_push']:false;
        $ary_notification['people_sms']=(isset($aryMemberData['people_sms']) && !empty($aryMemberData['people_sms']))? $aryMemberData['people_sms']:false;

        $ary_notification['birthday_email']=(isset($aryMemberData['birthday_email']) && !empty($aryMemberData['birthday_email']))? $aryMemberData['birthday_email']:false;
        $ary_notification['birthday_push']=(isset($aryMemberData['birthday_push']) && !empty($aryMemberData['birthday_push']))? $aryMemberData['birthday_push']:false;
        $ary_notification['birthday_sms']=(isset($aryMemberData['birthday_sms']) && !empty($aryMemberData['birthday_sms']))? $aryMemberData['birthday_sms']:false;

        $ary_notification['event_email']=(isset($aryMemberData['event_email']) && !empty($aryMemberData['event_email']))? $aryMemberData['event_email']:false;
        $ary_notification['event_push']=(isset($aryMemberData['event_push']) && !empty($aryMemberData['event_push']))? $aryMemberData['event_push']:false;
        $ary_notification['event_sms']=(isset($aryMemberData['event_sms']) && !empty($aryMemberData['event_sms']))? $aryMemberData['event_sms']:false;

       	$menu_arr = array(
            'notification_data' => json_encode($ary_notification),
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

    public function ajaxupdateeditpagedata() 
    {
    	$pageData = trim($this->input->post('pageData'));
        $aryPageData=json_decode($pageData, true);

        $id = NULL;
        
        $member_id=(isset($aryPageData['loggedUserId']) && !empty($aryPageData['loggedUserId']))? addslashes(trim($aryPageData['loggedUserId'])):0;
        
        $page_name=(isset($aryPageData['page_name']) && !empty($aryPageData['page_name']))? addslashes(trim($aryPageData['page_name'])):'';
        $page_url=(isset($aryPageData['page_url']) && !empty($aryPageData['page_url']))? addslashes(trim($aryPageData['page_url'])):'';        
        $page_category=(isset($aryPageData['page_category']) && !empty($aryPageData['page_category']))? addslashes(trim($aryPageData['page_category'])):'';
        $page_description=(isset($aryPageData['page_description']) && !empty($aryPageData['page_description']))? addslashes(trim($aryPageData['page_description'])):'';
        $meta_title=(isset($aryPageData['meta_title']) && !empty($aryPageData['meta_title']))? addslashes(trim($aryPageData['meta_title'])):'';
        $meta_keyword=(isset($aryPageData['meta_keyword']) && !empty($aryPageData['meta_keyword']))? addslashes(trim($aryPageData['meta_keyword'])):'';
        $meta_description=(isset($aryPageData['meta_description']) && !empty($aryPageData['meta_description']))? addslashes(trim($aryPageData['meta_description'])):'';
        
        $current_date=date('Y-m-d H:i:s');  

        $menu_arr = array(
            'member_id' => $member_id,
            'name' => $page_name,
            'page_url'  =>$page_url,            
            'page_category'  =>$page_category,
            'page_desc'  =>$page_description,
            'meta_title'  =>$meta_title,
            'meta_keyword'  =>$meta_keyword,
            'meta_description'  =>$meta_description,
            'create_date'  =>$current_date,
        );

        $lastId = $this->User_Model->addupdatepage($id, $menu_arr);

    	$returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Page Created Successfully.');
        $returnData['data']=array('id'=>$lastId);

        echo json_encode($returnData);
        exit;  
    }

    public function ajaxupdateeditimage() 
    {
        $generalData = trim($this->input->post('generalData'));
        $aryMemberData=json_decode($generalData, true);
        $id=(isset($aryMemberData['loggedUserId']) && !empty($aryMemberData['loggedUserId']))? addslashes(trim($aryMemberData['loggedUserId'])):0;        
        $hidden_image_encode=(isset($aryMemberData['hidden_image_encode']) && !empty($aryMemberData['hidden_image_encode']))? addslashes(trim($aryMemberData['hidden_image_encode'])):'';
        $profile_image=(isset($aryMemberData['profile_image']) && !empty($aryMemberData['profile_image']))? addslashes(trim($aryMemberData['profile_image'])):'';
        $current_date=date('Y-m-d H:i:s');  

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
			$this->User_Model->addUpdatPostFile(0,$menu_arr_post_file);
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


    public function ajaxupdatedeletedata() 
    {
        $generalData = trim($this->input->post('generalData'));
        $aryMemberData=json_decode($generalData, true);

        // echo "<pre />"; print_r($aryMemberData['delete_account_date']); die;

        $id=(isset($aryMemberData['loggedUserId']) && !empty($aryMemberData['loggedUserId']))? addslashes(trim($aryMemberData['loggedUserId'])):0;  

        $inactive_account=(isset($aryMemberData['inactive_account']) && !empty($aryMemberData['inactive_account']))? $aryMemberData['inactive_account']:0;

        $delete_account=(isset($aryMemberData['delete_account']) && !empty($aryMemberData['delete_account']))? $aryMemberData['delete_account']:0;

        // echo $inactive_account.' --- '.$delete_account; die;

        $current_date=date('Y-m-d H:i:s');

        $delete_account_date = NULL;
        if($delete_account == 1)
        {
        	if(!$aryMemberData['delete_account_date'])
        	{
        		$delete_account_date = $current_date;
        	}
        	else
        	{
        		$delete_account_date = $aryMemberData['delete_account_date'];
        	}        	
        }

       	$menu_arr = array(
            'inactive_account' => (string) $inactive_account,
            'delete_account' => (string) $delete_account,
            'delete_account_date' => $delete_account_date,
            'update_date'   =>$current_date
        );
        
        $strstatus="Updated";
        $lastId = $this->User_Model->addupdatemember($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Delete Info '.$strstatus.' Successfully.');
        $returnData['data']=array('id'=>$lastId);

        echo json_encode($returnData);
        exit;    	
    }

}
	




