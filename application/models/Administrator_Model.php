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

	public function addupdatechurch($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			return $this->db->where('id',$id)->update('tn_church',$menu_arr);
		}
		else
		{
			$this->db->insert('tn_church',$menu_arr);
			return $this->db->insert_id();
		}
	}	

	public function get_church_data($id)
	{
		$sql='SELECT * from tn_church WHERE id="'.$id.'"';
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData[0];
	}

	public function get_all_church_data()
	{
		$sql='SELECT * from tn_church WHERE deleted="0" and status="1"';
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