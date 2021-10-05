mainApp.controller('signupController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.signupData={};
	$scope.signupDataCheck=false;
	$scope.InvalidEmailCheck=false;
	$scope.signupDataEmailDupCheck=false;
   
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

		if (($scope.signupData.membership_type=='RM') && (($scope.isNullOrEmptyOrUndefined($scope.signupData.church_id)==true) || ($scope.signupData.church_id=='¿')))
		{
			validator++ ;
		}

		if (($scope.signupData.membership_type=='RM' || $scope.signupData.membership_type=='CC') && (($scope.isNullOrEmptyOrUndefined($scope.signupData.first_name)==true) || ($scope.signupData.first_name=='¿')))
		{
			validator++ ;
		}

		if (($scope.signupData.membership_type=='RM' || $scope.signupData.membership_type=='CC') && (($scope.isNullOrEmptyOrUndefined($scope.signupData.last_name)==true) || ($scope.signupData.last_name=='¿')))
		{
			validator++ ;
		}

		if (($scope.signupData.membership_type=='CM') && (($scope.isNullOrEmptyOrUndefined($scope.signupData.church_name)==true) || ($scope.signupData.church_name=='¿')))
		{
			validator++ ;
		}

		if (($scope.signupData.membership_type=='RM' || $scope.signupData.membership_type=='CC') && (($scope.isNullOrEmptyOrUndefined($scope.signupData.gender)==true) || ($scope.signupData.gender=='¿')))
		{
			validator++ ;
		}

		if (($scope.signupData.membership_type=='RM' || $scope.signupData.membership_type=='CC') && (($scope.isNullOrEmptyOrUndefined($scope.signupData.dob)==true) || ($scope.signupData.dob=='¿')))
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

		if (($scope.isNullOrEmptyOrUndefined($scope.signupData.toc)==true) || ($scope.signupData.toc=='¿'))
		{
			validator++ ;
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
            		window.location.href=varGlobalAdminBaseUrl+"profileedit";
            	}
            	else
            	{
            		swal("Error!",
		        		"Registration Failed!",
		        		"error"
		        	)
            	}
			});
		}
	};

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
});
