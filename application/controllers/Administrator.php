<?php 
class Administrator extends CI_Controller
{

	public function view($page = 'index')
	{
		if($this->session->userdata('login')) {
			redirect('administrator/dashboard');
			}

		if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
			show_404();
		}
		$data['title'] = ucfirst($page);
		$this->load->view('administrator/header-script');
		//$this->load->view('administrator/header');
		//$this->load->view('administrator/index');
		$this->load->view('administrator/'.$page, $data);
		$this->load->view('administrator/footer');
	}

	public function home($page = 'home')
	{
		if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
			show_404();
		}
		$data['title'] = ucfirst($page);
		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/'.$page, $data);
		$this->load->view('administrator/footer');
	}

	public function dashboard($page = 'dashboard'){
	   if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
	    show_404();
	   }
	   $data['title'] = ucfirst($page);
	   $this->load->view('administrator/header-script');
	   $this->load->view('administrator/header');
	   $this->load->view('administrator/header-bottom');
	   $this->load->view('administrator/'.$page, $data);
	   $this->load->view('administrator/footer');
	} 

  // Log in Admin
	public function adminLogin(){
		$data['title'] = 'Admin Login';

		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() === FALSE){
			//$data['title'] = ucfirst($page);
			$this->load->view('administrator/header-script');
			//$this->load->view('administrator/header');
			//$this->load->view('administrator/header-bottom');
			$this->load->view('administrator/index', $data);
			$this->load->view('administrator/footer');
		}else{
			// get email and Encrypt Password
			$email = $this->input->post('email');
			$encrypt_password = md5($this->input->post('password'));

			$user_id = $this->Administrator_Model->adminLogin($email, $encrypt_password);
			//$sitelogo = $this->Administrator_Model->update_siteconfiguration(1);

			if ($user_id && $user_id->role_id == 1) {
				//Create Session
				$user_data = array(
							'user_id' => $user_id->id,
			 				'username' => $user_id->username,
			 				'email' => $user_id->email,
			 				'login' => true,
			 				'role' => $user_id->role_id,
			 				'image' => $user_id->image,
			 				'site_logo' =>'',// $sitelogo['logo_img']
			 	);

			 	$this->session->set_userdata($user_data);

				//Set Message
				$this->session->set_flashdata('success', 'Welcome to administrator Dashboard.');
				redirect('administrator/dashboard');
			}else{
				$this->session->set_flashdata('danger', 'Login Credential in invalid!');
				redirect('administrator/index');
			}
			
		}
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
		redirect(base_url().'administrator/index');
	}

	public function forget_password($page = 'forget-password')
	{
		if (!file_exists(APPPATH.'views/administrator/'.$page.'.php')) {
			show_404();
		}
		$data['title'] = ucfirst($page);
		$this->load->view('administrator/header-script');
		//$this->load->view('administrator/header');
		//$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/'.$page, $data);
		$this->load->view('administrator/footer');
	}

	

	public function grouplist()
	{
		$data=array();

		$msg=$this->input->post_get('msg');
		if(!empty($msg))
		{
			$msg=base64_decode($msg);
			$this->session->set_flashdata('success', $msg);
		}

		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/grouplist', $data);
		$this->load->view('administrator/footer');
	}

	public function ajaxGetGroupList()
	{
		$post_data=$_POST ;
		$postData = array();
		if(isset($post_data['iColumns']))
		{
		    $new_array=array();
		    for ($i=0; $i<$post_data['iColumns']; $i++)
		    {
		        $new_array[$i]['data']=$i ;
		        $new_array[$i]['name']=$post_data['mDataProp_'.$i] ;
		        $new_array[$i]['searchable']=(isset($post_data['mDataProp_'.$i]) && !empty($post_data['mDataProp_'.$i])) ? $post_data['mDataProp_'.$i] : false ;
		        $new_array[$i]['orderable']=(isset($post_data['bSortable_'.$i]) && !empty($post_data['bSortable_'.$i])) ? $post_data['bSortable_'.$i] : false ;
		        $new_array[$i]['search']['value']='' ;
		        $new_array[$i]['search']['regex']=$post_data['bRegex_'.$i] ;
		    }
		    $postData['columns']=$new_array ;
		    $postData['order'][0]['column']=(isset($post_data['iSortCol_0']) && !empty($post_data['iSortCol_0'])) ? $post_data['iSortCol_0'] : '';
		    $postData['order'][0]['dir']=(isset($post_data['sSortDir_0']) && !empty($post_data['sSortDir_0'])) ? $post_data['sSortDir_0'] : '';
		    $postData['start']=$post_data['iDisplayStart'] ;
		    $postData['length']=$post_data['iDisplayLength'] ;
		}
		
		$searchgroupName=(isset($post_data['searchgroupName']) && $post_data['searchgroupName']!='') ? addslashes($post_data['searchgroupName']) : '' ;
		$searchcreateDate=(isset($post_data['searchcreateDate']) && $post_data['searchcreateDate']!='') ? addslashes($post_data['searchcreateDate']) : '' ;

		$limit_str='';
		$sort_str=' ORDER BY id DESC';

		if (!empty($postData['columns']))
		{
			$columns=$postData['columns'] ;
			foreach ($columns as $colkey=>$colval)
			{
				$colm_name=$colval['name'];
				if ($colval['orderable']== true && !empty($postData['order'][0]['column']))
				{
					if ($postData['order'][0]['column']==1) {
						$sort_str=' ORDER BY name '. $postData['order'][0]['dir'];
					} else if ($postData['order'][0]['column']==2) {
						$sort_str=' ORDER BY create_date '. $postData['order'][0]['dir'];
					}
				}
			}
		}
		if (!empty($postData))
		{
		    if (isset($postData['start']) && !empty($postData['length']))
		    {
		        $limit_str=' LIMIT '.$postData['start'].' , '.$postData['length'];
		    }
		}

		$returnArray=array();
		$searchStr="";
		$havingStr="";
		
		if (!empty($searchgroupName))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING name LIKE '%".$searchgroupName."%'";
			} else {
				$havingStr.=" AND name LIKE '%".$searchgroupName."%'";
			}
		}
		
		if (!empty($searchcreateDate))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING DATE_FORMAT(create_date,'%d/%m/%Y') LIKE '%".$searchcreateDate."%'";
			} else {
				$havingStr.=" AND DATE_FORMAT(create_date,'%d/%m/%Y') LIKE '%".$searchcreateDate."%'";
			}
		}

		
		$sql_main='SELECT * from tn_group WHERE deleted="0" '.$searchStr.' GROUP BY id '.$havingStr;
		$sql_query=$sql_main.$sort_str.' '.$limit_str;
		$query=$this->db->query($sql_query);
		$resultData=$query->result_array();

		$sql_query_total=$sql_main;
		$query=$this->db->query($sql_query_total);
		$result_total=$query->result_array();

		foreach($resultData as $k=>$v)
		{
			$activeInactiveLink='';

			$activeInactiveLink.='<a title="Edit Group" style="color:#40444a" href="'.base_url().'administrator/addgroup'.'/'.$v['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';

			if($v['status']=='0')
			{
				$activeInactiveLink.='&nbsp;&nbsp;<a title="Inactive" style="color:#ea1620" href="javascript:void(0);" ng-click="change_group_status(\'1\',\'Are you sure to Active this Group?\','.$v['id'].')" ><i class="fa fa-lock" aria-hidden="true"></i></a>';
			}
			else
			{
				$activeInactiveLink.='&nbsp;&nbsp;<a title="Active" style="color:#339933" href="javascript:void(0);" ng-click="change_group_status(\'0\',\'Are you sure to Inactive this Group?\','.$v['id'].')" ><i class="fa fa-unlock-alt" aria-hidden="true"></i></a>';
			}

			$activeInactiveLink.='&nbsp;&nbsp;<a title="Delete" style="color:#ea1620" href="javascript:void(0);" ng-click="delete_group_status(\'Are you sure to Delete this Group?\','.$v['id'].')" ><i class="fa fa-trash" aria-hidden="true"></i></a>';


			$returnArray[]=array(
				'id'=>$v['id'],
				'name'=>(isset($v['name']) && !empty($v['name'])) ? $v['name'] : 'NA',
				'create_date'=>(isset($v['create_date']) && !empty($v['create_date']) && $v['create_date']!='0000-00-00 00:00:00') ? date('d/m/Y',strtotime($v['create_date'])) : 'NA',
				'action'=>$activeInactiveLink
			);
		}

		/*echo "<pre>";
		print_r($returnArray);
		exit;*/

		$totcount=count($result_total);
		$json_data = array('jsonData'=> array(
		        "draw"            => intval($post_data['sEcho']),  // Just a Random Number for Draw
		        "recordsTotal"    => intval($totcount), // Total records count without searching and limit
		        "recordsFiltered" => intval($totcount), //records count after searching(if not search then equals totalcount)
		        "aaData"          => $returnArray //This array contains all the datatable rows which will be shown in the front end
		        ));
		echo json_encode($json_data); die();
	}

	public function addgroup($id=0)
	{
		$data=array();

		$data['id']=$id;
		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/addgroup', $data);
		$this->load->view('administrator/footer');
	}

	public function get_group_data() 
    {
    	$id=$this->input->get_post('id');
		$groupData = $this->Administrator_Model->get_group_data($id);

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('groupData'=>$groupData);
       
        echo json_encode($returnData);
        exit;
    }

	public function ajaxaddupdategroup() 
    {
        $groupData = trim($this->input->post('groupData'));
        $aryChurchData=json_decode($groupData, true);

        $id=(isset($aryChurchData['id']) && !empty($aryChurchData['id']))? addslashes(trim($aryChurchData['id'])):0;

        $groupName=(isset($aryChurchData['groupName']) && !empty($aryChurchData['groupName']))? addslashes(trim($aryChurchData['groupName'])):'';
        $groupDesc=(isset($aryChurchData['groupDesc']) && !empty($aryChurchData['groupDesc']))? addslashes(trim($aryChurchData['groupDesc'])):'';

        $current_date=date('Y-m-d H:i:s');

       	$menu_arr = array(
            'name' => $groupName,
            'group_desc'  =>$groupDesc,
        );

        if(!empty($id))
        {
        	$strstatus="Updated";
        	$menu_arr['update_date']=$current_date;
        }
        else{
        	$strstatus="Added";
        	$menu_arr['create_date']=$current_date;
        }

        $lastId = $this->Administrator_Model->addupdategroup($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Group '.$strstatus.' Successfully.');
        $returnData['data']=array('id'=>$lastId);

        echo json_encode($returnData);
        exit;    	
    }

    public function ajaxchangegroupstatus()
	{
		$statusData = trim($this->input->post('statusData'));
        $aryStatusData=json_decode($statusData, true);
        
		$id = $aryStatusData['id'];
		$status = $aryStatusData['status'];

		$menu_arr['status']=$status;
		$this->db->where('id',$id)->update('tn_group',$menu_arr);
		echo $id;
		exit;
	}

	public function ajaxdeletegroup()
	{
		$deleteData = trim($this->input->post('deleteData'));
        $aryDeleteData=json_decode($deleteData, true);
 
		$id = $aryDeleteData['id'];

		$menu_arr['deleted']='1';
		$this->db->where('id',$id)->update('tn_group',$menu_arr);
		echo $id;
		exit;
	}

	public function memberlist($church_id = 0)
	{
		$data=array();

		$msg=$this->input->post_get('msg');
		if(!empty($msg))
		{
			$msg=base64_decode($msg);
			$this->session->set_flashdata('success', $msg);
		}
		$data['church_id']=$church_id;
		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/churchmember/memberlist', $data);
		$this->load->view('administrator/footer');
	}
	public function ajaxGetMemberList()
	{
		$post_data=$_POST ;
		$postData = array();
		if(isset($post_data['iColumns']))
		{
		    $new_array=array();
		    for ($i=0; $i<$post_data['iColumns']; $i++)
		    {
		        $new_array[$i]['data']=$i ;
		        $new_array[$i]['name']=$post_data['mDataProp_'.$i] ;
		        $new_array[$i]['searchable']=(isset($post_data['mDataProp_'.$i]) && !empty($post_data['mDataProp_'.$i])) ? $post_data['mDataProp_'.$i] : false ;
		        $new_array[$i]['orderable']=(isset($post_data['bSortable_'.$i]) && !empty($post_data['bSortable_'.$i])) ? $post_data['bSortable_'.$i] : false ;
		        $new_array[$i]['search']['value']='' ;
		        $new_array[$i]['search']['regex']=$post_data['bRegex_'.$i] ;
		    }
		    $postData['columns']=$new_array ;
		    $postData['order'][0]['column']=(isset($post_data['iSortCol_0']) && !empty($post_data['iSortCol_0'])) ? $post_data['iSortCol_0'] : '';
		    $postData['order'][0]['dir']=(isset($post_data['sSortDir_0']) && !empty($post_data['sSortDir_0'])) ? $post_data['sSortDir_0'] : '';
		    $postData['start']=$post_data['iDisplayStart'] ;
		    $postData['length']=$post_data['iDisplayLength'] ;
		}
		
		$search_full_name=(isset($post_data['search_full_name']) && $post_data['search_full_name']!='') ? addslashes($post_data['search_full_name']) : '' ;
		$search_dob=(isset($post_data['search_dob']) && $post_data['search_dob']!='') ? addslashes($post_data['search_dob']) : '' ;
		$search_user_email=(isset($post_data['search_user_email']) && $post_data['search_user_email']!='') ? addslashes($post_data['search_user_email']) : '' ;
		$search_contact_mobile=(isset($post_data['search_contact_mobile']) && $post_data['search_contact_mobile']!='') ? addslashes($post_data['search_contact_mobile']) : '' ;
		$search_membership_type=(isset($post_data['search_membership_type']) && $post_data['search_membership_type']!='') ? addslashes($post_data['search_membership_type']) : '' ;
		$search_church_name=(isset($post_data['search_church_name']) && $post_data['search_church_name']!='') ? addslashes($post_data['search_church_name']) : '' ;
		
		$limit_str='';
		$sort_str=' ORDER BY id DESC';

		if (!empty($postData['columns'])) {
			$columns=$postData['columns'] ;
			foreach ($columns as $colkey=>$colval)
			{
				$colm_name=$colval['name'];
				if ($colval['orderable']== true && !empty($postData['order'][0]['column'])) {
					if ($postData['order'][0]['column']==1) {
						$sort_str=' ORDER BY name '. $postData['order'][0]['dir'];
					} else if ($postData['order'][0]['column']==2) {
						$sort_str=' ORDER BY trustee_board '.$postData['order'][0]['dir'];
					} else if ($postData['order'][0]['column']==3) {
						$sort_str=' ORDER BY foundation_date '. $postData['order'][0]['dir'];
					} else if ($postData['order'][0]['column']==4) {
						$sort_str=' ORDER BY contact_person '. $postData['order'][0]['dir'];
					}
				}
			}
		}
		if (!empty($postData))
		{
		    if (isset($postData['start']) && !empty($postData['length']))
		    {
		        $limit_str=' LIMIT '.$postData['start'].' , '.$postData['length'];
		    }
		}

		$returnArray=array();
		$searchStr="";
		$havingStr="";
		
		if (!empty($search_full_name))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING (tm.first_name LIKE '%".$search_full_name."%' OR tm.last_name LIKE '%".$search_full_name."%')";
			} else {
				$havingStr.=" AND (tm.first_name LIKE '%".$search_full_name."%' OR tm.last_name LIKE '%".$search_full_name."%')";
			}
		}

		if (!empty($search_dob))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING DATE_FORMAT(tm.dob,'%d/%m/%Y') LIKE '%".$search_dob."%'";
			} else {
				$havingStr.=" AND DATE_FORMAT(tm.dob,'%d/%m/%Y') LIKE '%".$search_dob."%'";
			}
		}

		if (!empty($search_user_email))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING tm.user_email LIKE '%".$search_user_email."%'";
			} else {
				$havingStr.=" AND tm.user_email LIKE '%".$search_user_email."%'";
			}
		}

		if (!empty($search_contact_mobile))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING tm.contact_mobile LIKE '%".$search_contact_mobile."%'";
			} else {
				$havingStr.=" AND tm.contact_mobile LIKE '%".$search_contact_mobile."%'";
			}
		}

		if (!empty($search_church_name))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING tm2.first_name LIKE '%".$search_church_name."%'";
			} else {
				$havingStr.=" AND tm2.first_name LIKE '%".$search_church_name."%'";
			}
		}

		if (!empty($search_membership_type))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING tm.membership_type LIKE '%".$search_membership_type."%'";
			} else {
				$havingStr.=" AND tm.membership_type LIKE '%".$search_membership_type."%'";
			}
		}

		
		$sql_main='SELECT 
					tm.*,
					tm2.first_name as church_name
					FROM tn_members as tm 
					LEFT JOIN tn_members as tm2 On tm2.id=tm.parent_id
					WHERE tm.deleted="0" '.$searchStr.' GROUP BY id '.$havingStr;

		$sql_query=$sql_main.$sort_str.' '.$limit_str;
		$query=$this->db->query($sql_query);
		$resultData=$query->result_array();

		$sql_query_total=$sql_main;
		$query=$this->db->query($sql_query_total);
		$result_total=$query->result_array();

		/*echo "<pre>";
		print_r($resultData);
		exit;*/

		foreach($resultData as $k=>$v)
		{
			$activeInactiveLink='';

			$activeInactiveLink.='<a title="Edit Member" style="color:#40444a" href="'.base_url().'administrator/addmember'.'/'.$v['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';

			if($v['status']=='0')
			{
				$activeInactiveLink.='&nbsp;&nbsp;<a title="Inactive" style="color:#ea1620" href="javascript:void(0);" ng-click="change_status(\'1\',\'Are you sure to Active this Member?\','.$v['id'].')" ><i class="fa fa-lock" aria-hidden="true"></i></a>';
			}
			else
			{
				$activeInactiveLink.='&nbsp;&nbsp;<a title="Active" style="color:#339933" href="javascript:void(0);" ng-click="change_status(\'0\',\'Are you sure to Inactive this Member?\','.$v['id'].')" ><i class="fa fa-unlock-alt" aria-hidden="true"></i></a>';
			}

			$activeInactiveLink.='&nbsp;&nbsp;<a title="Delete" style="color:#ea1620" href="javascript:void(0);" ng-click="delete_status(\'Are you sure to Delete this Member?\','.$v['id'].')" ><i class="fa fa-trash" aria-hidden="true"></i></a>';

			if($v['is_approved']=='Y')
			{
				$activeInactiveLink.='&nbsp;&nbsp;<a title="Click to Disapprove" style="color:#339933" href="javascript:void(0);" ng-click="change_approve_status(\'N\',\'Are you sure to Disapprove this Member?\','.$v['id'].')" ><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>';
			}
			else
			{
				$activeInactiveLink.='&nbsp;&nbsp;<a title="Click to Approve" style="color:#ea1620" href="javascript:void(0);" ng-click="change_approve_status(\'Y\',\'Are you sure to Approve this Member?\','.$v['id'].')" ><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>';
			}


			$str_full_name=$v['first_name']." ".$v['last_name'];
			if($v['membership_type']=="RM")
			{
				$str_membership_type="Regular Membership";
			}
			else
			{
				$str_membership_type="Church Membership";
			}

			$returnArray[]=array(
				'id'=>$v['id'],
				'full_name'=>$str_full_name,
				'dob'=>(isset($v['dob']) && !empty($v['dob']) && $v['dob']!='0000-00-00 00:00:00') ? date('d/m/Y',strtotime($v['dob'])) : 'NA',
				'user_email'=>(isset($v['user_email']) && !empty($v['user_email'])) ? $v['user_email'] : 'NA',
				'contact_mobile'=>(isset($v['contact_mobile']) && !empty($v['contact_mobile'])) ? $v['contact_mobile'] : 'NA',
				'membership_type'=>$str_membership_type,
				'church_name'=>(isset($v['church_name']) && !empty($v['church_name'])) ? $v['church_name'] : 'NA',

				'action'=>$activeInactiveLink
			);
		}

		/*echo "<pre>";
		print_r($returnArray);
		exit;*/

		$totcount=count($result_total);
		$json_data = array('jsonData'=> array(
		        "draw"            => intval($post_data['sEcho']),  // Just a Random Number for Draw
		        "recordsTotal"    => intval($totcount), // Total records count without searching and limit
		        "recordsFiltered" => intval($totcount), //records count after searching(if not search then equals totalcount)
		        "aaData"          => $returnArray //This array contains all the datatable rows which will be shown in the front end
		        ));
		echo json_encode($json_data); die();
	}

	public function addmember($id=0)
	{
		$data=array();

		$churchMemberTypeData = $this->Administrator_Model->get_church_member_type();
		$data['churchMemberTypeData'] = $churchMemberTypeData;

		$churchTypeData = $this->Administrator_Model->get_church_type();
		$data['churchTypeData'] = $churchTypeData;
		
		$all_church_data = $this->Administrator_Model->get_all_approve_church();
		$data['all_church_data'] = $all_church_data;

		$memberData = $this->Administrator_Model->get_member_data($id);
		$jsonMemberData = json_encode($memberData);
		$data['jsonMemberData'] = $jsonMemberData;

		/*echo "<pre>";
		print_r($data['all_church_data']);
		exit;*/

		$data['id']=$id;

		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/churchmember/addmember', $data);
		$this->load->view('administrator/footer');
	}

	public function ajaxaddupdatemember() 
    {
        $memberData = trim($this->input->post('memberData'));
        $aryMemberData=json_decode($memberData, true);

        $id=(isset($aryMemberData['id']) && !empty($aryMemberData['id']))? addslashes(trim($aryMemberData['id'])):0;

        $membership_type=(isset($aryMemberData['membership_type']) && !empty($aryMemberData['membership_type']))? addslashes(trim($aryMemberData['membership_type'])):'';

        $church_name=(isset($aryMemberData['church_name']) && !empty($aryMemberData['church_name']))? addslashes(trim($aryMemberData['church_name'])):'';
        $type=(isset($aryMemberData['type']) && !empty($aryMemberData['type']))? addslashes(trim($aryMemberData['type'])):0;
        $trustee_board=(isset($aryMemberData['trustee_board']) && !empty($aryMemberData['trustee_board']))? addslashes(trim($aryMemberData['trustee_board'])):'';

        $first_name=(isset($aryMemberData['first_name']) && !empty($aryMemberData['first_name']))? addslashes(trim($aryMemberData['first_name'])):'';
        $last_name=(isset($aryMemberData['last_name']) && !empty($aryMemberData['last_name']))? addslashes(trim($aryMemberData['last_name'])):'';
        $church_id=(isset($aryMemberData['church_id']) && !empty($aryMemberData['church_id']))? addslashes(trim($aryMemberData['church_id'])):0;         
        $gender=(isset($aryMemberData['gender']) && !empty($aryMemberData['gender']))? addslashes(trim($aryMemberData['gender'])):'';
        $marital_status=(isset($aryMemberData['marital_status']) && !empty($aryMemberData['marital_status']))? addslashes(trim($aryMemberData['marital_status'])):'';
       
       	$dob=(isset($aryMemberData['dob']) && !empty($aryMemberData['dob']))? date('Y-m-d',strtotime($aryMemberData['dob'])) :NULL;
        
        $user_email=(isset($aryMemberData['user_email']) && !empty($aryMemberData['user_email']))? addslashes(trim($aryMemberData['user_email'])):'';
        $contact_person=(isset($aryMemberData['contact_person']) && !empty($aryMemberData['contact_person']))? addslashes(trim($aryMemberData['contact_person'])):'';
        $contact_mobile=(isset($aryMemberData['contact_mobile']) && !empty($aryMemberData['contact_mobile']))? addslashes(trim($aryMemberData['contact_mobile'])):'';
        $contact_alt_mobile=(isset($aryMemberData['contact_alt_mobile']) && !empty($aryMemberData['contact_alt_mobile']))? addslashes(trim($aryMemberData['contact_alt_mobile'])):'';
        $alt_email=(isset($aryMemberData['alt_email']) && !empty($aryMemberData['alt_email']))? addslashes(trim($aryMemberData['alt_email'])):'';
        $website=(isset($aryMemberData['website']) && !empty($aryMemberData['website']))? addslashes(trim($aryMemberData['website'])):'';

        $address=(isset($aryMemberData['address']) && !empty($aryMemberData['address']))? addslashes(trim($aryMemberData['address'])):'';
        $city=(isset($aryMemberData['city']) && !empty($aryMemberData['city']))? addslashes(trim($aryMemberData['city'])):'';
        $country=(isset($aryMemberData['country']) && !empty($aryMemberData['country']))? addslashes(trim($aryMemberData['country'])):0;
        $state=(isset($aryMemberData['state']) && !empty($aryMemberData['state']))? addslashes(trim($aryMemberData['state'])):0;
        $postal_code=(isset($aryMemberData['postal_code']) && !empty($aryMemberData['postal_code']))? addslashes(trim($aryMemberData['postal_code'])):'';
		
		$password=rand(111111,999999);
		$current_date=date('Y-m-d H:i:s');
		if($membership_type=="CM")
		{
			$first_name=$church_name;
		}

		$flagDupEmail = $this->Administrator_Model->check_dup_email($user_email,$id);

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
	       		'parent_id'  =>$church_id,
	            'membership_type'  =>$membership_type,
	            'first_name' => $first_name,
	            'last_name'  =>$last_name,
	            'type'  =>$type,
	            'trustee_board'  =>$trustee_board,
	            'type'  =>$type,
	            'gender'  =>$gender,
	            'marital_status'  =>$marital_status,
	            'dob'  =>$dob,
	            
	            'contact_person'  =>$contact_person,
	            'contact_mobile'  =>$contact_mobile,
	            'contact_alt_mobile'  =>$contact_alt_mobile,
	            'alt_email'  =>$alt_email,
	            'website'  =>$website,
	            'address'  =>$address,
	            'city'  =>$city,
	            'country'  =>$country,
	            'state'  =>$state,
	            'postal_code'  =>$postal_code,
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

	        if(!empty($id))
	        {
	        	$strstatus="Updated";
	        	$menu_arr['update_date']=$current_date;
	        	
	        }else{
	        	$strstatus="Added";
	        	$menu_arr['create_date']=$current_date;
	        	$menu_arr['password']=$password;
	        	$menu_arr['user_email']=$user_email;
	        }

	        $lastId = $this->Administrator_Model->addupdatemember($id,$menu_arr);
	        if($lastId>0)
			{
				$returnData['status']='1';
		        $returnData['msg']='success';
		        $returnData['msgstring']=base64_encode('Member '.$strstatus.' Successfully.');
		        $returnData['data']=array('userLoginData'=>$userLoginData);
			}
			else
			{
				$returnData['status']='0';
		        $returnData['msg']='error';
		        $returnData['msgstring']='Member Addition Failed';
		        $returnData['data']=array();
			}
		}
        echo json_encode($returnData);
        exit;    	
    }

    public function ajaxchangememberapprovestatus()
	{
		$statusData = trim($this->input->post('statusData'));
        $aryStatusData=json_decode($statusData, true);
        
		$id = $aryStatusData['id'];
		$is_approved = $aryStatusData['is_approved'];

		$menu_arr['is_approved']=$is_approved;
		$this->db->where('id',$id)->update('tn_members',$menu_arr);
		echo $id;
		exit;
	}

	public function ajaxchangememberstatus()
	{
		$statusData = trim($this->input->post('statusData'));
        $aryStatusData=json_decode($statusData, true);
        
		$id = $aryStatusData['id'];
		$status = $aryStatusData['status'];

		$menu_arr['status']=$status;
		$this->db->where('id',$id)->update('tn_members',$menu_arr);
		echo $id;
		exit;
	}

	public function ajaxdeletemember()
	{
		$deleteData = trim($this->input->post('deleteData'));
        $aryDeleteData=json_decode($deleteData, true);
 
		$id = $aryDeleteData['id'];

		$menu_arr['deleted']='1';
		$this->db->where('id',$id)->update('tn_members',$menu_arr);
		echo $id;
		exit;
	}

    /*public function get_member_data() 
    {
    	$id=$this->input->get_post('id');
		$memberData = $this->Administrator_Model->get_member_data($id);

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('memberData'=>$memberData);
       
        echo json_encode($returnData);
        exit;
    }*/

    public function getcountrydata() 
    {
		$countryData = $this->Administrator_Model->getcountrydata();
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
		$stateData = $this->Administrator_Model->getstatedata($countryId);

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
		$cityData = $this->Administrator_Model->getcitydata($stateId);

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('cityData'=>$cityData);
       
        echo json_encode($returnData);
        exit;
    }

}
	



