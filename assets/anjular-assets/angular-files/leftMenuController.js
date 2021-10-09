mainApp.controller('leftMenuController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {

	$scope.leftMenuData={};
	$scope.allGroupObj={};

    $scope.init_left_menu = function(user_auto_id,parent_id,membership_type,is_admin)
	{
		$scope.leftMenuData.user_auto_id=user_auto_id;
		$scope.leftMenuData.parent_id=parent_id;
		$scope.leftMenuData.membership_type=membership_type;
		$scope.leftMenuData.is_admin=is_admin;
		$scope.get_all_group();
		$scope.get_set_task_menu();
    };

    $scope.set_task = function(courseId,level)
	{
		window.location.href=varGlobalAdminBaseUrl+"settask/"+courseId+"/"+level;
    };

    /*$scope.get_task = function(level)
	{
		window.location.href=varGlobalAdminBaseUrl+"gettask/"+level;
    };*/

    $scope.get_all_group = function ()
	{
		var formData = new FormData();
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxGetAllGroup",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$scope.allGroupObj=aryreturnData.data.allGroupData;
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

	$scope.get_set_task_menu = function ()
	{
		var formData = new FormData();
		formData.append('leftMenuData',angular.toJson($scope.leftMenuData));
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxGenerateSetTaskMenu",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$scope.allTaskLevelObj=aryreturnData.data.allTaskLevelData;
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
