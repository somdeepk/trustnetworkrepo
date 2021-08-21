var alterApp = angular.module('alterApp',['ngSanitize', 'ngMessages']);
alterApp.run(run);

run.$inject = ['$rootScope'];
function run ($rootScope) {
	$rootScope.spinner = {
		active: false,
		on: function () {
		  this.active = true;
		},
		off: function () {
		  this.active = false;
		}
	};	
};
