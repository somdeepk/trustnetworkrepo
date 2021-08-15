var mainApp = angular.module('mainApp',['ngDialog']);

mainApp.directive('validNumber', function() {
  	return {
	    require: '?ngModel',
	    link: function(scope, element, attrs, ngModelCtrl) {
			if(!ngModelCtrl) {
				return; 
			}
			ngModelCtrl.$parsers.push(function(val) {
				if (angular.isUndefined(val)) {
					var val = '';
				}
				var clean = val.replace( /[^0-9]+/g, '');
				if (val !== clean) {
					ngModelCtrl.$setViewValue(clean);
					ngModelCtrl.$render();
				}
				return clean;
			});

			element.bind('keypress', function(event) {
				if(event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57))
				{
					event.preventDefault();
				}
			});
	    }
  	};
});

mainApp.directive('validDecimalNumber', function() {
	return {
	    require: '?ngModel',
	    link: function(scope, element, attrs, ngModelCtrl) {
	      if(!ngModelCtrl) {
	        return; 
	      }
	      ngModelCtrl.$parsers.push(function(val) {
	        if (angular.isUndefined(val)) {
	            var val = '';
	        }
	        var clean = val.replace( /[^0-9.]+/g, '');
	        if (val !== clean) {
	          ngModelCtrl.$setViewValue(clean);
	          ngModelCtrl.$render();
	        }
	        return clean;
	      });

	      element.bind('keypress', function(event) {
	        if(event.keyCode === 32) {
	          event.preventDefault();
	        }
	      });
	    }
	};
});

mainApp.controller('overrideController', ['$rootScope', '$timeout', '$interval', '$scope', '$http', '$compile', '$filter', 'ngDialog', function($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, ngDialog) {
	$scope.initOverRideLog = function () {
		angular.element(document).ready(function() {
			$scope.overrideLog();
		});
	};
	
	
	$scope.overrideLog = function() {
		var passarray= [
			{"data": "ROLLID", "name": "ROLLID", "bVisible": true, "bSearchable": true, "bSortable":true},
			{"data": "STYLE", "name": "STYLE", "bVisible": true, "bSearchable": true, "bSortable":true},
			{"data": "CUSTOMER", "name": "CUSTOMER", "bVisible": true, "bSearchable": true, "bSortable":true},
			{"data": "WORKORDER", "name": "WORKORDER", "bVisible": true, "bSearchable": true, "bSortable":true},
			{"data": "TABLE", "name": "TABLE", "bVisible": true, "bSearchable": true, "bSortable":true},
			{"data": "DATE", "name": "DATE", "bVisible": true, "bSearchable": true, "bSortable":true}
		] ;
		$scope.overrideList = $('#overrideList').dataTable({
			"dom": "frtlip",
			"iDisplayLength":10,
			//"scrollY": "250px",
			//"scrollCollapse": true,
			"bProcessing": false,
			"bServerSide": true,
			"sAjaxSource":  "getOverRideData.php",
			"aoColumns": passarray,
			"columnDefs": [
				{"className": "dt-center", "targets": "_all"}
			],
			"order": [[ 5, "desc" ]],
			"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
				aoData.push(
					{"name": "searchRoll","value":$scope.searchRoll}, 
					{"name": "searchStyle","value":$scope.searchStyle}, 
					{"name": "searchCustomer","value":$scope.searchCustomer}, 
					{"name": "searchWorkorder","value":$scope.searchWorkorder}, 
					{"name": "searchTable","value":$scope.searchTable}, 
					{"name": "searchDate","value":$scope.searchDate}
				);
				oSettings.jqXHR = $.ajax( {
					"dataType": 'json',
					"type": "POST",
					"url": sSource,
					"data": aoData,
					"success": function (msg) {
						$scope.$apply();
						fnRowCallback(msg.jsonData);
					},
					"error": function (e) {
						console.log(e.message);
					}
				});
			},
			"oLanguage": {
				"sEmptyTable":     "No Records Found"
			},
			"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				//console.log(aData);
			},
			"fnCreatedRow": function( nRow, aData, iDataIndex ){
				$compile(nRow)($scope);
			},
		});
		var data_table = $('#overrideList').DataTable();
		$('#overrideList .zsearch_inputz').on('keyup',function(event) {
			data_table.draw(); // by this process we can recall the datatable ajax with search value
		});
		$('#overrideList_filter.dataTables_filter').hide();
	};
}]);