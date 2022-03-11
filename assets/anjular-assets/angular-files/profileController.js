mainApp.controller('profileController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
	$scope.friendData={};
	$scope.peopleYouMayNowObj={};
	$scope.allFriendRequestObj={};
	$scope.allFriendListObj={};
	$scope.allChurchMemberListObj={};
	$scope.allAgeGroupObj={};
	$scope.coverImageData={};
	$scope.aboutMemberDataObj={};

	$scope.peopleYouMayNowData = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
			var formData = new FormData();
			$scope.friendData.clickProfileTab=$rootScope.clickProfileTab;

			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxgetPeopleYouMayNowData",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.peopleYouMayNowObj=aryreturnData.data.friendData;
	        		/*console.log('PYMK')
	        		console.log($scope.peopleYouMayNowObj)*/
	        	}
	        	else
	        	{
	        		//$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	        		console.log("Something went wrong. Please try again later!")
	        	}
			});
			
	    }
    };

    $scope.sendFriendRequest = function(friend_id)
    {	

    	$scope.buttonSavingAnimation('zsendFriendRequestz_'+friend_id,'Requesting..','loader');
		
		$timeout(function()
		{
			$scope.friendData.friend_id=friend_id;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxSendFriendRequest",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.buttonSavingAnimation('zsendFriendRequestz_'+friend_id,'Request Send!','onlytext');
	        		$timeout(function()
					{
						//$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
						/*alert("ss")
						alert($scope.friendData.friend_id);*/
						$scope.peopleYouMayNowData();

						
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zsendFriendRequestz_'+friend_id,'Add Friend','onlytext');
	        		console.log("Request Send Failed!")
	        	}
			});
		},1200);
	};

	$scope.removeFromSuggestion = function(friend_id)
    {	

    	$scope.buttonSavingAnimation('zRemoveFromSuggestionz_'+friend_id,'Removing..','loader');
		
		$timeout(function()
		{
			$scope.friendData.friend_id=friend_id;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxRemoveFromSuggestion",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		/*$scope.buttonSavingAnimation('zRemoveFromSuggestionz_'+friend_id,'Removed!','onlytext');
	        		$timeout(function()
					{*/
						$scope.peopleYouMayNowData();						
					//},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zRemoveFromSuggestionz_'+friend_id,'Remove','onlytext');
	        		console.log("Removal Failed!")
	        	}
			});
		},600);
	};



	$scope.toggleChurchAdmin = function(adminobj,agegroup_id=0)
    {	
    	/*alert(ageGroupId)
    	return false*/
    	var adminid=adminobj.id;
    	var is_admin=adminobj.is_admin;

    	if($(".zmakeChurchAdminz_"+adminid).hasClass('btn-success')){
    		strText="Removing..";
    		strAdmin='N';
    	}else{
    		strText="Creating..";
    		strAdmin='Y';
    	}

    	$scope.buttonSavingAnimation('zmakeChurchAdminz_'+adminid,strText,'loader');		
		$timeout(function()
		{
			$scope.friendData.adminid=adminid;
			$scope.friendData.strAdmin=strAdmin;
			$scope.friendData.agegroup_id=agegroup_id;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"toggleChurchAdmin",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData){
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.getAllChurchMember();
	        		 /*
	        		if(strAdmin=='Y'){
	        			$(".zmakeChurchAdminz_"+adminid).removeClass('btn-primary');
    					$(".zmakeChurchAdminz_"+adminid).addClass('btn-success');
						$(".zmakeChurchAdminz_"+adminid).css("background-color",'#49f0d3');
						$(".zmakeChurchAdminz_"+adminid).css("bordr-color",'#49f0d3');
	        			$(".zmakeChurchAdminz_"+adminid).html('<i class="ri-admin-line"></i>Church Leader');
	        		}else{
	        			$(".zmakeChurchAdminz_"+adminid).removeClass('btn-success');
	        			$(".zmakeChurchAdminz_"+adminid).addClass('btn-primary');
	        			$(".zmakeChurchAdminz_"+adminid).css("background-color",'#50b5ff');
	        			$(".zmakeChurchAdminz_"+adminid).css("bordr-color",'#2aa3fb');
	        			$(".zmakeChurchAdminz_"+adminid).html('<i class="ri-user-add-line"></i>Create Leader')
	        		};   */  		
	        	}
	        	else if(aryreturnData.status=='2')
	        	{
	        		$(".zmakeChurchAdminz_"+adminid).removeClass('btn-primary');
					$(".zmakeChurchAdminz_"+adminid).css("background-color",'#ff9b8a');
	        		$(".zmakeChurchAdminz_"+adminid).css("bordr-color",'#ff9b8a');
					$(".zmakeChurchAdminz_"+adminid).addClass('btn-danger');
					$scope.buttonSavingAnimation('zmakeChurchAdminz_'+adminid,'Age group admin already exist ','onlytext');
	        		$timeout(function()
					{
						$(".zmakeChurchAdminz_"+adminid).removeClass('btn-danger');
	        			$(".zmakeChurchAdminz_"+adminid).css("background-color",'#50b5ff');
	        			$(".zmakeChurchAdminz_"+adminid).css("bordr-color",'#2aa3fb');
						$(".zmakeChurchAdminz_"+adminid).addClass('btn-primary');
	        			$(".zmakeChurchAdminz_"+adminid).html('<i class="ri-user-add-line"></i> Create Leader')	       
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zmakeChurchAdminz_'+adminid,'Create Leader','onlytext');
	        		console.log("Leader Creation Failed!")
	        	}
			});
		},1200);
	};

	$scope.toggleSetMemberLevel = function(adminobj)
    {	
    	var member_id=adminobj.id;
    	var maxmemberlevel=adminobj.maxmemberlevel;


    	if($(".ztoggleSetMemberLevelz_"+member_id).hasClass('btn-success')){
    		strText="Removing..";
    		setlevel="N";
    	}else{
    		strText="Assigning..";
    		setlevel="Y";
    	}

    	$scope.buttonSavingAnimation('ztoggleSetMemberLevelz_'+member_id,strText,'loader');		
		$timeout(function()
		{
			$scope.friendData.member_id=member_id;
			$scope.friendData.setlevel=setlevel;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"toggleSetMemberLevel",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData){
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{

	        		$scope.getAllChurchMember();
	        		/*member_max_level=aryreturnData.data.member_max_level
	        		if(setlevel=='Y'){
	        			$(".ztoggleSetMemberLevelz_"+member_id).removeClass('btn-primary');
    					$(".ztoggleSetMemberLevelz_"+member_id).addClass('btn-success');
						$(".ztoggleSetMemberLevelz_"+member_id).css("background-color",'#49f0d3');
						$(".ztoggleSetMemberLevelz_"+member_id).css("bordr-color",'#49f0d3');
	        			$(".ztoggleSetMemberLevelz_"+member_id).html('<i class="ri-stack-fill"></i>Unset Level ('+member_max_level+')');
	        		}else{
	        			$(".ztoggleSetMemberLevelz_"+member_id).removeClass('btn-success');
	        			$(".ztoggleSetMemberLevelz_"+member_id).addClass('btn-primary');
	        			$(".ztoggleSetMemberLevelz_"+member_id).css("background-color",'#50b5ff');
	        			$(".ztoggleSetMemberLevelz_"+member_id).css("bordr-color",'#2aa3fb');
	        			$(".ztoggleSetMemberLevelz_"+member_id).html('<i class="ri-stack-line"></i>Set Level')
	        		}; */    		
	        	}
	        	else
	        	{
	        		if($(".ztoggleSetMemberLevelz_"+member_id).hasClass('btn-success'))
	        		{
			    		$(".ztoggleSetMemberLevelz_"+member_id).html('<i class="ri-stack-fill"></i>Set Level')
			    	}else{
			    		$(".ztoggleSetMemberLevelz_"+member_id).html('<i class="ri-stack-line"></i>Unset Level')
			    	}

	        		console.log("Set To Level Failed!")
	        	}
			});
		},1200);
	};

	$scope.getAllFriendRequest = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
			var formData = new FormData();
			$scope.friendData.clickProfileTab=$rootScope.clickProfileTab;
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetAllFriendRequest",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.allFriendRequestObj=aryreturnData.data.friendData;
	        	}
	        	else
	        	{
	        		//$scope.buttonSavingAnimation('zsubmitMemberz','Submit','onlytext');
	        		console.log("Something went wrong. Please try again later!")
	        	}
			});
			
	    }
    };

	$scope.confirmFriendRequest = function(member_friends_aid)
    {
    	$scope.buttonSavingAnimation('zconfirmFriendRequestz_'+member_friends_aid,'Confirming..','loader');

		$timeout(function()
		{
			$scope.friendData.member_friends_aid=member_friends_aid;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxConfirmFriendRequest",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.buttonSavingAnimation('zconfirmFriendRequestz_'+member_friends_aid,'Confirmed!','onlytext');
	        		$timeout(function()
					{
						$scope.getAllFriendRequest();						
					},1200);
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zconfirmFriendRequestz_'+member_friends_aid,'Confirm','onlytext');
	        		console.log("Confirmation Failed!")
	        	}
			});
		},600);
	};


	$scope.deleteFromFriendRequest = function(member_friends_aid)
    {
    	$scope.buttonSavingAnimation('zdeleteFromFriendRequestz_'+member_friends_aid,'Deleting..','loader');

		$timeout(function()
		{
			$scope.friendData.member_friends_aid=member_friends_aid;
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxDeleteFromFriendRequest",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.getAllFriendRequest();	
	        	}
	        	else
	        	{
	        		$scope.buttonSavingAnimation('zdeleteFromFriendRequestz_'+member_friends_aid,'Delete Request','onlytext');
	        		console.log("Deletion Failed!")
	        	}
			});
		},600);
	};

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};


	$scope.selectprofileTab = function (user_auto_id,membership_type,is_admin,parent_id,cover_image)
	{
		$scope.coverImageData.exist_cover_image=cover_image;

		$scope.friendData.user_auto_id=user_auto_id;
		$scope.friendData.membership_type=membership_type;
		$scope.friendData.is_admin=is_admin;
		$scope.friendData.parent_id=parent_id;

		hidden_profile_tab=$('#hidden_profile_tab').val();	

		hiddenViewedMemberId=$('#hiddenViewedMemberId').val();
		$rootScope.viewedMemberId=hiddenViewedMemberId;

		//alert(hidden_profile_tab)	
		//$rootScope.clickProfileTab=hidden_profile_tab;
		$rootScope.tabPointer(hidden_profile_tab)
		$rootScope.getMemberData();

		if(hidden_profile_tab=='friendlistTab' || hidden_profile_tab=='churchlistTab' || hidden_profile_tab=='memberlistTab')
		{
			$scope.getAllFriendList();
		}
		else if(hidden_profile_tab=='friendrequestTab' || hidden_profile_tab=='churchrequestTab' || hidden_profile_tab=='memberrequestTab')
		{
			$scope.getAllFriendRequest();
			$scope.peopleYouMayNowData();
		}
		else if(hidden_profile_tab=='churchmemberTab')
		{
			$scope.getAllChurchMember()
		}


	};

	$scope.getAllFriendList = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
			var formData = new FormData();
			$scope.friendData.clickProfileTab=$rootScope.clickProfileTab;
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetAllFriendList",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.allFriendListObj=aryreturnData.data.friendListData;
	        	}
	        	else
	        	{
	        		console.log("Something went wrong. Please try again later!")
	        	}
			});			
	    }
    };

    $scope.getAllChurchMember = function()
	{
		if($scope.friendData.user_auto_id>0)
		{
			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetAllChurchMember",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.allChurchMemberListObj=aryreturnData.data.churchMemberListData;
	        		$scope.allAgeGroupObj=aryreturnData.data.allAgeGroupData;
	        	}
	        	else
	        	{
	        		console.log("Something went wrong. Please try again later!")
	        	}
			});			
	    }
    };


    $scope.initiateUpload=0;
    $image_crop = $('.zCropCoverImagez').croppie({
		enableExif: false,
		viewport: {
		  width:960,
		  height:241,
		  type:'square' //circle
		},
		boundary:{
		  width:960,
		  height:241
		}
	});

	$('#btnUploadCoverImage').click(function(){
	    $(this).val('');
	})  

	$('#btnUploadCoverImage').on('change', function()
	{
		$scope.initiateUpload=1;
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
		$('.zCropCoverImagez').removeClass('hiddenimportant')
		$('.zCoverImgContainerz').addClass('hiddenimportant')
		$('.zProfileImgContainerz').addClass('hiddenimportant')
		$('.zeditCoverz').addClass('hiddenimportant')
		$('.zCropCancelz').removeClass('hiddenimportant')
	});

	$scope.clearCoverImage = function()
	{		
		if(!$scope.isNullOrEmptyOrUndefined($scope.coverImageData.exist_cover_image))
    	{
			$("#uploaded_image").html('<img src="'+varImageUrl+'images/members/coverimages/'+$scope.coverImageData.exist_cover_image+'" alt="Cover Image" class="rounded img-fluid">');
		}
		else
		{
			$("#uploaded_image").html('<img src="'+varImageUrl+'images/members/coverimages/cover-no-image.jpg" alt="Cover Image" class="rounded img-fluid">');
		}
		$('.zCropCoverImagez').addClass('hiddenimportant');
		$('.zCoverImgContainerz').removeClass('hiddenimportant');
		$('.zProfileImgContainerz').removeClass('hiddenimportant');

		$('.zCropCancelz').addClass('hiddenimportant')
		$('.zeditCoverz').removeClass('hiddenimportant')
	};

	$scope.cropCoverImage = function()
    {
		$image_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function(response)
		{
			newImage=response;
			postresponse=response.replace(";", "colone");
			postresponse=postresponse.replace(",", "comma");
			$scope.coverImageData.encode_cover_image=postresponse;
			$scope.coverImageData.id=$scope.friendData.user_auto_id

			if($scope.coverImageData.id>0)
			{
				var formData = new FormData();
				formData.append('coverImageData',angular.toJson($scope.coverImageData)); 

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
	            		$scope.coverImageData.exist_cover_image=aryreturnData.data.imagename;
	            		//alert($scope.coverImageData.exist_cover_image)
	            		data='<img alt="Cover Image" class="rounded img-fluid" src="'+newImage+'">';
						$('.zCoverImgContainerz').html(data);
						$('.zCropCoverImagez').addClass('hiddenimportant');
						$('.zCoverImgContainerz').removeClass('hiddenimportant');
						$('.zProfileImgContainerz').removeClass('hiddenimportant');
						$('.zCropCancelz').addClass('hiddenimportant')
						$('.zeditCoverz').removeClass('hiddenimportant')
	            	}
	            	else
	            	{
	            		$scope.clearCoverImage();
	            		console.log("Cover Image Upload Failed!")
	            	}

				});
	        }
		})
	};


	$scope.placeLiveDataObj={};
	$scope.placeLiveDataObj.current_city={}
	$scope.placeLiveDataObj.current_city.name="";
	$scope.placeLiveDataObj.home_town={}
	$scope.placeLiveDataObj.home_town.name="";

	$scope.preparePlaceObject = function()
    {
    	$scope.selectPlaceLive='';
		$scope.othercityIndx=-1;

		$scope.placeLiveData={};
		$scope.placeLiveData.current_city={};
		$scope.placeLiveData.current_city.name='';

		$scope.placeLiveData.home_town={};
		$scope.placeLiveData.home_town.name='';

		$scope.placeLiveData.other_city={};
		$scope.placeLiveData.other_city.name='';
	};

	$scope.submitPlaceLiveData = function()
    {
		$scope.placeLiveDataCheck=true ;
		$timeout(function()
		{
			$scope.placeLiveDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.selectPlaceLive=='current_city') && ($scope.isNullOrEmptyOrUndefined($scope.placeLiveData.current_city.name)==true || $scope.placeLiveData.current_city.name=='¿'))
		{
			validator++ ;
		}

		if (($scope.selectPlaceLive=='home_town') && ($scope.isNullOrEmptyOrUndefined($scope.placeLiveData.home_town.name)==true || $scope.placeLiveData.home_town.name=='¿'))
		{
			validator++ ;
		}

		if (($scope.selectPlaceLive=='other_city') && ($scope.isNullOrEmptyOrUndefined($scope.placeLiveData.other_city.name)==true || $scope.placeLiveData.other_city.name=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{	
			$scope.buttonSavingAnimation('zsubmit_'+$scope.selectPlaceLive,'Saving..','loader');
		
			$timeout(function()
			{	
				$scope.placeLiveData.selectPlaceLive=$scope.selectPlaceLive;
				$scope.placeLiveData.othercityIndx=$scope.othercityIndx;
				var formData = new FormData();
				formData.append('placeLiveData',angular.toJson($scope.placeLiveData));

				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateplacelivedata",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					$scope.placeLiveDataCheck=false ;
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zsubmit_'+$scope.selectPlaceLive,'Saved!','onlytext');
	            		$timeout(function()
						{
							$scope.placeLiveDataObj=jQuery.parseJSON(aryreturnData.data.memberData.place_live_data);

							$scope.buttonSavingAnimation('zsubmit_'+$scope.selectPlaceLive,'Save','onlytext');							
						},1200);
	            	}
	            	else
	            	{
	            		$scope.buttonSavingAnimation('zsubmit_'+$scope.selectPlaceLive,'Save','onlytext');
	            		console.log("place Live addition Failed!")
	            	}

	            	$timeout(function()
					{
						$scope.preparePlaceObject();					
					},1400);         	
	            	
				});
			},1200);
		}
	};


	$rootScope.getMemberData = function()
    {
    	$scope.preparePlaceObject();

		var formData = new FormData();
		$scope.viewedMemberData={};
		$scope.viewedMemberData.viewedMemberId=$rootScope.viewedMemberId;
		formData.append('viewedMemberData',angular.toJson($scope.viewedMemberData));
		
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxgetmemberdata",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
				$scope.placeLiveDataObj=jQuery.parseJSON(aryreturnData.data.memberData.place_live_data);
				$scope.aboutMemberDataObj=aryreturnData.data.memberData;
				// console.log("MD")
				// console.log($scope.aboutMemberDataObj)
        	}
        	else
        	{
        		console.log("getting member data is failed!")
        	}
		});
	};

	$scope.deletePlaceLeaved = function(indexkey,assocKey='')
    {	
    	swal({
	      title: "Attention",
	      text: "Are you sure to delete",
	      icon: "warning",
	      buttons: true,
	      dangerMode: true,
	    })
	    .then((willDelete) =>
	    {
	    	if (willDelete)
	    	{
				$scope.placeLiveData.indexkey=indexkey;
				$scope.placeLiveData.assocKey=assocKey;

				var formData = new FormData();
				formData.append('placeLiveData',angular.toJson($scope.placeLiveData));
				//alert("fd")
				$http({
		            method  : 'POST',
		            url     : varGlobalAdminBaseUrl+"ajaxdeletePlaceLeaved",
		            transformRequest: angular.identity,
		            headers: {'Content-Type': undefined},                     
		            data:formData, 
		        }).success(function(returnData){
					aryreturnData=angular.fromJson(returnData);
		        	if(aryreturnData.status=='1')
		        	{
		        		$scope.placeLiveDataObj=jQuery.parseJSON(aryreturnData.data.memberData.place_live_data);
		        	}
		        	else
		        	{
		        		console.log("Deletion Failed!")
		        	}
				});
			}
		});
	};


	$image_profile_crop = $('#image_demo').croppie({
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
		var reader = new FileReader();
		reader.onload = function (event)
		{
			$image_profile_crop.croppie('bind', {
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
		$image_profile_crop.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function(response)
		{
			$scope.profileImageData={};
			postresponse=response.replace(";", "colone");
			postresponse=postresponse.replace(",", "comma");
			$scope.profileImageData.encode_profile_image=postresponse;
			$scope.profileImageData.id=$scope.friendData.user_auto_id;

			if($scope.profileImageData.id>0)
			{
				$scope.buttonSavingAnimation('zCropImagez','Saving..','loader');

				var formData = new FormData();
				formData.append('profileImageData',angular.toJson($scope.profileImageData)); 
				$http({
	                method  : 'POST',
	                url     : varGlobalAdminBaseUrl+"ajaxupdateeditprofileimage",
	                transformRequest: angular.identity,
	                headers: {'Content-Type': undefined},                     
	                data:formData, 
	            }).success(function(returnData) {
					aryreturnData=angular.fromJson(returnData);
	            	if(aryreturnData.status=='1')
	            	{
	            		$scope.buttonSavingAnimation('zCropImagez','Saved!','onlytext');
	            		$timeout(function()
						{
							$scope.buttonSavingAnimation('zCropImagez','Crop & Upload Image','onlytext');
							if(!$scope.isNullOrEmptyOrUndefined(aryreturnData.data.imagename))
					    	{
					    		$scope.aboutMemberDataObj.profile_image=aryreturnData.data.imagename;
								$("#header_profile_images").attr("src",varImageUrl+"images/members/"+aryreturnData.data.imagename);
							}
		            		$('#uploadimageModal').modal('hide');

						},1200);

	            		
	            	}
	            	else
	            	{
	            		//$scope.clearProfileImage();
	            		console.log("Profile Image Upload Failed!")
	            	}
				});
	        }

		})
	});

	/*$scope.clearProfileImage = function()
	{
		if(!$scope.isNullOrEmptyOrUndefined($scope.aboutMemberDataObj.profile_image))
    	{
			$("#uploaded_image").html('<img src="'+varImageUrl+'images/members/'+$scope.aboutMemberDataObj.profile_image+'" class="profile-pic" style="margin:0 auto; height:149px;">');
		}
		else
		{
			$("#uploaded_image").html('<img src="'+varImageUrl+'images/member-no-imgage.jpg" class="profile-pic" style="margin:0 auto; height:149px;">');
		}
	};*/

	$scope.editOtherCity = function(name,indx)
    {
		$scope.selectPlaceLive='other_city';
		$scope.placeLiveData.other_city.name=name;
		$scope.othercityIndx=indx;
	};

});
