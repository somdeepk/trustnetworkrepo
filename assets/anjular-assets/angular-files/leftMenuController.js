mainApp.controller('leftMenuController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
    $scope.set_task = function(level)
	{
		window.location.href=varGlobalAdminBaseUrl+"settask/"+level;
    };

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
});
