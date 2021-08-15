mainApp.controller('employeeTrainingLogController', function($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog) {
	$scope.userList='';
	$scope.issueList='';
	$scope.causationList='';
	$scope.typeList='';
	$scope.addIssueName='';
	$scope.empTraining={};
	$scope.trainingLogFiles=[];
	$scope.trainingActFiles=[];
	$scope.initEmpTrainingLog = function() {
		angular.element(document).ready(function() {
			$scope.empTraining={};
			$scope.trainingLogFiles=[];
			$scope.trainingActFiles=[];
			var passarray= [
					{"data": "ID", "name": "ID", "bVisible": false, "bSearchable": false, "bSortable":true},
					{"data": "logTime", "name": "logTime", "bVisible": true, "bSearchable": true},
					{"data": "empName", "name": "empName", "bVisible": true, "bSearchable": true},
					{"data": "logissue", "name": "logissue", "bVisible": true, "bSearchable": true},
					{"data": "causationEvent", "name": "causationEvent", "bVisible": true, "bSearchable": true},
					{"data": "logtype", "name": "logtype", "bVisible": true, "bSearchable": true},
					{"data": "enteredBy", "name": "enteredBy", "bVisible": true, "bSearchable": true},
					{"data": "ctc", "name": "ctc", "bVisible": true, "bSearchable": true},
					{"data": "desc", "name": "desc", "bVisible": true, "bSearchable": true},
					{"data": "action", "name": "action", "bVisible": true, "bSearchable": false, "bSortable":false}
                    ] ;
			$('#log_list').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource": "trainingLogPages/getTrainingLog.php",
				"aoColumns": passarray,
				"fnServerData": function ( sSource, aoData, fnCallback, oSettings) {
					var searchArr=[];
					$('#log_list').find('.zsearch_inputz').each(function(){
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
							fnCallback(msg.jsonData);
						},
						"error": function (e) {
							console.log(e.message);
						}
					});
				},
				"oLanguage": {
					"sEmptyTable":     "No Records Found"
				},
				"fnCallback": function() {
					console.log('ASD');
				},
				"fnCreatedRow": function( nRow, aData, iDataIndex ){
					$compile(nRow)($scope);
				},
			});
			$scope.log_list_data_table = $('#log_list').DataTable();
			$('#log_list .zsearch_inputz').on('keyup',function(event) {
				$scope.log_list_data_table.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('#log_list_filter.dataTables_filter').hide();
		});
	};
	
	$scope.manageTrainingLog = function(tid) {
		$scope.trainingLogFiles = [{'fileActualName':'', 'fileDisplayName':''}];
		$scope.trainingActFiles = [{'empty':'1'}];
		$scope.trainingLogCheck=false ;
		$scope.empTraining.causationEvent='¿';
		$scope.empTraining.issue='¿';
		$scope.empTraining.type='¿';
		$scope.empTraining.enteredBy='';
		$scope.empTraining.ctc='';
		$scope.empTraining.desc='';
		$scope.empTraining.logTime='';
		$scope.empTraining.logId=tid;
		var response = $http({
			method: 'POST',
			url: "trainingLogPages/trainingLogUsers.php",
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		});
		response.success(function (data, status, headers, config) {
			if (data) {
				$scope.userList=data.userList ;
				$scope.issueList=data.issueList ;
				$scope.causationList=data.causationList ;
				$scope.typeList=data.typeList ;
				$scope.empTraining.empName=$scope.userList[0];
				//console.log($scope.empTraining.logTime);
			}
		});
		response.error(function (data, status, headers, config) {
			console.log("Error10."+data);
		});
		if (tid>0) {
			$(".overlayWholePage").show();
			$timeout(function(){
				var response = $http({
					method: 'POST',
					url: "trainingLogPages/getTrainingLogDetails.php",
					data: $.param({'logId': tid}),
					headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
				});
				response.success(function (data, status, headers, config) {
					$(".overlayWholePage").hide();
					if (data) {
						console.log(data);
						$scope.empTraining.causationEvent=($scope.isNullOrEmptyOrUndefined(data.causationEvent)==false)? data.causationEvent : '¿';
						$scope.empTraining.issue=($scope.isNullOrEmptyOrUndefined(data.issue)==false)? data.issue : '¿';
						$scope.empTraining.type=($scope.isNullOrEmptyOrUndefined(data.type)==false)? data.type : '¿';
						$scope.empTraining.enteredBy=data.enteredBy;
						$scope.empTraining.ctc=data.ctc;
						$scope.empTraining.desc=data.desc;
						$scope.empTraining.empName=data.empName;
						$scope.empTraining.empName.userFullName=($scope.isNullOrEmptyOrUndefined(data.empName.userFullName)==false)? data.empName.userFullName : '¿';
						$scope.empTraining.editlogTime=data.logTime;
						$scope.empTraining.logTime=data.displogTime;
						if ($scope.isNullOrEmptyOrUndefined(data.attachment)==false) {
							//console.log((data.attachment).length);
							//$scope.empTraining.prevAttachment=data.attachment ;
							$scope.trainingLogFiles = [] // [{'fileActualName':''}];
							$scope.trainingActFiles = [] // [{'empty':'1'}];
							angular.forEach(data.attachment, function(aDataValue, aDataKey) {
								var tempLog={};
								var actLog={};
								tempLog.fileActualName=aDataValue.actualName ;
								tempLog.fileDisplayName=aDataValue.displayName ;
								$scope.trainingLogFiles[aDataKey]=tempLog ;
								actLog.empty=1 ;
								$scope.trainingActFiles[aDataKey]=actLog ;
							});
							if (Number((data.attachment).length)<5) {
								$scope.trainingLogFiles.push({'fileActualName':'', 'fileDisplayName':''});
								$scope.trainingActFiles.push({'empty':'1'});
							}
						}
					}
				});
				response.error(function (data, status, headers, config) {
					console.log("Error10."+data);
				});
			},300);
		} else {
			var getTimeStr= $scope.setCurrentTime();
			var getTimeStrArray=getTimeStr.split('|!|');
			if ($scope.isNullOrEmptyOrUndefined(getTimeStrArray[0])==false) {
				$scope.empTraining.editlogTime=getTimeStrArray[0];
			}
			if ($scope.isNullOrEmptyOrUndefined(getTimeStrArray[1])==false) {
				$scope.empTraining.logTime=getTimeStrArray[1];
			}
		}
	};
	
	$scope.issueChange = function(itm, mod) {
		//console.log(itm);
		//console.log(mod);
	};
	
	$scope.causationChange = function(itm, mod) {
		//console.log(itm);
		//console.log(mod);
	};
	
	$scope.setCurrentTime = function () {
		var currentdate = new Date();
		var selectDate=currentdate.getDate();
		var str = selectDate.toString();
		var newSelectedDate=(str.length<2)? "0" + str : str ;
		
		var selectYear=currentdate.getFullYear();
		
		var mstr=(Number(currentdate.getMonth())+1).toString();
		var newSelectedMonth=(mstr.length<2)? "0" + mstr : mstr ;
		
		var hstr=(currentdate.getHours()).toString();
		var newSelectedHour=(hstr.length<2)? "0" + hstr : hstr ;
		
		var mistr=(currentdate.getMinutes()).toString();
		var newSelectedMinute=(mistr.length<2)? "0" + mistr : mistr ;
		
		var sstr=(currentdate.getSeconds()).toString();
		var newSelectedSecond=(sstr.length<2)? "0" + sstr : sstr ;
		
		var dbDateStr=selectYear+'-'+newSelectedMonth+'-'+newSelectedDate+' '+newSelectedHour+':'+newSelectedMinute+':'+newSelectedSecond ;
		if (Number(currentdate.getHours())>12) {
			var twlvHourStr=Number(currentdate.getHours())-12 ;
			var nstr=twlvHourStr.toString();
			var newtwlvHourStr=(nstr.length<2)? "0" + nstr : nstr ;
			var ampmStr='PM';
		} else if (Number(currentdate.getHours())==0){
			var newtwlvHourStr=12 ;
			var ampmStr='AM';
		} else {
			var newtwlvHourStr=newSelectedHour ;
			var ampmStr='AM';
		}
		var displayDateStr=newSelectedMonth+'/'+newSelectedDate+'/'+selectYear+' '+newtwlvHourStr+':'+newSelectedMinute+' '+ampmStr ;
		
		return dbDateStr+'|!|'+displayDateStr ;
	};
	
	$scope.typeChange = function(itm, mod) {
		//console.log(itm);
		//console.log(mod);
	};
	
	$scope.addIssueOption = function() {
		$scope.addIssueOptionCheck=false ;
		$scope.addIssueName='';
	};
	
	$scope.addIssueNameSubmit = function() {
		$scope.addIssueOptionCheck=true ;
		if ($scope.isNullOrEmptyOrUndefined($scope.addIssueName)==false) {
			var addIssueName = ($scope.addIssueName).toLowerCase();
			var tcount=0;
			angular.forEach($scope.issueList, function(aDataValue, aDataKey) {
				var dval=aDataValue.toLowerCase();
				if (dval==addIssueName) {
					$scope.empTraining.issue=aDataValue ;
					tcount++;
				}
			});
			if (tcount==0) {
				$scope.empTraining.issue=$scope.addIssueName ;
				$scope.issueList.push($scope.addIssueName);
			}
			$('#addIssueDialog').modal('toggle');
		}
	};
	
	$scope.isNullOrEmptyOrUndefined = function (value) {
        return !value;
    };
	
	$scope.createEmployeeLog = function() {
		$scope.trainingLogCheck=true ;
		$timeout(function(){
			$scope.trainingLogCheck=false ;
		},2000);
		var validator=0;
		if ($scope.isNullOrEmptyOrUndefined($scope.empTraining.logTime)==true) {
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.empTraining.empName.userFullName)==true) || ($scope.empTraining.empName.userFullName=='¿')) {
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.empTraining.issue)==true) || ($scope.empTraining.issue=='¿')) {
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.empTraining.causationEvent)==true) || ($scope.empTraining.causationEvent=='¿')) {
			validator++ ;
		}
		if (Number(validator)==0) {
			$(".overlayWholePage").show();
			$scope.empTraining.causationEvent=($scope.isNullOrEmptyOrUndefined($scope.empTraining.causationEvent)==false && $scope.empTraining.causationEvent!='¿')?$scope.empTraining.causationEvent:'';
			$scope.empTraining.issue=($scope.isNullOrEmptyOrUndefined($scope.empTraining.issue)==false && $scope.empTraining.issue!='¿')?$scope.empTraining.issue:'';
			$scope.empTraining.type=($scope.isNullOrEmptyOrUndefined($scope.empTraining.type)==false && $scope.empTraining.type!='¿')?$scope.empTraining.type:'';
			$scope.empTraining.empId=($scope.isNullOrEmptyOrUndefined($scope.empTraining.empName.adminid)==false)?$scope.empTraining.empName.adminid:'';
			var formData = new FormData();
			$scope.empTraining.fileLog=$scope.trainingLogFiles;
            formData.append('empTraining',angular.toJson($scope.empTraining));
			angular.forEach($scope.trainingActFiles, function(val, indx) {
				if ($scope.isNullOrEmptyOrUndefined(val.empty)==true) {
					formData.append('trainingFiles['+indx+']', val);
				}
			});
			$http({
                method  : 'POST',
                url     : 'trainingLogPages/submitTrainingLog.php',
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(data) {
				//console.log(data);
				$(".overlayWholePage").hide();
				$('#trainingLogDialog').modal('toggle');
				$scope.log_list_data_table.draw();
				$scope.trainingLogCheck=false ;
			});
		}
	};
	
	$scope.addLogfFile = function () {
        $scope.trainingLogFiles.push({'fileActualName':'', 'fileDisplayName':''});
        $scope.trainingActFiles.push({'empty':'1'});
	};
	
	$scope.removeLogfFile = function ($ind) {
		var newFileList=[];
		var newActFileList=[];
		angular.forEach($scope.trainingLogFiles, function(val, indx) {
			if ($ind != indx) {
				newFileList.push(val);
				newActFileList.push($scope.trainingActFiles[indx]);
			}
		}); 
		$scope.trainingLogFiles = newFileList ;
		$scope.trainingActFiles = newActFileList ;
	};
	
	$scope.$on("onlyfileSelected", function (event, args, seq) {
        $scope.$apply(function () {
			$scope.trainingActFiles[seq]=args.file;
			$scope.trainingLogFiles[seq].fileDisplayName=args.file.name;
        });
    });
});