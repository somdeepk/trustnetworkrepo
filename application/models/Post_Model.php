<?php
class Post_Model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function XXXXXX($email, $password)
	{
		$sql="SELECT * FROM tn_members WHERE user_email='".$email."' AND password='".$password."' AND status='1' AND deleted='0'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		if(count($result)>0)
		{
			return $result[0];
		}
		else
		{
			return array();
		}
	}

	public function addupdatepost($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_post',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_post',$menu_arr);
			return $this->db->insert_id();
		}
	}


}
?>