mainApp.controller('eventController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.eventCalender={};
	$scope.inviteEventData={};
	$scope.eventCalender.calenderData={};	
	$scope.eventData={};
	$scope.loadDateRangeScheduleObj={};
	$scope.initiateData = function (user_auto_id,membership_type,is_admin,parent_id)
	{
		//alert("initiateData")
		$scope.memberData={};
		$scope.memberData.user_auto_id=user_auto_id;
		$scope.memberData.membership_type=membership_type;
		$scope.memberData.is_admin=is_admin;
		$scope.memberData.parent_id=parent_id;

		//$timeout(function()
		//{
			$scope.loadEventCalender();
			$scope.loadDateRangeSchedule();
			$rootScope.loadAcceptedInvitedToMeEvents();
		//},3000);
	};

	$rootScope.loadCalenderTab = function()
	{
		$scope.loadEventCalender();
		$scope.loadDateRangeSchedule();
		$rootScope.loadAcceptedInvitedToMeEvents();
	};

	$scope.loadDateRangeSchedule = function ()
	{		
	    $scope.loadScheduleData={};
		var formData = new FormData();
		formData.append('loadScheduleData',angular.toJson($scope.loadScheduleData));
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"loadDateRangeSchedule",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$scope.loadDateRangeScheduleObj=aryreturnData.data.resultTodayEvents;
        	}
        	else
        	{
        		console.log("DateRange Schedule Failed")
        	}
		});

	};

	$scope.loadEventCalender = function ()
	{		
	    var response = $http({
	      method: 'POST',
	      url     : varGlobalAdminBaseUrl+"loadEventCalender",
	      data: $.param({'currentMonthNumber' : $scope.eventCalender.calenderData.selectedMonth,'currentYearNumber' : $scope.eventCalender.calenderData.selectedYear}),
	      headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}, 
	      async:true,
	    });
	    response.success(function(data, status, headers, config)
	    {
	      $scope.eventCalender.calenderData=data;
	      $scope.eventCalender.calenderData.selectedMonth=data.currentMonthNumber;
	      $scope.eventCalender.calenderData.selectedYear=data.currentYearNumber;
	    });
	    response.error(function(data, status, headers, config)
	    {
	      console.log("Error.");
	    });
	};

	$scope.goToDate = function (jumpto)
	{
	    if(jumpto=='today')
	    {
	      $scope.eventCalender.calenderData.selectedMonth=$scope.eventCalender.calenderData.currMonth;
	      $scope.eventCalender.calenderData.selectedYear=$scope.eventCalender.calenderData.currYear;
	    }
	    else if(jumpto=='next')
	    {
	      if($scope.eventCalender.calenderData.selectedYear==$scope.eventCalender.calenderData.maxYear && $scope.eventCalender.calenderData.selectedMonth==12 )
	      {

	      }
	      else
	      {
	        $scope.eventCalender.calenderData.selectedMonth=$scope.pad((parseInt($scope.eventCalender.calenderData.selectedMonth)+1),2);
	        if($scope.eventCalender.calenderData.selectedMonth>12)
	        {
	          $scope.eventCalender.calenderData.selectedMonth='01';
	          $scope.eventCalender.calenderData.selectedYear=(parseInt($scope.eventCalender.calenderData.selectedYear)+1).toString();
	        }
	      }
	    }
	    else if(jumpto=='prev')
	    {
	      if($scope.eventCalender.calenderData.selectedYear==$scope.eventCalender.calenderData.minYear && $scope.eventCalender.calenderData.selectedMonth==1)
	      {

	      }
	      else
	      {
	        $scope.eventCalender.calenderData.selectedMonth=$scope.pad((parseInt($scope.eventCalender.calenderData.selectedMonth)-1),2);
	        if($scope.eventCalender.calenderData.selectedMonth<1)
	        {
	          $scope.eventCalender.calenderData.selectedMonth='12';
	          $scope.eventCalender.calenderData.selectedYear=(parseInt($scope.eventCalender.calenderData.selectedYear)-1).toString();
	        }
	      }
	    }
	    $scope.loadEventCalender();
	};

	$scope.editFromThisWeekEvent= function (eventId)
	{ 
		dataVal=$scope.eventDataVal;
		$scope.addCalendarEvent(dataVal,eventId);
		$scope.isEventPopClick=1;
	};

	$scope.editCalendarEvent= function (eventId,dataVal)
	{
		$scope.addCalendarEvent(dataVal,eventId);
		$scope.isEventPopClick=1;
	};

  	$scope.addCalendarEvent = function (dtVal,eventId=0)
  	{ 
	    $scope.eventDataVal= dtVal;
	    if($scope.isEventPopClick==1)
	    {
	      return true;
	    }

	    $scope.eventCalender.calenderData.displayDay=dtVal.dayNum;
	    $scope.eventCalender.calenderData.displayMonth=dtVal.shortMonthNm;
	    $scope.eventCalender.calenderData.displayYear=dtVal.shortYear;
	 
	    $scope.eventFormData={};
	    $scope.eventFormData.eventId=eventId;
	    $scope.eventFormData.selectedymdDate=dtVal.ymdDate;
   		
   		var formData = new FormData();
		formData.append('eventFormData',angular.toJson($scope.eventFormData));
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"addCalendarEvent",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
        	var element = angular.element('.zcalnedarEventContainerz').html(returnData);
	        $compile(element.contents())($scope);
		    $('#calnedarEventModal').modal('show');
			$scope.eventData={};
			$scope.totalInvitedFriend = 0;
  			$scope.aryInviteEventFriend = [];

			if(eventId>0)
			{
			  $scope.isEventPopClick=0;
			  var baseEventData=$scope.baseencoded_eventData;
			  var baseEventDataStr=atob(baseEventData);
			  var baseEventDataObj=jQuery.parseJSON(baseEventDataStr);
			  $scope.aryInviteEventFriendData=baseEventDataObj.aryInviteEventFriendData;
			  $scope.totalInvitedFriend=baseEventDataObj.aryInviteEventFriendData.length;
			  $scope.eventData=baseEventDataObj;
			}
		});
  	};

  	$scope.totalInvitedFriend = 0;
  	$scope.aryInviteEventFriend = [];
	$scope.setInviteFriendToEvent = function(memberId)
	{
		if($scope.aryInviteEventFriend.length>0)
		{
		  if($.inArray(memberId, $scope.aryInviteEventFriend) != -1){
		    $scope.aryInviteEventFriend.splice( $.inArray(memberId, $scope.aryInviteEventFriend), 1 );
		  }else{
		    $scope.aryInviteEventFriend.push(memberId);
		  }
		}else{
		  $scope.aryInviteEventFriend.push(memberId);
		}

		$scope.totalInvitedFriend=$scope.aryInviteEventFriend.length;
	};

  	$scope.inviteFriendToEvent = function ()
	{
		if($scope.memberData.user_auto_id>0)
		{
			$scope.friendData={};
			$scope.friendData.user_auto_id=$scope.memberData.user_auto_id;
			$scope.friendData.searchFriend=$scope.inviteEventData.searchFriend;

			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetAllFriendList",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	var aryFriendListObj=aryreturnData.data.friendListData;

	        	$scope.allFriendListObj=[];
	        	angular.forEach(aryFriendListObj,function(item,index)
				{
					var temEventAcceptReject='';					
					angular.forEach( $scope.aryInviteEventFriendData,function(itemInvited,indexInvited)
					{
						if(item.id==itemInvited.friend_id)
						{
							temEventAcceptReject=itemInvited.event_accept_reject;
							$scope.aryInviteEventFriend.push(item.id);
						}
					});
					item.event_accept_reject= temEventAcceptReject
					$scope.allFriendListObj.push(item);			
				});

	        	$('#calnedarEventModal').modal('hide');
	        	$('#inviteFriendToEventModal').modal('show');
			});			
	    }		
	};

	$scope.closeInviteFriendToEvent = function ()
	{
		$('#inviteFriendToEventModal').modal('hide');
		$('#calnedarEventModal').modal('show');
	};

	$scope.closeEventModal = function ()
	{
		$('#calnedarEventModal').modal('hide');
	};

  	$scope.submiCalendarEvent = function ()
  	{
	    var errorData=[];
	    $scope.validator=false;

	    var event_start_time=$('#event_start_time').val();
	    var event_end_time=$('#event_end_time').val();
	    var all_day_event=0;
	    if($('#chk_all_day_event').is(':checked'))
	    {
	      all_day_event=1;
	    }
    
	    $scope.eventData.event_start_time=event_start_time;
	    $scope.eventData.event_end_time=event_end_time;
	    $scope.eventData.all_day_event=all_day_event;
	    $scope.eventData.selectedymdDate=$scope.eventFormData.selectedymdDate;

	    if($scope.isNullOrEmptyOrUndefined($scope.eventData.event_type)==true)
	    {
	      errorData.push('Event Type');
	      $scope.validator=true;
	    }

	    if($scope.totalInvitedFriend<=0)
	    {
	      errorData.push('Invite Friend');
	      $scope.validator=true;
	    }

	    if($scope.isNullOrEmptyOrUndefined($scope.eventData.event_title)==true)
	    {
	      errorData.push('Event Title');
	      $scope.validator=true;
	    }

	    if($scope.isNullOrEmptyOrUndefined($scope.eventData.event_desc)==true)
	    {
	      errorData.push('Event Description');
	      $scope.validator=true;
	    }

	    if($scope.validator==true)
	    {
	      $timeout(function(){$scope.validator=false;},3400);
	      return false ;
	    }
	    else
	    {
	      	$scope.buttonSavingAnimation('zeventSubmitButtonz','Saving..','loader');
			$timeout(function()
			{	
				var formData = new FormData();

				$scope.eventData.aryInviteEventFriend=$scope.aryInviteEventFriend;
				$scope.eventData.user_auto_id=$scope.memberData.user_auto_id;
				formData.append('eventData',angular.toJson( $scope.eventData));

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"submitCalendarEvent",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.memberDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zeventSubmitButtonz','Saved!','onlytext');
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zeventSubmitButtonz','Submit','onlytext');
							$('#calnedarEventModal').modal('hide');
							$scope.eventData={};
							$scope.totalInvitedFriend = 0;
							$scope.aryInviteEventFriend = [];
							$scope.loadEventCalender();	
							$scope.loadDateRangeSchedule();						
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zeventSubmitButtonz','Submit','onlytext');
	            		console.log("Event Creation Failed!")
	            	}
				});
			},1200);
	     
	    }
  	};

  	


	$scope.acceptRejectEvent = function(value,status)
    {
    	if(status=="A")
    	{
    		$scope.buttonSavingAnimation('zBtnAcceptEventz_'+value.tefAutoId,'Accepting..','loader');
    	}
    	else
    	{
    		$scope.buttonSavingAnimation('zBtnRejectEventz_'+value.tefAutoId,'Accepting..','loader');
    	}

		$timeout(function()
		{
			$scope.loadScheduleData={};
	    	$scope.loadScheduleData.user_auto_id=$scope.memberData.user_auto_id;
	    	$scope.loadScheduleData.status=status;
	    	$scope.loadScheduleData.tefAutoId=value.tefAutoId;

			var formData = new FormData();
			formData.append('loadScheduleData',angular.toJson($scope.loadScheduleData));

			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxAcceptRejectEvent",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	$rootScope.loadInvitedToMeEvents();
			});
		},600);
	};

	$scope.pad = function (str, max)
	{
		str = str.toString();
		return str.length < max ? $scope.pad("0" + str, max) : str;
	};

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
});
