(function(){
	var mainApp = angular.module('mainApp',['treasure-overlay-spinner','angularSpinners','ngMessages','ngDialog']);
	mainApp.controller('workOrderPalletController',['$rootScope', '$timeout', '$interval', '$scope', '$http', '$compile', '$filter', 'spinnerService','ngDialog',
	function($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog) {
		const $table = $('#palletTable');
		//const $remove = $('#remove');
		let selections = [];
		$scope.palletRequestType='L' ;
		$scope.initTable = function() {
			$table.bootstrapTable({
				height: $scope.getHeight(),
				columns:[
					[
						{
							field: 'id',
							title: 'ID',
							align: 'center',
							valign: 'middle',
							sortable: true,
							searchable: true
						},
						{
							field: 'priority',
							title: 'Priority',
							align: 'center',
							valign: 'middle',
							sortable: true,
							searchable: true
						},
						{
							field: 'pallet',
							title: 'Pallet',
							align: 'center',
							valign: 'middle',
							sortable: true,
							searchable: true
						},
						{
							field: 'order',
							title: 'Order',
							align: 'center',
							valign: 'middle',
							sortable: true,
							searchable: true
						},
						{
							field: 'customer',
							title: 'Customer',
							align: 'center',
							valign: 'middle',
							sortable: true,
							searchable: true
						},
						{
							field: 'style',
							title: 'Style',
							align: 'center',
							valign: 'middle',
							sortable: true,
							searchable: true
						},
						{
							field: 'ydsOrdered',
							title: 'Yds Ordered',
							align: 'center',
							valign: 'middle',
							sortable: true
						},
						{
							field: 'ydsDone',
							title: 'Yds Done',
							align: 'center',
							valign: 'middle',
							sortable: true
						},
						{
							field: 'ydsLeft',
							title: 'Yds Left',
							align: 'center',
							valign: 'middle',
							sortable: true
						},
					]
				],
				queryParamsType : 'limit',
				queryParams: function(p) {
					var returnObj=p;
					returnObj.palletRequestType=$scope.palletRequestType ;
					return returnObj ;
				},
				method : 'post',
				contentType : 'application/x-www-form-urlencoded; charset=UTF-8',
				dataType : 'json',
				dataField : 'rows',
				totalField : 'total',
				responseHandler : function(p) {
					$compile(p.rows)($scope);
					return {
						'rows': p.rows,
						'total': p.total
					}
				},
				detailFormatter : function (param) {
					const html = [];
					$.each(param.rows, (key, value) => {
						html.push(`<p><b>${key}:</b> ${value}</p>`);
					});
					return html.join('');
				}
			});
			//$timeout(function () { $table.bootstrapTable('resetView'); }, 200);
			$table.on('expand-row.bs.table', (e, index, row, $detail) => {
				if (index % 2 == 1) {
					$detail.html('Loading from ajax request...');
					$.get('LICENSE', res => {
						$detail.html(res.replace(/\n/g, '<br>'));
					});
				}
			});
			$table.on('all.bs.table', (e, index, row) => {
				//console.log($table[0].children);
				
			});
			
			$(window).resize(() => {
				$table.bootstrapTable('resetView', {
					height: $scope.getHeight()
				});
			});
		};

		$scope.getIdSelections = function() {
			return $.map($table.bootstrapTable('getSelections'), ({id}) => id);
		};
		$scope.detailFormatter = function() {
			console.log('12345');
			const html = [];
			  $.each(row, (key, value) => {
				html.push(`<p><b>${key}:</b> ${value}</p>`);
			  });
			  return html.join('');
		};
		$scope.responseHandler = function(res) {
			console.log('ADkjfg');
			// $.each(res.rows, (i, row) => {
				// row.state = $.inArray(row.id, selections) !== -1;
			// });
			return res;
		};

		$scope.getHeight = function() {
			return $(window).height() - $('h1').outerHeight(true);
		};

		$scope.initTable();
		
	}]);
})();

