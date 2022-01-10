mainApp.controller('menuController', function($rootScope, $scope, $http, $compile, ngDialog, $timeout) {

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