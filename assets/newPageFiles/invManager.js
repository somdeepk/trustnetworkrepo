var mainApp = angular.module('mainApp',['ngDialog']);
mainApp.controller('invManagerController', ['$rootScope', '$timeout', '$interval', '$scope', '$http', '$compile', '$filter', 'ngDialog', function($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, ngDialog) {

			$scope.zoneStationDetails='';
			$scope.selectedZone='';
			$scope.printList='';
			$scope.printListOne='';
			$scope.printListTwo='';
			$scope.printListThree='';
			$scope.printListFour='';
			$scope.MyInterval = $interval( function() { console.log('1min') ; $scope.notinventoried_data_table.draw(); $scope.wrongstation_data_table.draw(); }, 60000);
			$scope.initInvManager = function() {
				angular.element(document).ready(function () {
					$scope.zoneStationDetails='';
					$scope.selectedZone='';
					$scope.printList='';
					$scope.printListOne='';
					$scope.printListTwo='';
					$scope.printListThree='';
					$scope.printListFour='';
					$scope.showUnInvRoll();
					$scope.showWrongStnRoll();
					$scope.showCBEInventoryRoll();
					$scope.showZoneStation();
				});
			};
			// this function shows Un inventoried Rolls starts
			$scope.showUnInvRoll = function() {
				var buttonCommon = {
					exportOptions: {
						format: {
							body: function ( data, row, column, node ) {
								return column === 0 ? '' : data;
							}
						}
					}
				};
				var passarray= [
                    {"data": "ids", "name": "ids", "bVisible": false, "bSearchable": false, "bSortable":false},
                    {"data": "rollID", "name": "rollID", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "styleID", "name": "styleID", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "Created", "name": "Created", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "Station", "name": "Station", "bVisible": true, "bSearchable": true, "bSortable":true}
                ] ;
                $('#znotinventoriedz').dataTable({
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
                    "bProcessing": false,
                    "bServerSide": true,
                    "sAjaxSource":  "unInventoriedRoll.php",
                    "aoColumns": passarray,
                    "fnServerData": function ( sSource, aoData, fnCallback, oSettings) {
                    	$scope.printListOne='';
                        var searchArr=[];
                        $('#znotinventoriedz').find('.zsearch_inputz').each(function() {
                        	searchArr.push($.trim($(this).val()));
                        });
                        var searchArrStr=searchArr.join('!~!');
                        aoData.push( { "name": "searchArrStr", "value": searchArrStr } );
                        oSettings.jqXHR = $.ajax( {
                            "dataType": 'json',
                            "type": "POST",
                            "url": sSource,
                            "data": aoData,
                            "success": function (msg) {
                            	$scope.printListOne=msg.totalData;
                                fnCallback(msg.jsonData);
                            },
                            "error": function (e) {
                                console.log('Error1'+e.message);
                            }
                        });
                    },
                    "oLanguage": {
                        "sEmptyTable":     "No Records Found"
                    },
                    "fnCallback": function() {
                    },
                    "fnCreatedRow": function( nRow, aData, iDataIndex ){
                        $compile(nRow)($scope);
                    },
                });
				$scope.notinventoried_data_table = $('#znotinventoriedz').DataTable();
                $('#znotinventoriedz .zsearch_inputz').on('keyup',function(event) {
                    $scope.notinventoried_data_table.draw(); // by this process we can recall the datatable ajax with search value
                });
            	$('.dataTables_filter').hide();
			};
			// this function shows Un inventoried Rolls ends

			// this function shows Wrong Station Rolls Starts
			$scope.showWrongStnRoll = function() {
				var buttonCommon = {
					exportOptions: {
						format: {
							body: function ( data, row, column, node ) {
								return column === 0 ? 'XX' : data;
							}
						}
					}
				};
				var passarray= [
                    {"data": "rollID", "name": "rollID", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "Style", "name": "Style", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "Station", "name": "Station", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "StationStyle", "name": "StationStyle", "bVisible": true, "bSearchable": true, "bSortable":true}
                ] ;

                $('#zwrongstationedz').dataTable({
					"dom": "Bfrtip",
					"buttons": ['copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'],
                    "iDisplayLength":10,
                    "bProcessing": false,
                    "bServerSide": true,
                    "sAjaxSource":  "wrongStationRoll.php",
                    "aoColumns": passarray,
                    "fnServerData": function ( sSource, aoData, fnCallback, oSettings) {
                    	$scope.printListTwo='';
                        var searchArr=[];
                        $('#zwrongstationedz').find('.zsearch_inputz').each(function() {
                        		searchArr.push($.trim($(this).val()));
                        });
                        var searchArrStr=searchArr.join('!~!');
                        aoData.push( { "name": "searchArrStr", "value": searchArrStr } );
                        oSettings.jqXHR = $.ajax( {
                            "dataType": 'json',
                            "type": "POST",
                            "url": sSource,
                            "data": aoData,
                            "success": function (msg) {
                                $scope.printListTwo=msg.totalData;
                                fnCallback(msg.jsonData);
                            },
                            "error": function (e) {
                                console.log('Error2'+e);
                            }
                        });
                    },
                    "oLanguage": {
                        "sEmptyTable":     "No Records Found"
                    },
                    "fnCallback": function() {
                    },
                    "fnCreatedRow": function( nRow, aData, iDataIndex ){
                        $compile(nRow)($scope);
                    },
                });
				$scope.wrongstation_data_table = $('#zwrongstationedz').DataTable();
                $('#zwrongstationedz .zsearch_inputz').on('keyup',function(event) {
                    $scope.wrongstation_data_table.draw(); // by this process we can recall the datatable ajax with search value
                });
            	$('.dataTables_filter').hide();
			};
			// this function shows Wrong Station Rolls Ends

			$scope.showCBEInventoryRoll = function() {
				var passarray= [
                    {"data": "rollID", "name": "rollID", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "CBE", "name": "CBE", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "CBEdate", "name": "CBEdate", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "Station", "name": "Station", "bVisible": true, "bSearchable": true, "bSortable":true},
                    {"data": "INVdate", "name": "INVdate", "bVisible": true, "bSearchable": true, "bSortable":true}
                ] ;

                $('#zcbeinventoryz').dataTable({
					"dom": "Bfrtip",
					"buttons": ['copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'],
                    "iDisplayLength":10,
                    "bProcessing": false,
                    "bServerSide": true,
                    "sAjaxSource":  "CBEinventoriedRoll.php",
                    "aoColumns": passarray,
                    "fnServerData": function ( sSource, aoData, fnCallback, oSettings) {
                    	$scope.printListFour='';
                        var searchArr=[];
                        $('#zcbeinventoryz').find('.zsearch_inputz').each(function() {
                        		searchArr.push($.trim($(this).val()));
                        });
                        var searchArrStr=searchArr.join('!~!');
                        aoData.push( { "name": "searchArrStr", "value": searchArrStr } );
                        oSettings.jqXHR = $.ajax( {
                            "dataType": 'json',
                            "type": "POST",
                            "url": sSource,
                            "data": aoData,
                            "success": function (msg) {
                            	$scope.printListFour=msg.totalData;
                                fnCallback(msg.jsonData);
                            },
                            "error": function (e) {
                                console.log('Error3'+e.message);
                            }
                        });
                    },
                    "oLanguage": {
                        "sEmptyTable":     "No Records Found"
                    },
                    "fnCallback": function() {
                    },
                    "fnCreatedRow": function( nRow, aData, iDataIndex ){
                        $compile(nRow)($scope);
                    },
                });
				$scope.cbeinventory_data_table = $('#zcbeinventoryz').DataTable();
                $('#zcbeinventoryz .zsearch_inputz').on('keyup',function(event) {
                    $scope.cbeinventory_data_table.draw(); // by this process we can recall the datatable ajax with search value
                });
            	$('.dataTables_filter').hide();
			};

			$scope.showZoneStation = function() {
				$scope.zoneStationDetails='';
				$scope.selectedZone='';
				var response = $http({
						method: 'POST',
						url: 'showUnInvZoneStation.php',
						headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
					});
					response.success(function(data, status, headers, config) {
						$scope.zoneStationDetails=data.rowData ;
						$scope.printListThree=data.totalData ;
					});
					response.error(function(data, status, headers, config) {
						$scope.selTask='';
						alert("Error.");
					});
			};

	 		$scope.showHideZone = function(param,typ) {
	 			if (typ==1) {
	 				$scope.selectedZone=param.zoneid;
	 			} else {
	 				$scope.selectedZone='';
	 			}
	 		};

	 		$scope.refreshTable = function(num) {
	 			if (num==1) {
	 				$scope.field_1_1='';
	 				$scope.field_1_2='';
	 				$scope.field_1_3='';
	 				$scope.field_1_4='';
	 				$timeout(function () { $scope.notinventoried_data_table.draw(); }, 400);
	 			} else if (num==2) {
	 				$scope.field_2_1='';
	 				$scope.field_2_2='';
	 				$scope.field_2_3='';
	 				$scope.field_2_4='';
	 				$timeout(function () { $scope.wrongstation_data_table.draw(); }, 400);
	 			} else if (num==3) {
	 				$scope.showZoneStation();
	 			} else if (num==4) {
	 				$scope.field_4_1='';
	 				$scope.field_4_2='';
	 				$scope.field_4_3='';
	 				$scope.field_4_4='';
	 				$scope.field_4_5='';
	 				$timeout(function () { $scope.cbeinventory_data_table.draw(); }, 400);
	 			}
	 		};

	 		$scope.printTable = function(num) {
	 			//console.log(num);
	 			//console.log($scope.printListThree);
	 			$scope.printList=num ;
	 			if (num==1) {
	 				$scope.printHeading='New Rolls Not Inventoried';
	 			} else if (num==2) {
	 				$scope.printHeading='Wrong Style in Station';
	 			} else if (num==3) {
	 				$scope.printHeading='Statons Not Inventoried in 30 Days';
	 			} else if (num==4) {
	 				$scope.printHeading='Rolls Inventoried After CBE';
	 			}
	 			var printDialog = ngDialog.open({ 
	                template: 'showPrintDialog', 
	                className: 'ngdialog-theme-plain custom-width-1000',
	                scope: $scope
	            });
	        	$scope.printDialog = printDialog.id;
	 		};

	 		$scope.printDiv = function() {
	 			 var printContents = document.getElementById('printableDiv').innerHTML;
				  var popupWin = window.open('', '_blank', 'width=300,height=300');
				  popupWin.document.open();
				  popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="newPageFiles/css/bootstrap.min.css"><link rel="stylesheet" type="text/css" href="newPageFiles/css/font-awesome.min.css"><link rel="stylesheet" type="text/css" href="newPageFiles/css/style.css"></head><body onload="window.print()">' + printContents + '</body></html>');
				  popupWin.document.close();
	 		};
			
	
}]);
