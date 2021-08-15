<?php 
class Administrator extends CI_Controller
{

	public function view($page = 'index'){
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

	public function home($page = 'home'){
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
			$sitelogo = $this->Administrator_Model->update_siteconfiguration(1);

			if ($user_id && $user_id->role_id == 1) {
				//Create Session
				$user_data = array(
							'user_id' => $user_id->id,
			 				'username' => $user_id->username,
			 				'email' => $user_id->email,
			 				'login' => true,
			 				'role' => $user_id->role_id,
			 				'image' => $user_id->image,
			 				'site_logo' => $sitelogo['logo_img']
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

	public function churchlist($offset = 0)
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
		$this->load->view('administrator/churchlist', $data);
		$this->load->view('administrator/footer');
	}

	public function ajaxGetChurchList()
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
		
		$searchchurchName=(isset($post_data['searchchurchName']) && $post_data['searchchurchName']!='') ? addslashes($post_data['searchchurchName']) : '' ;
		$searchtrusteeBoard=(isset($post_data['searchtrusteeBoard']) && $post_data['searchtrusteeBoard']!='') ? addslashes($post_data['searchtrusteeBoard']) : '' ;
		$searchfoundationDate=(isset($post_data['searchfoundationDate']) && $post_data['searchfoundationDate']!='') ? addslashes($post_data['searchfoundationDate']) : '' ;
		$searchcontachPerson=(isset($post_data['searchcontachPerson']) && $post_data['searchcontachPerson']!='') ? addslashes($post_data['searchcontachPerson']) : '' ;

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
		
		if (!empty($searchchurchName))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING name LIKE '%".$searchchurchName."%'";
			} else {
				$havingStr.=" AND name LIKE '%".$searchchurchName."%'";
			}
		}
		if (!empty($searchtrusteeBoard)) {
			if (empty($havingStr)) {
				$havingStr.=" HAVING trustee_board LIKE '%".$searchtrusteeBoard."%'";
			} else {
				$havingStr.=" AND trustee_board LIKE '%".$searchtrusteeBoard."%'";
			}
		}

		if (!empty($searchfoundationDate))
		{
			if (empty($havingStr)) {
				$havingStr.=" HAVING DATE_FORMAT(foundation_date,'%d/%m/%Y') LIKE '%".$searchfoundationDate."%'";
			} else {
				$havingStr.=" AND DATE_FORMAT(foundation_date,'%d/%m/%Y' LIKE '%".$searchfoundationDate."%'";
			}
		}

		if (!empty($searchcontachPerson)) {
			if (empty($havingStr)) {
				$havingStr.=" HAVING contact_person LIKE '%".$searchcontachPerson."%'";
			} else {
				$havingStr.=" AND contact_person LIKE '%".$searchcontachPerson."%'";
			}
		}
		
		$sql_main='SELECT * from tn_church WHERE deleted="0" '.$searchStr.' GROUP BY id '.$havingStr;
		$sql_query=$sql_main.$sort_str.' '.$limit_str;
		$query=$this->db->query($sql_query);
		$resultData=$query->result_array();

		$sql_query_total=$sql_main;
		$query=$this->db->query($sql_query_total);
		$result_total=$query->result_array();

		foreach($resultData as $k=>$v)
		{
			$activeInactiveLink='';

			$activeInactiveLink.='<a title="Edit Survey" style="color:#40444a" href="'.base_url().'administrator/addchurch'.'/'.$v['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';

			if($v['status']=='0')
			{
				$activeInactiveLink.='&nbsp;&nbsp;<a title="Inactive" style="color:#ea1620" href="javascript:void(0);" ng-click="change_status(\'1\',\'Are you sure to Active this Church?\','.$v['id'].')" ><i class="fa fa-lock" aria-hidden="true"></i></a>';
			}
			else
			{
				$activeInactiveLink.='&nbsp;&nbsp;<a title="Active" style="color:#339933" href="javascript:void(0);" ng-click="change_status(\'0\',\'Are you sure to Inactive this Church?\','.$v['id'].')" ><i class="fa fa-unlock-alt" aria-hidden="true"></i></a>';
			}

			$activeInactiveLink.='&nbsp;&nbsp;<a title="Delete" style="color:#ea1620" href="javascript:void(0);" ng-click="delete_status(\'Are you sure to Delete this Church?\','.$v['id'].')" ><i class="fa fa-trash" aria-hidden="true"></i></a>';


			$returnArray[]=array(
				'id'=>$v['id'],
				'name'=>(isset($v['name']) && !empty($v['name'])) ? $v['name'] : 'NA',
				'trustee_board'=>(isset($v['trustee_board']) && !empty($v['trustee_board'])) ? $v['trustee_board'] : 'NA',
				'foundation_date'=>(isset($v['foundation_date']) && !empty($v['foundation_date']) && $v['foundation_date']!='0000-00-00 00:00:00') ? date('d/m/Y',strtotime($v['foundation_date'])) : 'NA',
				'contact_person'=>(isset($v['contact_person']) && !empty($v['contact_person'])) ? $v['contact_person'] : 'NA',
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

	public function addchurch($id=0)
	{
		$data=array();

		$churchTypeData = $this->Administrator_Model->get_church_type();
		$data['churchTypeData'] = $churchTypeData;
		$data['id']=$id;

		$this->load->view('administrator/header-script');
		$this->load->view('administrator/header');
		$this->load->view('administrator/header-bottom');
		$this->load->view('administrator/addchurch', $data);
		$this->load->view('administrator/footer');
	}

	public function get_church_data() 
    {
    	$id=$this->input->get_post('id');
		$churchData = $this->Administrator_Model->get_church_data($id);

		$returnData=array();
        $returnData['status']='1';
        $returnData['msg']='';
        $returnData['data']=array('churchData'=>$churchData);
       
        echo json_encode($returnData);
        exit;
    }


	public function ajaxaddupdatechurch() 
    {
        $churchData = trim($this->input->post('churchData'));
        $aryChurchData=json_decode($churchData, true);

        $id=(isset($aryChurchData['id']) && !empty($aryChurchData['id']))? addslashes(trim($aryChurchData['id'])):0;
        $churchName=(isset($aryChurchData['churchName']) && !empty($aryChurchData['churchName']))? addslashes(trim($aryChurchData['churchName'])):'';
        $churchType=(isset($aryChurchData['churchType']) && !empty($aryChurchData['churchType']))? addslashes(trim($aryChurchData['churchType'])):'';
        $contachPerson=(isset($aryChurchData['contachPerson']) && !empty($aryChurchData['contachPerson']))? addslashes(trim($aryChurchData['contachPerson'])):'';
        $trusteeBoard=(isset($aryChurchData['trusteeBoard']) && !empty($aryChurchData['trusteeBoard']))? addslashes(trim($aryChurchData['trusteeBoard'])):'';
        $foundationDate=(isset($aryChurchData['foundationDate']) && !empty($aryChurchData['foundationDate']))? date('Y-m-d H:i:s',strtotime($aryChurchData['foundationDate'])) :NULL;

        $address=(isset($aryChurchData['address']) && !empty($aryChurchData['address']))? addslashes(trim($aryChurchData['address'])):'';
        $city=(isset($aryChurchData['city']) && !empty($aryChurchData['city']))? addslashes(trim($aryChurchData['city'])):'';
        $country=(isset($aryChurchData['country']) && !empty($aryChurchData['country']))? addslashes(trim($aryChurchData['country'])):0;
        $state=(isset($aryChurchData['state']) && !empty($aryChurchData['state']))? addslashes(trim($aryChurchData['state'])):0;
        $postalCode=(isset($aryChurchData['postalCode']) && !empty($aryChurchData['postalCode']))? addslashes(trim($aryChurchData['postalCode'])):'';

        $current_date=date('Y-m-d H:i:s');

       	$menu_arr = array(
            'name' => $churchName,
            'type'  =>$churchType,
            'contact_person'  =>$contachPerson,
            'trustee_board'  =>$trusteeBoard,
            'foundation_date' => $foundationDate,
            'address' => $address,
            'city' => $city,
            'country_id' => $country,
            'state_id' => $state,
            'postal_code' => $postalCode
        );

        if(!empty($id))
        {
        	$strstatus="Updated";
        	$menu_arr['update_date']=$current_date;
        }
        else
        {
        	$strstatus="Added";
        	$menu_arr['create_date']=$current_date;
        }

        $lastId = $this->Administrator_Model->addupdatechurch($id,$menu_arr);

        $returnData=array();
        $returnData['status']='1';
        $returnData['msg']=base64_encode('Church '.$strstatus.' Successfully.');
        $returnData['data']=array('id'=>$lastId);
        echo json_encode($returnData);
        exit;    	  	
    }

    public function ajaxchangechurchstatus()
	{
		$statusData = trim($this->input->post('statusData'));
        $aryStatusData=json_decode($statusData, true);
        
		$id = $aryStatusData['id'];
		$status = $aryStatusData['status'];

		$menu_arr['status']=$status;
		$this->db->where('id',$id)->update('tn_church',$menu_arr);
		echo $id;
		exit;
	}

	public function ajaxdeletechurch()
	{
		$deleteData = trim($this->input->post('deleteData'));
        $aryDeleteData=json_decode($deleteData, true);
 
		$id = $aryDeleteData['id'];

		$menu_arr['deleted']='1';
		$this->db->where('id',$id)->update('tn_church',$menu_arr);
		echo $id;
		exit;
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
				$havingStr.=" AND DATE_FORMAT(create_date,'%d/%m/%Y' LIKE '%".$searchcreateDate."%'";
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

			$activeInactiveLink.='<a title="Edit Survey" style="color:#40444a" href="'.base_url().'administrator/addgroup'.'/'.$v['id'].'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';

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

}
	




