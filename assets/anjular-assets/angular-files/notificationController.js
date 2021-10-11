mainApp.controller('notificationController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.notificationData={};
	$scope.allNotificationObj={};
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
        		swal("Error!",
	        		"Something went wrong. Please try again later!",
	        		"error"
	        	)
        	}
		});	
	};

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
});
