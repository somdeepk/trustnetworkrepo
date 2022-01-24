mainApp.controller('eventController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.eventCalender={};
	$scope.eventCalender.calenderData={};	

	$scope.initiateData = function (user_auto_id,membership_type,is_admin,parent_id)
	{
		$scope.memberData.user_auto_id=user_auto_id;
		$scope.memberData.membership_type=membership_type;
		$scope.memberData.is_admin=is_admin;
		$scope.memberData.parent_id=parent_id;
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
	    $scope.eventFormData.clientId=$scope.eventCalender.genData.clientId;
	    var response = $http({
	      method: 'POST',
	      url     : varGlobalAdminBaseUrl+"geteventform",
	      data: $.param({'eventFormData' : $scope.eventFormData }),
	      headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
	    });
	    response.success(function (data, status, headers, config) {
	      var element = angular.element('#appCreateEventContainer').html(data);
	      $compile(element.contents())($scope);
	      $('#eventFormModal').modal('show');

	      $scope.eventData={};
	      if(eventId>0)
	      {
	        $scope.isEventPopClick=0;
	        var baseEventData=$scope.baseencoded_event_data;
	        var baseEventDataStr=atob(baseEventData);
	        var baseEventDataObj=jQuery.parseJSON(baseEventDataStr);
	        $scope.eventData=baseEventDataObj;
	      }
	    });
	    response.error(function (data, status, headers, config)
	    {
	      console.log("Error.");
	    });
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

	    if($scope.eventCalender.genData.IdFire=="LEAD")
	    {
	      $scope.eventData.event_for_module_id=$scope.eventCalender.genData.custId;
	      $scope.eventData.event_for_module_type='LEAD';
	    }
	    else
	    {
	      $scope.eventData.event_for_module_id=$scope.eventCalender.genData.appId;
	      $scope.eventData.event_for_module_type='APPLICATION';
	    }
	    
	    $scope.eventData.event_start_time=event_start_time;
	    $scope.eventData.event_end_time=event_end_time;
	    $scope.eventData.all_day_event=all_day_event;
	    $scope.eventData.selectedymdDate=$scope.eventFormData.selectedymdDate

	    if($scope.isNullOrEmptyOrUndefined($scope.eventData.event_type)==true)
	    {
	      errorData.push('Event Type');
	      $scope.validator=true;
	    }

	    if($scope.isNullOrEmptyOrUndefined($scope.eventData.related_person)==true)
	    {
	      errorData.push('Related to');
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
	      $('#eventFormModal').find('#eventSubmitButton').addClass('cssdisabled');
	      var response = $http({
	        method: 'POST',
	        url: '/application/liveapp/submitevent',
	        data: $.param({'eventData' : $scope.eventData }),
	        headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
	        async:true,
	      });
	      response.success(function (data, status, headers, config)
	      {
	        $('#eventFormModal').find('#eventSubmitButton').removeClass('cssdisabled');
	        $('#eventFormModal').modal('hide');
	        if($scope.eventData.id>0)
	        {
	          $scope.showSuccess('Event Updated Successfully', 0,1500);
	        }
	        else
	        {
	         $scope.showSuccess('Event Added Successfully', 0,1500); 
	        }
	        $scope.eventData={};
	        $scope.viewApplicationCalender();
	      });
	      response.error(function (data, status, headers, config)
	      {
	        $('#eventFormModal').find('#eventSubmitButton').removeClass('cssdisabled');
	        console.log("Error.");
	      });
	    }
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
