<?php 
class Event extends CI_Controller
{
    
	public function loadEventCalender()
	{
	    $monthArray=array();
	    $mArray=array();
	    for ($t=1; $t<=12; $t++)
	    {
	      $monthNum=str_pad($t, 2, 0, STR_PAD_LEFT);
	      $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
	      $monthArray[]=array('monthNum'=>$monthNum, 'monthName'=>$monthName);
	      $mArray[$monthNum]=$monthName;
	    }


	    $paramMonth=(isset($_POST['currentMonthNumber']) && !empty($_POST['currentMonthNumber']))? $_POST['currentMonthNumber'] : date('m');
	    $paramYear=(isset($_POST['currentYearNumber']) && !empty($_POST['currentYearNumber']))? $_POST['currentYearNumber'] : date('Y');
	    $loggedUserId=(isset($_POST['loggedUserId']) && !empty($_POST['loggedUserId']))? $_POST['loggedUserId'] :0;

	    $paramMonthName=$mArray[$paramMonth];
	    $startDate = "01-".$paramMonth."-".$paramYear;
	    $startTime = strtotime($startDate);
	    $endTime = strtotime("+1 month", $startTime);

	    $allDatesOfParamMonth=array();
	    $weekArray=array();
	    $checkArray=array();
	    for ($i=$startTime; $i<$endTime; $i+=86400) {
	      $dateStr=date('Y-m-d', $i);
	      array_push($allDatesOfParamMonth, $dateStr);
	      $weekNumber=date("W", strtotime($dateStr));
	      $yearNumber=date('Y', $i);
	      $mNumber=date('m', $i);
	      $monthNumber=ltrim($mNumber, "0");
	      if (!in_array($weekNumber, $checkArray)) {
	        $weekArray[$yearNumber][]=array('monthNumber'=>$monthNumber, 'weekNumber'=>$weekNumber) ;
	        $checkArray[]=$weekNumber;
	      }
	    }
	    $finalArray=array();
	    $currDay=date('d');
	    $currMonth=date('m');
	    $currYear=date('Y');
	    $i=0;
	    foreach ($weekArray as $wkYear=>$wkNums) {
	      if (!empty($wkNums)) {
	        foreach ($wkNums as $weeksData) {
	          $weekVal=$weeksData['weekNumber'];
	          $monthNum=$weeksData['monthNumber'];
	          if (($weekVal==52 || $weekVal==53) && $monthNum==1) {
	            $weekYear=$wkYear-1 ;
	          } else {
	            $weekYear=$wkYear ;
	          }
	          $i++;
	          $weekStartDate = date("Y-m-d", strtotime($weekYear.'W'.str_pad($weekVal, 2, 0, STR_PAD_LEFT)));
	          $weekEndDate = date("Y-m-d", strtotime($weekYear.'W'.str_pad($weekVal, 2, 0, STR_PAD_LEFT).' +6 days'));
	          $allDates=array();
	          $inactiveDateCount=0;
	          for ($j=strtotime($weekStartDate); $j<=strtotime($weekEndDate); $j+=86400) {
	            $dateStr=date('Y-m-d', $j);
	            $dayNum=date('d', $j);
	            $weekDayNumber=date('w', $j);
	            $shortMonthNm='';
	            $activeDate=0;
	            if (in_array($dateStr, $allDatesOfParamMonth)) {
	              $activeDate=1;
	            } else {
	              $inactiveDateCount++;
	            }
	            $shortMonthNm=date('M', $j);
	            $shortYear=date('Y', $j);

	            $isToday=0;
	            if($dateStr==date('Y-m-d'))
	            {
	              $isToday=1;
	            }

	            $weekStartDay=date("Y-m-d 00:00:00", strtotime($dateStr));
	            $weekEndDay=date("Y-m-d 23:59:59", strtotime($dateStr));

	            $ary_argument=array();
	            $ary_argument['weekStartDay']=$weekStartDay;
	            $ary_argument['weekEndDay']=$weekEndDay;
	            $ary_argument['loggedUserId']=$loggedUserId;
	            $resultUserThisWeekEvents=$this->Event_Model->getEventThisWeekData($ary_argument);

	            $isEventPresent=0;
	            if(count($resultUserThisWeekEvents)>0)
	            {
	              $isEventPresent=1;

	              foreach($resultUserThisWeekEvents as $key => $value)
	              {
	                $disEventDuration='NA';
	                if(!empty($value['event_start']) && !empty($value['event_end']))
	                {
	                  $date1=date_create($value['event_start']);
	                  $date2=date_create($value['event_end']);
	                  $diff=(array)date_diff($date1,$date2);
	                  $disEventDuration=$this->Event_Model->CalculateDisplayDuration($diff);
	                }
	                $resultUserThisWeekEvents[$key]['disEventDuration']=$disEventDuration;

	                if(date('Y-m-d', strtotime($value['event_start']))== date('Y-m-d', strtotime($value['event_end'])))
	                {
	                  $disEventTime=date('h:i A', strtotime($value['event_start']));
	                }
	                else
	                {
	                  $disEventTime=date('jS M h:i A', strtotime($value['event_start']))." to ".date('jS M h:i A', strtotime($value['event_end']));
	                }
	                $resultUserThisWeekEvents[$key]['disEventTime']=$disEventTime;

	                $resultUserThisWeekEvents[$key]['is_editable']='Y';
	                if(time()>strtotime($value['event_start']))
	                {
	                  $resultUserThisWeekEvents[$key]['is_editable']='N';
	                }
	              }
	            }

	            $allDates[]=array('ymdDate'=>$dateStr, 'dayNum'=>$dayNum, 'weekDayNumber'=>$weekDayNumber, 'activeDate'=>$activeDate, 'shortMonthNm'=>$shortMonthNm, 'shortYear'=>$shortYear, 'isEventPresent'=>$isEventPresent, 'dayEventData'=>$resultUserThisWeekEvents, 'isToday'=>$isToday);
	          }
	          $hideWeek=0;
	          if ($inactiveDateCount>=6 && in_array($weekEndDate, $allDatesOfParamMonth))
	          {
	            $hideWeek=1;
	          }
	          $finalArray[]=array('weekNumber'=>$i, 'weekStartDate'=>$weekStartDate, 'weekEndDate'=>$weekEndDate, 'allDates'=>$allDates, 'hideWeek'=>$hideWeek);
	        }
	      }
	    }
	    
	    $yearArray=array();
	    $minYear=date('Y')-5;
	    $maxYear=date('Y')+13;
	    for ($y=$minYear; $y<=$maxYear; $y++)
	    {
	      $yearArray[]=$y;
	    }

	    echo json_encode(array('dateData'=>$finalArray, 'monthArray'=>$monthArray, 'yearArray'=>$yearArray, 'currentMonthNumber'=>$paramMonth, 'paramMonthName'=>$paramMonthName, 'currentYearNumber'=>$paramYear, 'weekArray'=>$weekArray, 'currYear'=>$currYear, 'currDay'=>$currDay,'currMonth'=>$currMonth, 'minYear'=>$minYear, 'maxYear'=>$maxYear));
	    exit;
	}

	public function loadDateRangeSchedule()
	{
		$loadScheduleData = trim($this->input->post('loadScheduleData'));
        $loadScheduleData=json_decode($loadScheduleData, true);
        $loggedUserId=(isset($loadScheduleData['loggedUserId']) && !empty($loadScheduleData['loggedUserId']))? addslashes(trim($loadScheduleData['loggedUserId'])):0; 

	    $todayStart=date("Y-m-d 00:00:00");
        $todayEnd=date("Y-m-d 23:59:59");
        $ary_argument=array();
        $ary_argument['weekStartDay']=$todayStart;
        $ary_argument['weekEndDay']=$todayEnd;
        $ary_argument['loggedUserId']=$loggedUserId;
        $resultTodayEvents=$this->Event_Model->getEventThisWeekData($ary_argument);

        $returnData['status']='1';
        $returnData['msg']='success';
        $returnData['msgstring']='DateRange Schedule';
        $returnData['data']=array('resultTodayEvents'=>$resultTodayEvents,'totalSchedule'=>count($resultTodayEvents));
		echo json_encode($returnData);
        exit;
	}


	public function addCalendarEvent()
  	{
  		$data=array();
	    $eventFormData=$this->input->get_post('eventFormData');
    	$aryEventFormData=json_decode($eventFormData, true);

        $selectedDMY=(isset($aryEventFormData['selectedymdDate']) && !empty($aryEventFormData['selectedymdDate']))? addslashes(trim($aryEventFormData['selectedymdDate'])):'';
        $eventId=(isset($aryEventFormData['eventId']) && !empty($aryEventFormData['eventId']))? addslashes(trim($aryEventFormData['eventId'])):0;
        $loggedUserId=(isset($aryEventFormData['loggedUserId']) && !empty($aryEventFormData['loggedUserId']))? addslashes(trim($aryEventFormData['loggedUserId'])):0;

	    $weekStartDay=date("Y-m-d 00:00:00", strtotime('monday this week', strtotime($selectedDMY)));
	    $weekEndDay=date("Y-m-d 23:59:59", strtotime('sunday this week', strtotime($selectedDMY)));

	    $ary_argument=array();
	    $ary_argument['weekStartDay']=$weekStartDay;
	    $ary_argument['weekEndDay']=$weekEndDay;
	    $ary_argument['loggedUserId']=$loggedUserId;
	    $resultUserThisWeekEvents=$this->Event_Model->getEventThisWeekData($ary_argument);
    
	    if(count($resultUserThisWeekEvents)>0)
	    {
	      foreach($resultUserThisWeekEvents as $key => $value)
	      {
	        $disEventDuration='NA';
	        if(!empty($value['event_start']) && !empty($value['event_end']))
	        {
	          $date1=date_create($value['event_start']);
	          $date2=date_create($value['event_end']);
	          $diff=(array)date_diff($date1,$date2);
	          $disEventDuration=$this->Event_Model->CalculateDisplayDuration($diff);
	        }
	        $resultUserThisWeekEvents[$key]['disEventDuration']=$disEventDuration;

	        if(date('Y-m-d', strtotime($value['event_start']))== date('Y-m-d', strtotime($value['event_end'])))
	        {
	          $disEventTime=date('jS h:i A', strtotime($value['event_start']));
	        }
	        else
	        {
	          $disEventTime=date('jS M h:i A', strtotime($value['event_start']))." to ".date('jS M h:i A', strtotime($value['event_end']));
	        }

	        $resultUserThisWeekEvents[$key]['disEventTime']=$disEventTime;

	        $resultUserThisWeekEvents[$key]['is_editable']='Y';
	        if(time()>strtotime($value['event_start']))
	        {
	          $resultUserThisWeekEvents[$key]['is_editable']='N';
	        }
	      }
	    }

	    $data['enableEventForm']='Y';
	    if(strtotime(date('Y-m-d'))>strtotime($selectedDMY))
	    {
	      $data['enableEventForm']='N';
	    }

	    $resultEventDetails=array();
	    if(!empty($eventId))
	    {
	      $resultEventDetails=$this->Event_Model->getEventData($eventId);
	      if(strtotime($resultEventDetails['event_start'])>strtotime(date('Y-m-d')))
	      {
	        $data['enableEventForm']='Y';
	      }
	    }

	    $data['resultUserThisWeekEvents']=$resultUserThisWeekEvents;
	    $data['resultEventDetails']=$resultEventDetails;

		$this->load->view('event/addcalendarevent', $data);
		//$this->set_output($html); 
	}
	

	public function submitCalendarEvent()
  	{
  		// echo "zzzzzz"; die;

  		$returnData=array();

	    $eventData=$this->input->get_post('eventData');
    	$eventData=json_decode($eventData, true);

	    $id=(isset($eventData['id']) && !empty($eventData['id']))? $eventData['id'] : 0 ;

	    $user_auto_id=(isset($eventData['loggedUserId']) && !empty($eventData['loggedUserId']))? $eventData['loggedUserId'] : 0 ;

	    $event_type=(isset($eventData['event_type']) && !empty($eventData['event_type']))? $eventData['event_type'] : '' ;
	    $aryInviteEventFriend=(isset($eventData['aryInviteEventFriend']) && !empty($eventData['aryInviteEventFriend']))? $eventData['aryInviteEventFriend'] : '' ;
	    $event_title=(isset($eventData['event_title']) && !empty($eventData['event_title']))? $eventData['event_title'] : '' ;
	    $event_desc=(isset($eventData['event_desc']) && !empty($eventData['event_desc']))? $eventData['event_desc'] : '' ;
	    $event_start_time=(isset($eventData['event_start_time']) && !empty($eventData['event_start_time']))? $eventData['event_start_time'] : '' ;
	    $event_end_time=(isset($eventData['event_end_time']) && !empty($eventData['event_end_time']))? $eventData['event_end_time'] : '' ;

	    $arySelectedymdDate=(isset($eventData['selectedymdDate']) && !empty($eventData['selectedymdDate']))? explode("-",$eventData['selectedymdDate']) : '' ;
	    $selectedDay=(isset($arySelectedymdDate[2]) && !empty($arySelectedymdDate[2]))? $arySelectedymdDate[2] : '' ;
	    $selectedMonth=(isset($arySelectedymdDate[1]) && !empty($arySelectedymdDate[1]))? $arySelectedymdDate[1] : '' ;
	    $selectedYear=(isset($arySelectedymdDate[0]) && !empty($arySelectedymdDate[0]))? $arySelectedymdDate[0] : '' ;

	    $all_day_event=(isset($eventData['all_day_event']) && !empty($eventData['all_day_event']))? $eventData['all_day_event'] : 0 ;
	    
	    $menu_arr=array();
	    
	    if (!empty($aryInviteEventFriend) && count($aryInviteEventFriend)>0 && $user_auto_id>0)
	    { 
			$menu_arr['member_id']=$user_auto_id;
			$menu_arr['event_type']=$event_type;
			$menu_arr['event_title']=$event_title;
			$menu_arr['event_desc']=$event_desc ;
			$menu_arr['all_day_event']=$all_day_event ;

			if(!empty($id))
			{
				//Start Delete Events Friend
				$menu_arr_friend = array(
		            'deleted'	=>'1'
		        );
		        $this->Event_Model->UpdatEventFriendsByEventId($menu_arr_friend,$id);
				// $sql="DELETE FROM tn_events_friend WHERE event_id='".$id."'";
				// $query=$this->db->query($sql);
				//End Delete Events Friend

				$resultEventDetails=$this->Event_Model->getEventData($id);
				$ary_event_start=explode(" ",$resultEventDetails['event_start']);
				$str_event_start_time=$ary_event_start[0]." ".$event_start_time;

				$ary_event_end=explode(" ",$resultEventDetails['event_end']);
				$str_event_end_time=$ary_event_end[0]." ".$event_end_time;

				$menu_arr['event_start']=$str_event_start_time;
				$menu_arr['event_end']=$str_event_end_time;
				$menu_arr['update_date']=date('Y-m-d H:i:s');
			}
			else
			{
				$str_event_start_time=$selectedYear.'-'.$selectedMonth.'-'.$selectedDay.' '.$event_start_time;
				$str_event_end_time=$selectedYear.'-'.$selectedMonth.'-'.$selectedDay.' '.$event_end_time;

				$menu_arr['event_start']=$str_event_start_time;
				$menu_arr['event_end']=$str_event_end_time;
				$menu_arr['create_date']=date('Y-m-d H:i:s');
			}

			$lastId = $this->Event_Model->addupdatevent($id,$menu_arr);

			//Start insert all friend of this events
			if(count($aryInviteEventFriend)>0)
        	{
        		foreach($aryInviteEventFriend as $k=>$v)
        		{
        			$menu_arr_friend = array(
			            'event_id'	=>$lastId,
			            'friend_id' =>$v,
			            'deleted' =>'0',
			        );

			        $sql_events_friend="SELECT id FROM tn_events_friend WHERE event_id='".$lastId."' AND friend_id='".$v."'";
					$query_events_friend=$this->db->query($sql_events_friend);
					$row_events_friend=$query_events_friend->row();
					if(!empty($row_events_friend) && $row_events_friend->id>0)
					{
						$this->Event_Model->addUpdatEventFriends($menu_arr_friend,$row_events_friend->id);
					}
					else
					{
						$this->Event_Model->addUpdatEventFriends($menu_arr_friend,0);
					}
			        
        		}
        	}
        	//End insert all friend of this events
			$returnData['status']='1';
	        $returnData['msg']='success';
	        $returnData['msgstring']='Event Createdy';
	        $returnData['data']=array('id'=>$lastId);
		}
		else
		{
			$returnData['status']='0';
	        $returnData['msg']='error';
	        $returnData['msgstring']='Event Creation Failed';
	        $returnData['data']=array();
		}
        echo json_encode($returnData);
        exit;
	}



}
	




