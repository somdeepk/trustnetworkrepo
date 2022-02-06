mainApp.controller('menuController', function($rootScope, $scope, $http, $compile, ngDialog, $timeout) {

	$scope.flagBlurMenu=0;
	$rootScope.loggedUserDataObj={};
	$rootScope.sgtnType='';

	$scope.initiateMenuPointer = function(loggedUserId)
	{
		$rootScope.loggedUserId=loggedUserId;
		$rootScope.getLoggedUserData(loggedUserId);
	};

	$rootScope.getLoggedUserData = function (loggedUserId)
	{
		$scope.profileSettingData={};
	    $scope.profileSettingData.loggedUserId=loggedUserId;

	    var formData = new FormData();
		formData.append('profileSettingData',angular.toJson($scope.profileSettingData));
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"getLoggedUserData",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData)
        {
			aryreturnData=angular.fromJson(returnData);
			if(aryreturnData.status=='1')
        	{
				var loggedUserData=aryreturnData.data.memberData;	    
			    var loggedUserDataStr=atob(loggedUserData);
			    var loggedUserDataObj=jQuery.parseJSON(loggedUserDataStr);
				$rootScope.loggedUserDataObj=loggedUserDataObj;

				console.log('Gloab Member Data')
				console.log($rootScope.loggedUserDataObj)

	       		$scope.flagBlurMenu=aryreturnData.data.flagBlurMenu;
        	}
        	else
        	{
        		$scope.flagBlurMenu=1;
        		swal("Error!",
	        		"Logged Member Data Not Found! Please logged out and try after some time..",
	        		"error"
	        	);
        	}
		});
	};

	$rootScope.viewProfileSetting = function(TabName='')
	{
		$('.loaderOverlay').fadeIn(200);
		var response = $http({
		    method: 'POST',
		    url: varGlobalAdminBaseUrl+"viewProfileSetting",
		    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
		    async:true,
		});
		response.success(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
			var element = angular.element('#angularMainContent').html(data);
			$compile(element.contents())($scope);
			if($scope.isNullOrEmptyOrUndefined(TabName)==false)
			{
				$timeout(function()
				{
					$('.'+TabName).click();
				},75);
			}

		});
		response.error(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
		});
	};

	$scope.viewConnection = function(sgtnType)
	{
		$rootScope.sgtnType=sgtnType;

		$('.loaderOverlay').fadeIn(200);
		var response = $http({
		    method: 'POST',
		    url: varGlobalAdminBaseUrl+"viewConnection",
		    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
		    async:true,
		});
		response.success(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
			var element = angular.element('#angularMainContent').html(data);
			$compile(element.contents())($scope);

			$rootScope.peopleYouMayNowDataAllFriendRequest();

		});
		response.error(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
		});
	};

	$scope.viewFriends = function(sgtnType)
	{
		$rootScope.sgtnType=sgtnType;

		$('.loaderOverlay').fadeIn(200);
		var response = $http({
		    method: 'POST',
		    url: varGlobalAdminBaseUrl+"viewFriends",
		    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
		    async:true,
		});
		response.success(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
			var element = angular.element('#angularMainContent').html(data);
			$compile(element.contents())($scope);
			$rootScope.viewFriends();

		});
		response.error(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
		});
	};

	$scope.viewPostPages = function()
	{
		$('.loaderOverlay').fadeIn(200);
		var response = $http({
		    method: 'POST',
		    url: varGlobalAdminBaseUrl+"viewPostPages",
		    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
		    async:true,
		});
		response.success(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
			var element = angular.element('#angularMainContent').html(data);
			$compile(element.contents())($scope);
			$rootScope.viewFriends();

		});
		response.error(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
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