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
			if(!$scope.isNullOrEmptyOrUndefined($rememberMeData.christtube_remember_me))
			{
				$scope.loginData.email=$rememberMeData.christtube_remember_me;
				$scope.loginData.password='';
				$scope.loginData.remember_me=true;
			}
		}
    };

	$scope.submitLogin = function(){

		// alert('zzzz');

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
            		
            		// window.location.href=varGlobalAdminBaseUrl+"index";

            		$("#loginDiv").hide();
					$("#otpDiv").show();

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


	$scope.setAuthenticator = function(){

		var formData = new FormData();
        formData.append('loginData',angular.toJson($scope.loginData));

        $http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxsetauthenticator",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {

            $scope.memberDataCheck=false ;
            aryreturnData=angular.fromJson(returnData);
            if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            {
                console.log(aryreturnData);  

                swal(aryreturnData.msgUser)
				.then((value) => {
				  // window.location.href = varGlobalAdminBaseUrl;
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

	};


	$scope.submitOtp = function(){

		// alert('submitted'); return false;

		$scope.loginDataCheck=true ;
        $timeout(function()
        {
            $scope.loginDataCheck=false ;
        },2000);

        var validator=0;
        if (($scope.isNullOrEmptyOrUndefined($scope.loginData.otp)==true) || ($scope.loginData.otp=='¿'))
        {
            validator++ ;
        }

		// alert('submitted'); return false;


		if (Number(validator)==0)
        {       

        	// alert('submitted'); return false;

            var formData = new FormData();
            formData.append('loginData',angular.toJson($scope.loginData));

            // console.log($scope.loginData); return false;

            $http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxsubmitotp",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
                $scope.memberDataCheck=false ;
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



});
