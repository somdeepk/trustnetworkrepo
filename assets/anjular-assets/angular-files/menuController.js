mainApp.controller('menuController', function($rootScope, $scope, $http, $compile, ngDialog, $timeout) {

	$rootScope.flagBlurMenu=0;

	$rootScope.initiateMenuPointer = function(user_auto_id)
	{
		$rootScope.checkProfileSettingToBlur(user_auto_id);
	};

	$rootScope.menuPointer = function(typ)
	{
		//$rootScope.profileSetting();
	};

	$rootScope.profileSetting = function()
	{
		//alert("dsd")
		$('.loaderOverlay').fadeIn(200);
		var response = $http({
		    method: 'POST',
		    url: varGlobalAdminBaseUrl+"profilesetting",
		    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
		    async:true,
		});
		response.success(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
			var element = angular.element('#angularMainContent').html(data);
			$compile(element.contents())($scope);

		});
		response.error(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
		});
	};

	$rootScope.checkProfileSettingToBlur = function (user_auto_id)
	{
		$scope.profileSettingData={};
	    $scope.profileSettingData.user_auto_id=user_auto_id;

	    var formData = new FormData();
		formData.append('profileSettingData',angular.toJson($scope.profileSettingData));
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"checkProfileSettingToBlur",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$rootScope.flagBlurMenu=aryreturnData.data.flagBlurMenu;
        	}
        	else
        	{
        		$rootScope.flagBlurMenu=1;
        	}
		});
	};

	$rootScope.ucwords=function(str)
	{
		return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1)
		{
			return $1.toUpperCase();
		});
	}

	$scope.isNullOrEmptyOrUndefined = function(value) {
		return !value
	};
});