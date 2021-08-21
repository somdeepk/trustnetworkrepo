mainApp.controller('loginController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.loginData={};
	$scope.loginDataCheck=false;
	$scope.loginDataInvalidCheck=false;
   
	$scope.submitLogin = function(){
		$scope.loginDataCheck=true ;
		$timeout(function()
		{
			$scope.loginDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.loginData.email)==true) || ($scope.loginData.email=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.loginData.password)==true) || ($scope.loginData.password=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{		
			var formData = new FormData();
			formData.append('loginData',angular.toJson($scope.loginData));

			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxcheckuserlogin",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				$scope.memberDataCheck=false ;
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            	{
            		if(aryreturnData.data.userLoginData.is_approved=='Y')
            		{
            			window.location.href=varGlobalAdminBaseUrl+"index";
            		}
            		else
            		{
            			window.location.href=varGlobalAdminBaseUrl+"profileedit";
            		}
              	}
            	else
            	{
            		$scope.invalidLoginMsg=aryreturnData.msg ;
            		$scope.loginDataInvalidCheck=true ;
            		$timeout(function()
					{
						$scope.loginDataInvalidCheck=false ;
					},2000);
            	}
			});
		}
	};
	
	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};		 

});
