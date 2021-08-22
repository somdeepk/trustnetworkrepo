mainApp.controller('profileController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.searchMember={};
	$scope.memberData={};
   
	$scope.getMemberData = function(id=0)
	{
		$scope.memberData.type='0';
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

	        		if(aryreturnData.data.memberData.membership_type=='CM')
	        		{
	        			$scope.memberData.church_name=aryreturnData.data.memberData.first_name;
	        		}
	        		$scope.getGlobalStateData($http,$scope.memberData.country);
	        		$scope.getGlobalCityData($http,$scope.memberData.state);
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


    $scope.submitMember = function()
    {
		$scope.memberDataCheck=true ;
		$timeout(function()
		{
			$scope.memberDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.memberData.membership_type=='RM') && (($scope.isNullOrEmptyOrUndefined($scope.memberData.first_name)==true) || ($scope.memberData.first_name=='¿')))
		{
			validator++ ;
		}
		if (($scope.memberData.membership_type=='RM') && (($scope.isNullOrEmptyOrUndefined($scope.memberData.last_name)==true) || ($scope.memberData.last_name=='¿')))
		{
			validator++ ;
		}

		if (($scope.memberData.membership_type=='CM') && (($scope.isNullOrEmptyOrUndefined($scope.memberData.church_name)==true) || ($scope.memberData.church_name=='¿')))
		{
			validator++ ;
		}

		if (($scope.memberData.membership_type=='RM') && (($scope.isNullOrEmptyOrUndefined($scope.memberData.gender)==true) || ($scope.memberData.gender=='¿')))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.dob)==true) || ($scope.memberData.dob=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{		
			var formData = new FormData();
			formData.append('memberData',angular.toJson($scope.memberData));
			angular.forEach($scope.files,function(file){           
				formData.append('file[]',file);
			}); 

			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxupdateeditprofile",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				$scope.memberDataCheck=false ;
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1')
            	{
            		window.location.href=varGlobalAdminBaseUrl+"profileedit";
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
		$("#uploaded_image").html('<img src="'+varImageUrl+'images/member-no-imgage.jpg" class="img-responsive border-blk"  style="margin:0 auto; width:74%;">');
		$('.image-preview').attr("data-content","").popover('hide');
		$('.image-preview-filename').val("");
		$('.image-preview-clear').hide();
		$('.image-preview-input input:file').val("");
		$(".image-preview-input-title").text("Browse"); 
	};

    $scope.resetForm = function()
	{
		$scope.memberData.first_name='';
		$scope.memberData.last_name='';
		$scope.memberData.church_name='';
		$scope.memberData.type='';
		$scope.memberData.gender='';
		$scope.memberData.dob='';
		$scope.memberData.trustee_board='';
		$scope.memberData.marital_status='';
		$scope.memberData.address='';
		$scope.memberData.country='';
		$scope.memberData.state='';
		$scope.memberData.city='';
		$scope.memberData.postal_code='';
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
