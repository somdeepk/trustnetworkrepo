alterApp.controller('dormantcustspeccontroller', function($rootScope, $timeout, $interval, $scope, $http, $compile) {
	$scope.dormCustSpecData={};
	
	$scope.initDormCustSpec = function () {
		angular.element(document).ready(function() {
			$scope.dormCustSpecData={};
			$scope.dormCustSpecData.monthParam=6;
			$scope.changeTab(6);
			$scope.selectionType='';
			$('#buttonContainer').css('margin-left','66%');
			$('#selContainer').val('');
			$('#selectAllSpecButton').show();
			$('#deselectAllSpecButton').hide();
			$('#deactivateAllSpecButton').hide();
		});
	};
	
	$scope.changeTab = function (param) {
		$scope.dormCustSpecData.monthParam=param;
		$scope.dormCustSpecData.search={};
		$scope.dormCustSpecData.selectedSpec=[];
		$scope.selectionType='';
		$('#buttonContainer').css('margin-left','66%');
		$('#selContainer').val('');
		$('#selectAllSpecButton').show();
		$('#deselectAllSpecButton').hide();
		$('#deactivateAllSpecButton').hide();
		$scope.getDormCustSpecList();
	};
	
	$scope.getDormCustSpecList = function () {
		var passarray= [
			{"data": "ID", "name": "ID", "bVisible": false, "bSearchable": false, "bSortable":true},
			{"data": "CUSTOMER", "name": "CUSTOMER", "bVisible": true, "bSearchable": true, "bSortable":true},
			{"data": "ABRDSTYL", "name": "ABRDSTYL", "bVisible": true, "bSearchable": true, "bSortable":true},
			{"data": "CUSTSTYL", "name": "CUSTSTYL", "bVisible": true, "bSearchable": true, "bSortable":true},
			{"data": "LASTDATE", "name": "LASTDATE", "bVisible": true, "bSearchable": true, "bSortable":true},
			{"data": "ACTION", "name": "ACTION", "bVisible": true, "bSearchable": false, "bSortable":false}
		] ;
		if (! $.fn.DataTable.isDataTable('#dormCustSpecTable')) {
			$('#dormCustSpecTable').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"scrollY": "710px",
				"scrollCollapse": true,
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource":  "getDormantCustomerSpecList.php",
				"aoColumns": passarray,
				"fnServerData": function ( sSource, aoData, fnCallback, oSettings) {
					aoData.push({ "name": "searchMonthParam", "value": $scope.dormCustSpecData.monthParam });
					aoData.push({ "name": "searchCustomer", "value": $scope.dormCustSpecData.search.customer });
					aoData.push({ "name": "searchAberdeenStyle", "value": $scope.dormCustSpecData.search.aberdeenStyle });
					aoData.push({ "name": "searchCustomerStyle", "value": $scope.dormCustSpecData.search.customerStyle });
					aoData.push({ "name": "searchLastUsedDate", "value": $scope.dormCustSpecData.search.lastUsedDate });
					oSettings.jqXHR = $.ajax({
						"dataSrc": 'Data',
						"type": "POST",
						"dataType": 'json',
						"url": sSource,
						"data": aoData,
						"success": function (msg) {
							//console.log($scope.dormCustSpecData.selectedSpec);
							fnCallback(msg.jsonData);
							$('#sqlContainer').val(msg.jsonData.retSql);
						},
						"error": function (e) {
							$('.popUpoverlayWholePage').hide();
							console.log(e.message);
						}
					});
				},
				"order": [[ 0, "DESC" ]],
				"columnDefs": [
					{ "className": "dt-center", "targets": [4, 5] }
				],
				"oLanguage": {
					"sEmptyTable":   "No Records Found"
				},
				"fnCallback": function() {
					console.log('ASD');
				},
				"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
					$(nRow).css("cursor", "pointer");
					angular.forEach($(aData), function(aDataValue, aDataKey) {
						angular.forEach($scope.dormCustSpecData.selectedSpec,function(selVal, key) {
							if ($scope.dormCustSpecData.selectedSpec.indexOf(aDataValue.ID) !== -1) {
								$('td', nRow).css('background-color', '#3495ef');
								$('td', nRow).css('color', '#ffffff');
							} else {
								$('td', nRow).css('background-color', '');
								$('td', nRow).css('color', '#454545');
							}
						});
					});
				},
				"fnCreatedRow": function( nRow, aData, iDataIndex ){
					$compile(nRow)($scope);
				},
			});
			var data_table = $('#dormCustSpecTable').DataTable();
			$('#dormantContainer .zsearch_inputz').on('keyup',function(event) {
				if (parseInt($scope.dormCustSpecData.selectedSpec.length)>0) {
					$scope.dormCustSpecData.selectedSpec=[];
					$('#selContainer').val('');
					$('#buttonContainer').css('margin-left','66%');
					$('#selectAllSpecButton').show();
					$('#deselectAllSpecButton').hide();
					$('#deactivateAllSpecButton').hide();
					$('#dormCustSpecTable tbody td').each(function() {
						$(this).css('background-color', '');
						$(this).css('color', '#454545');
					});
				}
				data_table.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('#dormCustSpecTable_filter.dataTables_filter').hide();
			$('#dormCustSpecTable_length').css('margin-top','5px');	
			$('#dormCustSpecTable_length label').css('margin-right','0%');
			$('.dataTables_scrollBody').css('max-height','490px')
			var table = $('#dormCustSpecTable').DataTable();
			$('#dormCustSpecTable tbody').on('click', 'tr', function () {
				var data = table.row(this).data();
				var specID=data.ID ;
				if ($scope.dormCustSpecData.selectedSpec.indexOf(specID) !== -1) {
					$(this).find('td').each(function(){
						$(this).css('background-color', '');
						$(this).css('color', '#454545');
					});
					angular.forEach($scope.dormCustSpecData.selectedSpec,function(selVal, key) {
						if (selVal==specID) {
							$scope.dormCustSpecData.selectedSpec.splice(key, 1);
						}
					});
				} else {
					$scope.dormCustSpecData.selectedSpec.push(specID);
					$(this).find('td').each(function(){
						$(this).css('background-color', '#3495ef');
						$(this).css('color', '#ffffff');
					});
				}
				$('#selContainer').val($scope.dormCustSpecData.selectedSpec.toString());
				if (parseInt($scope.dormCustSpecData.selectedSpec.length)>0) {
					$('#buttonContainer').css('margin-left','53%');
					$('#selectAllSpecButton').hide();
					$('#deselectAllSpecButton').show();
					$('#deactivateAllSpecButton').show();
				} else {
					$('#buttonContainer').css('margin-left','66%');
					$('#selectAllSpecButton').show();
					$('#deselectAllSpecButton').hide();
					$('#deactivateAllSpecButton').hide();
				}
			});
		}  else {
			var dataTable = $('#dormCustSpecTable').DataTable();
			dataTable.draw();
		}
	};
	
	$scope.makeDormant = function (param) {
		$scope.dormCustSpecData.selectedSpec=[];
		$('#selContainer').val(param);
		$('#dormCustSpecTable tbody td').each(function() {
			$(this).css('background-color', '');
			$(this).css('color', '#454545');
		});
		$('#buttonContainer').css('margin-left','53% ');
		$('#selectAllSpecButton').hide();
		$('#deselectAllSpecButton').show();
		$('#deactivateAllSpecButton').show();
	};
	
	$scope.manageSelection = function (param) {
		$scope.dormCustSpecData.selectedSpec=[];
		$('#selContainer').val('');
		if (param=='A') {
			$('#buttonContainer').css('margin-left','53% ');
			$('#selectAllSpecButton').hide();
			$('#deselectAllSpecButton').show();
			$('#deactivateAllSpecButton').show();
			$('.overlayWholePage').show();
			$scope.selectionType='A';
			var response = $http({
				method: 'POST',
				url: "getAllSelectedSpecIds.php",
				data: $.param({'paramSql': $('#sqlContainer').val()}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				$('.overlayWholePage').hide();
				if ($scope.isNullOrEmptyOrUndefined(data.retData)==false) {
					if (parseInt(data.retData.length)>0) {
						$scope.dormCustSpecData.selectedSpec=data.retData ;
						$('#selContainer').val(data.retData.toString());
						$('#dormCustSpecTable tbody td').each(function() {
							$(this).css('background-color', '#3495ef');
							$(this).css('color', '#ffffff');
						});
					}
				}
			});
			response.error(function (data, status, headers, config) {
				console.log("Error2.");
			});
		} else {
			$scope.selectionType='';
			$scope.dormCustSpecData.selectedSpec=[];
			$('#selContainer').val('');
			$('#dormCustSpecTable tbody td').each(function() {
				$(this).css('background-color', '');
				$(this).css('color', '#454545');
			});
			$('#buttonContainer').css('margin-left','66% ');
			$('#selectAllSpecButton').show();
			$('#deselectAllSpecButton').hide();
			$('#deactivateAllSpecButton').hide();
		}
	};
	
	$scope.initDeactivation = function() {
		$('.overlayWholePage').show();
		var response = $http({
			method: 'POST',
			url: "bulkDeactivateSpec.php",
			data: $.param({'paramData': $('#selContainer').val()}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$('.overlayWholePage').hide();
			//$('#dormantSpecListDialog').dialog("close");
			parent.location.reload();
		});
		response.error(function (data, status, headers, config) {
			console.log("Error2.");
		});
	};
	
	$scope.isNullOrEmptyOrUndefined = function (value) {
        return !value;
    };
	$scope.parseInt = parseInt ;
	$scope.parseFloat = parseFloat ;
	$scope.isObjectOrNot = function (val) {
		return angular.isObject(val);
	};
});