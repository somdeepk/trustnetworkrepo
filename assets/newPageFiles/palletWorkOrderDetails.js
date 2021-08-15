var mainApp = angular.module('mainApp',['ngSanitize', 'ui.select', 'treasure-overlay-spinner', 'angularSpinners', 'ngMessages', 'ngDialog']);

mainApp.directive('validDecimalNumber', function () {
    return {
        require: '?ngModel',
        link: function (scope, element, attrs, ngModelCtrl) {
            if (!ngModelCtrl) {
                return; 
            }

            ngModelCtrl.$parsers.push(function (val) {
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

mainApp.directive('validNumber', function() {
    return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
            if (!ngModelCtrl) {
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
                if (event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57)) {
                    event.preventDefault();
                }
            });
        }
    };
});

mainApp.filter('nl2br', function ($sce) {
	return function(msg, is_xhtml) { 
		var is_xhtml = is_xhtml || true;
		var breakTag = (is_xhtml) ? '<br />' : '<br>';
		var msg = (msg + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
		return $sce.trustAsHtml(msg);
	};
});

mainApp.directive('startDateTime', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		compile: function() {
			return {
				pre: function(scope, element, attrs, ngModelCtrl) {
					var format, dateObj;
					format1 = (!attrs.dpFormat) ? 'MM/DD/YYYY hh:mm A' : attrs.dpFormat;
					$(element).datetimepicker({
						format: format1,
						sideBySide: false,
						toolbarPlacement: 'default',
						showClear: true,
						showClose: true,
					}).on('dp.change', function(dttm) {
						var thisId=attrs.id;
						if (dttm.date._d!=undefined) {
							var res = thisId.replace("start", "finish");
							if ($('#'+res).data("DateTimePicker")) {
								$('#'+res).data("DateTimePicker").minDate(dttm.date);
							}
							var selectDate=dttm.date._d.getDate();
							var str = selectDate.toString();
							var newSelectedDate=(str.length<2)? "0" + str : str ;
							var selectYear=dttm.date._d.getFullYear();
							var mstr=(Number(dttm.date._d.getMonth())+1).toString();
							var newSelectedMonth=(mstr.length<2)? "0" + mstr : mstr ;
							var hstr=(dttm.date._d.getHours()).toString();
							var newSelectedHour=(hstr.length<2)? "0" + hstr : hstr ;
							var mistr=(dttm.date._d.getMinutes()).toString();
							var newSelectedMinute=(mistr.length<2)? "0" + mistr : mistr ;
							var sstr=(dttm.date._d.getSeconds()).toString();
							var newSelectedSecond=(sstr.length<2)? "0" + sstr : sstr ;
							var modstr=selectYear+'-'+newSelectedMonth+'-'+newSelectedDate+' '+newSelectedHour+':'+newSelectedMinute+':'+newSelectedSecond ;
						} else {
							var modstr='';
						}
						var tArr=thisId.split('_');
						var indx=tArr[1];
						scope.taskObj.taskDetails[indx].startTimeStr=modstr ;
						if ($('#'+thisId)) {
							ngModelCtrl.$setViewValue($('#'+thisId).val());
						}
						//$(this).data('DateTimePicker').hide();
					});
				}
			}
		}
	}
});

mainApp.directive('endDateTime', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		compile: function() {
			return {
				pre: function(scope, element, attrs, ngModelCtrl) {
					var format, dateObj;
					format1 = (!attrs.dpFormat) ? 'MM/DD/YYYY hh:mm A' : attrs.dpFormat;
					$(element).datetimepicker({
						format: format1,
						sideBySide: false,
						toolbarPlacement: 'default',
						showClear: true,
						showClose: true,
						useCurrent: false
					}).on('dp.change', function(dttm) {
						if (dttm.date._d!=undefined) {
							var thisId=attrs.id;
							var res = thisId.replace("finish", "start");
							if ($('#'+res).data("DateTimePicker")) {
								$('#'+res).data("DateTimePicker").maxDate(dttm.date);
							}
							var selectDate=dttm.date._d.getDate();
							var str = selectDate.toString();
							var newSelectedDate=(str.length<2)? "0" + str : str ;
							var selectYear=dttm.date._d.getFullYear();
							var mstr=(Number(dttm.date._d.getMonth())+1).toString();
							var newSelectedMonth=(mstr.length<2)? "0" + mstr : mstr ;
							var hstr=(dttm.date._d.getHours()).toString();
							var newSelectedHour=(hstr.length<2)? "0" + hstr : hstr ;
							var mistr=(dttm.date._d.getMinutes()).toString();
							var newSelectedMinute=(mistr.length<2)? "0" + mistr : mistr ;
							var sstr=(dttm.date._d.getSeconds()).toString();
							var newSelectedSecond=(sstr.length<2)? "0" + sstr : sstr ;
							var modstr=selectYear+'-'+newSelectedMonth+'-'+newSelectedDate+' '+newSelectedHour+':'+newSelectedMinute+':'+newSelectedSecond ;
						} else {
							var modstr='';
						}
						var tArr=thisId.split('_');
						var indx=tArr[1];
						scope.taskObj.taskDetails[indx].finishTimeStr=modstr ;
						if ($('#'+thisId)) {
							ngModelCtrl.$setViewValue($('#'+thisId).val());
						}
						//$(this).data('DateTimePicker').hide();
					});
				}
			}
		}
	}
});

mainApp.controller('palletWorkOrderDetailsController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
	$scope.palletDet= '';
	$scope.palletIpu= '';
	$scope.palletTask= '';
	$scope.palletMaster= '';
	$scope.loadRunning= '';
	$scope.showRollHeading= 'Master';
	$scope.initiateFSSEdit= '0';
	$scope.alterFSSID='';
	$scope.validateFSS= false;
	$scope.conversionObj={};
	$scope.taskObj={};
	$scope.initPalletWorkOrderDetails = function(palletID) {
		angular.element(document).ready(function () {
			$scope.initiateFSSEdit= '0';
			$scope.alterFSSID= '';
			$scope.validateFSS= false;
			$scope.conversionObj={};
			$scope.taskObj={};
			$scope.showRollHeading= 'Master';
			$scope.palletDet= '';
			$scope.palletIpu= '';
			$scope.palletTask= '';
			$scope.palletMaster= '';
			$scope.palletMasterCount= '';
			$scope.palletIpuCount= '';
			$scope.loadRunning= '';
			$scope.selectedMasterRolls = [];
			$scope.selectedIPURolls = [];
			$scope.selectedAlertRolls = [];
			$scope.rollSelectError= '';
			//console.log(palletID);
			if (Number(palletID) >0) {
				$scope.selectedPalletID=palletID ;
				$scope.getPalletDetails();
			} else {
				window.location.href='palletWorkOrder.php' ;
			}
		});
	};
    $scope.workOrderAmount='';
    $scope.sessionIsQuality=0;
    $scope.checkEditPermission=1;
	$scope.getPalletDetails = function() {
		$(".overlayWholePage").show();
		var response = $http({
            method: 'POST',
            url: "getPalletDetails.php",
            data: $.param({'selectedPalletID': $scope.selectedPalletID}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
        });
        response.success(function (data, status, headers, config) {
        	console.log(data);
        	$scope.palletDet=data.palletDet ;
        	$scope.basicPalletDet=data.palletDet ;
        	$scope.palletIpu=data.palletIpu ;
        	$scope.palletTask=data.palletTask ;
        	$scope.palletMaster=data.palletMaster ;
        	$scope.palletIpuCount=(data.palletIpu).length ;
        	$scope.palletMasterCount=(data.palletMaster).length ;
			$scope.setPriority=data.palletDet.priority ;
			$scope.officeInstruction=data.palletDet.palletComments ;
			$scope.workOrderAmount=data.palletDet.workOrderAmount ;
			$scope.sessionIsQuality=data.sessionIsQuality ;
			$scope.orphanTableId=data.orphanTableId ;
			//console.log($scope.sessionIsQuality);
			$(".overlayWholePage").hide();
			if ($scope.isNullOrEmptyOrUndefined(data.palletDet.finishingSpecId)==true && $scope.isNullOrEmptyOrUndefined(data.palletDet.FSSID)==true && $scope.isNullOrEmptyOrUndefined(data.palletDet.finCount)==false && parseInt($scope.palletDet.finCount)==0) {
				$('#noFSSDialogButton').click();
			}
			if (Number((data.palletMaster).length)>0) {
				angular.forEach($scope.palletMaster,function(selVal, key) {
					var masterQuality=$.trim(selVal.quality.toLowerCase());
					if (masterQuality=='alert' && parseInt($scope.sessionIsQuality)==0) {
						$scope.palletMaster[key].checkEditPermission= 0 ;
						$scope.checkEditPermission=0 ;
					} else {
						$scope.palletMaster[key].checkEditPermission= 1 ;
					}
				});
				//console.log($scope.palletMaster);
			}
        });
        response.error(function (data, status, headers, config) {
            alert("Error.");
        });
    };

    $scope.showMasterRollsContainer = function() {
    	var passarray= [
			{"data": "rid", "name": "rid", "bVisible": true, "bSearchable": false, "bSortable":false},
			{"data": "rollDate", "name": "rollDate", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "rollNum", "name": "rollNum", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Style", "name": "Style", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Length", "name": "Length", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Quality", "name": "Quality", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Station", "name": "Station", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Pallet", "name": "Pallet", "bVisible": true, "bSearchable": false, "bSortable":false},
			{"data": "Workorder", "name": "Workorder", "bVisible": true, "bSearchable": false, "bSortable":false},
			{"data": "action", "name": "action", "bVisible": true, "bSearchable": false, "bSortable":false},
		] ;
		$scope.masterRollsContainer = $('#masterRollsContainer').dataTable({
			"dom": "frtlip",
			"iDisplayLength":10,
			"bProcessing": false,
			"bServerSide": true,
			"sAjaxSource":  "getPalletMasterRolls.php",
			"aoColumns": passarray,
			"columnDefs": [
				{ "className": "dt-left pl20 zselectz", "targets": [0, 1, 2, 3, 4, 5, 6, 7] },
				{ "className": "dt-center", "targets": [8, 9] }
			],
			"order": [[ 2, "desc" ]],
			"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
				aoData.push(
					{"name": "styleFirstFour","value":$scope.palletDet.styleFirstFour}, 
					{"name": "palletID","value":$scope.selectedPalletID},
					{"name": "searchMasterRollDate","value":$scope.searchMasterRoll.Date},
					{"name": "searchMasterRollName","value":$scope.searchMasterRoll.Name},
					{"name": "searchMasterRollStyle","value":$scope.searchMasterRoll.Style},
					{"name": "searchMasterRollLength","value":$scope.searchMasterRoll.Length},
					{"name": "searchMasterRollQuality","value":$scope.searchMasterRoll.Quality},
					{"name": "searchMasterRollStation","value":$scope.searchMasterRoll.Station},
					{"name": "searchMasterRollPallet","value":$scope.searchMasterRoll.Pallet},
					{"name": "searchMasterRollWorkOrder","value":$scope.searchMasterRoll.WorkOrder},
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
				$(nRow).css("cursor", "pointer");
				angular.forEach($(aData), function(aDataValue, aDataKey) {
					angular.forEach($scope.selectedMasterRolls,function(selVal, key) {
						if ($scope.selectedMasterRolls.indexOf(aDataValue.frollid) !== -1) {
							$('td', nRow).css('background-color', '#2179bc');
							$('td', nRow).css('color', '#ffffff');
						} else {
							$('td', nRow).css('background-color', '');
							$('td', nRow).css('color', '#454545');
						}
                    });
				});
				$(nRow).find('td:eq(8)').css('background-color', '');
				$(nRow).find('td:eq(8)').css('color', '#454545');
				$(nRow).find('td:eq(9)').css('background-color', '');
			},
			"fnCreatedRow": function( nRow, aData, iDataIndex ){
				$compile(nRow)($scope);
			},
		});
		var data_table = $('#masterRollsContainer').DataTable();
		$('#masterRollsContainer .zsearch_inputz').on('keyup',function(event) {
			data_table.draw(); // by this process we can recall the datatable ajax with search value
		});
		$('#masterRollsContainer_filter.dataTables_filter').hide();
		var table = $('#masterRollsContainer').DataTable();
		$('#masterRollsContainer tbody').on('click', '.zselectz', function () {
			var data = table.row( $(this).parent() ).data();
			var frollid=data.frollid ;
			var rollLength=data.Length ;
			var totVal=0;
			if ($scope.selectedMasterRolls.indexOf(frollid) !== -1) {
				angular.forEach($scope.selectedMasterRolls,function(selVal, key) {
					if (parseInt(selVal)==parseInt(frollid)) {
						$scope.selectedMasterRolls.splice(key, 1);
						totVal=parseInt($scope.totalRollLength) - parseInt(rollLength);
					}
				});
				$($(this).parent()).find('td').each(function(key, value){
					if (parseInt(key)<8) {
						$(this).css('color', '#454545');
						$(this).css('background-color', '');
					}
				});
				$timeout(function() {
					$scope.totalRollLength=totVal;
				},80);
			} else {
				$scope.selectedMasterRolls.push(frollid);
				var totVal=parseInt($scope.totalRollLength) + parseInt(rollLength);
				$($(this).parent()).find('td').each(function(key, value){
					if (parseInt(key)<8) {
						$(this).css('color', '#ffffff');
						$(this).css('background-color', '#2179bc');
					}
				});
				$timeout(function() {
					$scope.totalRollLength=totVal;
				},80);
			}
		});
    };
	$scope.showMsg=0;
	$scope.alertRollids=[] ;
	$scope.alertRollNum='' ;
	$scope.alertRollID='' ;
	$scope.alertRollOfficeInstructionArray={};
	$scope.alertRollOfficeInstructionError='';
	$scope.showQualityAlert = function(frollid, qualityCheckPermission, alertRollNum) {
		$scope.alertRollOfficeInstruction='';
		$scope.alertRollids.push(frollid);
		$scope.alertRollNum=alertRollNum ;
		$scope.alertRollID=frollid ;
		if (Number(qualityCheckPermission)==0) { // If the User does not have Quality Check Permission
			$scope.showMsg=1;
		} else { // If the User have Quality Check Permission
			$scope.showMsg=2;
		}
		$timeout(function() {
			$('#roll_alert_dialog').click();
		},100);
	};
	
	$scope.closeRollAlert = function () {
		$(".overlayWholePage").show();
		angular.forEach($scope.selectedMasterRolls,function(mastVal, mastKey) {
			angular.forEach($scope.alertRollids, function(alrtVal, alrtKey) {
				if ($scope.isNullOrEmptyOrUndefined(mastVal)==false && $scope.isNullOrEmptyOrUndefined(alrtVal)==false && (mastVal==alrtVal)) {
					$scope.selectedMasterRolls.splice(mastKey, 1);
				}
			});
		});
		
		angular.forEach($scope.selectedAlertRolls,function(mastVal, mastKey) {
			angular.forEach($scope.alertRollids, function(alrtVal, alrtKey) {
				if ($scope.isNullOrEmptyOrUndefined(mastVal)==false && $scope.isNullOrEmptyOrUndefined(alrtVal)==false && (mastVal==alrtVal)) {
					$scope.selectedAlertRolls.splice(mastKey, 1);
				}
			});
		});
		var data_table = $('#masterRollsContainer').DataTable();
		data_table.draw(); // by this process we can recall the datatable ajax with search value
		$scope.showMsg=0;
		$scope.alertRollNum='';
		$scope.alertRollID='' ;
		$scope.alertRollOfficeInstruction='';
		$scope.alertRollOfficeInstructionArray={};
		$scope.alertRollOfficeInstructionError='';
		$('#rollAlertDialog').modal('toggle');
		$(".overlayWholePage").hide();
	};
	
	$scope.addRollOfficeInstruction= function() {
		if ($scope.isNullOrEmptyOrUndefined($.trim($('#alertRollOfficeInstruction').val()))==true) {
			$scope.alertRollOfficeInstructionError='Office Instruction Required';
		} else {
			$scope.alertRollOfficeInstructionError='';
			$scope.alertRollOfficeInstructionArray[$scope.alertRollID]=$.trim($('#alertRollOfficeInstruction').val()) ;
			$scope.showMsg=0;
			$scope.alertRollNum='';
			$scope.alertRollID='' ;
			$scope.alertRollOfficeInstructionError='';
			$('#rollAlertDialog').modal('toggle');
		}

	};
	
    $scope.showIpuRollsContainer = function() {
    	var passarray= [
			{"data": "rid", "name": "rid", "bVisible": false, "bSearchable": false, "bSortable":false},
			{"data": "rollDate", "name": "rollDate", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "rollNum", "name": "rollNum", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Style", "name": "Style", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Length", "name": "Length", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Quality", "name": "Quality", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Station", "name": "Station", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "Pallet", "name": "Pallet", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "workOrder", "name": "workOrder", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "releaseNum", "name": "releaseNum", "bVisible": true, "bSearchable": false, "bSortable":true},
			{"data": "action", "name": "action", "bVisible": true, "bSearchable": false, "bSortable":false},
		] ;
		$scope.ipuRollsContainer = $('#ipuRollsContainer').dataTable({
			"dom": "frtlip",
			"iDisplayLength":10,
			//"scrollY": "250px",
			//"scrollCollapse": true,
			"bProcessing": false,
			"bServerSide": true,
			"sAjaxSource":  "getPalletIpuRolls.php",
			"aoColumns": passarray,
			"columnDefs": [
				{ "className": "dt-left pl20 zselz", "targets": [0, 1, 2, 3, 4, 5, 6, 7] },
				{ "className": "dt-center", "targets": [8, 9, 10] }
			],
			"order": [[ 2, "desc" ]],
			"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
				aoData.push(
					{"name": "FSSID","value":$scope.palletDet.FSSID}, 
					{"name": "palletNum","value":$scope.palletDet.palletNum},
					{"name": "orphanTableId","value":$scope.orphanTableId},
					{"name": "searchIPURollDate", "value":$scope.searchIPURoll.Date},
					{"name": "searchIPURollName", "value":$scope.searchIPURoll.Name},
					{"name": "searchIPURollStyle", "value":$scope.searchIPURoll.Style},
					{"name": "searchIPURollLength", "value":$scope.searchIPURoll.Length},
					{"name": "searchIPURollQuality", "value":$scope.searchIPURoll.Quality},
					{"name": "searchIPURollStation", "value":$scope.searchIPURoll.Station},
					{"name": "searchIPURollPallet", "value":$scope.searchIPURoll.Pallet},
					{"name": "searchIPURollWorkOrder", "value":$scope.searchIPURoll.WorkOrder},
					{"name": "searchIPUReleaseNum", "value":$scope.searchIPURoll.release},
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
				setTimeout( function() {
					$(nRow).css("cursor", "pointer");
					angular.forEach($(aData), function(aDataValue, aDataKey) {
						angular.forEach($scope.selectedIPURolls,function(selVal, key) {
							if ($scope.selectedIPURolls.indexOf(aDataValue.frollid) !== -1) {
								$('td', nRow).css('background-color', '#2179bc');
								$('td', nRow).css('color', '#ffffff');
							} else {
								$('td', nRow).css('background-color', '');
								$('td', nRow).css('color', '#454545');
							}
						});
					});
					if ($scope.isNullOrEmptyOrUndefined(aData.openDateTime)==false && $scope.isNullOrEmptyOrUndefined(aData.closeDateTime)==true) {
						$(nRow).find('td:eq(7)').css('background-color', '#fcff00');
						$(nRow).find('td:eq(7)').css('color', '#000000');
					} else {
						$(nRow).find('td:eq(7)').css('background-color', '#5cb85c');
						$(nRow).find('td:eq(7)').css('color', '#ffffff');
					}
//					console.log(aData);
//					if ($scope.isNullOrEmptyOrUndefined(aData.workOrder)==false && $scope.isNullOrEmptyOrUndefined($scope.selectedPalletID)==false) {
//						if (Number(aData.workOrder)==Number($scope.selectedPalletID)) {
//							$(nRow).find('td:eq(8)').css('background-color', '#5cb85c');
//							$(nRow).find('td:eq(8)').css('color', '#ffffff');
//						} else {
//							$(nRow).find('td:eq(8)').css('background-color', '#f90e0e');
//							$(nRow).find('td:eq(8)').css('color', '#ffffff');
//						}
//					}

					if ($scope.isNullOrEmptyOrUndefined(aData.releaseNum)==false) {
						$(nRow).find('td:eq(8)').css('background-color', '#c9bf0a');
						$(nRow).find('td:eq(8)').css('color', '#ffffff');
					} else {
						$(nRow).find('td:eq(8)').css('background-color', '');
					}
					$(nRow).find('td:eq(9)').css('background-color', '');
				}, 100);
				
			},
			"fnCreatedRow": function( nRow, aData, iDataIndex ){
				$compile(nRow)($scope);
			},
		});
		var data_table = $('#ipuRollsContainer').DataTable();
		$('#ipuRollsContainer .zsearch_inputz').on('keyup',function(event) {
			data_table.draw(); // by this process we can recall the datatable ajax with search value
		});
		$('#ipuRollsContainer_filter.dataTables_filter').hide();
		var table = $('#ipuRollsContainer').DataTable();
		$('#ipuRollsContainer tbody').on('click', '.zselz', function () {
			var data = table.row( $(this).parent() ).data();
			var frollid=data.frollid ;
			var rollLength=data.Length ;
			var totVal=0;
			if ($scope.selectedIPURolls.indexOf(frollid) !== -1) {
				angular.forEach($scope.selectedIPURolls,function(selVal, key) {
					if (parseInt(selVal)==parseInt(frollid)) {
						$scope.selectedIPURolls.splice(key, 1);
						totVal=parseInt($scope.totalRollLength) - parseInt(rollLength);
					}
				});
				$($(this).parent()).find('td').each(function(key, value){
					if (parseInt(key)<7) {
						$(this).css('color', '#454545');
						$(this).css('background-color', '');
					}
				});
				$timeout(function() {
					$scope.totalRollLength=totVal;
				},80);
			} else {
				$scope.selectedIPURolls.push(frollid);
				var totVal=parseInt($scope.totalRollLength) + parseInt(rollLength);
				$($(this).parent()).find('td').each(function(key, value){
					if (parseInt(key)<7) {
						$(this).css('color', '#ffffff');
						$(this).css('background-color', '#2179bc');
					}
				});
				$timeout(function() {
					$scope.totalRollLength=totVal;
				},80);
			}
		});
    };
	$scope.searchMasterRoll={};
	$scope.searchIPURoll={};
	$scope.showRolls = function() {
		$scope.showRollHeading='Master';
		$('#masterTab').tab('show');
		$scope.selectedMasterRolls = [];
		var totRollLength=0;
		if (parseInt($scope.palletMaster.length)>0) {
			angular.forEach($scope.palletMaster,function(mastVal, key) {
				if (parseInt(mastVal.frollid)>0) {
					if ($scope.selectedMasterRolls.indexOf(mastVal.frollid) === -1) {
						$scope.selectedMasterRolls.push(mastVal.frollid);
						totRollLength+=parseInt(mastVal.rollLength);
					}
				}
			});
		}
		$scope.selectedIPURolls = [];
		if (parseInt($scope.palletIpu.length)>0) {
			angular.forEach($scope.palletIpu,function(ipuVal, key) {
				if (parseInt(ipuVal.frollid)>0) {
					if ($scope.selectedIPURolls.indexOf(ipuVal.frollid) === -1) {
						$scope.selectedIPURolls.push(ipuVal.frollid);
						totRollLength+=parseInt(ipuVal.rollLength);
					}
				}
			});
		}
		
		$scope.totalRollLength=totRollLength;
		$scope.rollSelectError='';
		$scope.searchMasterRoll.Style = $scope.palletDet.styleFirstFour ;
		$scope.searchIPURoll.Style = $scope.palletDet.custstyle ;
		// console.log($scope.palletDet.styleFirstFour);
		// console.log($scope.searchMasterRoll.Style);
		// console.log($scope.palletDet.custstyle);
		// console.log($scope.searchIPURoll.Style);
		var partString='';
		if ($scope.isNullOrEmptyOrUndefined($scope.palletDet.custstyle)==false) {
			var newStr=$scope.palletDet.custstyle;
			var strLen=newStr.length ;
			if (parseInt(strLen)>=4) {
				partString=newStr.substring(0, 4);
			} else {
				partString=newStr ;
			}
		}
		$scope.palletDet.styleFirstFour=partString ;
		if ( ! $.fn.DataTable.isDataTable('#masterRollsContainer')) {
			$scope.showMasterRollsContainer();
		} else {
			$scope.masterRollsContainer = $('#masterRollsContainer').DataTable();
			$scope.masterRollsContainer.draw();
		}
		
		if ( ! $.fn.DataTable.isDataTable('#ipuRollsContainer')) {
			$scope.showIpuRollsContainer();
		} else {
			$scope.ipuRollsContainer = $('#ipuRollsContainer').DataTable();
			$scope.ipuRollsContainer.draw();
		}
	};
	
	$scope.getMasterChange = function() {
		$scope.masterRollsContainer = $('#masterRollsContainer').DataTable();
		$scope.masterRollsContainer.draw();
	};
	
	$scope.isNullOrEmptyOrUndefined = function (value) {
        return !value;
    };
	
	$scope.addRollsToPallet = function() {
		if (($scope.selectedMasterRolls).length==0 && ($scope.selectedIPURolls).length==0) {
			$scope.rollSelectError='Atleast One Roll need to be Selected';
		} else {
			$scope.rollSelectError='';
			var response = $http({
				method: 'POST',
				url: "addRollsToPallet.php",
				data: $.param({'palletDet': $scope.palletDet, 'selectedMasterRolls': $scope.selectedMasterRolls, 'selectedIPURolls':$scope.selectedIPURolls, 'selectedPalletID':$scope.selectedPalletID, 'alertRollOfficeInstructionArray': $scope.alertRollOfficeInstructionArray}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				$('#rollCloser').click();
				$scope.getPalletDetails();
			});
			response.error(function (data, status, headers, config) {
				alert("Error.");
			});
		}
	};
	
	$scope.removeRoll = function(rollDetails, rollType) {
		var response = $http({
			method: 'POST',
			url: "updatePallet.php",
			data: $.param({'palletDet': $scope.palletDet, 'rollDetails': rollDetails, 'rollType':rollType, 'selectedPalletID':$scope.selectedPalletID}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.getPalletDetails();
		});
		response.error(function (data, status, headers, config) {
			alert("Error.");
		});
	};
	$scope.checkWorkOrder=false;
	$scope.submitPallet = function(type) {
		$scope.checkWorkOrder=true;
		if ($scope.isNullOrEmptyOrUndefined($scope.workOrderAmount)==false && Number($scope.workOrderAmount)>0) {
			$scope.loadRunning=1;
			$scope.showNotification="";
			var response = $http({
				method: 'POST',
				url: "submitPallet.php",
				data: $.param({'officeInstruction': $scope.officeInstruction, 'setPriority':$scope.setPriority, 'selectedPalletID':$scope.selectedPalletID, 'workOrderAmount': $scope.workOrderAmount}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				console.log(data);
				$scope.checkWorkOrder=false;
				$scope.loadRunning='';
				if (data==1) {
					$scope.showNotification="Record Submitted Successfully" ;
					if (type==1) {
						var openurl="fpdf17/palletPDF.php?palletID="+$scope.selectedPalletID ;
						window.open(openurl,'_blank');
					}
					$timeout(function() {
						$scope.showNotification="";
						window.location.href='palletWorkOrder.php';
					},700);
				} else {
					$scope.getPalletDetails();
				}
			});
			response.error(function (data, status, headers, config) {
				alert("Error.");
			});
		}
	};
	
	$scope.goToCustomerSpec = function() {
		$scope.loadRunning=1;
		window.location.href='editCustomerspec.php?custspecid='+ $scope.palletDet.customerSpecId +'&workOrderPalletId='+ $scope.selectedPalletID ;
	};
	
	$scope.checkFSSDetails = function () {
		$scope.loadRunning=1;
		var response = $http({
			method: 'POST',
			url: "checkCustFinSpec.php",
			data: $.param({'custspecid':$scope.palletDet.customerSpecId,'workOrderPalletId':$scope.selectedPalletID}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.loadRunning='';
			$scope.getPalletDetails();
		});
		response.error(function (data, status, headers, config) {
			alert("Error.");
		});
	};
	
	$scope.updateCustomerSpec = function() {
		$('#editCustStyle').modal('toggle');
		var response = $http({
			method: 'POST',
			url: "updateCustSpec.php",
			data: $.param({'palletDet':$scope.palletDet}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.getPalletDetails();
		});
		response.error(function (data, status, headers, config) {
			alert("Error.");
		});
	};
	
	$scope.copyCustomerSpec = function() {
		$scope.palletDet.seams=$scope.palletDet.company_seams ;
		$scope.palletDet.defects=$scope.palletDet.company_defects ;
		$scope.palletDet.core_size=$scope.palletDet.company_core_size ;
		$scope.palletDet.core_selvedge=$scope.palletDet.company_core_selvedge ;
	};
	$scope.createOrderReturnData='';
	$scope.selectOrderData='';
	$scope.palletNumList='';
	$scope.addWorkWorderRolls = function() {
		$scope.createOrderReturnData='';
		$scope.selectOrderData='';
		$scope.palletNumList='';
		var response = $http({
            method: 'POST',
            url: "getCustomerOrderDetails.php",
            data: $.param({'customerOrderId': $scope.palletDet.customerOrderId}),
            headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
        });
        response.success(function (data, status, headers, config) {
			$scope.createOrderReturnData=data;
        });
        response.error(function (data, status, headers, config) {
            alert("Error.");
        });
	};
	
	$scope.setOrderDetails = function(param) {
		if ($scope.isNullOrEmptyOrUndefined($scope.selectOrderData.orderitems)==false && $scope.selectOrderData.orderitems==param.orderitems) {
			$scope.selectOrderData='';
		} else {
			$scope.selectOrderData=param;
		}
	};
	
	$scope.resetCreateOrder = function() {
		$scope.createOrderReturnData='';
		$scope.selectOrderData='';
	};
	
	$scope.createWorkorder = function() {
		$scope.errorMsg = [] ;
		if ($scope.isNullOrEmptyOrUndefined($scope.selectOrderData)==true) {
			$scope.errorMsg.push("Item Need to be Selected");
		}
		if ($scope.isNullOrEmptyOrUndefined($scope.palletNumList)==true) {
			$scope.errorMsg.push("Pallet# Required.");
		}
		
		if($scope.isNullOrEmptyOrUndefined($scope.palletNumList.customerOrderId)==false && $scope.isNullOrEmptyOrUndefined($scope.selectOrderData.customerorderid)==false && $scope.palletNumList.customerOrderId!=$scope.selectOrderData.customerorderid) {
			$scope.errorMsg.push("Wrong Pallet# for this Item");
		}
		if (($scope.errorMsg).length==0) {
			//$('.close').click();
			var response = $http({
				method: 'POST',
				url: "createWorkorder.php",
				data: $.param({'selectedOrderItem': $scope.selectOrderData, 'palletNumList': $scope.palletNumList}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				if (Number(data)>0) {
					window.location.href='palletWorkOrderDetails.php?palletID='+data ;
				} else {
					alert("Error.");
				}
			});
			response.error(function (data, status, headers, config) {
				alert("Error.");
			});
		}
	};
	
	$scope.changeFSSEdit = function(val) {
		$scope.initiateFSSEdit=val;
		$scope.alterFSSID='';
		$scope.validateFSS=false;
	};
	
	$scope.alterFSSEdit = function() {
		$scope.alterFSSID=$('#alterFSSID').val();
		$scope.validateFSS=true;
		$('#errorConfirmation').modal('toggle');
	};
	
	$scope.submitFSSID = function() {
		if ($scope.isNullOrEmptyOrUndefined($scope.alterFSSID)==true) {
			return false ;
		} else {
			$('#errorConfirmation').modal('toggle');
			var response = $http({
				method: 'POST',
				url: "alterWorkOrderFSSID.php",
				data: $.param({'alterFSSID': $scope.alterFSSID, 'palletID': $scope.selectedPalletID}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				$scope.initPalletWorkOrderDetails($scope.selectedPalletID);
			});
			response.error(function (data, status, headers, config) {
				alert("Error.");
			});
		} 
	};
	
	$scope.changeRollCharecter = function(palletRollNum, RollId, typ) {
		$scope.conversionObj={};
		$scope.conversionObj.palletRollNum=palletRollNum;
		$scope.conversionObj.RollId=RollId;
		$scope.conversionObj.typ=typ;
		$scope.conversionObj.selectedPalletID=$scope.selectedPalletID ;
		$('#conversionConfirmation').modal('toggle');
	};
	
	$scope.initConversion = function() {
		$('#conversionConfirmation').modal('toggle');
		var response = $http({
			method: 'POST',
			url: "rollConvertion.php",
			data: $.param({'conversionObj': $scope.conversionObj}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.getPalletDetails();
		});
		response.error(function (data, status, headers, config) {
			console.log("Error.");
		});
	};
	
	// Task Related Functions
	
	$scope.tabChanger = function() {
		if ($scope.taskObj.taskTabChanger=='thisWorkOrder') {
			$scope.taskObj.submitTask=false;
			$scope.taskObj.taskDetails=[];
			$scope.taskObj.hasTask=0;
			var response = $http({
				method: 'POST',
				url: "newPageFiles/task_files/getTaskByOrderId.php",
				data: $.param({'workOrderId':$scope.selectedPalletID, 'moduleType': 'WO'}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				if ($scope.isNullOrEmptyOrUndefined(data.taskDetails)==false) {
					if (parseInt(data.taskDetails.length)>0) {
						$scope.taskObj.taskDetails=data.taskDetails;
						$scope.taskObj.hasTask=1;
					} else {
						var getData=$scope.getWorkOrderTaskDet();
						$scope.taskObj.taskDetails=[];
						$scope.taskObj.taskDetails.push(getData);
					}
				} else {
					var getData=$scope.getWorkOrderTaskDet();
					$scope.taskObj.taskDetails=[];
					$scope.taskObj.taskDetails.push(getData);
				}
				$scope.getNecessaryList();
			});
			response.error(function (data, status, headers, config) {
				alert("Error.");
			});
		} else if ($scope.taskObj.taskTabChanger=='template') {
			$timeout(function () {
				$scope.searchTemplate={};
				$scope.getTemplateList();
			}, 200);
		} else if ($scope.taskObj.taskTabChanger=='behaviors') {
			$scope.taskObj.behaviorList=[];
			var response = $http({
				method: 'POST',
				url: "newPageFiles/task_files/getBehavior.php",
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				if ($scope.isNullOrEmptyOrUndefined(data.behaveList)==false) {
					if (parseInt(data.behaveList.length)>0) {
						$scope.taskObj.behaviorList=data.behaveList ;
					}
				}
			});
			response.error(function (data, status, headers, config) {
				alert("Error.");
			});
		}
	};

	$scope.getNecessaryList = function() {
		var response = $http({
			method: 'POST',
			url: "newPageFiles/task_files/getNecessaryData.php",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.taskObj.userList=data.userList;
			$scope.taskObj.descList=data.descList;
			$scope.resetStartEndDate();
		});
		response.error(function (data, status, headers, config) {
			alert("Error.");
		});
	};
	
	$scope.getWorkOrderTaskDet = function() {
		var tempObj={};
		tempObj.tid=0;
		tempObj.templateId=0;
		tempObj.tOrder=0;
		tempObj.descId='';
		tempObj.descName='';
		tempObj.specification='';
		tempObj.assignToId='';
		tempObj.startTime='';
		tempObj.startTimeStr='';
		tempObj.finishTime='';
		tempObj.finishTimeStr='';
		return tempObj ;
	};
	
	$scope.addNewDescription = function() {
		$scope.taskObj.createNewDesc='';
	};
	
	$scope.SubmitNewDesc = function() {
		var response = $http({
			method: 'POST',
			url: "newPageFiles/task_files/submitNewDescription.php",
			data: $.param({'newDesc':$scope.taskObj.createNewDesc}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.taskObj.createNewDesc='';
			$('#addDescriptionDialog').modal('toggle');
			$scope.getNecessaryList();
		});
		response.error(function (data, status, headers, config) {
			alert("Error.");
		});
	};
	
	$scope.initCal = function(ind, type, call) {
		if (call=='C') {
			if (type=='S') {
				$timeout(function () {
					$('#startDateTime_'+ind).datetimepicker("setDate", "");
					$('#startDateTime_'+ind).val("");
					$scope.taskObj.taskDetails[ind].startTime='';
					$scope.taskObj.taskDetails[ind].startTimeStr='';
				}, 20);
			} else if (type=='F') {
				$timeout(function () {
					$('#finishDateTime_'+ind).datetimepicker("setDate", "");
					$('#finishDateTime_'+ind).val("");
					$scope.taskObj.taskDetails[ind].finishTime='';
					$scope.taskObj.taskDetails[ind].finishTimeStr='';
				}, 20);
			}
		} else if (call=='N') {
			if (type=='S') {
				if ($scope.isNullOrEmptyOrUndefined($scope.taskObj.taskDetails[ind].finishTime)==true && $scope.isNullOrEmptyOrUndefined($scope.taskObj.taskDetails[ind].finishTimeStr)==true) {
					$scope.taskObj.taskDetails[ind].startTime=(moment().format('MM/DD/YYYY hh:mm A'));
					$scope.taskObj.taskDetails[ind].startTimeStr=(moment().format('YYYY-MM-DD HH:mm:ss'));
					if ($('#finishDateTime_'+ind).data("DateTimePicker")) {
						$('#finishDateTime_'+ind).data("DateTimePicker").minDate(moment());
					}
				} else {
					$scope.taskObj.taskDetails[ind].startTime=$scope.taskObj.taskDetails[ind].finishTime;
					$scope.taskObj.taskDetails[ind].startTimeStr=$scope.taskObj.taskDetails[ind].finishTimeStr;
					if ($('#finishDateTime_'+ind).data("DateTimePicker")) {
						$('#finishDateTime_'+ind).data("DateTimePicker").minDate(moment($scope.taskObj.taskDetails[ind].finishTimeStr));
					}
				}
			} else if (type=='F') {
				$scope.taskObj.taskDetails[ind].finishTime=(moment().format('MM/DD/YYYY hh:mm A'));
				$scope.taskObj.taskDetails[ind].finishTimeStr=(moment().format('YYYY-MM-DD HH:mm:ss'));
				if ($('#startDateTime_'+ind).data("DateTimePicker")) {
					$('#startDateTime_'+ind).data("DateTimePicker").maxDate(moment());
				}
			}
		} else {
			if (type=='S') {
				$('#startDateTime_'+ind).trigger('focus');
				$timeout(function () {
					$('#startDateTime_'+ind).datetimepicker("setDate", "");
					$('#startDateTime_'+ind).val("");
					$scope.taskObj.taskDetails[ind].startTime='';
					$scope.taskObj.taskDetails[ind].startTimeStr='';
				}, 20);
			} else if (type=='F') {
				$('#finishDateTime_'+ind).trigger('focus');
				$timeout(function () {
					$('#finishDateTime_'+ind).datetimepicker("setDate", "");
					$('#finishDateTime_'+ind).val("");
					$scope.taskObj.taskDetails[ind].finishTime='';
					$scope.taskObj.taskDetails[ind].finishTimeStr='';
				}, 20);
			}
		}
	};
	
	$scope.addTask = function() {
		var getData=$scope.getWorkOrderTaskDet();
		$scope.taskObj.taskDetails.push(getData);
	};
	
	$scope.removeTask = function (indx) {
		var newItems=[];
		angular.forEach($scope.taskObj.taskDetails, function(value, index) {
			if (index != indx) {
				newItems.push(value);
			}
		}); 
		if (parseInt(newItems.length)==0) {
			var getData=$scope.getWorkOrderTaskDet();
			var tempArray=[];
			tempArray.push(getData);
			$scope.taskObj.taskDetails=tempArray;
		} else {
			$scope.taskObj.taskDetails=newItems;
		}
		$scope.resetStartEndDate();
	};
	
	$scope.submitTaskData = function() {
		$scope.taskObj.submitTask=true;
		if (parseInt($scope.taskObj.taskDetails.length)>0) {
			var errCount=0;
			var tcount=0;
			angular.forEach($scope.taskObj.taskDetails, function(tvalue, tindex) {
				if ($scope.isNullOrEmptyOrUndefined(tvalue.descId)==true) {
					errCount++ ;
				}
				if ($scope.isNullOrEmptyOrUndefined(tvalue.specification)==true) {
					errCount++ ;
				}
				if ($scope.isNullOrEmptyOrUndefined(tvalue.assignToId.adminid)==true) {
					errCount++ ;
				}
				if ($scope.isNullOrEmptyOrUndefined(tvalue.startTimeStr)==true && $scope.isNullOrEmptyOrUndefined(tvalue.finishTimeStr)==false) {
					errCount++ ;
				}
				if ($scope.isNullOrEmptyOrUndefined(tvalue.startTimeStr)==false && $scope.isNullOrEmptyOrUndefined(tvalue.finishTimeStr)==false) {
					if (parseInt($scope.toJSDate(tvalue.startTimeStr))>parseInt($scope.toJSDate(tvalue.finishTimeStr))) {
						errCount++ ;
						tcount++ ;
					}
				}
			});
			if (parseInt(tcount)>0) {
				$scope.smallNotify("Finish Time Must Be After Start Time", null, null, 'danger', 'centerNotifications');
			}
			if (parseInt(errCount)>0) {
				$timeout(function () {
					$scope.taskObj.submitTask=false;
				}, 2560);
				return false ;
			} else {
				var response = $http({
					method: 'POST',
					url: "newPageFiles/task_files/submitTaskDetails.php",
					data: $.param({'workOrderId':$scope.selectedPalletID, 'moduleType': 'WO', 'taskDetails': $scope.taskObj.taskDetails}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
				});
				response.success(function (data, status, headers, config) {
					$scope.taskObj.taskTabChanger='thisWorkOrder'; 
					$scope.tabChanger();
				});
				response.error(function (data, status, headers, config) {
					alert("Error.");
				});
			}
		} else {
			$scope.smallNotify("Error in Task Save.", null, null, 'danger', 'centerNotifications');
		}
	};
	
	$scope.moveTask = function(indx, direc) {
		if (parseInt(indx)>=0) {
			var movableObj={};
			movableObj.tid=$scope.taskObj.taskDetails[indx].tid;
			movableObj.templateId=$scope.taskObj.taskDetails[indx].templateId;
			movableObj.tOrder=$scope.taskObj.taskDetails[indx].tOrder;
			movableObj.descId=$scope.taskObj.taskDetails[indx].descId;
			movableObj.descName=$scope.taskObj.taskDetails[indx].descName;
			movableObj.specification=$scope.taskObj.taskDetails[indx].specification;
			movableObj.assignToId=$scope.taskObj.taskDetails[indx].assignToId;
			movableObj.startTime=$scope.taskObj.taskDetails[indx].startTime;
			movableObj.startTimeStr=$scope.taskObj.taskDetails[indx].startTimeStr;
			movableObj.finishTime=$scope.taskObj.taskDetails[indx].finishTime;
			movableObj.finishTimeStr=$scope.taskObj.taskDetails[indx].finishTimeStr;
			if (direc=='U') {
				var replacebleObj={};
				replacebleObj.tid=$scope.taskObj.taskDetails[indx-1].tid;
				replacebleObj.templateId=$scope.taskObj.taskDetails[indx-1].templateId;
				replacebleObj.tOrder=$scope.taskObj.taskDetails[indx-1].tOrder;
				replacebleObj.descId=$scope.taskObj.taskDetails[indx-1].descId;
				replacebleObj.descName=$scope.taskObj.taskDetails[indx-1].descName;
				replacebleObj.specification=$scope.taskObj.taskDetails[indx-1].specification;
				replacebleObj.assignToId=$scope.taskObj.taskDetails[indx-1].assignToId;
				replacebleObj.startTime=$scope.taskObj.taskDetails[indx-1].startTime;
				replacebleObj.startTimeStr=$scope.taskObj.taskDetails[indx-1].startTimeStr;
				replacebleObj.finishTime=$scope.taskObj.taskDetails[indx-1].finishTime;
				replacebleObj.finishTimeStr=$scope.taskObj.taskDetails[indx-1].finishTimeStr;
				$scope.taskObj.taskDetails[indx]={};
				$scope.taskObj.taskDetails[indx]=replacebleObj;
				$scope.taskObj.taskDetails[indx-1]={};
				$scope.taskObj.taskDetails[indx-1]=movableObj;
			} else if (direc=='D') {
				var replacebleObj={};
				replacebleObj.tid=$scope.taskObj.taskDetails[indx+1].tid;
				replacebleObj.templateId=$scope.taskObj.taskDetails[indx+1].templateId;
				replacebleObj.tOrder=$scope.taskObj.taskDetails[indx+1].tOrder;
				replacebleObj.descId=$scope.taskObj.taskDetails[indx+1].descId;
				replacebleObj.descName=$scope.taskObj.taskDetails[indx+1].descName;
				replacebleObj.specification=$scope.taskObj.taskDetails[indx+1].specification;
				replacebleObj.assignToId=$scope.taskObj.taskDetails[indx+1].assignToId;
				replacebleObj.startTime=$scope.taskObj.taskDetails[indx+1].startTime;
				replacebleObj.startTimeStr=$scope.taskObj.taskDetails[indx+1].startTimeStr;
				replacebleObj.finishTime=$scope.taskObj.taskDetails[indx+1].finishTime;
				replacebleObj.finishTimeStr=$scope.taskObj.taskDetails[indx+1].finishTimeStr;
				$scope.taskObj.taskDetails[indx]={};
				$scope.taskObj.taskDetails[indx]=replacebleObj;
				$scope.taskObj.taskDetails[indx+1]={};
				$scope.taskObj.taskDetails[indx+1]=movableObj;
			}
		}
		$scope.resetStartEndDate();
	};
	
	$scope.resetStartEndDate = function() {
		angular.forEach($scope.taskObj.taskDetails, function(tvalue, tindex) {
			if ($scope.isNullOrEmptyOrUndefined(tvalue.startTimeStr)==false) {
				if ($('#finishDateTime_'+tindex).data("DateTimePicker")) {
					$('#finishDateTime_'+tindex).data("DateTimePicker").minDate(moment(tvalue.startTimeStr));
				}
			} else {
				if ($('#finishDateTime_'+tindex).data("DateTimePicker")) {
					$('#finishDateTime_'+tindex).data("DateTimePicker").minDate(false);
				}
			}
			if ($scope.isNullOrEmptyOrUndefined(tvalue.finishTimeStr)==false) {
				if ($('#startDateTime_'+tindex).data("DateTimePicker")) {
					$('#startDateTime_'+tindex).data("DateTimePicker").maxDate(moment(tvalue.finishTimeStr));
				}
			} else {
				if ($('#startDateTime_'+tindex).data("DateTimePicker")) {
					$('#startDateTime_'+tindex).data("DateTimePicker").maxDate(false);
				}
			}
		});
	};
	
	$scope.changeDesc = function(paramObj, indx, typ) {
		if ($scope.isNullOrEmptyOrUndefined(paramObj.descId)==false && parseInt(indx)>=0) {
			$scope.taskObj.applicableIndex=indx ;
			if (typ=='D') {
				if (paramObj.descName=='Create IPU Rolls' && parseInt(paramObj.isBehave)>0) {
					$scope.taskObj.taskDetails[indx].specification='Work Order '+$scope.selectedPalletID ;
					$scope.taskObj.taskDetails[indx].descName='';
				} else if (paramObj.descName=='Scan Pallet' && parseInt(paramObj.isBehave)>0) {
					$scope.taskObj.taskDetails[indx].specification='PALLET#'+$scope.palletDet.palletNum ;
					$scope.taskObj.taskDetails[indx].descName='';
				} else if (paramObj.descName=='Weigh/Wrap Pallet' && parseInt(paramObj.isBehave)>0) {
					$scope.taskObj.taskDetails[indx].specification='PALLET#'+$scope.palletDet.palletNum ;
					$scope.taskObj.taskDetails[indx].descName='';
				} else {
					$scope.taskObj.taskDetails[indx].specification='';
					$scope.taskObj.taskDetails[indx].descName='';
					$('#dname_'+indx).val('');
					$('#specname_'+indx).val('');
				}
			} else if (typ=='S') {
				if (paramObj.descName=='Pick Master Roll' && parseInt(paramObj.isBehave)>0) {
					$scope.getSpecMasterRolls();
				} else if (paramObj.descName=='Create Pallet' && parseInt(paramObj.isBehave)>0) {
					$scope.getPalletSize(1);
				}
			}
		} else {
			$scope.taskObj.taskDetails[indx].specification='';
			$scope.taskObj.taskDetails[indx].descName='';
			$('#dname_'+indx).val('');
			$('#specname_'+indx).val('');
		}
	};
	
	$scope.getSpecMasterRolls = function() {
		$scope.searchSpecMasterRoll={};
		$('#specMasterRollDialog').modal({backdrop: 'static', keyboard: false});
		$scope.showSpecMasterRollsContainer();
	};
	
	$scope.showSpecMasterRollsContainer = function() {
		if (! $.fn.DataTable.isDataTable('#specMasterRollsContainer')) {
			var passarray= [
				{"data": "rid", "name": "rid", "bVisible": true, "bSearchable": false, "bSortable":false},
				{"data": "rollDate", "name": "rollDate", "bVisible": true, "bSearchable": false, "bSortable":true},
				{"data": "rollNum", "name": "rollNum", "bVisible": true, "bSearchable": false, "bSortable":true},
				{"data": "Style", "name": "Style", "bVisible": true, "bSearchable": false, "bSortable":true},
				{"data": "Length", "name": "Length", "bVisible": true, "bSearchable": false, "bSortable":true},
				{"data": "Quality", "name": "Quality", "bVisible": true, "bSearchable": false, "bSortable":true},
				{"data": "Station", "name": "Station", "bVisible": true, "bSearchable": false, "bSortable":true},
				{"data": "Pallet", "name": "Pallet", "bVisible": true, "bSearchable": false, "bSortable":false},
			] ;
			$scope.masterRollsContainer = $('#specMasterRollsContainer').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource":  "getPalletMasterRolls.php",
				"aoColumns": passarray,
				"columnDefs": [
					{"className": "dt-center", "targets": "_all"}
				],
				"order": [[ 2, "desc" ]],
				"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
					aoData.push(
						{"name": "styleFirstFour","value":$scope.palletDet.styleFirstFour}, 
						{"name": "palletID","value":$scope.selectedPalletID},
						{"name": "searchMasterRollDate","value":$scope.searchSpecMasterRoll.Date},
						{"name": "searchMasterRollName","value":$scope.searchSpecMasterRoll.Name},
						{"name": "searchMasterRollStyle","value":$scope.searchSpecMasterRoll.Style},
						{"name": "searchMasterRollLength","value":$scope.searchSpecMasterRoll.Length},
						{"name": "searchMasterRollQuality","value":$scope.searchSpecMasterRoll.Quality},
						{"name": "searchMasterRollStation","value":$scope.searchSpecMasterRoll.Station},
						{"name": "searchMasterRollPallet","value":$scope.searchSpecMasterRoll.Pallet}
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
					$(nRow).css("cursor", "pointer");
				},
				"fnCreatedRow": function( nRow, aData, iDataIndex ){
					$compile(nRow)($scope);
				},
			});
			var data_table = $('#specMasterRollsContainer').DataTable();
			$('#specMasterRollsContainer .zsearch_inputz').on('keyup',function(event) {
				data_table.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('#specMasterRollsContainer_filter.dataTables_filter').hide();
			var table = $('#specMasterRollsContainer').DataTable();
			$('#specMasterRollsContainer tbody').on('click', 'tr', function () {
				var data = table.row( this ).data();
				var frollid=data.frollid ;
				var frollName=data.rollNum ;
				$scope.taskObj.taskDetails[$scope.taskObj.applicableIndex].specification=frollName;
				$scope.taskObj.taskDetails[$scope.taskObj.applicableIndex].descName=frollid;
				$('#dname_'+$scope.taskObj.applicableIndex).val(frollid);
				$('#specname_'+$scope.taskObj.applicableIndex).val(frollName);
				$('#specMasterRollDialog').modal('toggle');
			});
		} else {
			var dataTable = $('#specMasterRollsContainer').DataTable();
			dataTable.draw();
		}
    };
	
	$scope.getPalletSize = function(ind) {
		$scope.taskObj.sizeList=[];
		var response = $http({
			method: 'POST',
			url: "newPageFiles/task_files/getPalletSizeDetails.php",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.taskObj.sizeList=data.sizeList ;
			if (parseInt(ind)>0) {
				$('#sizeModal').modal({backdrop: 'static', keyboard: false});
			}
		});
		response.error(function (data, status, headers, config) {
			alert("Error.");
		});
	};
	
	$scope.dismisDescSpec = function() {
		var tempObj={};
		tempObj.descId='';
		tempObj.descName='¿'; 
		tempObj.isBehave=0 ;
		$scope.taskObj.taskDetails[$scope.taskObj.applicableIndex].descId=tempObj;
		$scope.taskObj.taskDetails[$scope.taskObj.applicableIndex].specification='' ;
		$scope.taskObj.taskDetails[$scope.taskObj.applicableIndex].descName='' ;
	};
	
	$scope.goToAddSize = function() {
		var cnt=0;
		angular.forEach($scope.taskObj.sizeList, function(tvalue, tkey) {
			cnt=cnt+350 ;
		});
		$scope.scrolled=cnt;
		$("#sizeContainer").animate({
			scrollTop:  $scope.scrolled
		});
		$('.zmanclassz').last().focus();
	};
	
	$scope.createNewSize = function (indx, editval, deleteval) {
		var height=$scope.taskObj.sizeList[indx].height ;
		var length=$scope.taskObj.sizeList[indx].length ;
		var width=$scope.taskObj.sizeList[indx].width ;
		if (parseInt(height)>0 && parseInt(length)>0 && parseInt(width)>0) {
			$scope.taskObj.sizeList[indx].isEdit=editval ;
			$scope.taskObj.sizeList[indx].isDelete=deleteval ;
			var response = $http({
				method: 'POST',
				url: "orderProcessing/saveSizeData.php",
				data: $.param({'sizeData': $scope.taskObj.sizeList[indx], 'assignData': 0}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				if (parseInt(editval)==0 && parseInt(deleteval)==0) {
					$scope.taskObj.taskDetails[$scope.taskObj.applicableIndex].specification=height+'X'+width+'X'+length ;
					$scope.taskObj.taskDetails[$scope.taskObj.applicableIndex].descName=data.returnId ;
					$('#sizeModal').modal('toggle');
				} else {
					$scope.getPalletSize(0);
				}
			});
			response.error(function (data, status, headers, config) {
				$('.overlayWholePage').hide();
				console.log("Error2.");
			});
		} else {
			$scope.smallNotify("Proper Measurement Required.", null, null, 'danger', 'centerNotifications');
		}
	};
	
	$scope.initEditSize = function (indx, val) {
		if (val==0) {
			var psize=$scope.taskObj.sizeList[indx].pSize ;
			var psizeArr=psize.split('X');
			$scope.taskObj.sizeList[indx].height=psizeArr[0] ;
			$scope.taskObj.sizeList[indx].width=psizeArr[1] ;
			$scope.taskObj.sizeList[indx].length=psizeArr[2] ;
		}
		$scope.taskObj.sizeList[indx].isEdit=val ;
	};
	
	$scope.initDeleteSize = function (indx, val) {
		$scope.taskObj.sizeList[indx].isDelete=val ;
	};
	
	$scope.assignSize = function (indx) {
		var tval=$scope.taskObj.sizeList[indx].pSize ;
		var tvalId=$scope.taskObj.sizeList[indx].pId ;
		$scope.taskObj.taskDetails[$scope.taskObj.applicableIndex].specification=tval ;
		$scope.taskObj.taskDetails[$scope.taskObj.applicableIndex].descName=tvalId ;
		$('#sizeModal').modal('toggle');
	};
	
	$scope.createTemplate = function (tempId) {
		if ($scope.isNullOrEmptyOrUndefined(tempId)==true) {
			$scope.taskObj.templateObj={};
			$scope.taskObj.submitTemp=false;
			$scope.taskObj.templateObj.templateId=0;
			$scope.taskObj.templateObj.templateName='';
			$scope.taskObj.templateObj.templateList=[];
			angular.forEach($scope.taskObj.taskDetails, function(tvalue, tindex) {
				$scope.taskObj.templateObj.templateList.push(tvalue.descId);
			});
		} else {
			$scope.taskObj.templateObj={};
			$scope.taskObj.templateObj.templateId=tempId;
			$scope.taskObj.templateObj.templateName=$('#tempName_'+tempId).val();
			var tempTaskString=$('#tempData_'+tempId).val() ;
			var tempTaskArray=tempTaskString.split('|~|');
			var tempArray=[];
			angular.forEach(tempTaskArray, function(tvalue, tindex) {
				if ($scope.isNullOrEmptyOrUndefined(tvalue)==false) {
					var tValArray=tvalue.split('|-|');
					var specName=($scope.isNullOrEmptyOrUndefined(tValArray[2])==false)? tValArray[2] : '' ;
					var tempObj={};
					tempObj.descName=specName ;
					tempArray.push(tempObj) ;
				}
			});
			$scope.taskObj.templateObj.templateList=tempArray ;
		}
	};

	$scope.submitTemplate = function () {
		$scope.taskObj.submitTemp=true;
		if ($scope.isNullOrEmptyOrUndefined($scope.taskObj.templateObj.templateName)==true) {
			$timeout(function () {
				$scope.taskObj.submitTemp=false;
			}, 2560);
			return false ;
		} else if (parseInt($scope.taskObj.templateObj.templateList.length)==0) {
			$scope.smallNotify("Atleast One Task Required", null, null, 'danger', 'centerNotifications');
			return false ;
		} else {
			var response = $http({
				method: 'POST',
				url: "newPageFiles/task_files/submitTemplate.php",
				data: $.param({'workOrderId':$scope.selectedPalletID, 'templateData': $scope.taskObj.templateObj, 'moduleType': 'WO'}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				if (data.status=='duplicate') {
					$scope.smallNotify("Duplicate Template Name Not Allowed", null, null, 'danger', 'centerNotifications');
					return false ;
				} else if (data.status=='error') {
					$scope.smallNotify("Unknown Error Occured", null, null, 'danger', 'centerNotifications');
					return false ;
				} else if (data.status=='success') {
					$('#createTemplateDialog').modal('toggle');
					$scope.smallNotify("Template Created Successfully", null, null, 'success', 'centerNotifications');
					$scope.taskObj.taskTabChanger='template'; 
					$scope.tabChanger();
				}
			});
			response.error(function (data, status, headers, config) {
				alert("Error.");
			});
		}
	};
	
	$scope.getTemplateList = function () {
		if (! $.fn.DataTable.isDataTable('#taskTemplateListContainer')) {
			var passarray= [
				{"data": "tid", "name": "tid", "bVisible": false, "bSearchable": false, "bSortable":false},
				{"data": "taskName", "name": "taskName", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "numOfTask", "name": "numOfTask", "bVisible": true, "bSearchable": false, "bSortable":true},
				{"data": "numOfTimeUsed", "name": "numOfTimeUsed", "bVisible": true, "bSearchable": false, "bSortable":true},
				{"data": "viewTask", "name": "viewTask", "bVisible": true, "bSearchable": false, "bSortable":false},
				{"data": "useTemplate", "name": "useTemplate", "bVisible": true, "bSearchable": false, "bSortable":false},
			] ;
			$scope.masterRollsContainer = $('#taskTemplateListContainer').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource":  "newPageFiles/task_files/getTemplateList.php",
				"aoColumns": passarray,
				"columnDefs": [
						{ "className": "dt-center", "targets": [2, 3, 4] },
						{ "className": "pl10", "targets": [1] }
				],
				"order": [[ 3, "desc" ]],
				"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
					aoData.push(
						{"name": "searchTemplateName","value":$scope.searchTemplate.Name}
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
					
				},
				"fnCreatedRow": function( nRow, aData, iDataIndex ){
					$compile(nRow)($scope);
				},
			});
			var data_table = $('#taskTemplateListContainer').DataTable();
			$('#taskTemplateListContainer .zsearch_inputz').on('keyup',function(event) {
				data_table.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('#taskTemplateListContainer_filter.dataTables_filter').hide();
			$('#taskTemplateListContainer_length label').css('margin-right','0%');
			$('#taskTemplateListContainer_length').css('display','none');	
			$('#taskTemplateListContainer_paginate').css('margin-top','5px');
		} else {
			var dataTable = $('#taskTemplateListContainer').DataTable();
			dataTable.draw();
		}
	};
	
	$scope.assignTemplate = function (tempId) {
		$scope.taskObj.assignTemp={};
		$scope.taskObj.assignTemp.templateId=tempId;
		$scope.taskObj.assignTemp.templateName=$('#tempName_'+tempId).val();
		var hasValue=0;
		if ($scope.isNullOrEmptyOrUndefined($scope.taskObj.taskDetails)==false && parseInt($scope.taskObj.taskDetails.length)>0) {
			angular.forEach($scope.taskObj.taskDetails, function(taskvalue, taskindex) {
				if ($scope.isNullOrEmptyOrUndefined(taskvalue.descId.descId)==false) {
					hasValue++ ;
				}
			});
		}
		$scope.taskObj.assignTemp.hasValue=hasValue ;
	};
	
	$scope.applyTemplateToTask = function() {
		var tempArray=[];
		if (parseInt($scope.taskObj.assignTemp.templateId)>0) {
			var tempTaskString=$('#tempData_'+$scope.taskObj.assignTemp.templateId).val() ;
			var tempTaskArray=tempTaskString.split('|~|');
			if (parseInt(tempTaskArray.length)>0) {
				$scope.taskObj.taskDetails=[];
				angular.forEach(tempTaskArray, function(tvalue, tindex) {
					if ($scope.isNullOrEmptyOrUndefined(tvalue)==false) {
						var tValArray=tvalue.split('|-|');
						var taskOrder=($scope.isNullOrEmptyOrUndefined(tValArray[0])==false)? tValArray[0] : 0 ;
						var taskTemplateDetailsId=($scope.isNullOrEmptyOrUndefined(tValArray[1])==false)? tValArray[1] : 0 ;
						var descriptionName=($scope.isNullOrEmptyOrUndefined(tValArray[2])==false)? tValArray[2] : '' ;
						var descriptionId=($scope.isNullOrEmptyOrUndefined(tValArray[3])==false)? tValArray[3] : 0 ;
						var isBehave=($scope.isNullOrEmptyOrUndefined(tValArray[4])==false)? tValArray[4] : 0 ;
						var descObj={};
						descObj.descId=descriptionId ;
						descObj.descName=descriptionName ;
						descObj.isBehave=isBehave ;
						var taskData=$scope.getWorkOrderTaskDet();
						taskData.descId=descObj ;
						taskData.templateId=$scope.taskObj.assignTemp.templateId ;
						taskData.tOrder=taskOrder ;
						if (descriptionName=='Create IPU Rolls' && parseInt(isBehave)>0) {
							taskData.specification='Work Order '+$scope.selectedPalletID ;
							taskData.descName='';
						} else if (descriptionName=='Scan Pallet' && parseInt(isBehave)>0) {
							taskData.specification='PALLET#'+$scope.palletDet.palletNum ;
							taskData.descName='';
						} else if (descriptionName=='Weigh/Wrap Pallet' && parseInt(isBehave)>0) {
							taskData.specification='PALLET#'+$scope.palletDet.palletNum ;
							taskData.descName='';
						}
						tempArray.push(taskData);
					}
				});
			}
		}
		$scope.taskObj.taskDetails=tempArray ;
		$timeout(function () {
			$('#confirmAssignTemplateDialog').modal('toggle');
			$scope.smallNotify("Template Assigned Successfully", null, null, 'success', 'centerNotifications');
			$scope.taskObj.taskTabChanger='thisWorkOrder';
			$scope.taskObj.submitTask=false;
			$scope.taskObj.hasTask=0;
			$scope.getNecessaryList();
		}, 20);
		
	};
	
	$scope.toJSDate = function ( dateTime ) {
		var dateTime = dateTime.split(" ");//dateTime[0] = date, dateTime[1] = time
		var date = dateTime[0].split("-");
		var time = dateTime[1].split(":");
		return new Date(date[2], (date[1]-1), date[0], time[0], time[1], time[2], 0).getTime();
	}
	
	$scope.parseInt = parseInt ;
	$scope.parseFloat = parseFloat ;
	$scope.isObjectOrNot = function (val) {
		return angular.isObject(val);
	};
	
	$scope.smallNotify = function (text, callback, close_callback, style, typ) {
		var time = '4000';
		var $container = $('.'+typ);
		var icon = '<i class="fa fa-info-circle "></i>';
		var styler= ($scope.isNullOrEmptyOrUndefined(style)==false)? style : 'danger' ;
		var html = $('<div class="alert alert-' + styler + '  hide"><div class="clear"></div>' + icon +  " " + text + '</div>');
		$('<a>',{
			text: '×',
			class: 'button close',
			style: 'padding-left: 10px;',
			href: '#',
			click: function(e){
				e.preventDefault()
				close_callback && close_callback()
				remove_notice()
			}
		}).prependTo(html)
		$container.prepend(html)
		html.removeClass('hide').hide().fadeIn('slow')

		function remove_notice() {
			html.stop().fadeOut('slow').remove()
		}
	
		var timer =  setInterval(remove_notice, time);

		$(html).hover(function(){
			clearInterval(timer);
		}, function(){
			timer = setInterval(remove_notice, time);
		});
	
		html.on('click', function () {
			clearInterval(timer)
			callback && callback()
			remove_notice()
		});
	};
});