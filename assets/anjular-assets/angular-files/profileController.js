mainApp.controller('profileController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
	$scope.searchMember={};
	$scope.memberData={};
   	$scope.memberDataPassNotMtchCheck=false;
   	$scope.memberDataOldNotMtchCheck=false;

	$scope.getMemberData = function(id=0)
	{
		$scope.memberData.type='0';
		$scope.memberData.city='0';
		$scope.memberData.country='0';
		$scope.memberData.state='0';	
		
		$scope.getGlobalCountryData($http);

		if(id>0)
		{
			jsonMemberData=$('.zjsonMemberDataz').html();
			$scope.memberData=angular.fromJson(jsonMemberData);

    		if(!$scope.isNullOrEmptyOrUndefined($scope.memberData.notification_data))
    		{
    			var $notification_data=angular.fromJson($scope.memberData.notification_data);
    			$scope.memberData = $.extend({}, $scope.memberData, $notification_data);
    		}    		

    		if($scope.memberData.membership_type=='CM')
    		{
    			$scope.memberData.church_name=$scope.memberData.first_name;
    		}

    		$scope.getGlobalStateData($http,$scope.memberData.country);
    		$scope.getGlobalCityData($http,$scope.memberData.state);
			
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
			$scope.buttonSavingAnimation('zsubmitMemberz','Saving..','loader');
		
			$timeout(function()
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
	            		$scope.buttonSavingAnimation('zsubmitMemberz','Saved!','onlytext');
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	            		swal("Error!",
			        		"Member addition Failed!",
			        		"error"
			        	)
	            	}
				});
			},1200);
		}
	};



	$scope.submitContactInfo = function()
    {	
    	$scope.buttonSavingAnimation('zsubmitMemberz','Saving..','loader');
		
		$timeout(function()
		{
			var formData = new FormData();
			formData.append('memberData',angular.toJson($scope.memberData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxupdatecontactinfo",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				$scope.memberDataCheck=false ;
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.buttonSavingAnimation('zsubmitMemberz','Saved!','onlytext');
	        		$timeout(function()
					{
						$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	        		swal("Error!",
		        		"Member addition Failed!",
		        		"error"
		        	)
	        	}
			});
		},1200);
	};

	$scope.submitNotification = function()
    {	
		
		$scope.buttonSavingAnimation('zsubmitMemberz','Saving..','loader');
		$timeout(function()
		{
			var formData = new FormData();
			formData.append('memberData',angular.toJson($scope.memberData));
			/*return true;*/
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxupdatenotification",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				$scope.memberDataCheck=false ;
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.buttonSavingAnimation('zsubmitMemberz','Saved!','onlytext');
	        		$timeout(function()
					{
						$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	        		swal("Error!",
		        		"Notification Updation Failed!",
		        		"error"
		        	)
	        	}
			});
		},1200);
	};


	$scope.submitChangePasswordInfo = function()
    {
		$scope.memberDataCheck=true ;
		$timeout(function()
		{
			$scope.memberDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.current_password)==true) || ($scope.memberData.current_password=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.new_password)==true) || ($scope.memberData.new_password=='¿'))
		{
			validator++ ;
		}

		if (($scope.isNullOrEmptyOrUndefined($scope.memberData.verify_password)==true) || ($scope.memberData.verify_password=='¿'))
		{
			validator++ ;
		}

		if ( (($scope.isNullOrEmptyOrUndefined($scope.memberData.new_password)==false) && ($scope.memberData.new_password!='¿')) && (($scope.isNullOrEmptyOrUndefined($scope.memberData.verify_password)==false) && ($scope.memberData.verify_password!='¿')) && ($scope.memberData.new_password!=$scope.memberData.verify_password) )
		{

			$scope.memberDataPassNotMtchCheck=true ;
			$timeout(function()
			{
				$scope.memberDataPassNotMtchCheck=false ;
			},2000);				
			validator++;
		}


		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zsubmitMemberz','Saving..','loader');
		
			$timeout(function()
			{	
				var formData = new FormData();
				formData.append('memberData',angular.toJson($scope.memberData));
				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdatechangepassword",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.memberDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status==2)
	            	{
	            		$scope.memberDataOldNotMtchCheck=true ;
						$timeout(function()
						{
							$scope.memberDataOldNotMtchCheck=false ;
						},2000);

						$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');	            		
	            	}
	            	else if(aryreturnData.status=='1' && aryreturnData.msg=='success')
	            	{
	            		$scope.buttonSavingAnimation('zsubmitMemberz','Saved!','onlytext');
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');

	            		swal("Error!",
			        		"Password Changed Failed!",
			        		"error"
			        	)
	            	}
				});
			},1200);
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

	$scope.resetConatctForm = function()
	{
		$scope.memberData.contact_person='';
		$scope.memberData.contact_mobile='';
		$scope.memberData.contact_alt_mobile='';
		$scope.memberData.alt_email='';
		$scope.memberData.website='';
	};

	$scope.resetChangePasswordForm = function()
	{
		$scope.memberData.current_password='';
		$scope.memberData.new_password='';
		$scope.memberData.verify_password='';
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
