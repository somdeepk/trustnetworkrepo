mainApp.controller('signupController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.notComplexPassword=false;
	$scope.complexPasswordMsg='';
	$scope.signupData={};
	$scope.signupDataCheck=false;
	$scope.InvalidEmailCheck=false;
	$scope.signupDataEmailDupCheck=false;
   
   	$scope.obj_membership_type = {
        '': 'Select Membership Type',
        'RM': 'Regular Membership',
        'PM': 'Premium Membership'
    }	

    $scope.obj_membership_option = {
         '': 'Select Membership'
    }

    $scope.getMembershipOption = function(val)
	{

		if($scope.signupData.membership_type=='RM')
		{
			$scope.obj_membership_option = {
		        '': 'Select Membership',
		        'regular_members': 'Regular Members',
		        // 'athletes': 'Athletes',
		        // 'armed_force': 'Armed Force',
		        // 'family_profile': 'Family Profile',
		        // 'politician': 'Politician',
		        // 'public_safety': 'Public Safety',
		        // 'public_official': 'Public Official'
		    }
		}
		else if($scope.signupData.membership_type=='PM')
		{

			$scope.obj_membership_option = {
		        '': 'Select Membership',
		        'church_ministries': 'Church/Ministries',
		        // 'ministers_and_speaker': 'Ministers and Speakers',
		        // 'pastor': 'Pastor',
		        // 'clergy': 'Clergy',
		        // 'christian_business': 'Christian Business',
		        // 'music_artist_and_musicians': 'Music Artist and Musicians',
		    }			
		}
		else
		{
			$scope.obj_membership_option = {
		         '': 'Select Membership'
		    }
		}
		$scope.signupData.membership_option='';
	};	

	$scope.submitSignup = function() {
		$scope.signupDataCheck=true ;
		$timeout(function()
		{
			$scope.signupDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.signupData.membership_type)==true) || ($scope.signupData.membership_type=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.signupData.membership_option)==true) || ($scope.signupData.membership_option=='¿'))
		{
			validator++ ;
		}

		if ($scope.signupData.membership_type=='PM' && (($scope.isNullOrEmptyOrUndefined($scope.signupData.church_type)==true) || ($scope.signupData.church_type=='¿')))
		{
			validator++ ;
		}


		if ($scope.signupData.membership_type=='PM' && (($scope.isNullOrEmptyOrUndefined($scope.signupData.church_name)==true) || ($scope.signupData.church_name=='¿')))
		{
			validator++ ;
		}

		if ($scope.signupData.membership_type=='RM' && (($scope.isNullOrEmptyOrUndefined($scope.signupData.first_name)==true) || ($scope.signupData.first_name=='¿')))
		{
			validator++ ;
		}

		if ($scope.signupData.membership_type=='RM' && (($scope.isNullOrEmptyOrUndefined($scope.signupData.last_name)==true) || ($scope.signupData.last_name=='¿')))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.signupData.mobile)==true) || ($scope.signupData.mobile=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.signupData.dob)==true) || ($scope.signupData.dob=='¿'))
		{
			validator++ ;
		}

		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (($scope.isNullOrEmptyOrUndefined($scope.signupData.user_email)==true) || ($scope.signupData.user_email=='¿'))
		{
			validator++ ;
		}else if (!regex.test($scope.signupData.user_email))
        {
        	$scope.InvalidEmailCheck=true ;
			$timeout(function()
			{
				$scope.InvalidEmailCheck=false ;
			},2000);
            validator++ ;
        }

		if (($scope.isNullOrEmptyOrUndefined($scope.signupData.password)==true) || ($scope.signupData.password=='¿'))
		{
			validator++ ;
		}

		$scope.complexPasswordMsg = $scope.isComplexPassword($scope.signupData.user_email, $scope.signupData.password);
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
			formData.append('signupData',angular.toJson($scope.signupData));
			angular.forEach($scope.files,function(file){           
				formData.append('file[]',file);
			}); 

			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxsubmitsignup",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				$scope.memberDataCheck=false ;
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status==2)
            	{
            		$scope.signupDataEmailDupCheck=true ;
					$timeout(function()
					{
						$scope.signupDataEmailDupCheck=false ;
					},2000);
            	}
            	else if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            	{
            		window.location.href=varGlobalAdminBaseUrl+"index";
            	}
            	else
            	{
            		console.log("Registration Failed!")
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

});