<?php
class Administrator_Model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function adminLogin($email, $encrypt_password)
	{
		$this->db->where('email', $email);
		$this->db->where('password', $encrypt_password);

		$result = $this->db->get('users');

		if ($result->num_rows() == 1)
		{
			return $result->row(0);
		}else{
			return false;
		}
	}

	public function update_siteconfiguration($id = FALSE)
	{
		if($id === FALSE){
			$query = $this->db->get('site_config');
			return $query->result_array(); 
		}

		$query = $this->db->get_where('site_config', array('id' => $id));
		return $query->row_array();
	}

	public function get_admin_data()
	{
		$id = $this->session -> userdata('user_id');
		if($id === FALSE){
			$query = $this->db->get('users');
			return $query->result_array(); 
		}

		$query = $this->db->get_where('users', array('id' => $id));
		return $query->row_array();
	}

	public function change_password($new_password){

		$data = array(
			'password' => md5($new_password)
		    );
		$this->db->where('id', $this->session->userdata('user_id'));
		return $this->db->update('users', $data);
	}

	public function match_old_password($password)
	{
		$id = $this->session -> userdata('user_id');
		if($id === FALSE){
			$query = $this->db->get('users');
			return $query->result_array(); 
		}

		$query = $this->db->get_where('users', array('password' => $password));
		return $query->row_array();
	}


	public function get_church_type()
	{
		$arrayChurchType[1]="Basilica";
		$arrayChurchType[2]="Pilgrimage Church";
		$arrayChurchType[3]="Conventual Church";
		$arrayChurchType[4]="Collegiate Church";
		$arrayChurchType[5]="Evangelical Church Structures";
		$arrayChurchType[6]="Alternative Buildings";
		return $arrayChurchType;
	}

	public function get_all_approve_church()
	{
		$sql="SELECT * from tn_members WHERE is_approved='Y' AND membership_type='CM' AND status='1' AND deleted='0' order by first_name ASC";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function get_group_data($id)
	{
		$sql='SELECT * from tn_group WHERE id="'.$id.'"';
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData[0];
	}

	public function addupdategroup($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			return $this->db->where('id',$id)->update('tn_group',$menu_arr);
		}
		else
		{
			$this->db->insert('tn_group',$menu_arr);
			return $this->db->insert_id();
		}
	}
	
	public function get_church_member_type()
	{
		$aryReturn[1]="Free Membership";
		$aryReturn[2]="Church Free Membership";
		return $aryReturn;
	}

	public function check_dup_email($email='',$id=0)
	{
		$strParam='';
		if($id>0)
		{
			$strParam=' AND id!="'.$id.'"';
		}
		$sql="SELECT * from tn_members WHERE user_email='".$email."' AND deleted='0' ".$strParam;
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		if(count($resultData)>0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function addupdatemember($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			return $this->db->where('id',$id)->update('tn_members',$menu_arr);
		}
		else
		{
			$this->db->insert('tn_members',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function get_member_data($id)
	{
		$sql='SELECT * from tn_members WHERE id="'.$id.'"';
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData[0];
	}

	public function getcountrydata()
	{
		$sql="select * from tn_countries";
		$query=$this->db->query($sql);
		$result=$query->result();
		if(!empty($result))
		{
			return $result;
		}
		else
		{
			return array();
		}
	}

	public function getstatedata($countryId)
	{
		$sql="select * from tn_states where country_id='".$countryId."'";
		$query=$this->db->query($sql);
		$result=$query->result();
		if(!empty($result))
		{
			return $result;
		}
		else
		{
			return array();
		}
	}

	public function getcitydata($stateId)
	{
		$sql="select * from tn_cities where state_id='".$stateId."'";
		$query=$this->db->query($sql);
		$result=$query->result();
		if(!empty($result))
		{
			return $result;
		}
		else
		{
			return array();
		}
	}

}
?>