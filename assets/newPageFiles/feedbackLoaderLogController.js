alterApp.controller('feedbackloaderlogcontroller', function($rootScope, $timeout, $interval, $scope, $http, $compile) {
	$scope.selectedLog='';
	$scope.loadfeedbackLog =function () {
		angular.element(document).ready(function() {
			//$scope.selectedLog='';
			var passarray= [
				{"data": "logId", "name": "logId", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "logDate", "name": "logDate", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "logCompany", "name": "logCompany", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "logStyle", "name": "logStyle", "bVisible": true, "bSearchable": false, "bSortable":true},
				{"data": "logEmployee", "name": "logEmployee", "bVisible": true, "bSearchable": true, "bSortable":true},
			] ;
			$scope.feedBackLogTable = $('#feedBackLogTable').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"scrollY": "300px",
				"scrollCollapse": true,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource":  "getFeedBackLogData.php",
				"aoColumns": passarray,
				"columnDefs": [
					{"className": "dt-center", "targets": "_all"}
				],
				"order": [[ 0, "desc" ]],
				"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
					aoData.push( { "name": "paramCustomerID", "value": $scope.customerShipData.customerId } );
					aoData.push( { "name": "bolType", "value": 'DORMANT' } );
					aoData.push( { "name": "searchBOLNum", "value": $scope.customerShipData.bolListSearch.bolNum } );
					aoData.push( { "name": "searchBOLDate", "value": $scope.customerShipData.bolListSearch.bolDate } );
					aoData.push( { "name": "searchShippedVia", "value": $scope.customerShipData.bolListSearch.shippedVia } );
					aoData.push( { "name": "searchBilling", "value": $scope.customerShipData.bolListSearch.billing } );
					aoData.push( { "name": "searchItemCount", "value": $scope.customerShipData.bolListSearch.itemCount } );
					aoData.push( { "name": "searchNetWeight", "value": $scope.customerShipData.bolListSearch.netWeight } );
					aoData.push( { "name": "searchGrossWeight", "value": $scope.customerShipData.bolListSearch.grossWeight } );
					aoData.push( { "name": "searchClass", "value": $scope.customerShipData.bolListSearch.bclass } );
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
					$(nRow).css("cursor", "pointer");
					$('#selectedLog').val('');
					// $('td', nRow).css('background-color', '');
					// $('td', nRow).css('color', '#454545');
				},
				"fnCreatedRow": function( nRow, aData, iDataIndex ){
					$compile(nRow)($scope);
				},
			});
			//$scope.feedBackLogTable = $('#feedBackLogTable').DataTable();
			$('#feedBackLogTable.zsearch_inputz').on('keyup',function(event) {
				$scope.feedBackLogTable.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('.dataTables_filter').hide();
			var table = $('#feedBackLogTable').DataTable();
			$('#feedBackLogTable tbody').on('click', 'tr', function () {
				$('#feedBackLogTable tbody').find('tr').each(function(param) {
					$(this).css('background-color', '');
					$(this).css('color', '#454545');
				});
				var data = table.row( this ).data();
				//console.log(data);
				var logId=data.logId ;
				
				if ($scope.isNullOrEmptyOrUndefined($scope.selectedLog)==false) {
					if ($scope.selectedLog!=logId) {
						$scope.selectedLog=logId ;
						$(this).css('background-color', '#2179bc');
						$(this).css('color', '#ffffff');
					} else {
						$(this).css('background-color', '');
						$(this).css('color', '#454545');
						$scope.selectedLog='';
					}
				} else {
					$scope.selectedLog=logId ;
					$(this).css('background-color', '#2179bc');
					$(this).css('color', '#ffffff');
				}
				$('#selectedLog').val($scope.selectedLog);
			});
		});
	};
	
	$scope.loadTrashYardsLog =function () {
		angular.element(document).ready(function() {
			var passarray= [
				{"data": "defectId", "name": "defectId", "bVisible": false, "bSearchable": false, "bSortable":true},
				{"data": "trashDate", "name": "trashDate", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "trashReason", "name": "trashReason", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "trashComments", "name": "trashComments", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "trashLength", "name": "trashLength", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "trashUsers", "name": "trashUsers", "bVisible": true, "bSearchable": true, "bSortable":true},
			] ;
			var buttonCommon = {
				exportOptions: {
					format: {
						body: function ( data, row, column, node ) {
							return column === 0 ? 'XX' : data;
						}
					}
				}
			};
			$scope.trashYardLogTable = $('#trashYardLogTable').dataTable({
				"dom": "Bfrtip",
				"buttons": [ $.extend( true, {}, buttonCommon, {
								extend: 'copyHtml5'
							} ),
							$.extend( true, {}, buttonCommon, {
								extend: 'excelHtml5'
							} ),
							$.extend( true, {}, buttonCommon, {
								extend: 'pdfHtml5'
							} ), 
							$.extend( true, {}, buttonCommon, {
								extend: 'csvHtml5'
							} )],
				"iDisplayLength":10,
				"scrollY": "300px",
				"scrollCollapse": true,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource":  "getTrashYardData.php",
				"aoColumns": passarray,
				"columnDefs": [
					{"className": "dt-center", "targets": "_all"}
				],
				"order": [[ 0, "desc" ]],
				"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
					 var searchArr=[];
					$('.zsearch_inputz').each(function(param) {
						searchArr.push($.trim($(this).val()));
					});
					var searchArrStr=searchArr.join('!~!');
					console.log($scope.trashRollId);
					aoData.push( { "name": "searchArrStr", "value": searchArrStr } );
					aoData.push( { "name": "trashRollId", "value": $scope.trashRollId } );
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
					$(nRow).css("cursor", "pointer");
					$('#selectedLog').val('');
				},
				"fnCreatedRow": function( nRow, aData, iDataIndex ){
					$compile(nRow)($scope);
				},
			});
			$('#trashYardLogTable.zsearch_inputz').on('keyup',function(event) {
				$scope.trashYardLogTable.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('.dataTables_filter').hide();
		});
	};
	$scope.search={};
	$scope.selectedRolls=[];
	//$scope.selectedGrolls='';
	$scope.loadGreigeRollList = function () {
		angular.element(document).ready(function() {
			var passarray= [
				{"data": "ROLLID", "name": "ROLLID", "bVisible": false, "bSearchable": false, "bSortable":false},
				{"data": "ROLLNUM", "name": "ROLLNUM", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "ROLLDATE", "name": "ROLLDATE", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "GREIGESTL", "name": "GREIGESTL", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "FPO", "name": "FPO", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "KPO", "name": "KPO", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "NETWEIGHT", "name": "NETWEIGHT", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "LENGTH", "name": "LENGTH", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "LOCATION", "name": "LOCATION", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "QUALITY", "name": "QUALITY", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "STATION", "name": "STATION", "bVisible": true, "bSearchable": true, "bSortable":true},
			] ;
			$scope.greigeRollTable = $('#greigeRollTable').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"scrollY": "410px",
				"scrollCollapse": true,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource":  "getGreigeRollsForFPO.php",
				"aoColumns": passarray,
				"columnDefs": [
					{"className": "dt-center", "targets": "_all"}
				],
				"order": [[ 0, "desc" ]],
				"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
					aoData.push({ "name": "searchGreigeStyle", "value":($scope.isNullOrEmptyOrUndefined($scope.search.greige_style)==false)? $scope.search.greige_style : ''});
					aoData.push({ "name": "searchMadeBy", "value":($scope.isNullOrEmptyOrUndefined($scope.search.made_by)==false)? $scope.search.made_by : ''});
					aoData.push({ "name": "searchPoNo", "value":($scope.isNullOrEmptyOrUndefined($scope.search.purchase_no)==false)? $scope.search.purchase_no : ''});
					aoData.push({ "name": "searchRollId", "value":($scope.isNullOrEmptyOrUndefined($scope.search.rollId)==false)? $scope.search.rollId : ''});
					aoData.push({ "name": "searchRollDate", "value":($scope.isNullOrEmptyOrUndefined($scope.search.rollDate)==false)? $scope.search.rollDate : ''});
					aoData.push({ "name": "searchRollStyle", "value":($scope.isNullOrEmptyOrUndefined($scope.search.rollStyle)==false)? $scope.search.rollStyle : ''});
					aoData.push({ "name": "searchFPO", "value":($scope.isNullOrEmptyOrUndefined($scope.search.fpo)==false)? $scope.search.fpo : ''});
					aoData.push({ "name": "searchKPO", "value":($scope.isNullOrEmptyOrUndefined($scope.search.kpo)==false)? $scope.search.kpo : ''});
					aoData.push({ "name": "searchNetWeight", "value":($scope.isNullOrEmptyOrUndefined($scope.search.netWeight)==false)? $scope.search.netWeight : ''});
					aoData.push({ "name": "searchLength", "value":($scope.isNullOrEmptyOrUndefined($scope.search.length)==false)? $scope.search.length : ''});
					aoData.push({ "name": "searchLocation", "value":($scope.isNullOrEmptyOrUndefined($scope.search.location)==false)? $scope.search.location : ''});
					aoData.push({ "name": "searchQuality", "value":($scope.isNullOrEmptyOrUndefined($scope.search.quality)==false)? $scope.search.quality : ''});
					aoData.push({ "name": "searchStation", "value":($scope.isNullOrEmptyOrUndefined($scope.search.station)==false)? $scope.search.station : ''});
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
					$(nRow).css("cursor", "pointer");
					var parentSelectedGreigeRolls=window.parent.$('#selectedGreigeRolls').val();
					var parentSelectedGreigeRollsArray=parentSelectedGreigeRolls.split(',');
					if (parseInt(parentSelectedGreigeRollsArray.length)>0) {
						angular.forEach(parentSelectedGreigeRollsArray, function(sval, skey) {
							if ($scope.isNullOrEmptyOrUndefined(sval)==false) {
								if ($scope.selectedRolls.indexOf(sval) === -1) {
									$scope.selectedRolls.push(sval);
								}
							}
						});
					}
					angular.forEach($(aData), function(aDataValue, aDataKey) {
						if (parseInt(aDataValue.FPO)==$scope.search.purchase_no) {
							if ($scope.isNullOrEmptyOrUndefined(aDataValue.ROLLID)==false) {
								if ($scope.selectedRolls.indexOf(aDataValue.ROLLID) === -1) {
									$scope.selectedRolls.push(aDataValue.ROLLID);
								}
							}
						}
					});
					var tempArray=$scope.uniqueArray($scope.selectedRolls);
					$scope.selectedRolls=tempArray ;
					$timeout(function () {
						angular.forEach($(aData), function(aDataValue, aDataKey) {
							angular.forEach($scope.selectedRolls, function(selVal, key) {
								if ($scope.selectedRolls.indexOf(aDataValue.ROLLID) !== -1) {
									$('td', nRow).css('background-color', '#2179bc');
									$('td', nRow).css('color', '#ffffff');
								} else {
									$('td', nRow).css('background-color', '');
									$('td', nRow).css('color', '#454545');
								}
							});
						});
						$('#selectedGrolls').val($scope.selectedRolls.join());
					}, 220);
				},
				"fnCreatedRow": function( nRow, aData, iDataIndex ){
					$compile(nRow)($scope);
				},
			});
			$('#greigeRollTable.zsearch_inputz').on('keyup',function(event) {
				$scope.greigeRollTable.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('.dataTables_filter').hide();
			var table = $('#greigeRollTable').DataTable();
			$('#greigeRollTable tbody').on('click', 'tr', function () {
				var data = table.row( this ).data();
				var rollID=data.ROLLID ;
				if ($scope.isNullOrEmptyOrUndefined(rollID)==false) {
					if ($scope.selectedRolls.indexOf(rollID) !== -1) {
						$(this).find('td').each(function(){
							$(this).css('background-color', '');
							$(this).css('color', '#454545');
						});
						angular.forEach($scope.selectedRolls,function(selVal, key) {
							if (selVal==rollID) {
								$scope.selectedRolls.splice(key, 1);
							}
						});
					} else {
						$scope.selectedRolls.push(rollID);
						$(this).find('td').each(function(){
							$(this).css('background-color', '#2179bc');
							$(this).css('color', '#ffffff');
						});
					}
				}
				$('#selectedGrolls').val($scope.selectedRolls.join());
			});
		});
	};
	$scope.selectedRollsContainer='';
	$scope.selectedRollsLengthWeightContainer='';
	$scope.selectedReleaseRolls=[];
	$scope.selectedReleaseRollsLengthWeight=[];
	$scope.loadReleaseRollList = function () {
		$scope.selectedReleaseRolls=($scope.isNullOrEmptyOrUndefined($scope.selectedRollsContainer)==false)? $scope.selectedRollsContainer.split(',') : [] ;
		$scope.selectedReleaseRollsLengthWeight=($scope.isNullOrEmptyOrUndefined($scope.selectedRollsLengthWeightContainer)==false)? $scope.selectedRollsLengthWeightContainer.split(',') : [] ;
		angular.element(document).ready(function() {
			if (! $.fn.DataTable.isDataTable('#availableReleaseRollsTable')) {
				var passarray= [
					{"data": "ID", "name": "ID", "bVisible": false, "bSearchable": false},
					{"data": "ROLL", "name": "ROLL", "bVisible": true, "bSearchable": true},
					{"data": "DATE", "name": "DATE", "bVisible": true, "bSearchable": true},
					{"data": "STYLE", "name": "STYLE", "bVisible": true, "bSearchable": true},
					{"data": "LENGTH", "name": "LENGTH", "bVisible": true, "bSearchable": true},
					{"data": "WEIGHT", "name": "WEIGHT", "bVisible": true, "bSearchable": true},
					{"data": "QUALITY", "name": "QUALITY", "bVisible": true, "bSearchable": true},
					{"data": "LOCATION", "name": "LOCATION", "bVisible": true, "bSearchable": true},
					{"data": "STATION", "name": "STATION", "bVisible": true, "bSearchable": true}
				] ;

				$('#availableReleaseRollsTable').dataTable({
					"dom": "frtlip",
					"iDisplayLength":10,
					"scrollY": "410px",
					"scrollCollapse": true,
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource":  "getReleaseRollsList.php",
					"aoColumns": passarray,
					"fnServerData": function ( sSource, aoData, fnCallback, oSettings) {
						aoData.push( { "name": "searchReleaseType", "value": $scope.search.release_type } );
						aoData.push( { "name": "searchReleaseCustomerStyleId", "value": $scope.search.customerStyle } );
						aoData.push( { "name": "searchReleaseNum", "value": $scope.search.release_num } );
						aoData.push( { "name": "searchReleaseId", "value": $scope.search.release_id } );
						aoData.push( { "name": "searchRoll", "value": $scope.search.rolls } );
						aoData.push( { "name": "searchDate", "value": $scope.search.date } );
						aoData.push( { "name": "searchStyle", "value": $scope.search.style } );
						aoData.push( { "name": "searchLength", "value": $scope.search.length } );
						aoData.push( { "name": "searchWeight", "value": $scope.search.weight } );
						aoData.push( { "name": "searchQuality", "value": $scope.search.quality } );
						aoData.push( { "name": "searchLocation", "value": $scope.search.location } );
						aoData.push( { "name": "searchStation", "value": $scope.search.station } );
						oSettings.jqXHR = $.ajax({
							"dataSrc": 'Data',
							"type": "POST",
							"dataType": 'json',
							"url": sSource,
							"data": aoData,
							"beforeSend": function () {
								$('.popUpoverlayWholePage').show();
							},
							"success": function (msg) {
								$('.popUpoverlayWholePage').hide();
								fnCallback(msg.jsonData);
								//console.log(msg.primarySql);
							},
							"error": function (e) {
								$('.popUpoverlayWholePage').hide();
								console.log(e.message);
							}
						});
					},
					"order": [[ 0, "DESC" ]],
					"oLanguage": {
						"sEmptyTable":   "No Records Found"
					},
					"fnCallback": function() {
						console.log('ASD');
					},
					"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
						$(nRow).css("cursor", "pointer");
						angular.forEach($(aData), function(aDataValue, aDataKey) {
							var rollData=aDataValue.ROLLDATA ;
							angular.forEach($scope.selectedReleaseRolls,function(selVal, key) {
								if ($scope.selectedReleaseRolls.indexOf(aDataValue.ID) !== -1) {
									$('td', nRow).css('background-color', '#2179bc');
									$('td', nRow).css('color', '#ffffff');
									if ($scope.selectedReleaseRollsLengthWeight.indexOf(rollData)===-1) {
										$scope.selectedReleaseRollsLengthWeight.push(rollData);
									}
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
				var data_table = $('#availableReleaseRollsTable').DataTable();
				$('#availableReleaseRollsTable .zsearch_inputz').on('keyup',function(event) {
					data_table.draw(); // by this process we can recall the datatable ajax with search value
				});
				$('#availableReleaseRollsTable_filter.dataTables_filter').hide();
				$('#availableReleaseRollsTable_length').css('margin-top','5px');	
				$('#availableReleaseRollsTable_length label').css('margin-right','0%');	
				
				var table = $('#availableReleaseRollsTable').DataTable();
				$('#availableReleaseRollsTable tbody').on('click', 'tr', function () {
					var data = table.row( this ).data();
					var rollid=data.ID ;
					var rollData=data.ROLLDATA ;
					if ($scope.selectedReleaseRolls.indexOf(rollid) !== -1) {
						$(this).find('td').each(function(){
							$(this).css('background-color', '');
							$(this).css('color', '#454545');
						});
						angular.forEach($scope.selectedReleaseRolls,function(selVal, key) {
							if (selVal==rollid) {
								$scope.selectedReleaseRolls.splice(key, 1);
								$scope.selectedReleaseRollsLengthWeight.splice(key, 1);
							}
						});
					} else {
						$scope.selectedReleaseRolls.push(rollid);
						$(this).find('td').each(function(){
							$(this).css('background-color', '#2179bc');
							$(this).css('color', '#ffffff');
						});
						$scope.selectedReleaseRollsLengthWeight.push(rollData);
					}
					$('#selectedRollsContainer').val($scope.selectedReleaseRolls.join(","));
					$('#selectedRollsLengthWeightContainer').val($scope.selectedReleaseRollsLengthWeight.join(","));
					$timeout(function () {
						$scope.selectedRollsContainer=$scope.selectedReleaseRolls.join(",");
						$scope.selectedRollsLengthWeightContainer=$scope.selectedReleaseRollsLengthWeight.join(",");
					}, 250);
					//$scope.setRollsTotalValue();
				});
			} else {
				var dataTable = $('#availableReleaseRollsTable').DataTable();
				dataTable.draw();
			}
		});
	};
	
	$scope.setRollsTotalValue= function() {
		$timeout(function () { 
			var totWt=0;
			var totLn=0;
			if (parseInt($scope.selectedReleaseRollsLengthWeight.length)>0) {
				angular.forEach($scope.selectedReleaseRollsLengthWeight,function(wtVal, wtKey) {
					var wtValArr=wtVal.split('_');
					totLn+=($scope.isNullOrEmptyOrUndefined(wtValArr[1])==false && parseFloat(wtValArr[1]))? parseFloat(wtValArr[1]) : 0 ;
					totWt+=($scope.isNullOrEmptyOrUndefined(wtValArr[2])==false && parseFloat(wtValArr[2]))? parseFloat(wtValArr[2]) : 0 ;
				});
			}
			$scope.releaseData.submitRelease.quantity=totLn.toFixed(2) ;
			$scope.releaseData.submitRelease.netWeight=totWt.toFixed(2) ;
			$scope.calculatePriceValue();
		}, 120);
	};
	
	$scope.uniqueArray = function (list) {
		var result = [];
		$.each(list, function(i, e) {
			if ($.inArray(e, result) == -1) result.push(e);
		});
		return result;
	};
	
	$scope.isNullOrEmptyOrUndefined = function (value) {
        return !value;
    };
});