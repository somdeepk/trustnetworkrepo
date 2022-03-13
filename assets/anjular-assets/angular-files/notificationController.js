mainApp.controller('notificationController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.parseInt = parseInt ;
	$scope.notificationData={};
	$scope.allNotificationObj={};
	$scope.friendData={};
	$scope.allFriendRequestObj={};

	$rootScope.clickProfileTab='newsfeedTab';

	$rootScope.tabPointer = function(typ)
	{
		$rootScope.clickProfileTab=typ;
		if(typ=="timelineTab")
		{
			$rootScope.loadAcceptedInvitedToMeEvents();
		}
	};

	$rootScope.loadAcceptedInvitedToMeEvents = function ()
	{
		$scope.loadScheduleData={};
	    $scope.loadScheduleData.user_auto_id=$scope.friendData.user_auto_id;
	    $scope.loadScheduleData.date_range='7days';
	    $scope.loadScheduleData.event_accept_reject='A';
	    var formData = new FormData();
		formData.append('loadScheduleData',angular.toJson($scope.loadScheduleData));
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"loadInvitedToMeEvents",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$rootScope.loadAcceptedInvitedToMeEventsObj=aryreturnData.data.resultMyEvents;
        	}
        	else
        	{
        		console.log("DateRange Schedule Failed.");
        	}
		});
	};

	$rootScope.loadInvitedToMeEvents = function ()
	{
		$scope.loadScheduleData={};
	    $scope.loadScheduleData.user_auto_id=$scope.friendData.user_auto_id;
	    $scope.loadScheduleData.date_range='1month';
	    $scope.loadScheduleData.event_accept_reject='';
	    
	    var formData = new FormData();
		formData.append('loadScheduleData',angular.toJson($scope.loadScheduleData));
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"loadInvitedToMeEvents",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$rootScope.loadInvitedToMeEventsObj=aryreturnData.data.resultMyEvents;
        	}
        	else
        	{
        		console.log("DateRange Schedule Failed.");
        	}
		});
	};

	$rootScope.getUserOtherData = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"getUserOtherData",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$rootScope.totalPostCount=aryreturnData.data.totalPostCount;
	        	}
	        	else
	        	{
	        		console.log("Something went wrong. Please try again later!");
	        	}
			});			
	    }
    };

    $scope.get_all_notifiction = function (user_auto_id,parent_id,membership_type,is_admin,admin_id)
	{

		$scope.notificationData.user_auto_id=user_auto_id;
		$scope.notificationData.parent_id=parent_id;
		$scope.notificationData.membership_type=membership_type;
		$scope.notificationData.admin_id=admin_id;
		$scope.notificationData.is_admin=is_admin;

		var formData = new FormData();
		formData.append('notificationData',angular.toJson($scope.notificationData));
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxGetAllNotification",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$scope.allNotificationObj=aryreturnData.data.allNotificationData;
        	}
        	else
        	{
        		console.log("Something went wrong. Please try again later!")
        	}
		});	


		$scope.friendData.user_auto_id=user_auto_id;
		$scope.getAllFriendRequest()
		$rootScope.getUserOtherData()
	};

	$scope.getAllFriendRequest = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
			//alert("dsd")
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetAllFriendRequest",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.allFriendRequestObj=aryreturnData.data.friendData;
	        	}
	        	else
	        	{
	        		//$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	        		console.log("Something went wrong. Please try again later!")
	        	}
			});
			
	    }
    };

    $scope.confirmFriendRequest = function(member_friends_aid)
    {
    	$scope.buttonSavingAnimation('zconfirmFriendRequestz_'+member_friends_aid,'Confirming..','loader');
    	$timeout(function()
		{
			$(".zNotifyPopUpz").addClass('iq-show');
		},2);

		$timeout(function()
		{
			
			$scope.friendData.member_friends_aid=member_friends_aid;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxConfirmFriendRequest",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.buttonSavingAnimation('zconfirmFriendRequestz_'+member_friends_aid,'Confirmed!','onlytext');
	        		$timeout(function()
					{
						$scope.getAllFriendRequest();						
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zconfirmFriendRequestz_'+member_friends_aid,'Confirm','onlytext');
	        		console.log("Confirmation Failed!")
	        	}
			});
		},2000);
	};


	$scope.deleteFromFriendRequest = function(member_friends_aid)
    {
    	$scope.buttonSavingAnimation('zdeleteFromFriendRequestz_'+member_friends_aid,'Deleting..','loader');
    	$timeout(function()
		{
			$(".zNotifyPopUpz").addClass('iq-show');
		},2);

		$timeout(function()
		{
			$scope.friendData.member_friends_aid=member_friends_aid;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxDeleteFromFriendRequest",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.getAllFriendRequest();	
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zdeleteFromFriendRequestz_'+member_friends_aid,'Delete Request','onlytext');
	        		console.log("Deletion Failed!")
	        	}
			});
		},2000);
	};

	$rootScope.ShowPhotoSlider = function (id,nextPrevIdFire="")
    {
    	//alert("ds"+id)
    	$scope.photoSlideData={};
    	$scope.photoSlideData.id=id;
    	//if($scope.photoExist==true)
    	//{
	    	var formData = new FormData();
			formData.append('photoSlideData',angular.toJson($scope.photoSlideData));
	        $http({
	            method: 'POST',
	            url     : varBaseUrl+"post/ajaxShowPhotoSlider",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
		        data:formData,
	        }).then(function successCallback(returnData)
	        {
	            aryreturnData=angular.fromJson(returnData);
	            aryreturnData=aryreturnData.data;
	         	if(aryreturnData.status=='1')
	        	{
		            $rootScope.photoSlideDataObj=aryreturnData.data;	
		            if(nextPrevIdFire=='direct')
		            {
		            	$('#examplePhotoModal').modal('show');
		            }
		            //$scope.photoSlideDataReturnObj.=aryreturnData.photoSlideDataReturnObj.resultPrev;	 
		            //$scope.photoSlideDataReturnObj.=aryreturnData.photoSlideDataReturnObj.totPrev;	 
		            console.log('l')       		
		            console.log($scope.photoSlideDataObj)       		
	        	}
	        	else
	        	{
	        		// swal("Error!",
		        	// 	"No Data Found!",
		        	// 	"error"
		        	// )
	        	}
	        });
	    //}
    }

	// $rootScope.openPostModalPopup = function(valuePS)
 //    {
 //    	$('#exampleModal_'+valuePS.id).modal('show')
 //    };

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
});
