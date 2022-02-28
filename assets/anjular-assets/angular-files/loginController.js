mainApp.controller('loginController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.loginData={};
	$scope.loginDataCheck=false;
	$scope.loginDataInvalidCheck=false;
   
   	$scope.getLoginData = function()
	{
		jsonRememberMe=$('.zjsonCookieRememberMez').html();			
		if(!$scope.isNullOrEmptyOrUndefined(jsonRememberMe))
		{
			$rememberMeData=angular.fromJson(jsonRememberMe);
			if(!$scope.isNullOrEmptyOrUndefined($rememberMeData.trust_member_remember_me))
			{
				$scope.loginData.email=$rememberMeData.trust_member_remember_me;
				$scope.loginData.password='';
				$scope.loginData.remember_me=true;
			}
		}
    };

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
						$scope.invalidLoginMsg='' ;
					},2000);
            	}
			});
		}
	};
	
	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};		

	$scope.invalidLoginMsg='';
	$scope.successResetMsg='';

	$scope.resetPassword = function(){

		$scope.invalidLoginMsg='' ;
		$scope.successResetMsg='';

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
		if (Number(validator)==0)
		{		
			var formData = new FormData();
			formData.append('loginData',angular.toJson($scope.loginData));

			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxresetpassword",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {

				$scope.loginDataInvalidCheck=true ;
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            	{
            		$scope.successResetMsg=aryreturnData.msgUser;
              	}
            	else
            	{
            		$scope.invalidLoginMsg=aryreturnData.msg ;            		
            	}

        		$timeout(function()
				{
					$scope.loginDataInvalidCheck=false ;
				},2000);
			});
		}
	};


	$scope.setNewPassword = function(){

		$scope.loginDataCheck=true ;
		$timeout(function()
		{
			$scope.loginDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.loginData.new_password)==true) || ($scope.loginData.new_password=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.loginData.confirm_new_password)==true) || ($scope.loginData.confirm_new_password=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.loginData.new_password)!=true) && ($scope.isNullOrEmptyOrUndefined($scope.loginData.confirm_new_password)!=true) && $scope.loginData.new_password != $scope.loginData.confirm_new_password)
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.loginData.new_password)!=true) && ($scope.isNullOrEmptyOrUndefined($scope.loginData.confirm_new_password)!=true) && $scope.loginData.confirm_new_password.length<6)
		{
			validator++ ;
		}

		// alert('xxxxxx');
		// return false;

		if (Number(validator)==0)
		{		
			var formData = new FormData();

			var email  = $("#email").val();
			$scope.loginData.email = email;
			formData.append('loginData',angular.toJson($scope.loginData));

			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxsetnewpassword",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				$scope.memberDataCheck=false ;
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            	{            
            		swal(aryreturnData.msgUser)
					.then((value) => {
					  window.location.href = varGlobalAdminBaseUrl;
					});
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

});
