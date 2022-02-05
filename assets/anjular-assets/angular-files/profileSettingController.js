mainApp.controller('profileSettingController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
   	$scope.memberDataPassNotMtchCheck=false;
   	$scope.memberDataOldNotMtchCheck=false;

	$scope.initProfileSetting = function()
	{
		var profileSettingData=$scope.baseencoded_profileSettingData;
	    var profileSettingDataStr=atob(profileSettingData);
	    var profileSettingDataObj=jQuery.parseJSON(profileSettingDataStr);
		$scope.profileSettingData=profileSettingDataObj;
		$scope.generalData=profileSettingDataObj.memberData;
		$scope.questionData=jQuery.parseJSON(profileSettingDataObj.memberData.profile_question);

		// console.log('sddsd');
		// console.log($scope.generalData);
		
		// $scope.getGlobalCountryData($http);
		// if($scope.profileSettingData.memberData.id>0)
		// {
		// 	$scope.getGlobalStateData($http,$scope.profileSettingData.memberData.country);
		// 	$scope.getGlobalCityData($http,$scope.profileSettingData.memberData.state);
		// }
    };

    $scope.submitProfileGeneralData = function()
    {
		$scope.generalDataCheck=true ;
		$timeout(function()
		{
			$scope.generalDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.generalData.first_name)==true) || ($scope.generalData.first_name=='¿'))
		{
			validator++ ;
		}

		if (($scope.generalData.membership_type=='RM') && (($scope.isNullOrEmptyOrUndefined($scope.generalData.last_name)==true) || ($scope.generalData.last_name=='¿')))
		{
			validator++ ;
		}

		if (($scope.generalData.membership_type=='RM') && (($scope.isNullOrEmptyOrUndefined($scope.generalData.last_name)==true) || ($scope.generalData.last_name=='¿')))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zsubmitGeneralDataz','Saving..','loader');
		
			$timeout(function()
			{	
				var formData = new FormData();
				formData.append('generalData',angular.toJson($scope.generalData));

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditgeneraldata",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.generalDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zsubmitGeneralDataz','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($scope.profileSettingData.memberData.id);
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zsubmitGeneralDataz','Save','onlytext');
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zsubmitGeneralDataz','Save','onlytext');
	            		console.log("Member addition Failed!")
	            	}
				});
			},1200);
		}
	};

    $scope.submitQuestionData = function()
    {
		$scope.questionDataCheck=true ;
		$timeout(function()
		{
			$scope.questionDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q1)==true) || ($scope.questionData.q1=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q2)==true) || ($scope.questionData.q2=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q3)==true) || ($scope.questionData.q3=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q4)==true) || ($scope.questionData.q4=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q5)==true) || ($scope.questionData.q5=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q6)==true) || ($scope.questionData.q6=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q7)==true) || ($scope.questionData.q7=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zsubmitQuestionDataz','Saving..','loader');
		
			$timeout(function()
			{	

				$scope.questionData.id=$scope.profileSettingData.memberData.id

				var formData = new FormData();
				formData.append('questionData',angular.toJson($scope.questionData));

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditquestiondata",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.questionDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zsubmitQuestionDataz','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($scope.profileSettingData.memberData.id);
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zsubmitQuestionDataz','Save','onlytext');
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zsubmitQuestionDataz','Save','onlytext');
	            		console.log("Question Answer addition Failed!")
	            	}
				});
			},1200);
		}
	};


	$scope.submitChangePasswordInfo = function()
    {
		$scope.memberDataCheck=true ;
		$timeout(function()
		{
			$scope.memberDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.current_password)==true) || ($scope.memberData.current_password=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.new_password)==true) || ($scope.memberData.new_password=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.verify_password)==true) || ($scope.memberData.verify_password=='¿'))
		{
			validator++ ;
		}

		if ( (($scope.isNullOrEmptyOrUndefined($scope.memberData.new_password)==false) && ($scope.memberData.new_password!='¿')) && (($scope.isNullOrEmptyOrUndefined($scope.memberData.verify_password)==false) && ($scope.memberData.verify_password!='¿')) && ($scope.memberData.new_password!=$scope.memberData.verify_password) )
		{
			$scope.memberDataPassNotMtchCheck=true ;
			$timeout(function()
			{
				$scope.memberDataPassNotMtchCheck=false ;
			},2000);				
			validator++;
		}


		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zsubmitMemberz','Saving..','loader');
		
			$timeout(function()
			{	
				$scope.memberData.id=$scope.profileSettingData.memberData.id;
				var formData = new FormData();
				formData.append('memberData',angular.toJson($scope.memberData));
				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdatechangepassword",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.memberDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status==2)
	            	{
	            		$scope.memberDataOldNotMtchCheck=true ;
						$timeout(function()
						{
							$scope.memberDataOldNotMtchCheck=false ;
						},2000);

						$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');	            		
	            	}
	            	else if(aryreturnData.status=='1' && aryreturnData.msg=='success')
	            	{
	            		$scope.buttonSavingAnimation('zsubmitMemberz','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($scope.profileSettingData.memberData.id);
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	            		swal("Error!",
			        		"Password Changed Failed!",
			        		"error"
			        	)
	            	}
				});
			},1200);
		}
	};

	$scope.resetChangePasswordForm = function()
	{
		$scope.memberData.current_password='';
		$scope.memberData.new_password='';
		$scope.memberData.verify_password='';
	};

	$scope.getStateData = function(countryId)
	{
		$scope.getGlobalStateData($http,countryId);
    };

    $scope.getCityData = function(stateId)
	{
		$scope.getGlobalCityData($http,stateId);
    };

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
});
