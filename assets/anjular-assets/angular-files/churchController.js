mainApp.controller('churchController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
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
				{"data": "tot_members", "name": "tot_members", "bVisible": true, "bSearchable": true, "bSortable":true},
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
		$scope.churchData.city='0';
		$scope.churchData.country='0';
		$scope.churchData.state='0';

		$scope.getGlobalCountryData($http);

		if(id>0)
		{
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
	        		$scope.churchData.trusteeBoard=churchData.trustee_board;
	        		$scope.churchData.foundationDate=churchData.foundation_date;
	        		$scope.churchData.contachPerson=churchData.contact_person;
	        		$scope.churchData.user_email=churchData.user_email;
	        		$scope.churchData.contact_mobile=churchData.contact_mobile;
	        		$scope.churchData.contact_alt_mobile=churchData.contact_alt_mobile;
	        		$scope.churchData.address=churchData.address;
	        		$scope.churchData.city=churchData.city;
	        		$scope.churchData.country=churchData.country_id;
	        		$scope.churchData.state=churchData.state_id;
	        		$scope.churchData.postalCode=churchData.postal_code;

	        		$scope.getGlobalStateData($http,$scope.churchData.country);
	        		$scope.getGlobalCityData($http,$scope.churchData.state);
	        	}
	        	else
	        	{
	        		swal("Error!",
		        		"No Data Found",
		        		"error"
		        	)
	        	}
			});
	    }
    };
    

	$scope.addChurch = function ()
	{
		window.location.href=varGlobalAdminBaseUrl+"addchurch";
	};

	$scope.submitChurch = function() {
		$scope.churchDataCheck=true ;
		$timeout(function()
		{
			$scope.churchDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.churchData.churchName)==true) || ($scope.churchData.churchName=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.churchData.contact_mobile)==true) || ($scope.churchData.contact_mobile=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.churchData.user_email)==true) || ($scope.churchData.user_email=='¿'))
		{
			validator++ ;
		}


		if (Number(validator)==0)
		{		
			var formData = new FormData();
			formData.append('churchData',angular.toJson($scope.churchData));	
			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxaddupdatechurch",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				$scope.churchDataCheck=false ;
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1')
            	{
            		window.location.href=varGlobalAdminBaseUrl+"churchlist?msg="+aryreturnData.msg;
            	}
            	else
            	{
            		swal("Error!",
		        		"Church addition Failed!",
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

	$scope.searchGroup={};
	$scope.groupData={};
	$scope.getGroupListInit = function() {
		$timeout(function () {
			$scope.getGroupList();
		}, 200);
	};
	$scope.getGroupList = function()
	{
		if (! $.fn.DataTable.isDataTable('#datatableGroupList'))
		{
			var passarray= [
				{"data": "id", "name": "id", "bVisible": false, "bSearchable": false, "bSortable":true},
				{"data": "name", "name": "name", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "create_date", "name": "create_date", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "action", "name": "action", "bVisible": true, "bSearchable": false, "bSortable":false},
			] ;

			$scope.masterRollsContainer = $('#datatableGroupList').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource":  varGlobalAdminBaseUrl+"ajaxGetGroupList",
				"aoColumns": passarray,
				"columnDefs": [
					{"className": "dt-center", "targets": "_all"}
				],
				//"order": [[ 2, "desc" ]],
				"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
					aoData.push(
						{"name": "searchgroupName","value":$scope.searchGroup.groupName},
						{"name": "searchcreateDate","value":$scope.searchGroup.createDate},
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
			var data_table = $('#datatableGroupList').DataTable();
			$('#datatableGroupList .zsearch_inputz').on('keyup',function(event)
			{
				data_table.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('#datatableGroupList_filter.dataTables_filter').hide();
			var table = $('#datatableGroupList').DataTable();
			$('#datatableGroupList tbody').on('click', 'tr', function () {
				var data = table.row( this ).data();
			});
		} else {
			var dataTable = $('#datatableGroupList').DataTable();
			dataTable.draw();
		}
    };

    $scope.getGroupData = function(id=0)
	{
		if(id>0)
		{
			var formData = new FormData();
			formData.append('id',id);	
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"get_group_data",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData)
	        {
	        	aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		var groupData=aryreturnData.data.groupData;
	        		$scope.groupData.id=groupData.id;
	        		$scope.groupData.groupName=groupData.name;
	        		$scope.groupData.groupDesc=groupData.group_desc;
	        	}
	        	else
	        	{
	        		swal("Error!",
		        		"No Data Found",
		        		"error"
		        	)
	        	}
			});
	    }
    };

    $scope.addGroup = function ()
	{
		window.location.href=varGlobalAdminBaseUrl+"addgroup";
	};

	$scope.submitGroup = function()
	{
		$scope.groupDataCheck=true ;
		$timeout(function()
		{
			$scope.groupDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.groupData.groupName)==true) || ($scope.groupData.groupName=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{		
			var formData = new FormData();
			formData.append('groupData',angular.toJson($scope.groupData));	
			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxaddupdategroup",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            })
            .success(function(returnData)
            {
            	$scope.groupDataCheck=false ;
            	aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1')
            	{
            		window.location.href=varGlobalAdminBaseUrl+"grouplist?msg="+aryreturnData.msg;
            	}
            	else
            	{
            		swal("Error!",
		        		"Group addition Failed!",
		        		"error"
		        	)
            	}
			});
		}
	};

	$scope.change_group_status = function(status,msg,id)
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
		            url     : varGlobalAdminBaseUrl+"ajaxchangegroupstatus",
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
		        		var data_table = $('#datatableGroupList').DataTable();
						data_table.draw();
				    });
				});
		    }
	    });

	};

	$scope.delete_group_status = function(msg,id)
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
		            url     : varGlobalAdminBaseUrl+"ajaxdeletegroup",
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
		        		var data_table = $('#datatableGroupList').DataTable();
						data_table.draw();
				    });
				});
		    }
	    });
	};

	$scope.getStateData = function(countryId)
	{
		$scope.getGlobalStateData($http,countryId);
    };

    $scope.getCityData = function(stateId)
	{
		$scope.getGlobalCityData($http,stateId);
    };
    
	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};

	
});
