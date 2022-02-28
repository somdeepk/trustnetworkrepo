<?php
class Event_Model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}	

	public function getEventThisWeekData($ary_argument=array())
	{
		$weekStartDay=$ary_argument['weekStartDay'];
	    $weekEndDay=$ary_argument['weekEndDay'];
	    $strWhereParam="";
	    if(!empty($ary_argument['loggedUserId']) && $ary_argument['loggedUserId']>0)
	    {
	    	$loggedUserId=$ary_argument['loggedUserId'];
	    	$strWhereParam=" AND member_id='".$loggedUserId."'";
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


	public function getEventData($id)
	{
		$sql="SELECT * FROM tn_events WHERE id='".$id."'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		if(count($result)>0)
		{
			$sql_events_friend="SELECT * FROM tn_events_friend WHERE event_id='".$id."' AND deleted='0'";
			$query_events_friend=$this->db->query($sql_events_friend);
			$result_events_friend=$query_events_friend->result_array();

			$aryInviteEventFriendData=array();
			if(count($result_events_friend)>0)
			{
				$aryInviteEventFriendData=$result_events_friend;
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

			$result[0]['aryInviteEventFriendData']=$aryInviteEventFriendData;

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

	public function UpdatEventFriendsByEventId($menu_arr=NULL,$event_id=NULL)
	{
		
		$this->db->where('event_id',$event_id)->update('tn_events_friend',$menu_arr);
		return $id;
	}

	

}
?>