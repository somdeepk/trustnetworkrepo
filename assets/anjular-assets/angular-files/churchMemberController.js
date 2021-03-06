mainApp.controller('churchMemberController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.searchMember={};
	$scope.memberData={};


	$scope.getMemberListInit = function() {
		$timeout(function () {
			$scope.getMemberList();
		}, 200);
	};	

	$scope.getMemberList = function()
	{
		if (! $.fn.DataTable.isDataTable('#datatableMemberList'))
		{
			filter_church_id=$("#filter_church_id").val();
			var passarray= [
				{"data": "id", "name": "id", "bVisible": false, "bSearchable": false, "bSortable":true},
				{"data": "full_name", "name": "full_name", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "dob", "name": "dob", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "contact_email", "name": "contact_email", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "contact_mobile", "name": "contact_mobile", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "membership_type", "name": "membership_type", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "church_name", "name": "church_name", "bVisible": true, "bSearchable": true, "bSortable":true},
				{"data": "action", "name": "action", "bVisible": true, "bSearchable": false, "bSortable":false},
			] ;

			$scope.masterRollsContainer = $('#datatableMemberList').dataTable({
				"dom": "frtlip",
				"iDisplayLength":10,
				"bProcessing": false,
				"bServerSide": true,
				"sAjaxSource":  varGlobalAdminBaseUrl+"ajaxGetMemberList",
				"aoColumns": passarray,
				"columnDefs": [
					{"className": "dt-center", "targets": "_all"}
				],
				//"order": [[ 2, "desc" ]],
				"fnServerData": function ( sSource, aoData, fnRowCallback, oSettings) {
					aoData.push(
						{"name": "search_full_name","value":$scope.searchMember.full_name},
						{"name": "search_dob","value":$scope.searchMember.dob},
						{"name": "search_contact_email","value":$scope.searchMember.contact_email},
						{"name": "search_contact_mobile","value":$scope.searchMember.contact_mobile},
						{"name": "search_membership_type","value":$scope.searchMember.membership_type},
						{"name": "search_church_name","value":$scope.searchMember.church_name},
						{"name": "filter_church_id","value":filter_church_id},
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
			var data_table = $('#datatableMemberList').DataTable();
			$('#datatableMemberList .zsearch_inputz').on('keyup',function(event)
			{
				data_table.draw(); // by this process we can recall the datatable ajax with search value
			});
			$('#datatableMemberList_filter.dataTables_filter').hide();
			var table = $('#datatableMemberList').DataTable();
			$('#datatableMemberList tbody').on('click', 'tr', function () {
				var data = table.row( this ).data();
			});
		} else {
			var dataTable = $('#datatableMemberList').DataTable();
			dataTable.draw();
		}
    }	

    $scope.getMemberData = function(id=0)
	{
		$scope.memberData.city='0';
		$scope.memberData.country='0';
		$scope.memberData.state='0';
		
		$scope.getGlobalCountryData($http);

		if(id>0)
		{
			var formData = new FormData();
			formData.append('id',id);

			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"get_member_data",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData)
	        {
	        	aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.memberData=aryreturnData.data.memberData;
	        		$scope.getGlobalStateData($http,$scope.memberData.country);
	        		$scope.getGlobalCityData($http,$scope.memberData.state);
	        		if(aryreturnData.data.memberData.church_id==0)
	        		{
	        			$scope.memberData.church_id='';
	        		}
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

	$scope.addMember = function ()
	{
		window.location.href=varGlobalAdminBaseUrl+"addmember";
	};

	$scope.filte_membership_type = function ()
	{
		var dataTable = $('#datatableMemberList').DataTable();
		dataTable.draw();
	};

	$scope.submitMember = function() {
		$scope.memberDataCheck=true ;
		$timeout(function()
		{
			$scope.memberDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.first_name)==true) || ($scope.memberData.first_name=='??'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.last_name)==true) || ($scope.memberData.last_name=='??'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.gender)==true) || ($scope.memberData.gender=='??'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.marital_status)==true) || ($scope.memberData.marital_status=='??'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.dob)==true) || ($scope.memberData.dob=='??'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.membership_type)==true) || ($scope.memberData.membership_type=='??'))
		{
			validator++ ;
		}

		if (($scope.memberData.membership_type=='CM') && ($scope.isNullOrEmptyOrUndefined($scope.memberData.church_id)==true))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.contact_mobile)==true) || ($scope.memberData.contact_mobile=='??'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.contact_email)==true) || ($scope.memberData.contact_email=='??'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{		
			//alert(validator)
			var formData = new FormData();
			formData.append('memberData',angular.toJson($scope.memberData));
			angular.forEach($scope.files,function(file){           
				formData.append('file[]',file);
			}); 

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
            		window.location.href=varGlobalAdminBaseUrl+"memberlist?msg="+aryreturnData.msg;
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

	$scope.files = [];
    
    //listen for the file selected event
    $scope.$on("fileSelected", function (event, args) {
        $scope.$apply(function () {            
            var img = $('<img/>', {
              id: 'dynamic',
              width:200,
              height:150
            });      
            $scope.files[0] = args.file;
            var reader = new FileReader();
            // Set preview image into the popover data-content
            reader.onload = function (e) {
                $(".image-preview-input-title").text("Change");
                $(".image-preview-clear").show();
                $(".image-preview-filename").val($scope.files[0].name);   
                       img.attr('src', e.target.result);
                $("#uploaded_image").html($(img)[0].outerHTML);
            }        
            reader.readAsDataURL($scope.files[0]);
        });
    });

	$scope.clearProfileImage = function()
	{
		$scope.files = [];
		$scope.memberData.profile_image = '';
		$("#uploaded_image").html('<img src="'+varBaseUrl+'assets/images/member-no-imgage.jpg" class="img-responsive border-blk"  style="margin:0 auto; width:74%;">');
		$('.image-preview').attr("data-content","").popover('hide');
		$('.image-preview-filename').val("");
		$('.image-preview-clear').hide();
		$('.image-preview-input input:file').val("");
		$(".image-preview-input-title").text("Browse"); 
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
		            url     : varGlobalAdminBaseUrl+"ajaxchangememberstatus",
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
		        		var data_table = $('#datatableMemberList').DataTable();
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
		            url     : varGlobalAdminBaseUrl+"ajaxdeletemember",
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
		        		var data_table = $('#datatableMemberList').DataTable();
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

	$scope.getStateData = function(countryId)
	{
		$scope.getGlobalStateData($http,countryId);
    };

    $scope.getCityData = function(stateId)
	{
		$scope.getGlobalCityData($http,stateId);
    };

	 

});
