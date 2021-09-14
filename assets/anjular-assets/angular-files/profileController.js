mainApp.controller('profileController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
	$scope.friendData={};
	$scope.peopleYouMayNowObj={};
	$scope.allFriendRequestObj={};
	$scope.allFriendListObj={};
	$scope.allChurchMemberListObj={};
	$scope.friendData.clickProfileTab='timelineTab';

	$scope.peopleYouMayNowData = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxgetPeopleYouMayNowData",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.peopleYouMayNowObj=aryreturnData.data.friendData;
	        		/*console.log('PYMK')
	        		console.log($scope.peopleYouMayNowObj)*/
	        	}
	        	else
	        	{
	        		//$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	        		swal("Error!",
		        		"Something went wrong. Please try again later!",
		        		"error"
		        	)
	        	}
			});
			
	    }
    };

    $scope.sendFriendRequest = function(friend_id)
    {	

    	$scope.buttonSavingAnimation('zsendFriendRequestz_'+friend_id,'Requesting..','loader');
		
		$timeout(function()
		{
			$scope.friendData.friend_id=friend_id;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxSendFriendRequest",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.buttonSavingAnimation('zsendFriendRequestz_'+friend_id,'Request Send!','onlytext');
	        		$timeout(function()
					{
						//$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
						/*alert("ss")
						alert($scope.friendData.friend_id);*/
						$scope.peopleYouMayNowData();

						
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zsendFriendRequestz_'+friend_id,'Add Friend','onlytext');
	        		swal("Error!",
		        		"Request Send Failed!",
		        		"error"
		        	)
	        	}
			});
		},1200);
	};

	$scope.removeFromSuggestion = function(friend_id)
    {	

    	$scope.buttonSavingAnimation('zRemoveFromSuggestionz_'+friend_id,'Removing..','loader');
		
		$timeout(function()
		{
			$scope.friendData.friend_id=friend_id;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxRemoveFromSuggestion",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		/*$scope.buttonSavingAnimation('zRemoveFromSuggestionz_'+friend_id,'Removed!','onlytext');
	        		$timeout(function()
					{*/
						$scope.peopleYouMayNowData();						
					//},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zRemoveFromSuggestionz_'+friend_id,'Remove','onlytext');
	        		swal("Error!",
		        		"Removal Failed!",
		        		"error"
		        	)
	        	}
			});
		},600);
	};

	$scope.toggleChurchAdmin = function(adminobj)
    {	
    	var adminid=adminobj.id;
    	var is_admin=adminobj.is_admin;

    	if($(".zmakeChurchAdminz_"+adminid).hasClass('btn-success')){
    		strText="Removing..";
    		strAdmin='N';
    	}else{
    		strText="Creating..";
    		strAdmin='Y';
    	}

    	$scope.buttonSavingAnimation('zmakeChurchAdminz_'+adminid,strText,'loader');		
		$timeout(function()
		{
			$scope.friendData.adminid=adminid;
			$scope.friendData.strAdmin=strAdmin;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"toggleChurchAdmin",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData){
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		if(strAdmin=='Y'){
	        			$(".zmakeChurchAdminz_"+adminid).removeClass('btn-primary');
    					$(".zmakeChurchAdminz_"+adminid).addClass('btn-success');
						$(".zmakeChurchAdminz_"+adminid).css("background-color",'#49f0d3');
						$(".zmakeChurchAdminz_"+adminid).css("bordr-color",'#49f0d3');
	        			$(".zmakeChurchAdminz_"+adminid).html('<i class="ri-admin-line"></i>Church Admin');
	        		}else{
	        			$(".zmakeChurchAdminz_"+adminid).removeClass('btn-success');
	        			$(".zmakeChurchAdminz_"+adminid).addClass('btn-primary');
	        			$(".zmakeChurchAdminz_"+adminid).css("background-color",'#50b5ff');
	        			$(".zmakeChurchAdminz_"+adminid).css("bordr-color",'#2aa3fb');
	        			$(".zmakeChurchAdminz_"+adminid).html('<i class="ri-user-add-line"></i>Create Admin')
	        		};     		
	        	}
	        	else if(aryreturnData.status=='2')
	        	{
	        		$(".zmakeChurchAdminz_"+adminid).removeClass('btn-primary');
					$(".zmakeChurchAdminz_"+adminid).css("background-color",'#ff9b8a');
	        		$(".zmakeChurchAdminz_"+adminid).css("bordr-color",'#ff9b8a');
					$(".zmakeChurchAdminz_"+adminid).addClass('btn-danger');
					$scope.buttonSavingAnimation('zmakeChurchAdminz_'+adminid,'Admin already exist ','onlytext');
	        		$timeout(function()
					{
						$(".zmakeChurchAdminz_"+adminid).removeClass('btn-danger');
	        			$(".zmakeChurchAdminz_"+adminid).css("background-color",'#50b5ff');
	        			$(".zmakeChurchAdminz_"+adminid).css("bordr-color",'#2aa3fb');
						$(".zmakeChurchAdminz_"+adminid).addClass('btn-primary');
	        			$(".zmakeChurchAdminz_"+adminid).html('<i class="ri-user-add-line"></i>Create Admin')	       
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zmakeChurchAdminz_'+adminid,'Create Admin','onlytext');
	        		swal("Error!",
		        		"Admin Creation Failed!",
		        		"error"
		        	)
	        	}
			});
		},1200);
	};

	$scope.getAllFriendRequest = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
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
	        		swal("Error!",
		        		"Something went wrong. Please try again later!",
		        		"error"
		        	)
	        	}
			});
			
	    }
    };

	$scope.confirmFriendRequest = function(member_friends_aid)
    {
    	$scope.buttonSavingAnimation('zconfirmFriendRequestz_'+member_friends_aid,'Confirming..','loader');

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
	        		swal("Error!",
		        		"Confirmation Failed!",
		        		"error"
		        	)
	        	}
			});
		},600);
	};


	$scope.deleteFromFriendRequest = function(member_friends_aid)
    {
    	$scope.buttonSavingAnimation('zdeleteFromFriendRequestz_'+member_friends_aid,'Deleting..','loader');

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
	        		swal("Error!",
		        		"Deletion Failed!",
		        		"error"
		        	)
	        	}
			});
		},600);
	};

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};


	$scope.selectprofileTab = function (user_auto_id,membership_type,is_admin,parent_id)
	{
		$scope.friendData.user_auto_id=user_auto_id;
		$scope.friendData.membership_type=membership_type;
		$scope.friendData.is_admin=is_admin;
		$scope.friendData.parent_id=parent_id;

		hidden_profile_tab=$('#hidden_profile_tab').val();	
		//alert(hidden_profile_tab)	
		$scope.friendData.clickProfileTab=hidden_profile_tab;

		if(hidden_profile_tab=='friendlistTab' || hidden_profile_tab=='churchlistTab' || hidden_profile_tab=='memberlistTab')
		{
			$scope.getAllFriendList();
		}
		else if(hidden_profile_tab=='friendrequestTab' || hidden_profile_tab=='churchrequestTab' || hidden_profile_tab=='memberrequestTab')
		{
			$scope.getAllFriendRequest();
			$scope.peopleYouMayNowData();
		}
		else if(hidden_profile_tab=='churchmemberTab')
		{
			$scope.getAllChurchMember()
		}
		//alert($scope.friendData.clickProfileTab)
	};

	$scope.getAllFriendList = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
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
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.allFriendListObj=aryreturnData.data.friendListData;
	        		/*console.log('FLIST')
	        		console.log($scope.allFriendListObj)*/
	        	}
	        	else
	        	{
	        		//$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	        		swal("Error!",
		        		"Something went wrong. Please try again later!",
		        		"error"
		        	)
	        	}
			});			
	    }
    };

    $scope.getAllChurchMember = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetAllChurchMember",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.allChurchMemberListObj=aryreturnData.data.churchMemberListData;
	        	}
	        	else
	        	{
	        		//$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	        		swal("Error!",
		        		"Something went wrong. Please try again later!",
		        		"error"
		        	)
	        	}
			});			
	    }
    };

});
