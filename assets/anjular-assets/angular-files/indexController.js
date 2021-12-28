mainApp.controller('indexController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.singlePostData={};
	$scope.memberData={};
	$scope.friendData={};
	$scope.tagPostData={};

	$scope.initiateData = function (user_auto_id,membership_type,is_admin,parent_id)
	{
		$scope.memberData.user_auto_id=user_auto_id;
		$scope.memberData.membership_type=membership_type;
		$scope.memberData.is_admin=is_admin;
		$scope.memberData.parent_id=parent_id;
	};
   
   	$scope.submitPost = function(){
		$scope.singlePostDataCheck=true ;
		$timeout(function()
		{
			$scope.singlePostDataCheck=false ;
		},2000);
		
		
		$scope.singlePostData.member_id=$scope.memberData.user_auto_id;

		var formData = new FormData();
		formData.append('singlePostData',angular.toJson($scope.singlePostData));
		formData.append('aryPostTagFriend',angular.toJson($scope.aryPostTagFriend));

		$scope.buttonSavingAnimation('zbtnSinglePostz','Posting..','loader');

		$http({
            method  : 'POST',
            url     : varBaseUrl+"post/ajaxsubmitsinglepost",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			$scope.memberDataCheck=false ;
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
        	{
        		$scope.buttonSavingAnimation('zbtnSinglePostz','Posted','onlytext');
        		$timeout(function()
				{
					$scope.buttonSavingAnimation('zbtnSinglePostz','Post','onlytext');
					$('#postModal').modal('hide');
					$scope.singlePostData={};
					$scope.tagPostData={};
					$scope.aryPostTagFriend = [];
				},1200);
          	}
        	else
        	{
        		$scope.buttonSavingAnimation('zbtnSinglePostz','Post','onlytext');
        		swal("Error!",
	        		"Something went wrong. Please try again later!",
	        		"error"
	        	)      		
        	}
		});
	};

	$scope.tagPostToFriend = function ()
	{
		if($scope.memberData.user_auto_id>0)
		{
			$scope.friendData.user_auto_id=$scope.memberData.user_auto_id;
			$scope.friendData.searchFriend=$scope.tagPostData.searchFriend;

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
	        	$scope.allFriendListObj=aryreturnData.data.friendListData;

	        	console.log($scope.allFriendListObj)
	        	$('#tagPostToFriendModal').modal('show');
				$('#postModal').modal('hide');
			});			
	    }		
	};	

	$scope.aryPostTagFriend = [];
	$scope.setTagFriendToPost = function(memberId)
	{
		if($scope.aryPostTagFriend.length>0)
		{
		  if($.inArray(memberId, $scope.aryPostTagFriend) != -1){
		    $scope.aryPostTagFriend.splice( $.inArray(memberId, $scope.aryPostTagFriend), 1 );
		  }else{
		    $scope.aryPostTagFriend.push(memberId);
		  }
		}else{
		  $scope.aryPostTagFriend.push(memberId);
		}

		console.log($scope.aryPostTagFriend);
	};


	$scope.closeTagPostModal = function ()
	{
		$('#postModal').modal('show');
		$('#tagPostToFriendModal').modal('hide');
	};

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};		 

});
