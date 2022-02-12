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

	public function get_member_data($id)
	{
		$sql='SELECT 

			tm.*, 
			tm2.first_name as churchName
			from tn_members as tm 
			LEFT JOIN tn_members as tm2 ON tm2.id=tm.parent_id
			WHERE tm.id="'.$id.'"';
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData[0];
	}

	public function ajaxgetPeopleYouMayNowData($loggedUserId,$sgtnType="")
	{
		$strWhereParam="";
		if(!empty($sgtnType))
		{
			if($sgtnType=="chrchSgtn")
			{
				$strWhereParam=" AND tm.membership_type='PM'";
			}
			elseif($sgtnType=="memberSgtn")
			{
				$strWhereParam=" AND tm.membership_type='RM'";
			}
			elseif ($sgtnType=="frndSgtn")
			{
				$strWhereParam=" AND (tm.membership_type='RM' OR tm.membership_type='PM')";
			}
		}

		$sql="SELECT 
				tm.*,
				tmf.id as member_friends_aid, 
				tmf.request_status ,
				tmf.member_id 
				FROM tn_members as tm
				LEFT JOIN tn_member_friends as tmf ON tm.id=tmf.friend_id AND tmf.member_id ='".$loggedUserId."'
				WHERE 
				tm.id NOT IN (SELECT friend_id FROM tn_member_friends as tmf WHERE tmf.member_id='".$loggedUserId."' AND tmf.request_status!='1')

    			AND tm.id NOT IN (SELECT member_id FROM tn_member_friends as tmf WHERE tmf.friend_id='".$loggedUserId."' AND (tmf.request_status='1' OR tmf.request_status='2'))

    			AND tm.id NOT IN (SELECT friend_id FROM tn_member_friends as tmf WHERE tmf.member_id='".$loggedUserId."'  AND tmf.request_status!='1')

    			AND tm.id!='".$loggedUserId."' AND tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0'".$strWhereParam." order by first_name ASC";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function ajaxGetAllFriendRequest($loggedUserId,$sgtnType="")
	{
		$strWhereParam="";
		if(!empty($sgtnType))
		{
			if($sgtnType=="chrchSgtn")
			{
				$strWhereParam=" AND tm.membership_type='PM'";
			}
			elseif($sgtnType=="memberSgtn")
			{
				$strWhereParam=" AND tm.membership_type='RM'";
			}
			elseif ($sgtnType=="frndSgtn")
			{
				$strWhereParam=" AND (tm.membership_type='RM' OR tm.membership_type='PM')";
			}
		}

		$sql="SELECT 
				tm.*,
				tmf.id as member_friends_aid, 
				tmf.request_status 
				FROM tn_members as tm
				LEFT JOIN tn_member_friends as tmf ON tm.id=tmf.member_id
				WHERE tm.id IN 
    			(SELECT member_id FROM tn_member_friends as tmf WHERE tmf.friend_id='".$loggedUserId."' AND tmf.request_status='1' ) AND tm.id!='".$loggedUserId."' AND tm.is_approved='Y' and  tmf.friend_id='".$loggedUserId."' AND tm.status='1' AND tm.deleted='0' ".$strWhereParam." group by tm.id order by first_name ASC";

		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
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

	public function ajaxGetAllFriendList($loggedUserId,$sgtnType="",$aryArgument=array())
	{
		$searchFriend=$aryArgument['searchFriend'];

		$strWhereParam="";
		if(!empty($sgtnType))
		{
			if($sgtnType=="chrchSgtn")
			{
				$strWhereParam=" AND tm.membership_type='PM'";
			}
			elseif($sgtnType=="memberSgtn")
			{
				$strWhereParam=" AND tm.membership_type='RM'";
			}
			elseif ($sgtnType=="frndSgtn")
			{
				$strWhereParam=" AND (tm.membership_type='RM' OR tm.membership_type='PM')";
			}
		}

		if(!empty($searchFriend))
		{
			$strWhereParam.=" AND (tm.first_name LIKE '%".$searchFriend."%' OR tm.last_name LIKE '%".$searchFriend."%') ";
		}

		$sql="SELECT 
				tm.id,
				tm.profile_image,
				tm.membership_type,
				tm.first_name,
				tm.last_name,
				tm2.first_name as church_first_name,
				tm2.last_name as church_last_name

				FROM tn_members as tm
				LEFT JOIN tn_members as tm2 on tm2.id=tm.parent_id
				WHERE 
				(
					tm.id IN
    				(SELECT friend_id FROM tn_member_friends as tmf WHERE tmf.member_id='".$loggedUserId."' AND tmf.request_status='2') OR tm.id IN 
    				(SELECT member_id FROM tn_member_friends as tmf WHERE tmf.friend_id='".$loggedUserId."' AND tmf.request_status='2')
    			)
    			AND tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' ".$strWhereParam." order by first_name ASC";

		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function ajaxDeleteMyFriend($loggedUserId=0,$myFriendId=0)
	{
		$current_date=date('Y-m-d H:i:s');

		$sql="UPDATE tn_member_friends SET request_status='4', deletion_date='".$current_date."' WHERE ( (member_id='".$loggedUserId."' AND friend_id='".$myFriendId."' AND request_status='2') OR (member_id='".$myFriendId."' AND friend_id='".$loggedUserId."' AND request_status='2'))";
		$query=$this->db->query($sql);
		return 1;
	}

	public function get_group_data($loggedUserId=0)
	{
		$sql="SELECT * from tn_group WHERE status='1' AND deleted='0' AND (member_id='".$loggedUserId."' OR member_id=0)";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function get_all_approve_church($searchChurch='')
	{
		$strWhereParam="";
		if(!empty($searchChurch))
		{
			$strWhereParam=" AND (first_name LIKE '%".$searchChurch."%') ";
		}
		$sql="SELECT id, first_name, church_type, profile_image FROM tn_members WHERE is_approved='Y' AND membership_type='PM' AND status='1' AND deleted='0' ".$strWhereParam." order by first_name ASC";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}
	
	public function get_page_data($loggedUserId=0)
	{
		$sql="SELECT * from tn_page WHERE status='1' AND deleted='0' AND (member_id='".$loggedUserId."' OR member_id=0)";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
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

	public function check_current_password($id,$encrypt_password)
	{
		$sql='SELECT count(id) as totrow from tn_members WHERE id="'.$id.'" AND password="'.$encrypt_password.'" and deleted="0"';
		$query=$this->db->query($sql);
		$rowData=$query->row();
		return $rowData->totrow;
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

	public function addupdategroup($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_group',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_group',$menu_arr);
			return $this->db->insert_id();
		}
	}
	
	public function addupdatepage($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_page',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_page',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function addUpdatPostFile($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_post_file',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_post_file',$menu_arr);
			return $this->db->insert_id();
		}
	}
}
?>