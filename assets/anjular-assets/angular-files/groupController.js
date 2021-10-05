mainApp.controller('churchController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		

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




	/*******************START AGE GROUP********************/


	$scope.searchAgeGroup={};
	$scope.agegroupData={};
	$scope.getAgeGroupListInit = function() {
		$timeout(function () {
			$scope.getAgeGroupList();
		}, 200);
	};
	$scope.getAgeGroupList = function()
	{
		if (! $.fn.DataTable.isDataTable('#datatableAgeGroupList'))
		{
			var passarray= [
				{"data": "id", "name": "id", "bVisible": false, "bSearchable": false, "bSortable":true},
				{"data": "agegroup_name", "name": "agegroup_name", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "age_range", "name": "age_range", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "create_date", "name": "create_date", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "action", "name": "action", "bVisible": true, "bSearchable": false, "bSortable":false},
			] ;

			$scope.masterRollsContainer = $('#datatableAgeGroupList').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource":  varGlobalAdminBaseUrl+"ajaxGetAgeGroupList",
				"aoColumns": passarray,
				"columnDefs": [
					{"className": "dt-center", "targets": "_all"}
				],
				//"order": [[ 2, "desc" ]],
				"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
					aoData.push(
						{"name": "searchagegroup_name","value":$scope.searchAgeGroup.agegroup_name},
						{"name": "searchage_range","value":$scope.searchAgeGroup.age_range},
						{"name": "searchcreate_date","value":$scope.searchAgeGroup.create_date}
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
			var data_table = $('#datatableAgeGroupList').DataTable();
			$('#datatableAgeGroupList .zsearch_inputz').on('keyup',function(event)
			{
				data_table.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('#datatableAgeGroupList_filter.dataTables_filter').hide();
			var table = $('#datatableAgeGroupList').DataTable();
			$('#datatableAgeGroupList tbody').on('click', 'tr', function () {
				var data = table.row( this ).data();
			});
		} else {
			var dataTable = $('#datatableAgeGroupList').DataTable();
			dataTable.draw();
		}
    };

    $scope.addAgeGroup = function ()
	{
		window.location.href=varGlobalAdminBaseUrl+"addagegroup";
	};
	$scope.submitAgeGroup = function()
	{
		$scope.agegroupDataCheck=true ;
		$timeout(function()
		{
			$scope.agegroupDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.agegroupData.agegroup_name)==true) || ($scope.agegroupData.agegroup_name=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.agegroupData.age_range)==true) || ($scope.agegroupData.age_range=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{		
			var formData = new FormData();
			formData.append('agegroupData',angular.toJson($scope.agegroupData));	
			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxaddupdateagegroup",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            })
            .success(function(returnData)
            {
            	$scope.agegroupDataCheck=false ;
            	aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1')
            	{
            		window.location.href=varGlobalAdminBaseUrl+"agegrouplist?msg="+aryreturnData.msg;
            	}
            	else
            	{
            		swal("Error!",
		        		"Age Group addition Failed!",
		        		"error"
		        	)
            	}
			});
		}
	};

	$scope.getageGroupData = function(id=0)
	{
		if(id>0)
		{
			var formData = new FormData();
			formData.append('id',id);	
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"get_age_group_data",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData)
	        {
	        	aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		var agegroupData=aryreturnData.data.agegroupData;
	        		$scope.agegroupData=agegroupData;
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


    $scope.change_agegroup_status = function(status,msg,id)
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
		            url     : varGlobalAdminBaseUrl+"ajaxchangeagegroupstatus",
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
		        		var data_table = $('#datatableAgeGroupList').DataTable();
						data_table.draw();
				    });
				});
		    }
	    });

	};

	$scope.delete_agegroup_status = function(msg,id)
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
		            url     : varGlobalAdminBaseUrl+"ajaxdeleteagegroup",
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
		        		var data_table = $('#datatableAgeGroupList').DataTable();
						data_table.draw();
				    });
				});
		    }
	    });
	};
	/*******************END AGE GROUP********************/
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
