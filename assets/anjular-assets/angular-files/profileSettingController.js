mainApp.controller('profileSettingController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
   	$scope.memberDataPassNotMtchCheck=false;
   	$scope.memberDataOldNotMtchCheck=false;

	$scope.initProfileSetting = function()
	{
		var profileSettingData=$scope.baseencoded_profileSettingData;
	    var profileSettingDataStr=atob(profileSettingData);
	    var profileSettingDataObj=jQuery.parseJSON(profileSettingDataStr);
		$scope.profileSettingData=profileSettingDataObj;

		$scope.getGlobalCountryData($http);

		if($scope.profileSettingData.memberData.id>0)
		{
    		$scope.getGlobalStateData($http,$scope.profileSettingData.memberData.country);
    		$scope.getGlobalCityData($http,$scope.profileSettingData.memberData.state);
			
	    }
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
	            		swal("Error!",
			        		"Member addition Failed!",
			        		"error"
			        	)
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
