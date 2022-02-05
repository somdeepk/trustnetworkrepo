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
	
	public function ajaxAddUpdateStreamingMember($argu_arr=NULL)
	{
		$stream_video_id=$argu_arr['stream_video_id'];
		$member_id=$argu_arr['member_id'];
		$join_leave_flag=$argu_arr['join_leave_flag'];
		$current_date=date('Y-m-d H:i:s');

		$sql='SELECT * from tn_streaming_member WHERE stream_video_id="'.$stream_video_id.'" AND member_id="'.$member_id.'"';
		$query=$this->db->query($sql);
		$rowData=$query->row();
		$streaming_member_aid=0;
		if(!empty($rowData) && $rowData->id>0)
		{
			$streaming_member_aid=$rowData->id;
		}

		if(!empty($streaming_member_aid) && $streaming_member_aid>0)
		{

			if($join_leave_flag=='J') //Join
			{	
				$menu_arr['leave_date']=NULL;				
			}
			elseif($join_leave_flag=='L') //Join
			{	
				$sqlLeaveTime='SELECT * from tn_streaming_member WHERE stream_video_id="'.$stream_video_id.'" AND member_id="'.$member_id.'" AND leave_date is NULL';
				$queryLeaveTime=$this->db->query($sqlLeaveTime);
				$rowDataLeaveTime=$queryLeaveTime->row();
				if(!empty($rowDataLeaveTime))
				{
					$menu_arr['leave_date']=$current_date;	
				}							
			}

			$this->db->where('id',$streaming_member_aid)->update('tn_streaming_member',$menu_arr);
			return $streaming_member_aid;			
		}
		else
		{
			$menu_arr['stream_video_id']=$stream_video_id;
			$menu_arr['member_id']=$member_id;
			$menu_arr['join_date']=$current_date;
			$menu_arr['leave_date']=NULL;
			$this->db->insert('tn_streaming_member',$menu_arr);
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
    			(SELECT member_id FROM tn_member_friends as tmf WHERE tmf.friend_id='".$user_auto_id."' AND tmf.request_status='1' ) AND tm.id!='".$user_auto_id."' AND tm.is_approved='Y' and  tmf.friend_id='".$user_auto_id."' AND tm.status='1' AND tm.deleted='0' ".$strWhereParam." group by tm.id order by tm.id DESC"; // first_name ASC

		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

	public function ajaxGetAllFriendList($user_auto_id,$clickProfileTab="",$aryArgument=array())
	{
		$searchFriend=$aryArgument['searchFriend'];
		$limit=$aryArgument['limit'];

		$strLimit="";
		if($limit!="")
		{
			$strLimit=" limit 0,".$limit;
		}

		$strWhereParam="";
		if(!empty($clickProfileTab))
		{
			if($clickProfileTab=="churchlistTab")
			{
				$strWhereParam.=" AND tm.membership_type='CM'";
			}
			if($clickProfileTab=="memberlistTab")
			{
				$strWhereParam.=" AND tm.membership_type='RM'";
			}
		}

		if(!empty($searchFriend))
		{
			$strWhereParam.=" AND (tm.first_name LIKE '%".$searchFriend."%' OR tm.last_name LIKE '%".$searchFriend."%') ";
		}

		$sql="SELECT 
				tm.*,
				tm2.first_name as church_first_name,
				tm2.last_name as church_last_name

				FROM tn_members as tm
				LEFT JOIN tn_members as tm2 on tm2.id=tm.parent_id
				WHERE 
				(
					tm.id IN
    				(SELECT friend_id FROM tn_member_friends as tmf WHERE tmf.member_id='".$user_auto_id."' AND tmf.request_status='2') OR tm.id IN 
    				(SELECT member_id FROM tn_member_friends as tmf WHERE tmf.friend_id='".$user_auto_id."' AND tmf.request_status='2')
    			)
    			AND tm.is_approved='Y' AND tm.status='1' AND tm.deleted='0' ".$strWhereParam." order by first_name ASC ".$strLimit;

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
				(SELECT IF (tml2.task_level> 0, tml2.task_level, 0) FROM tn_member_level as tml2 where tml2.course_id=MAX(tml.course_id) and tml2.member_id=tm.id order by tml2.id desc limit 1) as maxmemberlevel,
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
			$leader_id=$argument['leader_id'];
			$strWhereParam=" AND tl.church_id='".$user_auto_id."' AND tl.church_admin_id='".$leader_id."' AND tl.course_id='".$course_id."' AND tl.task_level='".$task_level."'";
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
		//$course_id=$argument['course_id'];
		//$task_level=$argument['task_level'];
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
				if (file_exists(IMAGE_PATH."/taskvideo/".$v['video_name']) && $v['video_name']!='')
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
		$leader_id=$argument['leader_id'];

		$str_is_admin=$this->session->userdata('is_admin');

		if($membershipType=="CM" || $membershipType=="CC")
		{		

			$strWhereParam=" AND tl.church_id='".$user_auto_id."' AND tl.church_admin_id='".$leader_id."' AND tl.course_id='".$course_id."' AND tl.task_level='".$task_level."'";
		}
		elseif($str_is_admin=='Y' && $membershipType=="RM" )
		{
			$strWhereParam=" AND tl.church_id='".$parent_id."' AND tl.church_admin_id='".$user_auto_id."' AND tl.course_id='".$course_id."'  AND tl.task_level='".$task_level."'";
		}
		elseif($str_is_admin=='N' && $membershipType=="RM" )
		{
			$strWhereParam=" AND tl.church_id='".$parent_id."' AND tl.church_admin_id='".$leader_id."' AND tl.course_id='".$course_id."'  AND tl.task_level='".$task_level."' AND tlsv.is_live='Y'";
		}

		$sql="SELECT 
				tlsv.*,
				tl.task_level,
				tm.is_admin,
				tm.membership_type
				FROM tn_task_level as tl
				LEFT JOIN tn_task_level_stream_video as tlsv ON tlsv.task_level_id=tl.id
				LEFT JOIN tn_members as tm ON tm.id='".$user_auto_id."'
				WHERE tl.deleted='0' AND tlsv.deleted='0' ".$strWhereParam." order by tlsv.id DESC";

		/*echo $sql;
		exit;*/
		$query=$this->db->query($sql);
		$resultData=$query->result_array();

		if(count($resultData)>0)
		{
			foreach($resultData as $k=>$v)
			{	
				$resultData[$k]['is_admin']=$str_is_admin;
				$resultData[$k]['display_start_time']=date('m-d-Y h:i A',strtotime($v['start_time']));
				$resultData[$k]['start_time']=date('Y-m-d H:i',strtotime($v['start_time']));
				$resultData[$k]['start_time_numbers']=str_replace(array('-',' ',':'),array('','',''),date('Y-m-d H:i',strtotime($v['start_time'])));
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
		$sql="SELECT
		IF(MAX(tml.course_id)> 0, MAX(tml.course_id), 0) as maxcourseid,
		(SELECT IF (tml2.task_level> 0, tml2.task_level, 0) FROM tn_member_level as tml2 where tml2.course_id=MAX(tml.course_id) and tml2.member_id='".$member_id."' order by tml2.id desc limit 1) as maxmemberlevel
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


	public function get_all_church_admin($parent_id)
	{
		$sql="SELECT * FROM tn_members WHERE parent_id='".$parent_id."' AND membership_type='RM' AND is_admin='Y' AND status='1' AND deleted='0'"; 
		$queryAgeGroupAdmin=$this->db->query($sql);					
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		return $resultData;
	}

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
		$admin_id=$aryNotificationData['admin_id'];
		$is_admin=$aryNotificationData['is_admin'];
		if($membership_type=='RM' && $is_admin=='N')
		{
			$sql="SELECT IF(MAX(tml.course_id)> 0, MAX(tml.course_id), 0) as maxcourseid,
			(SELECT IF (tml2.task_level> 0, tml2.task_level, 0) FROM tn_member_level as tml2 where tml2.course_id=MAX(tml.course_id) and tml2.member_id='".$user_auto_id."' order by tml2.id desc limit 1) as maxmemberlevel
			 FROM tn_member_level as tml WHERE tml.status='1' and member_id='".$user_auto_id."'";
			$query=$this->db->query($sql);
			$rowData=$query->row();
			$maxmemberlevel=0;
			if(!empty($rowData))
			{
				$maxcourseid=$rowData->maxcourseid;
				$maxmemberlevel=$rowData->maxmemberlevel;
			}
			
			if($maxmemberlevel>0)
			{
				$sql="SELECT 
						tm.id,
						tm.is_admin,
						ttl.id as task_level_id,
						ttl.course_id,
						ttl.task_level,
						ttl.church_id,
						ttlsv.video_title,
						ttlsv.video_title,
						ttlsv.start_time,
						ttlsv.description,
						ttlsv.create_date

						FROM tn_members as tm
						LEFT JOIN tn_task_level as ttl ON ttl.church_admin_id=tm.id
						LEFT JOIN tn_task_level_stream_video as ttlsv ON ttlsv.task_level_id=ttl.id
						WHERE tm.membership_type='RM' AND tm.parent_id='".$parent_id."' AND tm.is_admin='Y' AND tm.deleted='0' AND ttl.church_id='".$parent_id."'  AND ttl.church_admin_id='".$admin_id."' AND ttl.course_id='".$maxcourseid."'  AND ttl.task_level='".$maxmemberlevel."' AND ttl.deleted='0' AND ttl.status='1' AND ttlsv.deleted='0' AND ttlsv.status='1' AND DATE(ttlsv.start_time)>=DATE(now()) order by ttlsv.start_time limit 1";
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

	public function get_member_watch_task_video_by_level($argument)
	{
		$membershipType=$argument['membershipType'];
		$user_auto_id=$argument['user_auto_id'];
		$parent_id=$argument['parent_id'];
		$leader_id=$argument['leader_id'];
		$course_id=$argument['course_id'];
		$task_level=$argument['task_level'];

		$strWhereParam=" AND tl.church_id='".$parent_id."' AND tl.church_admin_id='".$leader_id."' AND tl.course_id='".$course_id."' AND tl.task_level='".$task_level."'";
		$sql="SELECT 
				tl.*,
				tlv.id as task_level_video_id, 
				tlv.video_number, 
				tlv.video_name,
				tlv.video_size,
				tlv.video_type,
				tlvv.is_full_viwed,
				tlvv.member_id
				FROM tn_task_level as tl
				LEFT JOIN tn_task_level_video as tlv ON tlv.task_level_id=tl.id
				LEFT JOIN tn_task_level_video_viewed as tlvv ON tlvv.task_level_video_id=tlv.id and  tlvv.member_id='".$user_auto_id."'
				WHERE tl.deleted='0' ".$strWhereParam." order by tlv.video_number";
		$query=$this->db->query($sql);
		$taskVideoLevelData=$query->result_array();

		$finalTaskVideoLevelData=array();
		if(count($taskVideoLevelData)>0)
		{
			$isOpen='Y';
			foreach($taskVideoLevelData as $k=>$v)
			{
				if (file_exists(IMAGE_PATH."/taskvideo/".$v['video_name']) && $v['video_name']!='')
				{
					$key=($v['video_number']-1);
	
					$finalTaskVideoLevelData[$key]['membershipType']=$membershipType;
					$finalTaskVideoLevelData[$key]['is_admin']='N';
					$finalTaskVideoLevelData[$key]['task_level_video_id']=$v['task_level_video_id'];
					$finalTaskVideoLevelData[$key]['video_number']=$v['video_number'];
					$finalTaskVideoLevelData[$key]['video_name']=$v['video_name'];
					$finalTaskVideoLevelData[$key]['video_size']=$v['video_size'];
					$finalTaskVideoLevelData[$key]['video_type']=$v['video_type'];
					$finalTaskVideoLevelData[$key]['is_full_viwed']=$v['is_full_viwed'];
					if(empty($v['is_full_viwed']))
					{
						$finalTaskVideoLevelData[$key]['is_full_viwed']='N';
					}
					
					if($v['is_full_viwed']=='Y')
					{
						$finalTaskVideoLevelData[$key]['view_status']='viewed';
						$finalTaskVideoLevelData[$key]['view_txt']='Viewed';
					}
					elseif( (empty($v['is_full_viwed']) || $v['is_full_viwed']=='N') && $isOpen=='Y')
					{
						$finalTaskVideoLevelData[$key]['view_status']='open';
						$finalTaskVideoLevelData[$key]['view_txt']='open';
						$isOpen='N';
					}
					else
					{
						$finalTaskVideoLevelData[$key]['view_status']='block';
						$finalTaskVideoLevelData[$key]['view_txt']='Block';
					}

					
					$finalTaskVideoLevelData[$key]['video_path_with_video']=IMAGE_URL.'/taskvideo/'.$v['video_name'];
				}
			}
		}

		return $finalTaskVideoLevelData;
	}


	public function addUpdateTaskLevelVideoViewed($argument=NULL)
	{
		$current_date=date('Y-m-d H:i:s');
		$user_auto_id=$argument['user_auto_id'];
		$task_level_video_id=$argument['task_level_video_id'];
		$video_ended=$argument['video_ended'];
		$video_viewed_time=$argument['video_viewed_time'];
		
		$str_is_full_viwed='N';
		if($video_ended>=1)
		{
			$str_is_full_viwed='Y';
		}
		$sql='SELECT * from tn_task_level_video_viewed WHERE member_id="'.$user_auto_id.'" AND task_level_video_id="'.$task_level_video_id.'"';
		$query=$this->db->query($sql);
		$rowData=$query->row();

		$task_level_video_viewed_aid=0;
		if(!empty($rowData) && $rowData->id>0)
		{
			$task_level_video_viewed_aid=$rowData->id;
		}

		if($task_level_video_viewed_aid>0)
		{
			$menu_arr['member_id']=$user_auto_id;
			$menu_arr['task_level_video_id']=$task_level_video_id;
			$menu_arr['video_viewed_time']  =$video_viewed_time;
			$menu_arr['is_full_viwed']=$str_is_full_viwed;
			$menu_arr['view_date']  =$current_date;
			$this->db->where('id',$task_level_video_viewed_aid)->update('tn_task_level_video_viewed',$menu_arr);
			return $task_level_video_viewed_aid;
		}
		else
		{
			$menu_arr['member_id']=$user_auto_id;
			$menu_arr['task_level_video_id']=$task_level_video_id;
			$menu_arr['video_viewed_time']  =$video_viewed_time;
			$menu_arr['is_full_viwed']=$str_is_full_viwed;
			$menu_arr['view_date']  =$current_date;

			$this->db->insert('tn_task_level_video_viewed',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function get_live_streaming_member_by_level($argument)
	{
		$task_level=$argument['task_level'];
		$membershipType=$argument['membershipType'];
		$user_auto_id=$argument['user_auto_id'];
		$parent_id=$argument['parent_id'];
		$course_id=$argument['course_id'];
		$task_level=$argument['task_level'];
		$leader_id=$argument['leader_id'];
		$sql="SELECT 
				tlsv.*,
				tl.course_id,
				tl.task_level,
				tsm.member_id,
				tm.profile_image,
				tm.first_name,
                tm.last_name,
				IF(MAX(tml.course_id)> 0, MAX(tml.course_id), 0) as maxcourseid,				
				(SELECT IF (tml2.task_level> 0, tml2.task_level, 0) FROM tn_member_level as tml2 where tml2.course_id=MAX(tml.course_id) and tml2.member_id=tm.id order by tml2.id desc limit 1) as maxmemberlevel,
				(SELECT course_name FROM tn_task_level_course where id=MAX(tml.course_id)) as coursename,

				(SELECT sum(tml3.no_of_badge) FROM tn_member_level as tml3 where tml3.course_id=MAX(tml.course_id) and tml3.member_id=tm.id order by tml3.id desc limit 1) as totbadge

				FROM tn_task_level as tl
				LEFT JOIN tn_task_level_stream_video as tlsv ON tlsv.task_level_id=tl.id
				LEFT JOIN tn_streaming_member as tsm ON tsm.stream_video_id=tlsv.id
				LEFT JOIN tn_members as tm ON tm.id=tsm.member_id
				LEFT JOIN tn_member_level as tml ON tml.member_id=tm.id and tml.status='1'

				WHERE tl.deleted='0' AND tlsv.deleted='0' AND tl.church_id='".$parent_id."' AND tl.church_admin_id='".$user_auto_id."' AND tl.course_id='".$course_id."'  AND tl.task_level='".$task_level."' AND tlsv.is_live='Y' AND tsm.join_date IS NOT NULL and tsm.leave_date IS NULL AND tm.status='1' AND tm.deleted='0' group by tm.id order by tlsv.id DESC";


		$query=$this->db->query($sql);
		$resultData=$query->result_array();

		return $resultData;
	}


	public function insert_member_level($menu_arr=NULL)
	{
		$course_id=$menu_arr['course_id'];
		$task_level=$menu_arr['task_level'];
		$member_id=$menu_arr['member_id'];

		$sql='SELECT id from tn_member_level WHERE course_id="'.$course_id.'" AND task_level="'.$task_level.'" AND member_id="'.$member_id.'"';
		$query=$this->db->query($sql);
		$rowData=$query->row();
		if(empty($rowData))
		{
			$this->db->insert('tn_member_level',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function update_member_level($menu_arr=NULL)
	{
		$course_id=$menu_arr['course_id'];
		$task_level=$menu_arr['task_level'];
		$member_id=$menu_arr['member_id'];

		$sql='SELECT id from tn_member_level WHERE course_id="'.$course_id.'" AND task_level="'.$task_level.'" AND member_id="'.$member_id.'"';
		$query=$this->db->query($sql);
		$rowData=$query->row();
		$id=0;
		if(!empty($rowData) && $rowData->id>0)
		{
			$this->db->where('id',$rowData->id)->update('tn_member_level',$menu_arr);
			return $member_id;
		}
		
	}

	public function get_member_total_badge_by_course($member_id=0,$course_id=0)
	{
	 	$sql="SELECT 
				sum(no_of_badge) as totbadge
				from tn_member_level WHERE member_id='".$member_id."' AND course_id='".$course_id."' and status='1'";
        $query=$this->db->query($sql);
		$rowData=$query->row();
		if(!empty($rowData) && $rowData->totbadge>0)
		{
			return $rowData->totbadge;
		}
	}


	public function get_member_level_standard($id)
	{
		$sql="SELECT 
				(SELECT IF (tml2.task_level> 0, tml2.task_level, 0) FROM tn_member_level as tml2 where tml2.course_id=MAX(tml.course_id) and tml2.member_id=tm.id order by tml2.id desc limit 1) as maxmemberlevel,
				(SELECT course_name FROM tn_task_level_course where id=MAX(tml.course_id)) as coursename,
				(SELECT sum(tml3.no_of_badge) FROM tn_member_level as tml3 where tml3.course_id=MAX(tml.course_id) and tml3.member_id=tm.id order by tml3.id desc limit 1) as totbadge
				FROM tn_members as tm
				LEFT JOIN tn_member_level as tml ON tml.member_id=tm.id and tml.status='1'
				WHERE tm.id='".$id."' group by tm.id";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();
		$resultData=$resultData[0];

		$aryfinal=array();
		if(count($resultData)>0)
		{
			$aryfinal['maxmemberlevel']=$resultData['maxmemberlevel'];
			$aryfinal['coursename']=$resultData['coursename'];
			$aryfinal['totbadge']=$resultData['totbadge'];
		}
		return $aryfinal;
	}

	public function addUpdatExam($menu_arr=NULL,$id=NULL)
	{
		if(!empty($id) && $id>0)
		{
			$this->db->where('id',$id)->update('tbl_exam',$menu_arr);
			return $id;
		}
		else
		{			
			$this->db->insert('tbl_exam',$menu_arr);
			return $this->db->insert_id();
		}
	}
	public function addUpdatExamQuestion($menu_arr=NULL,$id=NULL)
	{
		if(!empty($id) && $id>0)
		{
			$this->db->where('id',$id)->update('tbl_exam_question',$menu_arr);
			return $id;
		}
		else
		{			
			$this->db->insert('tbl_exam_question',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function deleteAllExamQuestion($delete_arr=NULL,$exam_id=NULL)
	{
		$this->db->where('exam_id',$exam_id)->update('tbl_exam_question',$delete_arr);
		return $id;
	}

	public function get_exam_by_level($argument)
	{
		$task_level=$argument['task_level'];
		$membershipType=$argument['membershipType'];
		$user_auto_id=$argument['user_auto_id'];
		$parent_id=$argument['parent_id'];
		$course_id=$argument['course_id'];
		$task_level=$argument['task_level'];
		$leader_id=$argument['leader_id'];

		$str_is_admin=$this->session->userdata('is_admin');

		if($membershipType=="CM" || $membershipType=="CC")
		{		
			$strWhereParam=" AND tl.church_id='".$user_auto_id."' AND tl.church_admin_id='".$leader_id."' AND tl.course_id='".$course_id."' AND tl.task_level='".$task_level."'";
		}
		elseif($str_is_admin=='Y' && $membershipType=="RM" )
		{
			$strWhereParam=" AND tl.church_id='".$parent_id."' AND tl.church_admin_id='".$user_auto_id."' AND tl.course_id='".$course_id."'  AND tl.task_level='".$task_level."'";
		}
		elseif($str_is_admin=='N' && $membershipType=="RM" )
		{
			$strWhereParam=" AND tl.church_id='".$parent_id."' AND tl.church_admin_id='".$leader_id."' AND tl.course_id='".$course_id."'  AND tl.task_level='".$task_level."' AND tl.status='1' AND te.start_time<=now() AND te.end_time>=now() ";
		}

		//2021-11-30 21:26:00
		$sql="SELECT 
				te.*,
				tl.id as task_level_id,
				tl.course_id,
				tl.task_level
				FROM tn_task_level as tl
				LEFT JOIN tbl_exam as te ON te.task_level_id=tl.id
				WHERE te.deleted='0'".$strWhereParam." ORDER BY te.id DESC";
		$query=$this->db->query($sql);
		$resultData=$query->result_array();

		$str_is_admin=$this->session->userdata('is_admin');

		$returnAry=array();

		if(count($resultData)>0)
		{
			foreach($resultData as $k=>$v)
			{	

				$isExtendedTimeOver='N';
				if($str_is_admin=='N' && $membershipType=="RM" )
				{
					$sqlMemberExamDtls="SELECT 
							count(id) as totalNumberExamGiven,
							(SELECT percentage_got FROM tbl_exam_given where id=MAX(teg.id)) as percentage_got,
							(SELECT is_exam_pass FROM tbl_exam_given where id=MAX(teg.id)) as is_exam_pass,
							(SELECT exam_date FROM tbl_exam_given where id=MAX(teg.id)) as exam_date
							FROM tbl_exam_given as teg
							WHERE teg.exam_id='".$v['id']."' AND teg.member_id='".$user_auto_id."'";
					$queryMemberExamDtls=$this->db->query($sqlMemberExamDtls);
					$resultMemberExamData=$queryMemberExamDtls->result_array()[0];
			
					if(!empty($resultMemberExamData['exam_date']))
					{
						$extendedOneDayTime =date('Y-m-d H:i:s',strtotime('+24 hours',strtotime($resultMemberExamData['exam_date'])));
						$extendedOneDayTime=strtotime($extendedOneDayTime);
						$currentTimeStamp=time();

						if($currentTimeStamp>$extendedOneDayTime)
						{
							$isExtendedTimeOver="Y";
						}
					}
				}
				/*1638974555
				1638716862*/


				if($isExtendedTimeOver=='N')
				{
					$totalNumberExamGiven=0;
					$percentage_got=0;
					$is_exam_pass='';
					$star_is_exam_pass='';
					$exam_date='';	

					if($str_is_admin=='N' && $membershipType=="RM" )
					{
						$totalNumberExamGiven=$resultMemberExamData['totalNumberExamGiven'];
						$percentage_got=$resultMemberExamData['percentage_got'];
						$is_exam_pass=$resultMemberExamData['is_exam_pass'];
						if($is_exam_pass=='Y')
						{
							$star_is_exam_pass='Pass';
						}
						else
						{
							$star_is_exam_pass='Fail';
						}
						
						$exam_date=$resultMemberExamData['exam_date'];
					}

					$returnAry[$k]=$v;
					$returnAry[$k]['totalNumberExamGiven']=$totalNumberExamGiven;
					$returnAry[$k]['percentage_got']=$percentage_got;
					$returnAry[$k]['is_exam_pass']=$is_exam_pass;
					$returnAry[$k]['star_is_exam_pass']=$star_is_exam_pass;
					$returnAry[$k]['exam_date']=$exam_date;	


					$returnAry[$k]['is_admin']=$str_is_admin;
					$returnAry[$k]['display_start_time']=date('m-d-Y h:i A',strtotime($v['start_time']));
					$returnAry[$k]['start_time']=date('Y-m-d H:i',strtotime($v['start_time']));
					$returnAry[$k]['start_time_numbers']=str_replace(array('-',' ',':'),array('','',''),date('Y-m-d H:i',strtotime($v['start_time'])));

					$returnAry[$k]['display_end_time']=date('m-d-Y h:i A',strtotime($v['end_time']));
					$returnAry[$k]['end_time']=date('Y-m-d H:i',strtotime($v['end_time']));
					$returnAry[$k]['end_time_numbers']=str_replace(array('-',' ',':'),array('','',''),date('Y-m-d H:i',strtotime($v['end_time'])));
				}

				
			}
		}

		/*echo "<pre>";
		print_r($returnAry);
		exit;*/
		//return array();
		return $returnAry;
	}

	public function GetExamData($id)
	{
		$aryReturnData=array();
		$sql="SELECT * from tbl_exam WHERE  id= '".$id."' AND deleted='0'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		if(count($result)>0)
		{
			$result=$result[0];
			$aryReturnData['exam_title']=$result['exam_title'];
			$aryReturnData['start_time']=$result['start_time'];
			$aryReturnData['end_time']=$result['end_time'];
			
			$sqlExamQuestion="SELECT * from tbl_exam_question WHERE exam_id=".$id." AND is_deleted= '0'";
			$queryExamQuestion=$this->db->query($sqlExamQuestion);
			$resultExamQuestion=$queryExamQuestion->result_array();
			if(count($resultExamQuestion)>0)
			{
				$aryQuestionnaire=array();
				foreach($resultExamQuestion as $k=>$v)
				{
					$aryQuestionnaire[$k]['questionID']=$v['id'];
					$aryQuestionnaire[$k]['question']=$v['exam_question'];
					$ary_exam_answer_option=json_decode($v['exam_answer_option'],true);
					$aryQuestionnaire[$k]['correct_ans']=$ary_exam_answer_option['correct_ans'];
					$aryQuestionnaire[$k]['options']=$ary_exam_answer_option['options'];
				}
			}
			$aryReturnData['aryQuestionnaire']=$aryQuestionnaire;
		}
		return $aryReturnData;
	}

	public function addUpdatExamGiven($menu_arr=NULL,$id=NULL)
	{
		if(!empty($id) && $id>0)
		{
			$this->db->where('id',$id)->update('tbl_exam_given',$menu_arr);
			return $id;
		}
		else
		{			
			$this->db->insert('tbl_exam_given',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function addUpdatExamGivenAnswer($menu_arr=NULL,$id=NULL)
	{
		if(!empty($id) && $id>0)
		{
			$this->db->where('id',$id)->update('tbl_exam_given_answer',$menu_arr);
			return $id;
		}
		else
		{			
			$this->db->insert('tbl_exam_given_answer',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function submit_ticket($paramArray=array(), $pId=0)
	{
		if (!empty($paramArray))
		{
			if (!empty($pId)) {
				$this->db->where('id',$pId)->update('tn_support_ticket',$paramArray);
				return $pId;
			} else {
				$this->db->insert('tn_support_ticket',$paramArray);
				return $this->db->insert_id();
			}
		}
	}

	public function getTotalPostCount($user_auto_id)
	{
		$sql="SELECT count(*) as totalPostCount FROM tn_post WHERE member_id='".$user_auto_id."' AND status='1' AND deleted='0'";
		$query=$this->db->query($sql);
		$rowData=$query->row();
		if(!empty($rowData) && $rowData->totalPostCount>0)
		{
			return $rowData->totalPostCount;
		}else{
			return 0;
		}
	}


	public function addupdatevent($id=NULL,$menu_arr=NULL)
	{
		if(!empty($id))
		{
			$this->db->where('id',$id)->update('tn_events',$menu_arr);
			return $id;
		}
		else
		{
			$this->db->insert('tn_events',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function addUpdatEventFriends($menu_arr=NULL,$id=NULL)
	{
		if(!empty($id) && $id>0)
		{
			$this->db->where('id',$id)->update('tn_events_friend',$menu_arr);
			return $id;
		}
		else
		{			
			$this->db->insert('tn_events_friend',$menu_arr);
			return $this->db->insert_id();
		}
	}

	public function getEventData($id)
	{
		$sql="SELECT * FROM tn_events WHERE id='".$id."'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		if(count($result)>0)
		{
			$sql_events_friend="SELECT * FROM tn_events_friend WHERE event_id='".$id."'";
			$query_events_friend=$this->db->query($sql_events_friend);
			$result_events_friend=$query_events_friend->result_array();

			$aryInviteEventFriend=array();
			if(count($result_events_friend)>0)
			{
				foreach($result_events_friend as $k=>$v)
				{
					$aryInviteEventFriend[]=$v['friend_id'];
				}
			}

			$result[0]['event_start_time']=date("H:i:s",strtotime($result[0]['event_start']));
			$result[0]['event_end_time']=date("H:i:s",strtotime($result[0]['event_end']));


			if($result[0]['event_start_time']=='00:00:00')
			{
				$result[0]['starttimeminute']=0;
			}
			else
			{
				$aryStartTimeMinute=explode(":",$result[0]['event_start_time']);
				$strStartTimeMinute=($aryStartTimeMinute[0]*60)+($aryStartTimeMinute[1]);
				$result[0]['starttimeminute']=$strStartTimeMinute;
			}
			$aryEndTimeMinute=explode(":",$result[0]['event_end_time']);
			$strEndTimeMinute=($aryEndTimeMinute[0]*60)+($aryEndTimeMinute[1]);
			$result[0]['endtimeminute']=$strEndTimeMinute;


			$result[0]['display_event_start_time']=date("h:i A",strtotime($result[0]['event_start']));
			$result[0]['display_event_end_time']=date("h:i A",strtotime($result[0]['event_end']));

			$result[0]['aryInviteEventFriend']=$aryInviteEventFriend;

			// echo "<pre>";
			// print_r($result[0]);
			// exit;

			return $result[0];
		}
		else
		{
			return array();
		}
	}

	public function getEventThisWeekData($ary_argument=array())
	{
		$weekStartDay=$ary_argument['weekStartDay'];
	    $weekEndDay=$ary_argument['weekEndDay'];
	    $strWhereParam="";
	    if(!empty($ary_argument['user_auto_id']) && $ary_argument['user_auto_id']>0)
	    {
	    	$user_auto_id=$ary_argument['user_auto_id'];
	    	$strWhereParam=" AND member_id='".$user_auto_id."'";
	    }

		$sql="SELECT * FROM tn_events WHERE (event_start>='".$weekStartDay."' AND event_end<='".$weekEndDay."') ".$strWhereParam." AND status='1' AND deleted='0' order by event_start";
		$query=$this->db->query($sql);
		$result=$query->result_array();

		$finalData=array();
		if(count($result)>0)
		{
			foreach ($result as $key => $value)
			{
				$finalData[$key]=$value;
				$finalData[$key]['displayStartTime']= date("h:i A",strtotime($value['event_start']));

				$date1=date_create($value['event_start']);
		        $date2=date_create($value['event_end']);
		        $diff=(array)date_diff($date1,$date2);
		        $disEventDuration=$this->CalculateDisplayDuration($diff);
		        $finalData[$key]['disEventDuration']=$disEventDuration;
			}
		}
		return $finalData;
	}


	public function CalculateDisplayDuration($ary_argument)
	{
		$strReturn="";
		if(!empty($ary_argument['y']))
		{
			$strReturn.=$ary_argument['y']." Yr ";
		}

		if(!empty($ary_argument['m']))
		{
			$strReturn.=$ary_argument['m']." Mo ";
		}

		if(!empty($ary_argument['d']))
		{
			$strReturn.=$ary_argument['d']." Day ";
		}

		if(!empty($ary_argument['h']))
		{
			$strReturn.=$ary_argument['h']." Hr ";
		}

		if(!empty($ary_argument['i']))
		{
			$strReturn.=$ary_argument['i']." Min ";
		}
		return $strReturn;		
	}

	public function loadInvitedToMeEvents($ary_argument=array())
	{
	    $startDate=$ary_argument['startDate'];
	    $endDate=$ary_argument['endDate'];
	    $user_auto_id=$ary_argument['user_auto_id'];

	    $strWhereParam="";
	    if(!empty($ary_argument['event_accept_reject']))
	    {
	    	$event_accept_reject=$ary_argument['event_accept_reject'];
	    	$strWhereParam=" AND tef.event_accept_reject='".$event_accept_reject."'";
	    }

		$sql="SELECT 
		te.*,
		tef.id as tefAutoId,
		tef.event_accept_reject,
		tm.membership_type,
		tm.first_name,
        tm.last_name
		FROM tn_events as te
		LEFT JOIN tn_events_friend as tef ON tef.event_id=te.id
        LEFT JOIN tn_members as tm ON tm.id=te.member_id

		WHERE ((te.event_start>='".$startDate."' OR te.event_end>='".$startDate."' ) AND ( te.event_start<='".$endDate."')) AND te.status='1' AND te.deleted='0' AND tef.friend_id='".$user_auto_id."' AND tm.status='1' AND tm.deleted='0' ".$strWhereParam." order by te.event_start";

		// echo $sql;
		// exit;

		$query=$this->db->query($sql);
		$result=$query->result_array();


		$finalData=array();
		if(count($result)>0)
		{
			foreach ($result as $key => $value)
			{

				$sqlFriend="SELECT 
				tef.id,
				tm.profile_image,
				tm.membership_type,
				tm.first_name,
		        tm.last_name
				FROM tn_events_friend as tef
		        LEFT JOIN tn_members as tm ON tm.id=tef.friend_id
				WHERE tef.event_id='".$value['id']."' AND tm.status='1' AND tm.deleted='0' order by rand() limit 5";
				$queryFriend=$this->db->query($sqlFriend);
				$ary_all_invited_friend=$queryFriend->result_array();

				$finalData[$key]=$value;
				$finalData[$key]['displayStartDate']= date("d M Y",strtotime($value['event_start']));
				$finalData[$key]['displayStartTime']= date("h:i A",strtotime($value['event_start']));
				$date1=date_create($value['event_start']);
		        $date2=date_create($value['event_end']);
		        $diff=(array)date_diff($date1,$date2);
		        $disEventDuration=$this->CalculateDisplayDuration($diff);
		        $finalData[$key]['disEventDuration']=$disEventDuration;

		        $finalData[$key]['all_invited_friend']=array();
		        if(count($ary_all_invited_friend)>0)
		        {
		        	$finalData[$key]['all_invited_friend']=$ary_all_invited_friend;
		        }
		        
			}
		}
		return $finalData;
	}

}
?>