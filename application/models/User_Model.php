<?php
class User_Model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}
	public function ajaxcheckuserlogin($email, $password)
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

	public function addupdatemember($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_members',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_members',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function ajaxAddUpdateMemberFriends($menu_arr=NULL,$member_friends_aid=0)
	{
		$member_id=$menu_arr['member_id'];
		$friend_id=$menu_arr['friend_id'];
		$sql='SELECT * from tn_member_friends WHERE member_id="'.$member_id.'" AND friend_id="'.$friend_id.'"';
		$query=$this->db->query($sql);
		$rowData=$query->row();
		$member_friends_aid=0;
		if(!empty($rowData) && $rowData->id>0)
		{
			$member_friends_aid=$rowData->id;
		}
		if(!empty($member_friends_aid) && $member_friends_aid>0)
		{
			$this->db->where('id',$member_friends_aid)->update('tn_member_friends',$menu_arr);
			return $member_friends_aid;
		}
		else
		{
			$this->db->insert('tn_member_friends',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function ajaxConfirmDeleteFriendRequest($menu_arr=NULL,$member_friends_aid=0)
	{
		if(!empty($member_friends_aid) && $member_friends_aid>0)
		{
			$this->db->where('id',$member_friends_aid)->update('tn_member_friends',$menu_arr);
			return $member_friends_aid;
		}
		else
		{
			$this->db->insert('tn_member_friends',$menu_arr);
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

	public function ajaxgetPeopleYouMayNowData($user_auto_id,$clickProfileTab="")
	{
		$strWhereParam="";
		if(!empty($clickProfileTab))
		{
			if($clickProfileTab=="churchrequestTab")
			{
				$strWhereParam=" AND tm.membership_type='CM'";
			}
			elseif($clickProfileTab=="memberrequestTab")
			{
				$strWhereParam=" AND tm.membership_type='RM'";
			}
		}

		$sql="SELECT 
				tm.*,
				tmf.id as member_friends_aid, 
				tmf.request_status ,
				tmf.member_id 
				FROM tn_members as tm
				LEFT JOIN tn_member_friends as tmf ON tm.id=tmf.friend_id AND tmf.member_id ='".$user_auto_id."'
				WHERE 
				tm.id NOT IN (SELECT friend_id FROM tn_member_friends as tmf WHERE tmf.member_id='".$user_auto_id."' AND tmf.request_status!='1')

    			AND tm.id NOT IN (SELECT member_id FROM tn_member_friends as tmf WHERE tmf.friend_id='".$user_auto_id."' AND (tmf.request_status='1' OR tmf.request_status='2'))

    			AND tm.id NOT IN (SELECT friend_id FROM tn_member_friends as tmf WHERE tmf.member_id='".$user_auto_id."'  AND tmf.request_status!='1')

    			AND tm.id!='".$user_auto_id."' AND tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' ".$strWhereParam." order by first_name ASC";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

//AND tm.id NOT IN (SELECT friend_id FROM tn_member_friends as tmf WHERE tmf.member_id='".$user_auto_id."'  AND tmf.request_status='1' )
	/*$sql="SELECT 
				tm.*,
				tmf.id as member_friends_aid, 
				tmf.request_status,
				(SELECT GROUP_CONCAT(friend_id) FROM tn_member_friends as tmf WHERE tmf.member_id='".$user_auto_id."'  AND tmf.request_status='1' ) AS tempFriend
				FROM tn_members as tm
				LEFT JOIN tn_member_friends as tmf ON tm.id=tmf.friend_id
				WHERE 
				tm.id NOT IN (SELECT friend_id FROM tn_member_friends as tmf WHERE tmf.member_id='".$user_auto_id."' AND tmf.request_status!='1' )
    			AND tm.id NOT IN (SELECT member_id FROM tn_member_friends as tmf WHERE tmf.friend_id='".$user_auto_id."' AND tmf.request_status='1' )
    			AND tm.id!='".$user_auto_id."' AND tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' order by first_name ASC";*/
    	


	public function ajaxGetAllFriendRequest($user_auto_id,$clickProfileTab="")
	{
		$strWhereParam="";
		if(!empty($clickProfileTab))
		{
			if($clickProfileTab=="churchrequestTab")
			{
				$strWhereParam=" AND tm.membership_type='CM'";
			}
			elseif($clickProfileTab=="memberrequestTab")
			{
				$strWhereParam=" AND tm.membership_type='RM'";
			}
		}

		$sql="SELECT 
				tm.*,
				tmf.id as member_friends_aid, 
				tmf.request_status 
				FROM tn_members as tm
				LEFT JOIN tn_member_friends as tmf ON tm.id=tmf.member_id
				WHERE tm.id IN 
    			(SELECT member_id FROM tn_member_friends as tmf WHERE tmf.friend_id='".$user_auto_id."' AND tmf.request_status='1' ) AND tm.id!='".$user_auto_id."' AND tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' ".$strWhereParam." order by first_name ASC";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function ajaxGetAllFriendList($user_auto_id,$clickProfileTab="")
	{
		$strWhereParam="";
		if(!empty($clickProfileTab))
		{
			if($clickProfileTab=="churchlistTab")
			{
				$strWhereParam=" AND tm.membership_type='CM'";
			}
			if($clickProfileTab=="memberlistTab")
			{
				$strWhereParam=" AND tm.membership_type='RM'";
			}
		}

		$sql="SELECT 
				tm.* 
				FROM tn_members as tm
				WHERE 
				(
					tm.id IN
    				(SELECT friend_id FROM tn_member_friends as tmf WHERE tmf.member_id='".$user_auto_id."' AND tmf.request_status='2') OR tm.id IN 
    				(SELECT member_id FROM tn_member_friends as tmf WHERE tmf.friend_id='".$user_auto_id."' AND tmf.request_status='2')
    			)
    			AND tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' ".$strWhereParam." order by first_name ASC";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function ajaxGetAllChurchMember($aryFriendData)
	{
		$clickProfileTab=(isset($aryFriendData['clickProfileTab']) && !empty($aryFriendData['clickProfileTab']))? addslashes(trim($aryFriendData['clickProfileTab'])):'';
		$user_auto_id=(isset($aryFriendData['user_auto_id']) && !empty($aryFriendData['user_auto_id']))? addslashes(trim($aryFriendData['user_auto_id'])):0;
		$parent_id=(isset($aryFriendData['parent_id']) && !empty($aryFriendData['parent_id']))? addslashes(trim($aryFriendData['parent_id'])):0;
		$membership_type=(isset($aryFriendData['membership_type']) && !empty($aryFriendData['membership_type']))? addslashes(trim($aryFriendData['membership_type'])):'N';        
		
		if($membership_type=='CM')
		{
			$strParamWhere=" AND tm.parent_id='".$user_auto_id."'";
		}
		else
		{
			$strParamWhere=" AND tm.parent_id='".$parent_id."' AND tm.id!='".$user_auto_id."'";
		}

		$sql="SELECT 
				tm.* 
				FROM tn_members as tm
				WHERE tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' ".$strParamWhere." order by first_name ASC";

		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function check_current_password($id,$encrypt_password)
	{
		$sql='SELECT count(id) as totrow from tn_members WHERE id="'.$id.'" AND password="'.$encrypt_password.'" and deleted="0"';
		$query=$this->db->query($sql);
		$rowData=$query->row();
		return $rowData->totrow;
	}


	public function get_all_approve_church()
	{
		$sql="SELECT * from tn_members WHERE is_approved='Y' AND membership_type='CM' AND status='1' AND deleted='0' order by first_name ASC";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function check_dup_email($email='')
	{
		$sql="SELECT * from tn_members WHERE user_email='".$email."' AND deleted='0'";
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

	public function check_admin_exist($user_auto_id,$adminid)
	{
		$sql="SELECT * from tn_members WHERE is_admin='Y' AND parent_id='".$user_auto_id."' and id!='".$adminid."' AND deleted='0'";
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