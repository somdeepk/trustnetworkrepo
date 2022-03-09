mainApp.controller('loginController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.loginData={};
	$scope.loginDataCheck=false;
	$scope.loginDataInvalidCheck=false;
    $scope.loginOTPPage=false;
   
   	$scope.getLoginData = function()
	{
		jsonRememberMe=$('.zjsonCookieRememberMez').html();			
		if(!$scope.isNullOrEmptyOrUndefined(jsonRememberMe))
		{
			$rememberMeData=angular.fromJson(jsonRememberMe);
			if(!$scope.isNullOrEmptyOrUndefined($rememberMeData.christtube_remember_me))
			{
				$scope.loginData.email=$rememberMeData.christtube_remember_me;
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
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            	{                    
                    $scope.loginOTPPage=true;
                    $scope.setAuthenticator();
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
	 

    $scope.invalidLoginMsg='' ;
    $scope.successResetMsg='';
	$scope.setAuthenticator = function(){
        $scope.successResetMsg='';
        $scope.invalidLoginMsg='' ;
		var formData = new FormData();
        formData.append('loginData',angular.toJson($scope.loginData));

        $http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxsetauthenticator",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
            $scope.loginDataInvalidCheck=true ;
            aryreturnData=angular.fromJson(returnData);
            if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            {
                //console.log(aryreturnData)
                $scope.successResetMsg=aryreturnData.msgUser; 
                $timeout(function()
                {
                    $scope.loginDataInvalidCheck=false ;
                },6000);  
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

	};


	$scope.submitOtp = function()
    {
        $scope.invalidLoginMsg='' ;
        $scope.successResetMsg='';

		$scope.loginOTPDataCheck=true ;
        $timeout(function()
        {
            $scope.loginOTPDataCheck=false ;
        },2000);

        var validator=0;
        if (($scope.isNullOrEmptyOrUndefined($scope.loginData.otp)==true) || ($scope.loginData.otp=='¿'))
        {
            validator++ ;
        }

		if (Number(validator)==0)
        {       
            var formData = new FormData();
            formData.append('loginData',angular.toJson($scope.loginData));
            $http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxsubmitotp",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
                aryreturnData=angular.fromJson(returnData);
                if(aryreturnData.status=='1' && aryreturnData.msg=='success')
                {
                    window.location.href=varGlobalAdminBaseUrl+"index";
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
