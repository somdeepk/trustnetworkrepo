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
mainApp.controller('inspectionController', ['$rootScope', '$timeout', '$interval', '$scope', '$http', '$compile', '$filter', 'ngDialog', function($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, ngDialog) {
	$scope.tableSwitcher=1;
	$scope.workOrderNum='';
	$scope.palletId='';
	$scope.inspectorUser='';
	$scope.userDisplayName='';
	$scope.batcherRollName='';
	$scope.batcherRollStyle='';
	$scope.batcherRollFSSID='';
	$scope.userList='';
	$scope.workOrderList=[];
	$scope.workOrder={};
	$scope.workOrder.listType='AS';
	$scope.rollPickFor='';
	$scope.pickedUpRoll='';
	$scope.pickedUpRollError='';
	$scope.pickedUpRollDetails='';
	$scope.backTableRolls='';
	$scope.backTableRollsCount=0;
	$scope.middleTableRolls='';
	$scope.middleTableRollsCount=0;
	$scope.showMasterRollCaution='';
	$scope.showHangRollCaution='';
	$scope.hangRollDetails='';
	$scope.trashDefectType='';
	$scope.trashDefectReason='';
	$scope.trashDefectLength='' ;
	$scope.trashDefectComment='' ;
	$scope.trashDefectError='' ;
	$scope.trashDefectId='' ;
	$scope.trashDefectRemove='' ;
	$scope.trashArray='' ;
	$scope.defectNum='' ;
	$scope.defectDetailsArray='' ;
	$scope.createRoll={};
	$scope.createRollErrorArray=[];
	$scope.rollSplit='';
	$scope.batcherRollArray=[];
	$scope.defectSheetFor='';
	$scope.loadRunning='';
	$scope.selectedWorkOrderStyleId='';
	$scope.evsData={};
	$scope.MyInterval = $interval( function() { $scope.showMiddleTable(); }, 60000);
	$scope.initInspection = function(param) {
		angular.element(document).ready(function () {
			$scope.tableSwitcher=($scope.isNullOrEmptyOrUndefined(param)==false)? param : 1;
			$scope.emptyFullAllocation();
			$scope.showMiddleTable();
			$scope.switchTable();
		});
	};
	
	$scope.showMiddleTable =function() {
		if ($scope.isNullOrEmptyOrUndefined($scope.tableSwitcher)==false) {
			var response = $http({
				method: 'POST',
				url: "inspectionPages/showMiddleTable.php",
				data: $.param({'tableSwitcher': $scope.tableSwitcher, 'inspectorUser': $scope.inspectorUser}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				if (data) {
					if ($scope.isNullOrEmptyOrUndefined(data.middleTableRollArray)==false) {
						$scope.middleTableRolls=data.middleTableRollArray ;
						$scope.middleTableRollsCount=Object.keys($scope.middleTableRolls).length ;
					}
				}
			});
			response.error(function (data, status, headers, config) {
				console.log("Error0."+data);
			});
		}
	};
	
	$scope.switchTable = function(paramDet) {
		$scope.loadRunning=1;
		var response = $http({
			method: 'POST',
			url: "inspectionPages/inspectSwitchTable.php",
			data: $.param({'tableSwitcher': $scope.tableSwitcher}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.loadRunning='';
			if (data) {
				$scope.workOrderNum='';
				$scope.palletId='';
				$scope.inspectorUser='';
				$scope.userDisplayName='';
				$scope.backTableRolls='';
				$scope.backTableRollsCount=0;
				$scope.hangRollDetails='';
				$scope.batcherRollName='';
				$scope.batcherRollStyle='';
				$scope.batcherRollFSSID='';
				$scope.rollSplit='' ;
				$scope.batcherRollArray=[];
				$scope.defectSheetFor='';
				$scope.defectDetailsArray='' ;
				$scope.selectedWorkOrderStyleId='';
				$scope.evsData={};
				if ($scope.isNullOrEmptyOrUndefined(data.workOrderNum)==false) {
					$scope.workOrderNum=data.workOrderNum ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.palletId)==false) {
					$scope.palletId=data.palletId ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.inspectorUser)==false) {
					$scope.inspectorUser=data.inspectorUser ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.userDisplayName)==false) {
					$scope.userDisplayName=data.userDisplayName ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.backTableRollArray)==false) {
					$scope.backTableRolls=data.backTableRollArray ;
					$scope.backTableRollsCount=Object.keys($scope.backTableRolls).length ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.hangRollArray)==false) {
					$scope.hangRollDetails=data.hangRollArray ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.batcherRollName)==false) {
					$scope.batcherRollName=data.batcherRollName ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.batcherRollStyle)==false) {
					$scope.batcherRollStyle=data.batcherRollStyle ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.batcherRollFSSID)==false) {
					$scope.batcherRollFSSID=data.batcherRollFSSID ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.selectedWorkOrderStyleId)==false) {
					$scope.selectedWorkOrderStyleId=data.selectedWorkOrderStyleId ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.rollSplit)==false) {
					$scope.rollSplit=data.rollSplit ;
				}
				if ($scope.isNullOrEmptyOrUndefined(data.defectDetailsArray)==false) {
					var defectDetailsArrayCount=Object.keys(data.defectDetailsArray).length ;
					if (defectDetailsArrayCount>0) {
						$scope.defectDetailsArray=data.defectDetailsArray ;
					}
				}
				if ($scope.isNullOrEmptyOrUndefined($scope.batcherRollName)==false) {
					angular.forEach($(data.defectDetailsArray), function(aDataValue, aDataKey) {
						var tempObj={};
						tempObj.rollName=aDataValue.ondefect_rollname ;
						tempObj.styleName=aDataValue.ondefect_rollstyle ;
						tempObj.styleFSS=aDataValue.ondefect_rollfss ;
						$scope.batcherRollArray.push(tempObj);
					});
					
					if ($scope.isNullOrEmptyOrUndefined(paramDet)==false) {
						$scope.defectSheetFor=paramDet ;
					} else {
						if ($scope.isNullOrEmptyOrUndefined($scope.batcherRollArray[0])==false) {
							$scope.defectSheetFor=$scope.batcherRollArray[0] ;
						}
					}
				}
				$scope.showMiddleTable();
			}
		});
		response.error(function (data, status, headers, config) {
			$scope.loadRunning='';
			console.log("Error1."+data);
		});
	};
	
	$scope.changeTable = function(typ) {
		$scope.emptyFullAllocation();
		$scope.tableSwitcher=typ;
		$scope.switchTable();
	};
	
	$scope.setUser = function(userDetails) {
		$scope.loadRunning=1;
		var response = $http({
			method: 'POST',
			url: "inspectionPages/setTable.php",
			data: $.param({'userDetails': userDetails, 'tableSwitcher':$scope.tableSwitcher}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.loadRunning='';
			if (data) {
				if (data==1) {
					$scope.inspectorUser=userDetails.adminid ;
					$scope.userDisplayName=userDetails.userFullName ;
				}
				$('#inspector').modal('toggle');
			}
		});
		response.error(function (data, status, headers, config) {
			$scope.loadRunning='';
			console.log("Error2."+data);
		});
	};
	
	$scope.setWorkOrder = function(workorderDetails) {
		$scope.loadRunning=1;
		var response = $http({
			method: 'POST',
			url: "inspectionPages/setTable.php",
			data: $.param({'workorderDetails': workorderDetails, 'tableSwitcher':$scope.tableSwitcher}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.loadRunning='';
			if (data) {
				if (parseInt(data)>0) {
					$scope.workOrderNum=workorderDetails.workOrderNum;
					$scope.palletId=workorderDetails.palletId;
					$scope.switchTable();
				}
				$('#workOrderModal').modal('toggle');
			}
		});
		response.error(function (data, status, headers, config) {
			$scope.loadRunning='';
			console.log("Error3."+data);
		});
	};
	
	$scope.checkRoll = function() {
		if ($scope.isNullOrEmptyOrUndefined($scope.pickedUpRoll)==false) {
			if ($.trim($scope.pickedUpRoll)=='') {
				$scope.pickedUpRollError='Roll Id Required';
			} else {
				$scope.loadRunning=1;
				var response = $http({
					method: 'POST',
					url: "inspectionPages/checkInspectionRoll.php",
					data: $.param({'rollPickFor': $scope.rollPickFor, 'tableSwitcher':$scope.tableSwitcher, 'pickedUpRoll':$.trim($scope.pickedUpRoll), 'palletId':$scope.palletId}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
				});
				response.success(function (data, status, headers, config) {
					$scope.loadRunning='';
					$scope.pickedUpRollError='';
					$scope.showMasterRollCaution='';
					$scope.showHangRollCaution='';
					if ($scope.isNullOrEmptyOrUndefined(data.rollsArray)==false) {
						if ($scope.isNullOrEmptyOrUndefined(data.rollsArray.frollid)==false) {
							$scope.pickedUpRollDetails=data.rollsArray ;
							if (data.countRollNum>0) {
								$('#backTable').modal('toggle');
								$('#rollInfo').modal('toggle');
							} else {
								if ($scope.rollPickFor=='BACKTABLE') {
									$scope.showMasterRollCaution=1 ;
								} else if ($scope.rollPickFor=='HANGTABLE') {
									$scope.showHangRollCaution=1 ;
								}
							}
						} else {
							$scope.pickedUpRollError='Invalid Roll Id';
						}
					} else {
						$scope.pickedUpRollError='Invalid Roll Id';
					}
				});
				response.error(function (data, status, headers, config) {
					console.log("Error4."+data);
				});
			}
		} else {
			$scope.loadRunning='';
			$scope.pickedUpRollError='Roll Id Required';
		}
	};
	
	$scope.alterModal = function(typ) {
		if (typ==1) {
			$('#backTable').modal('toggle');
			$('#rollInfo').modal('toggle');
		} else if (typ==2) {
			$('#workOrderConfirmation').modal('hide');
			$('#workOrderModal').modal('show');
		} else if (typ==3) {
			$('#backTable').modal('toggle');
			$('#rollInfo').modal('toggle');
		}
	};

	$scope.allocateRoll = function() {
		//console.log($scope.rollPickFor);
		//return false ;
		var proceed=0 ;
		if ($scope.rollPickFor=='HANGTABLE') {
			if ($scope.isNullOrEmptyOrUndefined($scope.evsData.showExplain)==false && $scope.isNullOrEmptyOrUndefined($scope.evsData.requiredExplanation)==true) {
				var proceed=0 ;
				$scope.evsData.errorExplanation='Please Enter Explanation.' ;
				$timeout(function() { $scope.evsData.errorExplanation='' ; },1700);
			} else {
				proceed=1 ;
			}
		} else {
			proceed=1 ;
		}
		
		if (parseInt(proceed)==1) {
			$scope.loadRunning=1;
			$('#rollInfo').modal('toggle');
			if ($scope.rollPickFor=='HANGTABLE') {
				$('#EVSmodal').modal('toggle');
			}
			var response = $http({
				method: 'POST',
				url: "inspectionPages/allocateInspectionRoll.php",
				data: $.param({'rollPickFor': $scope.rollPickFor, 'tableSwitcher':$scope.tableSwitcher, 'pickedUpRollDetails':$scope.pickedUpRollDetails, 'userDisplayName':$scope.userDisplayName, 'showHangRollCaution':$scope.showHangRollCaution, 'palletId': $scope.palletId, 'evsData': $scope.evsData, 'inspectorUser': $scope.inspectorUser}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				if (data) {
					if (data==1) {
						$scope.loadRunning='';
						if ($scope.rollPickFor=='HANGTABLE') {
							$('#workOrderConfirmation').modal('toggle');
						}
						$scope.emptyRollAllocation();
						$scope.switchTable();
					}
				}
			});
			response.error(function (data, status, headers, config) {
				$scope.loadRunning='';
				console.log("Error4."+data);
			});
		}
	};	
	
	$scope.checkEVS = function() {
		var response = $http({
			method: 'POST',
			url: "inspectionPages/checkEVSData.php",
			data: $.param({'pickedUpRollDetails':$scope.pickedUpRollDetails}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			if (data) {
				$scope.evsData.evsFileName=data.evsFileName ;
				$scope.evsData.inspectorName=data.inspectorName ;
				$scope.evsData.showExplain='' ;
				$scope.evsData.requiredExplanation='' ;
				$scope.evsData.errorExplanation='' ;
			}
		});
		response.error(function (data, status, headers, config) {
			$scope.loadRunning='';
			console.log("Error4."+data);
		});
		//console.log($scope.pickedUpRollDetails);
	};
	
	$scope.clearEvsData = function (tNum) {
		$scope.evsData={};
		if (parseInt(tNum)==0) {
			$('#EVSmodal').modal('toggle');
		} else if (parseInt(tNum)==1) {
			$('#rollInfo').modal('toggle');
			$('#EVSmodal').modal('toggle');
		}
	};
	
	$scope.proceedEVS = function () {
		
	};
	
	$scope.saveTrashDefect = function() {
		var trashDefectType=$scope.trashDefectType ;
		$scope.trashDefectError='';
		if ($scope.isNullOrEmptyOrUndefined($scope.trashDefectReason)==true) {
			$scope.trashDefectError+='Defect Required';
		}
		if ($scope.isNullOrEmptyOrUndefined($scope.trashDefectLength)==true) {
			if ($scope.isNullOrEmptyOrUndefined($scope.trashDefectError)==true) {
				if (trashDefectType=='TRASH') {
					$scope.trashDefectError+='Length Required';
				} else {
					$scope.trashDefectError+='Marker Required';
				}
			} else {
				if (trashDefectType=='TRASH') {
					$scope.trashDefectError+=' & Length Required';
				} else {
					$scope.trashDefectError+=' & Marker Required';
				}
			}
		} else if ($scope.trashDefectLength<=0) {
			if ($scope.isNullOrEmptyOrUndefined($scope.trashDefectError)==true) {
				if (trashDefectType=='TRASH') {
					$scope.trashDefectError+='Length Required';
				} else {
					$scope.trashDefectError+='Marker Required';
				}
			} else {
				if (trashDefectType=='TRASH') {
					$scope.trashDefectError+=' & Length Required';
				} else {
					$scope.trashDefectError+=' & Marker Required';
				}
			}
		} else if (trashDefectType=='DEFECT' && $scope.isNullOrEmptyOrUndefined($scope.defectNum)==true && $scope.trashDefectLength<101) {
			if ($scope.isNullOrEmptyOrUndefined($scope.trashDefectError)==true) {
				$scope.trashDefectError+='Marker must be >100';
			} else {
				$scope.trashDefectError+=' & Marker must be >100';
			}
		}
		if ($scope.isNullOrEmptyOrUndefined($scope.trashDefectError)==true) {
			$scope.defectNum='' ;
			$('#trash').modal('toggle');
			$scope.loadRunning=1;
			var response = $http({
				method: 'POST',
				url: "inspectionPages/registerTrashDefect.php",
				data: $.param({'hangRollDetails': $scope.hangRollDetails, 'batcherRollName':$scope.batcherRollName, 'trashDefectType':$scope.trashDefectType, 'trashDefectLength':$scope.trashDefectLength, 'trashDefectReason':$scope.trashDefectReason, 'trashDefectComment':$scope.trashDefectComment, 'inspectorUser':$scope.inspectorUser, 'trashDefectId':$scope.trashDefectId, 'trashDefectRemove':$scope.trashDefectRemove, 'defectSheetFor':$scope.defectSheetFor}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				$scope.loadRunning='';
				if (data) {
					if ($scope.isNullOrEmptyOrUndefined(data.lastRegisteredDefects)==false) {
						$scope.switchTable($scope.defectSheetFor);
						if (Number(data.remainingLength)<=0) {
							$('#masterRollConfirmation').modal('toggle');
							$('#masterRollConfirmation').modal({backdrop: 'static', keyboard: false}) ;
						}
					}
				}
			});
			response.error(function (data, status, headers, config) {
				$scope.loadRunning='';
				console.log("Error5."+data);
			});
		}
	};
	
	$scope.allocateTrashDefects = function(type,defectDet) {
		$scope.trashDefectType=type ;
		$scope.trashDefectReason='' ;
		$scope.trashDefectLength='' ;
		$scope.trashDefectComment='' ;
		$scope.trashDefectError='' ;
		$scope.trashDefectId='' ;
		$scope.trashDefectRemove='';
		$scope.trashArray='';
		if (type=='TRASH') {
			var response = $http({
				method: 'POST',
				url: "inspectionPages/getTrashDetails.php",
				data: $.param({'hangRollDetails': $scope.hangRollDetails}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				if (data) {
					$scope.trashArray=data.trashArray ;
				}
			});
			response.error(function (data, status, headers, config) {
				alert("Error.");
			});
		} else {
			if ($scope.isNullOrEmptyOrUndefined(defectDet)==false) {
				$scope.defectNum=defectDet.defectLocation ;
				if ($scope.defectNum>0) {
					$scope.trashDefectLength=$scope.defectNum ;
				}
				$scope.trashDefectReason=defectDet.defectReason ;
				$scope.trashDefectComment=defectDet.defectComment ;
				$scope.trashDefectId=defectDet.defectLogId ;
			}
		}
	};
	
	$scope.startRollCreation =function () {
		$scope.createRoll={};
		$scope.createRollErrorArray=[];
		if ($scope.isNullOrEmptyOrUndefined($scope.userDisplayName)==false) {
			$scope.createRoll.Inspector=$scope.userDisplayName ;
		}
		if ($scope.isNullOrEmptyOrUndefined($scope.hangRollDetails.hangFinStyleName)==false) {
			$scope.createRoll.Style=$scope.batcherRollStyle ;
		}
		if ($scope.isNullOrEmptyOrUndefined($scope.hangRollDetails.hangRollName)==false) {
			$scope.createRoll.comments='Parent Roll : '+$scope.hangRollDetails.hangRollName ;
		}
	};

	$scope.checkLengthValue = function () {
		$scope.createRoll.Netweight='';
		if ($scope.isNullOrEmptyOrUndefined($scope.createRoll.Length)==false) {
			if (Number($scope.createRoll.Length)>0) {
				$scope.createRoll.Netweight=($scope.createRoll.Length/$scope.hangRollDetails.hangFinStyleYield).toFixed(2) ;
			}
		}
	};
	
	$scope.saveCreatedRoll = function () {
		$scope.createRollErrorArray=[];
		$('#progressDisplayer').html('');
		$('#newlyCreatedRollsDisplayer').html();
		if ($scope.isNullOrEmptyOrUndefined($scope.createRoll)==true) {
			$scope.createRollErrorArray.push('Length');
			$scope.createRollErrorArray.push('Netweight');
			$scope.createRollErrorArray.push('Quality');
		} else {
			if ($scope.isNullOrEmptyOrUndefined($scope.createRoll.Length)==true) {
				$scope.createRollErrorArray.push('Length');
			} else if (Number($scope.createRoll.Length)==0) {
				$scope.createRollErrorArray.push('Length');
			}
			
			if ($scope.isNullOrEmptyOrUndefined($scope.createRoll.Netweight)==true) {
				$scope.createRollErrorArray.push('Netweight');
			} else if (Number($scope.createRoll.Netweight)==0) {
				$scope.createRollErrorArray.push('Netweight');
			}
			
			if ($scope.isNullOrEmptyOrUndefined($scope.createRoll.quality)==true) {
				$scope.createRollErrorArray.push('Quality');
			}
			
			if ($scope.createRollErrorArray.length>0) {
				console.log('LogError');
			} else {
				$('#creatingRoll').modal('toggle');
				$scope.loadRunning=1;
				var response = $http({
					method: 'POST',
					url: "inspectionPages/saveCreatedRoll.php",
					data: $.param({'hangRollDetails': $scope.hangRollDetails, 'createRoll': $scope.createRoll, 'inspectorUser': $scope.inspectorUser, 'workOrderNum': $scope.workOrderNum, 'palletId': $scope.palletId, 'batcherRollName': $scope.batcherRollName, 'batcherRollFSSID': $scope.batcherRollFSSID, 'selectedWorkOrderStyleId': $scope.selectedWorkOrderStyleId, 'tableSwitcher': $scope.tableSwitcher, 'batcherRollArray':$scope.batcherRollArray}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
				});
				response.success(function (data, status, headers, config) {
					$scope.loadRunning='';
					if (data) {
						if ($scope.isNullOrEmptyOrUndefined(data.createdRollIdString)==false) {
							if ($scope.isNullOrEmptyOrUndefined(data.masterRollsUpdatedLength)==false) {
								if (parseInt(data.expectedRolls)>0 && parseInt(data.ipuRollCount)>0 && parseInt(data.ipuRollCount)>=parseInt(data.expectedRolls)) {
									$timeout(function() {
										$('#progressDisplayer').html('<label class="control-label col-md-12 col-sm-12 padding-lr0 text-left">Work Order Progress : <span id="progressDisplayer">'+data.ipuRollCount+' / '+data.expectedRolls+' Rolls</span></label>');
										var newRollStr='';
										if ($scope.isNullOrEmptyOrUndefined(data.createdRollNameArray)==false) {
											var rollStr='';
											angular.forEach(data.createdRollNameArray, function(value, index) {
												if ($scope.isNullOrEmptyOrUndefined(value)==false) {
													rollStr+='<div class="col-md-12 padding-lr0 mb10"> '+ (parseInt(index)+1) +'. '+value+' </div>';
												}
											});
											if ($scope.isNullOrEmptyOrUndefined(rollStr)==false) {
												$('#newlyCreatedRollsDisplayer').html('<label class="control-label col-md-12 col-sm-12 padding-lr0 text-left">Newly Created Rolls :</label><div class="clear5"></div><div class="col-md-12">'+rollStr+'</div>');
											}
										}
										$('#progressModal').modal('toggle');
										$('#progressModal').modal({backdrop: 'static', keyboard: false}) ;
									},575);
								}
								if (Number(data.masterRollsUpdatedLength)>0) {
									$scope.showMiddleTable();
									$scope.switchTable();
									if ($scope.isNullOrEmptyOrUndefined(data.createdRollIdString)==false) {
										$timeout(function(){
										var openurl="fpdf17/defectSheetPDF.php?rollIds="+data.createdRollIdString ;
										window.open(openurl,'_blank');
										},300);
										
										$timeout(function(){
											var openurl="Direct_Print.php?copynum=3&closeWindow=1" ;
											window.open(openurl,'_blank');
										},500);
									}
								} else {
									$scope.showMiddleTable();
									$scope.switchTable();
									if ($scope.isNullOrEmptyOrUndefined(data.createdRollIdString)==false) {
										$timeout(function(){ 
										var openurl="fpdf17/defectSheetPDF.php?rollIds="+data.createdRollIdString ;
										window.open(openurl,'_blank');
										},300);
										
										$timeout(function(){
											var openurl="Direct_Print.php?copynum=3&closeWindow=1" ;
											window.open(openurl,'_blank');
										},500);
									}
									$('#masterRollConfirmation').modal('toggle');
									$('#masterRollConfirmation').modal({backdrop: 'static', keyboard: false}) ;
								}
							}
						} else {
							console.log('Error Occured !');
						}
					}
				});
				response.error(function (data, status, headers, config) {
					$scope.loadRunning='';
					console.log("Error6."+data);
				});
			}
		}
	};
	
	$scope.consumeMasterRoll = function() {
		$('#masterRollConfirmation').modal('toggle');
		$scope.loadRunning=1;
		var response = $http({
			method: 'POST',
			url: "inspectionPages/consumeMasterRoll.php",
			data: $.param({'hangRollDetails': $scope.hangRollDetails, 'tableSwitcher': $scope.tableSwitcher}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.loadRunning='';
			if (data) {
				$scope.switchTable();
			}
		});
		response.error(function (data, status, headers, config) {
			console.log("Error7."+data);
		});
	};
	
	$scope.emptyRollAllocation = function(type) {
		$scope.rollPickFor=type;
		$scope.pickedUpRoll='';
		$scope.pickedUpRollError='';
		$scope.pickedUpRollDetails='';
		$scope.showMasterRollCaution='';
		$scope.showHangRollCaution='';
		$scope.evsData={};
	};
	
	$scope.emptyFullAllocation = function() {
		$scope.workOrderNum='';
		$scope.palletId='';
		$scope.inspectorUser='';
		$scope.userDisplayName='';
		$scope.batcherRollName='';
		$scope.batcherRollStyle='';
		$scope.batcherRollFSSID='';
		$scope.rollPickFor='';
		$scope.pickedUpRoll='';
		$scope.pickedUpRollError='';
		$scope.pickedUpRollDetails='';
		$scope.backTableRolls='';
		$scope.backTableRollsCount=0;
		$scope.middleTableRolls='';
		$scope.middleTableRollsCount=0;
		$scope.showMasterRollCaution='';
		$scope.showHangRollCaution='';
		$scope.hangRollDetails='';
		$scope.trashDefectType='';
		$scope.trashDefectReason='';
		$scope.trashDefectLength='' ;
		$scope.trashDefectComment='' ;
		$scope.trashDefectError='' ;
		$scope.trashDefectId='' ;
		$scope.rollSplit='';
		$scope.trashDefectRemove='';
		$scope.trashArray='';
		$scope.defectNum='';
		$scope.defectDetailsArray='';
		$scope.createRoll={};
		$scope.createRollErrorArray=[];
		$scope.batcherRollArray={};
		$scope.defectSheetFor='';
		$scope.loadRunning='';
		$scope.selectedWorkOrderStyleId='';
		$scope.evsData={};
	};
	
	$scope.isNullOrEmptyOrUndefined = function(value) {
        return !value
    };
	
	$scope.parseInt = parseInt ;
	$scope.parseFloat = parseFloat ;
	
	$scope.supervisorPassword='';
	$scope.supervisorPasswordError='';
	$scope.clearData=0;
	$scope.emptySuperViserCheck = function (val) {
		$scope.supervisorPassword='';
		$scope.supervisorPasswordError='';
		$scope.clearData=val;
	};
	
	$scope.checkSupervisor = function () {
		if ($scope.isNullOrEmptyOrUndefined($scope.supervisorPassword)==false) {
			var response = $http({
				method: 'POST',
				url: "inspectionPages/checkSupervisorPin.php",
				data: $.param({'supervisorPassword': $scope.supervisorPassword}),
				headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			});
			response.success(function (data, status, headers, config) {
				if (data) {
					if (parseInt(data)>0) {
						$scope.loadRunning=1;
						$scope.supplierOverrideStart();
						$('#supervisorCheck').modal('toggle');
					} else {
						$scope.supervisorPasswordError='Pin Mismatch';
					}
				}
			});
			response.error(function (data, status, headers, config) {
				$scope.loadRunning='';
				console.log("Error8."+data);
			});
		} else {
			$scope.supervisorPasswordError='Pin Required';
		}
	};
	
	$scope.supplierOverrideStart = function () {
		var response = $http({
			method: 'POST',
			url: "inspectionPages/supplierOverrideProcess.php",
			data: $.param({'hangRollDetails': $scope.hangRollDetails, 'tableSwitcher': $scope.tableSwitcher, 'workOrderNum': $scope.workOrderNum, 'palletId': $scope.palletId, 'clearData': $scope.clearData}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.loadRunning='';
			if (data) {
				$scope.clearData=0;
				$scope.switchTable();
			}
		});
		response.error(function (data, status, headers, config) {
			console.log("Error9."+data);
		});
	};
	
	$scope.chooseSpliter = function (num) {
		var response = $http({
			method: 'POST',
			url: "inspectionPages/updateRollSplit.php",
			data: $.param({'rollSplitNum': num, 'tableSwitcher': $scope.tableSwitcher}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			$scope.switchTable();
		});
		response.error(function (data, status, headers, config) {
			console.log("Error10."+data);
		});
	};
	
	$scope.setDefectSheetFor = function (defectSheetParam)  {
		$scope.defectSheetFor=defectSheetParam ;
		//console.log($scope.defectSheetFor);
	};
	
	$scope.showWorkOrderList = function () {
		$scope.workOrderList=[];
		var response = $http({
			method: 'POST',
			url: "inspectionPages/getWorkOrderList.php",
			data: $.param({'listType': $scope.workOrder.listType, 'tableSwitcher': $scope.tableSwitcher}),
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			if (data) {
				$scope.workOrderList=data.workOrderList ;
			}
		});
		response.error(function (data, status, headers, config) {
			console.log("Error10."+data);
		});
	};
	
	$scope.showInspectorList = function () {
		var response = $http({
			method: 'POST',
			url: "inspectionPages/getUserList.php",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			if (data) {
				$scope.userList=data.userList ;
			}
		});
		response.error(function (data, status, headers, config) {
			console.log("Error10."+data);
		});
	};
}]);