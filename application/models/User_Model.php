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
	public function assign_under_group_admin($member_id)
	{
		$admin_id=0;
		$resultData=$this->get_member_data($member_id);
		if(count($resultData)>0 && $resultData['membership_type']=='RM' && $resultData['is_admin']=='N')
		{
			$parent_id=$resultData['parent_id'];
			$dob=$resultData['dob'];
			$diff = (date('Y') - date('Y',strtotime($dob)));

			if($diff>0)
			{
				$sqlAgeGroup="SELECT * from tn_age_group WHERE min_age<=".$diff." AND max_age>= '".$diff."'";
				$queryAgeGroup=$this->db->query($sqlAgeGroup);
				$resultAgeGroupData=$queryAgeGroup->result_array();
				if(count($resultAgeGroupData)>0)
				{
					$agegroup_id=$resultAgeGroupData[0]['id'];
					$sqlAgeGroupAdmin="SELECT * from tn_members WHERE parent_id='".$parent_id."' AND membership_type='RM' AND is_admin='Y' AND status='1' AND deleted='0' AND agegroup_id='".$agegroup_id."' "; 
					$queryAgeGroupAdmin=$this->db->query($sqlAgeGroupAdmin);
					$resultAgeGroupAdminData=$queryAgeGroupAdmin->result_array();
					if(count($resultAgeGroupAdminData)>0)
					{
						$admin_id=$resultAgeGroupAdminData[0]['id'];
						$menu_arr_group = array(
				            'admin_id' => $admin_id
				        );
						$member_friends_aid = $this->addupdatemember($member_id,$menu_arr_group);
					}
				}
			}
		}

		return $admin_id;
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

    			AND tm.id!='".$user_auto_id."' AND tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' AND tm.membership_type!='CC' ".$strWhereParam." order by first_name ASC";
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
		
		if($membership_type=='CM' || $membership_type=='CC')
		{
			$strParamWhere=" AND tm.parent_id='".$user_auto_id."'";
		}
		else
		{
			$strParamWhere=" AND tm.admin_id='".$user_auto_id."' AND tm.parent_id='".$parent_id."' AND tm.id!='".$user_auto_id."'";
		}

		$sql="SELECT 
				tm.* ,
				tm2.first_name as admin_first_name,
				tm2.last_name as admin_last_name,
				tag.agegroup_name,
				IF(MAX(tml.task_level)> 0, MAX(tml.task_level), 0) as maxmemberlevel,
				IF(MAX(tml.course_id)> 0, MAX(tml.course_id), 0) as maxcourseid,
				(SELECT course_name FROM tn_task_level_course where id=MAX(tml.course_id)) as coursename

				FROM tn_members as tm
				LEFT JOIN tn_members as tm2 ON tm2.id=tm.admin_id and tm2.status='1' and tm2.deleted='0'
				LEFT JOIN tn_age_group as tag ON tag.id=tm.agegroup_id and tag.status='1' and tag.deleted='0'
				LEFT JOIN tn_member_level as tml ON tml.member_id=tm.id and tml.status='1'
				WHERE tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' ".$strParamWhere." group by tm.id order by first_name ASC";
				
		//				
		/*$sql="SELECT 
				tm.* 
				FROM tn_members as tm
				WHERE tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' ".$strParamWhere." order by first_name ASC";*/
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
		$sql="SELECT * from tn_members WHERE is_approved='Y' AND membership_type='CM' AND type!='9999' AND status='1' AND deleted='0' order by first_name ASC";
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

	public function check_age_group_admin_exist($user_auto_id,$adminid,$agegroup_id)
	{
		$sql="SELECT * from tn_members WHERE is_admin='Y' AND parent_id='".$user_auto_id."' AND agegroup_id='".$agegroup_id."' AND agegroup_id!='0' and id!='".$adminid."' AND deleted='0'";
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

	public function addUpdateTaskLevel($menu_arr=NULL)
	{
		$current_date=date('Y-m-d H:i:s');
		$course_id=$menu_arr['course_id'];
		$task_level=$menu_arr['task_level'];
		$church_id=$menu_arr['church_id'];
		$church_admin_id=$menu_arr['church_admin_id'];
		$sql='SELECT * from tn_task_level WHERE course_id="'.$course_id.'" AND task_level="'.$task_level.'" AND church_id="'.$church_id.'" AND church_admin_id="'.$church_admin_id.'" AND deleted="0"';
		$query=$this->db->query($sql);
		$rowData=$query->row();
		$task_level_id=0;
		if(!empty($rowData) && $rowData->id>0)
		{
			$task_level_id=$rowData->id;
		}
		if(!empty($task_level_id) && $task_level_id>0)
		{
			$menu_arr['update_date']  =$current_date;
			$this->db->where('id',$task_level_id)->update('tn_task_level',$menu_arr);
			return $task_level_id;
		}
		else
		{
			$menu_arr['create_date']  =$current_date;
			$this->db->insert('tn_task_level',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function addUpdatTaskLevelVideo($menu_arr=NULL,$id=NULL)
	{
		$current_date=date('Y-m-d H:i:s');
		$course_id=$menu_arr['course_id'];
		$task_level_id=$menu_arr['task_level_id'];
		$video_number=$menu_arr['video_number'];

		$sql='SELECT * from tn_task_level_video WHERE task_level_id="'.$task_level_id.'" AND video_number="'.$video_number.'"';
		$query=$this->db->query($sql);
		$rowData=$query->row();
		$task_level_video_id=0;
		if(!empty($rowData) && $rowData->id>0)
		{
			$task_level_video_id=$rowData->id;
		}

		if(!empty($task_level_video_id) && $task_level_video_id>0)
		{
			$menu_arr['update_date']  =$current_date;
			$this->db->where('id',$task_level_video_id)->update('tn_task_level_video',$menu_arr);
			return $task_level_video_id;
		}
		else
		{
			$menu_arr['create_date']  =$current_date;
			$this->db->insert('tn_task_level_video',$menu_arr);
			return $this->db->insert_id();
		}
	}


	public function get_task_video_by_level($argument)
	{
		$membershipType=$argument['membershipType'];
		$user_auto_id=$argument['user_auto_id'];
		$parent_id=$argument['parent_id'];
		$course_id=$argument['course_id'];
		$task_level=$argument['task_level'];

		if($membershipType=="CM" || $membershipType=="CC")
		{
			$strWhereParam=" AND tl.church_id='".$user_auto_id."' AND tl.course_id='".$course_id."' AND tl.task_level='".$task_level."'";
		}
		else
		{
			$strWhereParam=" AND tl.church_id='".$parent_id."' AND tl.church_admin_id='".$user_auto_id."' AND tl.course_id='".$course_id."' AND tl.task_level='".$task_level."'";
		}
		$sql="SELECT 
				tl.*,
				tlv.video_number, 
				tlv.video_name, 
				tlv.video_size,
				tlv.video_type
				FROM tn_task_level as tl
				LEFT JOIN tn_task_level_video as tlv ON tlv.task_level_id=tl.id
				WHERE tl.deleted='0' ".$strWhereParam." order by tlv.video_number";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function get_task_min_three_video_by_level($argument)
	{
		$course_id=$argument['course_id'];
		$task_level=$argument['task_level'];
		$str_is_admin=$this->session->userdata('is_admin');

		$taskVideoLevelData=$this->get_task_video_by_level($argument);
		$finalTaskVideoLevelData=array();

		for ($k = 0; $k <= 2; $k++)
		{
			$finalTaskVideoLevelData[$k]['is_admin']=$str_is_admin;
			$finalTaskVideoLevelData[$k]['video_number']=0;
			$finalTaskVideoLevelData[$k]['video_name']='';
			$finalTaskVideoLevelData[$k]['video_size']='';
			$finalTaskVideoLevelData[$k]['video_type']='';
			$finalTaskVideoLevelData[$k]['video_path_with_video']='';
		}

		if(count($taskVideoLevelData)>0)
		{
			foreach($taskVideoLevelData as $k=>$v)
			{
				if (file_exists(IMAGE_PATH."/taskvideo/".$v['video_name']))
				{
					$key=($v['video_number']-1);
	
					$finalTaskVideoLevelData[$key]['is_admin']=$str_is_admin;
					$finalTaskVideoLevelData[$key]['video_number']=$v['video_number'];
					$finalTaskVideoLevelData[$key]['video_name']=$v['video_name'];
					$finalTaskVideoLevelData[$key]['video_size']=$v['video_size'];
					$finalTaskVideoLevelData[$key]['video_type']=$v['video_type'];
					$finalTaskVideoLevelData[$key]['video_path_with_video']=IMAGE_URL.'/taskvideo/'.$v['video_name'];
				}
			}
		}
		return $finalTaskVideoLevelData;
	}

	public function addUpdatLiveStreamVideo($menu_arr=NULL,$id=NULL)
	{
		if(!empty($id) && $id>0)
		{
			$this->db->where('id',$id)->update('tn_task_level_stream_video',$menu_arr);
			return $id;
		}
		else
		{			
			$this->db->insert('tn_task_level_stream_video',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function get_live_stream_video_by_level($argument)
	{
		$task_level=$argument['task_level'];
		$membershipType=$argument['membershipType'];
		$user_auto_id=$argument['user_auto_id'];
		$parent_id=$argument['parent_id'];
		$course_id=$argument['course_id'];
		$task_level=$argument['task_level'];
		$str_is_admin=$this->session->userdata('is_admin');

		if($membershipType=="CM" || $membershipType=="CC")
		{
			$strWhereParam=" AND tl.church_id='".$user_auto_id."' AND tl.course_id='".$course_id." AND task_level='".$task_level."'";
		}
		else
		{
			$strWhereParam=" AND tl.church_id='".$parent_id."' AND tl.church_admin_id='".$user_auto_id."' AND tl.course_id='".$course_id."'  AND task_level='".$task_level."'";
		}

		$sql="SELECT 
				tlsv.*,
				tl.task_level,
				tm.is_admin
				FROM tn_task_level as tl
				LEFT JOIN tn_task_level_stream_video as tlsv ON tlsv.task_level_id=tl.id
				LEFT JOIN tn_members as tm ON tm.id='".$user_auto_id."'
				WHERE tl.deleted='0' AND tlsv.deleted='0' ".$strWhereParam." order by tlsv.id DESC";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();

		if(count($resultData)>0)
		{
			foreach($resultData as $k=>$v)
			{	
				$resultData[$k]['is_admin']=$str_is_admin;
				$resultData[$k]['display_star_time']=date('m-d-Y h:i A',strtotime($v['star_time']));
				$resultData[$k]['star_time']=date('Y-m-d H:i',strtotime($v['star_time']));
				//$resultData[$k]['display_end_time']=date('m-d-Y h:i A',strtotime($v['end_time']));
				//$resultData[$k]['video_path_with_video']=IMAGE_URL.'/taskvideo/'.$task_level.'/streamvideo/'.$v['video_name'];
			}
		}
		//return array();
		return $resultData;
	}

	public function check_member_level_exist($member_id)
	{
		$sql="SELECT * from tn_member_level WHERE member_id='".$member_id."'";
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

	public function revert_assign_member_level($member_id,$menu_arr=NULL,$is_revert="")
	{
		if(!empty($member_id) && $member_id>0 && $is_revert=='revert')
		{
			$this->db->where('member_id',$member_id)->update('tn_member_level',$menu_arr);
			return $member_id;
		}
		else
		{			
			$this->db->insert('tn_member_level',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function get_member_max_level($member_id)
	{
		$sql="SELECT IF(MAX(tml.course_id)> 0, MAX(tml.course_id), 0) as maxcourseid,IF(MAX(tml.task_level)> 0, MAX(tml.task_level), 0) as maxmemberlevel
				FROM tn_member_level as tml WHERE tml.status='1' and member_id='".$member_id."'";
		$query=$this->db->query($sql);
		$rowData=$query->row();
		if(!empty($rowData))
		{
			return $rowData;
		}
		else
		{
			return 0;
		}
	}


	/*public function get_church_admin($user_auto_id,$adminid)
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
	}*/

	public function convert_level_number_text($number)
	{
		$arayLevel=array();
		$arayLevel[1]="levelone";
		$arayLevel[2]="leveltwo";
		$arayLevel[3]="levelthree";
		$arayLevel[4]="levelfour";
		$arayLevel[5]="levelfive";
		$arayLevel[6]="levelsix";

		return $arayLevel[$number];
	}

	public function ajaxGetLiveStreamScheduleNotification($aryNotificationData)
	{
		$user_auto_id=$aryNotificationData['user_auto_id'];
		$parent_id=$aryNotificationData['parent_id'];
		$membership_type=$aryNotificationData['membership_type'];
		$is_admin=$aryNotificationData['is_admin'];
		if($membership_type=='RM' && $is_admin=='N')
		{
			$sql="SELECT IF(MAX(tml.task_level)> 0, MAX(tml.task_level), 0) as maxmemberlevel
				FROM tn_member_level as tml WHERE tml.status='1' and member_id='".$user_auto_id."'";
			$query=$this->db->query($sql);
			$rowData=$query->row();
			$maxmemberlevel=0;
			if(!empty($rowData) && $rowData->maxmemberlevel>0)
			{
				$maxmemberlevel=$rowData->maxmemberlevel;
				//$maxmemberLevelText=$this->convert_level_number_text($maxmemberlevel);
			}
			
			if($maxmemberlevel>0)
			{
				$sql="SELECT 
						tm.id,
						tm.is_admin,
						ttl.id as task_level_id,
						ttl.task_level,
						ttl.church_id,
						ttlsv.video_title,
						ttlsv.video_title,
						ttlsv.star_time,
						ttlsv.description,
						ttlsv.create_date

						FROM tn_members as tm
						LEFT JOIN tn_task_level as ttl ON ttl.church_admin_id=tm.id
						LEFT JOIN tn_task_level_stream_video as ttlsv ON ttlsv.task_level_id=ttl.id
						WHERE tm.membership_type='RM' AND tm.parent_id='".$parent_id."' AND tm.is_admin='Y' AND tm.deleted='0' AND ttl.church_id='".$parent_id."' AND ttl.task_level='".$maxmemberlevel."' AND ttl.deleted='0' AND ttl.status='1' AND ttlsv.deleted='0' AND ttlsv.status='1' AND DATE(ttlsv.star_time)>=DATE(now()) order by ttlsv.star_time limit 1";
				$query=$this->db->query($sql);
				$result=$query->result_array();
				if(count($result)>0)
				{
					return $result;
				}
			}			
		}

		return array();
	}

	public function get_group_data()
	{
		$sql='SELECT * from tn_group WHERE status="1" AND deleted="0"';
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function get_abandon_member_under_church($parent_id)
	{
		$sql="SELECT * from tn_members WHERE parent_id='".$parent_id."' AND admin_id='0' AND membership_type='RM' AND is_admin='N' AND status='1' AND deleted='0'"; 
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function remove_member_from_group_admin($admin_id=0,$parent_id=0)
	{
		$menu_arr=array('admin_id'=>0,'agegroup_id'=>0);
		$whereAry=array('parent_id'=>$parent_id,'admin_id'=>$admin_id);
		$this->db->where($whereAry)->update('tn_members',$menu_arr);	
	}

	public function get_all_age_group_data($id=0)
	{
		$strWhereParam="";
		if($id>0)
		{
			$strWhereParam=" AND id!='".$id."'";
		}
		$sql="SELECT * from tn_age_group WHERE status='1' AND deleted='0' ".$strWhereParam." order by min_age ";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function get_all_course()
	{
		$sql="SELECT id,course_name,number_of_level from tn_task_level_course WHERE status='1' AND deleted='0'";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function get_course_data($id=0)
	{
		$sql="SELECT * from tn_task_level_course WHERE id='".$id."'";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData[0];
	}
	
}
?>