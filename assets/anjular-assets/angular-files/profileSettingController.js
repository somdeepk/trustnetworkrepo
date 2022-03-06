mainApp.controller('profileSettingController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
   	$scope.memberDataPassNotMtchCheck=false;
   	$scope.memberDataOldNotMtchCheck=false;
   	$scope.groupData={};
   	$scope.srchChurchData={};

   	$scope.pageData={};
   	$scope.pageData.page_category='';

   	$scope.coverImageData={};

	$scope.initProfileSetting = function()
	{
		var profileSettingData=$scope.baseencoded_profileSettingData;
	    var profileSettingDataStr=atob(profileSettingData);
	    var profileSettingDataObj=jQuery.parseJSON(profileSettingDataStr);
		$scope.profileSettingData=profileSettingDataObj;
		$scope.generalData=profileSettingDataObj.memberData;

		$scope.srchChurchData.searchChurch=$scope.generalData.churchName;
		$scope.generalData.assignParentId=$scope.generalData.parent_id;
		$scope.coverImageData.exist_cover_image=$scope.generalData.cover_image;

		if($scope.generalData.inactive_account=="1")
		{
			$scope.generalData.inactive_account=true;
		}
		else
		{
			$scope.generalData.inactive_account=false;
		}

		if($scope.generalData.delete_account=="1")
		{
			$scope.generalData.delete_account=true;
		}
		else
		{
			$scope.generalData.delete_account=false;
		}

		$scope.questionData=jQuery.parseJSON(profileSettingDataObj.memberData.profile_question);
		$scope.securityData=jQuery.parseJSON(profileSettingDataObj.memberData.security_data);
		$scope.notificationData=jQuery.parseJSON(profileSettingDataObj.memberData.notification_data);

		// console.log('sddsd');
		// console.log($scope.generalData);
		
		// $scope.getGlobalCountryData($http);
		// if($scope.profileSettingData.memberData.id>0)
		// {
		// 	$scope.getGlobalStateData($http,$scope.profileSettingData.memberData.country);
		// 	$scope.getGlobalCityData($http,$scope.profileSettingData.memberData.state);
		// }
    };

    $scope.submitProfileGeneralData = function()
    {
		$scope.generalDataCheck=true ;
		$timeout(function()
		{
			$scope.generalDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.generalData.first_name)==true) || ($scope.generalData.first_name=='¿'))
		{
			validator++ ;
		}

		if (($scope.generalData.membership_type=='RM') && (($scope.isNullOrEmptyOrUndefined($scope.generalData.last_name)==true) || ($scope.generalData.last_name=='¿')))
		{
			validator++ ;
		}

		if (($scope.generalData.membership_type=='RM') && ($scope.isNullOrEmptyOrUndefined($scope.generalData.assignParentId)==true || $scope.generalData.assignParentId==0 ))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{
			$scope.buttonSavingAnimation('zsubmitGeneralDataz','Saving..','loader');
		
			$timeout(function()
			{	
				var formData = new FormData();
				formData.append('generalData',angular.toJson($scope.generalData));

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditgeneraldata",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.generalDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		if ($scope.generalData.membership_type=='RM' && $scope.isNullOrEmptyOrUndefined($scope.generalData.assignParentId)==false)
						{
							$scope.generalData.parent_id=$scope.generalData.assignParentId
						}
	            		

	            		$scope.buttonSavingAnimation('zsubmitGeneralDataz','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($scope.profileSettingData.memberData.id);
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zsubmitGeneralDataz','Save','onlytext');
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zsubmitGeneralDataz','Save','onlytext');
	            		console.log("Member addition Failed!")
	            	}
				});
			},1200);
		}
	};

    $scope.submitQuestionData = function()
    {
		$scope.questionDataCheck=true ;
		$timeout(function()
		{
			$scope.questionDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q1)==true) || ($scope.questionData.q1=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q2)==true) || ($scope.questionData.q2=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q3)==true) || ($scope.questionData.q3=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q4)==true) || ($scope.questionData.q4=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q5)==true) || ($scope.questionData.q5=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q6)==true) || ($scope.questionData.q6=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.questionData.q7)==true) || ($scope.questionData.q7=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zsubmitQuestionDataz','Saving..','loader');
		
			$timeout(function()
			{	

				$scope.questionData.id=$scope.profileSettingData.memberData.id;

				var formData = new FormData();
				formData.append('questionData',angular.toJson($scope.questionData));

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditquestiondata",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.questionDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zsubmitQuestionDataz','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($scope.profileSettingData.memberData.id);
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zsubmitQuestionDataz','Save','onlytext');
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zsubmitQuestionDataz','Save','onlytext');
	            		console.log("Question Answer addition Failed!")
	            	}
				});
			},1200);
		}
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
				$scope.memberData.id=$scope.profileSettingData.memberData.id;
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

						$scope.buttonSavingAnimation('zsubmitMemberz','Save','onlytext');	            		
	            	}
	            	else if(aryreturnData.status=='1' && aryreturnData.msg=='success')
	            	{
	            		$scope.resetChangePasswordForm();
	            		$scope.buttonSavingAnimation('zsubmitMemberz','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($scope.profileSettingData.memberData.id);
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zsubmitMemberz','Save','onlytext');
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zsubmitMemberz','Save','onlytext');
	            		console.log("Password Changed Failed!")
	            	}
				});
			},1200);
		}
	};

	$scope.resetChangePasswordForm = function()
	{
		$scope.memberData.current_password='';
		$scope.memberData.new_password='';
		$scope.memberData.verify_password='';
	};

	$scope.searchChurchToTag = function ()
	{
		$scope.srchChurchData.searchChurch=$scope.srchChurchData.searchChurch;

		var formData = new FormData();
		formData.append('srchChurchData',angular.toJson($scope.srchChurchData));
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxGetAllChurches",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			aryreturnData=angular.fromJson(returnData);
        	$rootScope.allChurchMemberObj=aryreturnData.data.churchData;
		});
	};

	$scope.setRegularMemebrUnderChurch = function (objVal)
	{
		$scope.generalData.assignParentId=objVal.id;
		$scope.srchChurchData.searchChurch=objVal.first_name;
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
	

	$scope.submitGroup = function()
    {		
		$scope.groupDataCheck=true ;
		$timeout(function()
		{
			$scope.groupDataCheck=false ;
		},2000);

		var validator=0;

		if (($scope.isNullOrEmptyOrUndefined($scope.groupData.group_name)==true) || ($scope.groupData.group_name=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.groupData.group_description)==true) || ($scope.groupData.group_description=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zcreateGroup','Saving..','loader');		
			$timeout(function()
			{	
				var formData = new FormData();
				$scope.groupData.loggedUserId = $rootScope.loggedUserId;
				formData.append('groupData',angular.toJson($scope.groupData));

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditgroupdata",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.groupDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zcreateGroup','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($rootScope.loggedUserId);
	            		$timeout(function()
						{
							$scope.resetGroup();
							$scope.buttonSavingAnimation('zcreateGroup','Create Now','onlytext');
						},1200);


	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zcreateGroup','Create Now','onlytext');
	            		console.log("Group Ceation Failed!");
	            	}
				});
			},1200);
		}	

	};


	$scope.resetGroup = function()
	{
		$scope.groupData={};
	};


	$scope.submitSecurity = function()
    {	
		
		$scope.buttonSavingAnimation('zsubmitSecurity','Saving..','loader');
		$timeout(function()
		{
			var formData = new FormData();
			$scope.securityData.loggedUserId = $rootScope.loggedUserId;
			formData.append('securityData',angular.toJson($scope.securityData));

			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxupdatesecuritydata",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.buttonSavingAnimation('zsubmitSecurity','Saved!','onlytext');
	        		$rootScope.getLoggedUserData($rootScope.loggedUserId);
	        		$timeout(function()
					{
						$scope.buttonSavingAnimation('zsubmitSecurity','Save','onlytext');
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zsubmitSecurity','Save','onlytext');
	        		console.log("Security Updation Failed!");	        		
	        	}
			});
		},1200);
	};


	$scope.submitNotification = function()
    {	
		
		$scope.buttonSavingAnimation('zsubmitNotification','Saving..','loader');
		$timeout(function()
		{
			var formData = new FormData();
			$scope.notificationData.loggedUserId = $rootScope.loggedUserId;
			formData.append('notificationData',angular.toJson($scope.notificationData));

			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxupdatenotificationdata",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.buttonSavingAnimation('zsubmitNotification','Saved!','onlytext');
	        		$rootScope.getLoggedUserData($rootScope.loggedUserId);
	        		$timeout(function()
					{
						$scope.buttonSavingAnimation('zsubmitNotification','Save','onlytext');
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zsubmitNotification','Save','onlytext');
	        		console.log("Notification Updation Failed!");	        		
	        	}
			});
		},1200);
	};


	$scope.submitPage = function()
    {		
		$scope.pageDataCheck=true ;
		$timeout(function()
		{
			$scope.pageDataCheck=false ;
		},2000);

		var validator=0;

		if (($scope.isNullOrEmptyOrUndefined($scope.pageData.page_name)==true) || ($scope.pageData.page_name=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.pageData.page_url)==true) || ($scope.pageData.page_url=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.pageData.page_category)==true) || ($scope.pageData.page_category=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.pageData.page_description)==true) || ($scope.pageData.page_description=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.pageData.meta_title)==true) || ($scope.pageData.meta_title=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.pageData.meta_keyword)==true) || ($scope.pageData.meta_keyword=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.pageData.meta_description)==true) || ($scope.pageData.meta_description=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zcreatePage','Saving..','loader');		
			$timeout(function()
			{	
				var formData = new FormData();
				$scope.pageData.loggedUserId = $rootScope.loggedUserId;
				formData.append('pageData',angular.toJson($scope.pageData));

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditpagedata",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.pageDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zcreatePage','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($rootScope.loggedUserId);
	            		$timeout(function()
						{
							$scope.resetPage();
							$scope.buttonSavingAnimation('zcreatePage','Create Now','onlytext');
						},1200);


	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zcreatePage','Create Now','onlytext');
	            		console.log("Page Ceation Failed!");
	            	}
				});
			},1200);
		}	
	};


	$scope.resetPage = function()
	{
		$scope.pageData={};
	};


	/************Start Profile Image Secton***********/
	$scope.submitAccountActiveDelete = function()
    {	
		
		$scope.buttonSavingAnimation('zsubmitAccountActiveDeletez','Saving..','loader');
		$timeout(function()
		{
			var formData = new FormData();
			$scope.generalData.loggedUserId = $rootScope.loggedUserId;
			formData.append('generalData',angular.toJson($scope.generalData));

			// console.log($scope.generalData.inactive_account+' --- '+$scope.generalData.delete_account); return false;

			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxupdatedeletedata",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {

	        	// console.log(returnData); return false;

				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.buttonSavingAnimation('zsubmitAccountActiveDeletez','Saved!','onlytext');
	        		$rootScope.getLoggedUserData($rootScope.loggedUserId);
	        		$timeout(function()
					{
						$scope.buttonSavingAnimation('zsubmitAccountActiveDeletez','Submit','onlytext');
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zsubmitAccountActiveDeletez','Submit','onlytext');
	        		console.log("Deletion Updation Failed!");	        		
	        	}
			});
		},1200);
	};

	$image_crop = $('#image_demo').croppie({
		enableExif: true,
		viewport: {
		  width:200,
		  height:200,
		  type:'square' //circle
		},
		boundary:{
		  width:300,
		  height:300
		}
	});

	$('#upload_image').click(function(){
	    $(this).val('');
	})  

	$('#upload_image').on('change', function()
	{
		// alert('zzzz');
		var reader = new FileReader();
		reader.onload = function (event)
		{
			$image_crop.croppie('bind', {
			url: event.target.result
			}).then(function()
			{
				console.log('jQuery bind complete');
			});
		}
		reader.readAsDataURL(this.files[0]);
		$('#uploadimageModal').modal('show');
	});

	$('.zCropImagez').click(function(event)
	{
		$image_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function(response)
		{
			data='<img class="profile-pic" src="'+response+'" style="margin:0 auto; height:149px;">';
			response=response.replace(";", "colone");
			response=response.replace(",", "comma");
			$scope.generalData.hidden_image_encode=response;
			$scope.submitImage();
		})
	});

	/*$scope.clearProfileImage = function()
	{
		if(!$scope.isNullOrEmptyOrUndefined($scope.generalData.profile_image))
    	{
			$("#uploaded_image").html('<img src="'+varImageUrl+'images/members/'+$scope.generalData.profile_image+'" class="profile-pic" style="margin:0 auto; height:149px;">');
		}
		else
		{
			$("#uploaded_image").html('<img src="'+varImageUrl+'images/member-no-imgage.jpg" class="profile-pic" style="margin:0 auto; height:149px;">');
		}
	};
*/

	$scope.submitImage = function()
    {
		$scope.generalDataCheck=true ;
		$timeout(function()
		{
			$scope.generalDataCheck=false ;
		},2000);

		var validator=0;

		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zCropImagez','Saving..','loader');
		
			$timeout(function()
			{	
				var formData = new FormData();
				$scope.generalData.loggedUserId = $rootScope.loggedUserId;
				formData.append('generalData',angular.toJson($scope.generalData));
				
				angular.forEach($scope.files,function(file){           
					formData.append('file[]',file);
				}); 

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditimage",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {

	            	// console.log(returnData); return false;

					$scope.generalDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zCropImagez','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($rootScope.loggedUserId);
	            		$timeout(function()
						{
							$('#uploadimageModal').modal('hide');
							$('#uploaded_image').html(data);
							$scope.buttonSavingAnimation('zCropImagez','Crop & Upload Image','onlytext');
						},1200);

						if(!$scope.isNullOrEmptyOrUndefined(aryreturnData.data.imagename))
				    	{
				    		$scope.generalData.profile_image=aryreturnData.data.imagename;
				    		$scope.generalData.hidden_image_encode='';
						}
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zCropImagez','Crop & Upload Image','onlytext');	            		
			        	console.log("Image Upload Failed!");
	            	}
				});
			},1200);
		}
	};

	/************End Profile Image Secton***********/



	/************Start Cover Image Secton***********/

	$scope.initiateUpload=0;
    $cover_image_crop = $('.zCropCoverImagez').croppie({
		enableExif: false,
		viewport: {
		  width:500,
		  height:175,
		  type:'square' //circle
		},
		boundary:{
		  width:500,
		  height:175
		}
	});

	$('#btnUploadCoverImage').click(function(){
	    $(this).val('');
	});  

	$('#btnUploadCoverImage').on('change', function()
	{
		$scope.initiateUpload=1;
		var reader = new FileReader();
		reader.onload = function (event)
		{
			$cover_image_crop.croppie('bind', {
			url: event.target.result
			}).then(function()
			{
				console.log('jQuery bind complete');
			});
		}
		reader.readAsDataURL(this.files[0]);
		$('.zCropCoverImagez').removeClass('hiddenimportant');
		$('.zCoverImgContainerz').addClass('hiddenimportant');
		$('.zProfileImgContainerz').addClass('hiddenimportant');
		$('.zeditCoverz').addClass('hiddenimportant');
		$('.zCropCancelz').removeClass('hiddenimportant');
	});

	$scope.clearCoverImage = function()
	{		
		$('.zCropCoverImagez').addClass('hiddenimportant');
		$('.zCoverImgContainerz').removeClass('hiddenimportant');
		$('.zProfileImgContainerz').removeClass('hiddenimportant');

		$('.zCropCancelz').addClass('hiddenimportant');
		$('.zeditCoverz').removeClass('hiddenimportant');
	};

	$scope.cropCoverImage = function()
    {
		$cover_image_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function(response)
		{
			newImage=response;
			postresponse=response.replace(";", "colone");
			postresponse=postresponse.replace(",", "comma");
			$scope.coverImageData.encode_cover_image=postresponse;
			$scope.coverImageData.id=$scope.profileSettingData.memberData.id;

			if($scope.coverImageData.id>0)
			{
				var formData = new FormData();
				formData.append('coverImageData',angular.toJson($scope.coverImageData)); 
				$scope.buttonSavingAnimation('zCropCoverBtnImagez','Saving..','loader');
				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditcoverimage",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zCropCoverBtnImagez','Saved!','onlytext');
	            		$rootScope.getLoggedUserData($rootScope.loggedUserId);
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zCropCoverBtnImagez','Crop & Upload Image','onlytext');
							$rootScope.getLoggedUserData($rootScope.loggedUserId);
		            		$scope.coverImageData.exist_cover_image=aryreturnData.data.imagename;
		            		data='<img alt="Cover Image" class="rounded img-fluid" src="'+newImage+'">';
							$('.zCoverImgContainerz').html(data);
							$('.zCropCoverImagez').addClass('hiddenimportant');
							$('.zCoverImgContainerz').removeClass('hiddenimportant');
							$('.zProfileImgContainerz').removeClass('hiddenimportant');
							$('.zCropCancelz').addClass('hiddenimportant');
							$('.zeditCoverz').removeClass('hiddenimportant');
						},1200);
	            		
	            	}
	            	else
	            	{
	            		$scope.clearCoverImage();
	            		$scope.buttonSavingAnimation('zCropCoverBtnImagez','Crop & Upload Image','onlytext');
	            		console.log("Cover Image Upload Failed!");
	            	}

				});
	        }
		})
	};

	/************End Profile Image Secton***********/

});