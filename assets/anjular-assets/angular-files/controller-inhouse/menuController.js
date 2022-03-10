mainApp.controller('menuController', function($rootScope, $scope, $http, $compile, ngDialog, $timeout) {

	$scope.flagBlurMenu=0;
	$rootScope.loggedUserDataObj={};
	$rootScope.allChurchMemberObj={};
	$rootScope.sgtnType='';

	$scope.initiateMenuPointer = function(loggedUserId)
	{
		$rootScope.loggedUserId=loggedUserId;
		$rootScope.getLoggedUserData(loggedUserId);

		$scope.viewPostPages();
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
				$rootScope.allChurchMemberObj=$rootScope.loggedUserDataObj.ChurchData;
				
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
			$rootScope.viewFriendsList();

		});
		response.error(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
		});
	};

	$scope.viewPostPages = function()
	{
		if($('#create-post-modal').length>0)
		{
			$('#create-post-modal').remove();
		}

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

		});
		response.error(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
		});
	};

	$scope.viewEvents = function(filetype)
	{
		$('.loaderOverlay').fadeIn(200);
		var response = $http({
		    method: 'POST',
		    url: varGlobalAdminBaseUrl+"viewEvents",
		    headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
		    async:true,
		});
		response.success(function(data, status, headers, config) {
			$('.loaderOverlay').fadeOut(200);
			var element = angular.element('#angularMainContent').html(data);
			$compile(element.contents())($scope);
			
			$rootScope.loadEventCalender();
			$rootScope.loadDateRangeSchedule();
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

	$rootScope.CheckImageOrVideo = function(filetype)
	{
		if(filetype=='video/mp4' || filetype=='video/wmv' || filetype=='video/avi' || filetype=='video/3gp' || filetype=='video/mov' || filetype=='video/mpeg')
		{
			return "video";
		}
		else
		{
			//alert(filetype)
			return "image";
		}
	};


	$rootScope.isComplexPassword = function(user_email = '', password = '')
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