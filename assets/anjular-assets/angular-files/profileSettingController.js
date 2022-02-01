mainApp.controller('profileSettingController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
   	$scope.memberDataPassNotMtchCheck=false;
   	$scope.memberDataOldNotMtchCheck=false;

	$scope.initProfileSetting = function()
	{
		var profileSettingData=$scope.baseencoded_profileSettingData;
	    var profileSettingDataStr=atob(profileSettingData);
	    var profileSettingDataObj=jQuery.parseJSON(profileSettingDataStr);
		$scope.profileSettingData=profileSettingDataObj;
		$scope.questionData=jQuery.parseJSON(profileSettingDataObj.memberData.profile_question);

		console.log('sddsd')
		console.log($scope.questionData)

		// $scope.getGlobalCountryData($http);
		// if($scope.profileSettingData.memberData.id>0)
		// {
		// 	$scope.getGlobalStateData($http,$scope.profileSettingData.memberData.country);
		// 	$scope.getGlobalCityData($http,$scope.profileSettingData.memberData.state);
		// }
    };

    $scope.submitProfileGeneralData = function()
    {
		$scope.memberDataCheck=true ;
		$timeout(function()
		{
			$scope.memberDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.profileSettingData.memberData.first_name)==true) || ($scope.profileSettingData.memberData.first_name=='¿'))
		{
			validator++ ;
		}

		if (($scope.profileSettingData.memberData.membership_type=='RM') && (($scope.isNullOrEmptyOrUndefined($scope.profileSettingData.memberData.last_name)==true) || ($scope.profileSettingData.memberData.last_name=='¿')))
		{
			validator++ ;
		}

		if (($scope.profileSettingData.memberData.membership_type=='RM') && (($scope.isNullOrEmptyOrUndefined($scope.profileSettingData.memberData.last_name)==true) || ($scope.profileSettingData.memberData.last_name=='¿')))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zsubmitGeneralDataz','Saving..','loader');
		
			$timeout(function()
			{	
				var formData = new FormData();
				formData.append('profileGeneralData',angular.toJson($scope.profileSettingData));

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditgeneraldata",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.memberDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zsubmitGeneralDataz','Saved!','onlytext');
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
		$scope.memberDataCheck=true ;
		$timeout(function()
		{
			$scope.memberDataCheck=false ;
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
					$scope.memberDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zsubmitQuestionDataz','Saved!','onlytext');
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
