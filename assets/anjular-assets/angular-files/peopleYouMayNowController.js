mainApp.controller('peopleYouMayNowController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
	$scope.friendData={};
	$scope.peopleYouMayNowObj={};
	$scope.allFriendRequestObj={};
	$scope.allFriendListObj={};
	$scope.clickProfileTab='timelineTab';

	$scope.peopleYouMayNowData = function(user_auto_id)
	{
		if(user_auto_id>0)
		{
			$scope.friendData.user_auto_id=user_auto_id;

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
						$scope.peopleYouMayNowData($scope.friendData.user_auto_id);

						
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
						$scope.peopleYouMayNowData($scope.friendData.user_auto_id);						
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



	$scope.getAllFriendRequest = function(user_auto_id)
	{
		if(user_auto_id>0)
		{
			$scope.friendData.user_auto_id=user_auto_id;

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
						$scope.getAllFriendRequest($scope.friendData.user_auto_id);						
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
	        		$scope.getAllFriendRequest($scope.friendData.user_auto_id);	
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


	$scope.selectprofileTab = function (user_auto_id)
	{
		$scope.friendData.user_auto_id=user_auto_id;
		hidden_profile_tab=$('#hidden_profile_tab').val();
		$scope.clickProfileTab=hidden_profile_tab;
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

});
