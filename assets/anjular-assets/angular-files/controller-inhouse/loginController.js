mainApp.controller('loginController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
	
    $scope.notComplexPassword=false;
    $scope.complexPasswordMsg='';
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

                // console.log(returnData); return false;

				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            	{                    
                    // google authenticator
                    if(aryreturnData.two_factor == '1' && aryreturnData.two_factor_val == 'google')
                    {
                        // do something for google authenticator
                        $scope.loginOTPPage=true;
                    }

                    // sms authenticator
                    else if(aryreturnData.two_factor == '1' && aryreturnData.two_factor_val == 'sms')
                    {
                        // do something for sms authenticator
                    }

                    // email authenticator
                    else if(aryreturnData.two_factor == '1' && aryreturnData.two_factor_val == 'email')
                    {
                        // do something for email authenticator
                    }

                    // open dashboard if two factor authentication is off
                    else
                    {
                        window.location.href=varGlobalAdminBaseUrl+"index";
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

    $scope.isComplexPassword = function(user_email = '', password = '')
    {
        if (password.length < 6 || !password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/) || !password.match(/([0-9])/) || !password.match(/([!,%,&,@,#,$,^,*,?,_,~])/) ) 
        {
            return "Minimum 6 characters including alphabet(uppercase and lowercaase), number and special character!";
        }

        if (password.indexOf(user_email) >= 0)
        {
            return "Password should not contain username/email!";
        }

        return 1;
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

            // console.log($scope.loginData); return false;

            var formData = new FormData();
            formData.append('loginData',angular.toJson($scope.loginData));

            $http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxresetpassword",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {

                // console.log(returnData); return false;
                
                $scope.loginDataInvalidCheck=true ;
                aryreturnData=angular.fromJson(returnData);
                if(aryreturnData.status=='1' && aryreturnData.msg=='success')
                {
                    $scope.successResetMsg=aryreturnData.msgUser;
                    $timeout(function()
                    {
                        $scope.loginDataInvalidCheck=false ;
                    },25000);
                }
                else
                {
                    $scope.invalidLoginMsg=aryreturnData.msg ;
                    $timeout(function()
                    {
                        $scope.loginDataInvalidCheck=false ;
                    },2000);
                }
            });
        }
    };


    $scope.setNewPassword = function(){

        // alert('zzz');

        // console.log($scope.loginData); return false;

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

        var email  = $("#email").val();
        $scope.loginData.email = email;            
        $scope.complexPasswordMsg = $scope.isComplexPassword($scope.loginData.email, $scope.loginData.new_password);
        if ($scope.complexPasswordMsg != 1 && validator == 0)
        {
            $scope.notComplexPassword=true ;
            $timeout(function()
            {
                $scope.notComplexPassword=false ;
            },2000);                
            validator++;
        }

        if (Number(validator)==0)
        {       
            var formData = new FormData();
            formData.append('loginData',angular.toJson($scope.loginData));

            // console.log($scope.loginData); return false;
            
            $http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxsetnewpassword",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {

                // console.log(returnData); return false;

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
