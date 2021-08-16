mainApp.controller('churchMemberController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.searchChurch={};
	$scope.churchData={};


	$scope.getChurchListInit = function() {
		$timeout(function () {
			$scope.getChurchList();
		}, 200);
	};	

	$scope.getChurchList = function()
	{
		if (! $.fn.DataTable.isDataTable('#datatableChurchList'))
		{
			var passarray= [
				{"data": "id", "name": "id", "bVisible": false, "bSearchable": false, "bSortable":true},
				{"data": "name", "name": "name", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "trustee_board", "name": "trustee_board", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "foundation_date", "name": "foundation_date", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "contact_person", "name": "contact_person", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "action", "name": "action", "bVisible": true, "bSearchable": false, "bSortable":false},
			] ;

			$scope.masterRollsContainer = $('#datatableChurchList').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource":  varGlobalAdminBaseUrl+"ajaxGetChurchList",
				"aoColumns": passarray,
				"columnDefs": [
					{"className": "dt-center", "targets": "_all"}
				],
				//"order": [[ 2, "desc" ]],
				"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
					aoData.push(
						{"name": "searchchurchName","value":$scope.searchChurch.churchName},
						{"name": "searchtrusteeBoard","value":$scope.searchChurch.trusteeBoard},
						{"name": "searchfoundationDate","value":$scope.searchChurch.foundationDate},
						{"name": "searchcontachPerson","value":$scope.searchChurch.contachPerson},
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
					"sEmptyTable":"No Records Found"
				},
				 "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
					$(nRow).css("cursor", "pointer");
				},
				"fnCreatedRow": function( nRow, aData, iDataIndex ){
					$compile(nRow)($scope);
				},
			});
			var data_table = $('#datatableChurchList').DataTable();
			$('#datatableChurchList .zsearch_inputz').on('keyup',function(event)
			{
				data_table.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('#datatableChurchList_filter.dataTables_filter').hide();
			var table = $('#datatableChurchList').DataTable();
			$('#datatableChurchList tbody').on('click', 'tr', function () {
				var data = table.row( this ).data();
			});
		} else {
			var dataTable = $('#datatableChurchList').DataTable();
			dataTable.draw();
		}
    }	

    $scope.getChurchData = function(id=0)
	{
		$scope.churchData.churchType='0';

		var formData = new FormData();
		formData.append('id',id);

		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"get_church_data",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData)
        {
        	aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		var churchData=aryreturnData.data.churchData;

        		$scope.churchData.id=churchData.id;
        		$scope.churchData.churchName=churchData.name;
        		$scope.churchData.churchType=churchData.type;
        		$scope.churchData.contachPerson=churchData.contact_person;
        		$scope.churchData.trusteeBoard=churchData.trustee_board;
        		$scope.churchData.foundationDate=churchData.foundation_date;
        		$scope.churchData.address=churchData.address;
        		$scope.churchData.city=churchData.city;
        		$scope.churchData.country=churchData.country_id;
        		$scope.churchData.state=churchData.state_id;
        		$scope.churchData.postalCode=churchData.postal_code;
        	}
        	else
        	{
        		swal("Error!",
	        		"No Data Found",
	        		"error"
	        	)
        	}
		});
    };

	$scope.addChurch = function ()
	{
		window.location.href=varGlobalAdminBaseUrl+"addchurch";
	};

	$scope.submitMember = function() {
		$scope.memberDataCheck=true ;
		$timeout(function()
		{
			$scope.memberDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.first_name)==true) || ($scope.memberData.first_name=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.last_name)==true) || ($scope.memberData.last_name=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.gender)==true) || ($scope.memberData.gender=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.marital_status)==true) || ($scope.memberData.marital_status=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.dob)==true) || ($scope.memberData.dob=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.membership_type)==true) || ($scope.memberData.membership_type=='¿'))
		{
			validator++ ;
		}

		if (($scope.memberData.membership_type=='CM') && ($scope.isNullOrEmptyOrUndefined($scope.memberData.church_id)==true))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.contact_mobile)==true) || ($scope.memberData.contact_mobile=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.contact_email)==true) || ($scope.memberData.contact_email=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{		
			var formData = new FormData();
			formData.append('memberData',angular.toJson($scope.memberData));	
			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxaddupdatemember",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				$scope.memberDataCheck=false ;
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1')
            	{
            		window.location.href=varGlobalAdminBaseUrl+"churchlist?msg="+aryreturnData.msg;
            	}
            	else
            	{
            		swal("Error!",
		        		"Member addition Failed!",
		        		"error"
		        	)
            	}
			});
		}
	};


	$scope.change_status = function(status,msg,id)
	{
		$scope.statusData={};
		$scope.statusData.status=status;
		$scope.statusData.id=id;
		var formData = new FormData();
		formData.append('statusData',angular.toJson($scope.statusData));

		swal({
	      title: "Attention",
	      text: msg,
	      icon: "warning",
	      buttons: true,
	      dangerMode: true,
	    })
	    .then((willDelete) =>
	    {
	    	if (willDelete)
	    	{
		      $http({
		            method  : 'POST',
		            url     : varGlobalAdminBaseUrl+"ajaxchangechurchstatus",
		            transformRequest: angular.identity,
		            headers: {'Content-Type': undefined},                     
		            data:formData, 
		        }).success(function(data)
		        {
		        	swal(
		        		"Confirm!",
		        		"Status Changes Successfully!",
		        		"success"
		        	)
		        	.then((willDelete) => {
		        		var data_table = $('#datatableChurchList').DataTable();
						data_table.draw();
				    });
				});
		    }
	    });

	};

	$scope.delete_status = function(msg,id)
	{
		$scope.deleteData={};
		$scope.deleteData.id=id;
		var formData = new FormData();
		formData.append('deleteData',angular.toJson($scope.deleteData));

		swal({
	      title: "Attention",
	      text: msg,
	      icon: "warning",
	      buttons: true,
	      dangerMode: true,
	    })
	    .then((willDelete) =>
	    {
	    	if (willDelete)
	    	{
		      $http({
		            method  : 'POST',
		            url     : varGlobalAdminBaseUrl+"ajaxdeletechurch",
		            transformRequest: angular.identity,
		            headers: {'Content-Type': undefined},                     
		            data:formData, 
		        }).success(function(data)
		        {
		        	swal(
		        		"Confirm!",
		        		"Deleted Successfully!",
		        		"success"
		        	)
		        	.then((willDelete) => {
		        		var data_table = $('#datatableChurchList').DataTable();
						data_table.draw();
				    });
				});
		    }
	    });

	};


	$scope.toJSDate = function ( dateTime ) {
		var dateTime = dateTime.split(" ");//dateTime[0] = date, dateTime[1] = time
		var date = dateTime[0].split("-");
		var time = dateTime[1].split(":");
		return new Date(date[2], (date[1]-1), date[0], time[0], time[1], time[2], 0).getTime();
	};
	
	$scope.getObjectLength = function (paramObj) {
		var keys = Object.keys(paramObj);
		var len = keys.length;
		return len ;
	};
	
	$scope.parseInt = parseInt ;
	$scope.parseFloat = parseFloat ;
	$scope.isObjectOrNot = function (val) {
		return angular.isObject(val);
	};
	
	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
	
	$scope.checkDate = function (s) {
		console.log(s);
		var currVal = s;
		var dateformat = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
		var Val_date=currVal;
		if	(Val_date.match(dateformat)) {
			var seperator1 = Val_date.split('/');
			var seperator2 = Val_date.split('-');
			if (seperator1.length>1) {
				var splitdate = Val_date.split('/');
			} else if (seperator2.length>1) {
				var splitdate = Val_date.split('-');
			}
			var dd = parseInt(splitdate[0]);
			var mm  = parseInt(splitdate[1]);
			var yy = parseInt(splitdate[2]);
			var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
			//console.log(yy);
			if(yy<=1980) {
				console.log('Invalid date format0!');
				return false;
			}
			if (mm==1 || mm>2) {
				if (dd>ListofDays[mm-1]) {
					console.log('Invalid date format1!');
					return false;
				}
			}
			if (mm==2) {
				var lyear = false;
				if ( (!(yy % 4) && yy % 100) || !(yy % 400)) {
					lyear = true;
				}
				if ((lyear==false) && (dd>=29)) {
					console.log('Invalid date format2!');
					return false;
				}
				if ((lyear==true) && (dd>29)) {
					console.log('Invalid date format3!');
					return false;
				}
			}
		}
	};
});
