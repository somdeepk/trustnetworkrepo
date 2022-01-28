mainApp.controller('indexController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
	$scope.parseInt = parseInt ;	
	$scope.singlePostData={};
	$scope.memberData={};
	$scope.friendData={};
	$scope.tagPostData={};
	$scope.aryPostScroll=[];
	$scope.initiateData = function (user_auto_id,membership_type,is_admin,parent_id)
	{
		$scope.memberData.user_auto_id=user_auto_id;
		$scope.memberData.membership_type=membership_type;
		$scope.memberData.is_admin=is_admin;
		$scope.memberData.parent_id=parent_id;

		$scope.GetLimitFriendForTimeline();
		$scope.GetLimitPhotoForTimeline();
		$rootScope.loadAcceptedInvitedToMeEvents();
	};
   
   	$scope.submitPost = function(){
		$scope.singlePostDataCheck=true ;
		$timeout(function()
		{
			$scope.singlePostDataCheck=false ;
		},2000);
		
		$scope.singlePostData.member_id=$scope.memberData.user_auto_id;

		var formData = new FormData();
		formData.append('singlePostData',angular.toJson($scope.singlePostData));
		formData.append('aryPostTagFriend',angular.toJson($scope.aryPostTagFriend));
		angular.forEach($scope.singlePostData.uploaddata,function(file){    
			formData.append('file[]',file);
		}); 

		$scope.buttonSavingAnimation('zbtnSinglePostz','Posting..','loader');

		$http({
            method  : 'POST',
            url     : varBaseUrl+"post/ajaxsubmitsinglepost",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData) {
			$scope.memberDataCheck=false ;
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
        	{
        		$scope.buttonSavingAnimation('zbtnSinglePostz','Posted','onlytext');
        		$timeout(function()
				{
					$scope.buttonSavingAnimation('zbtnSinglePostz','Post','onlytext');
					$('#postModal').modal('hide');
					$scope.singlePostData={};
					$scope.tagPostData={};
					$scope.aryPostTagFriend = [];
					$('#post_file_upload').val("");
					$scope.singlePostData.uploaddata=[];
					$("#post_image_preview_container").html('');
					//$scope.getMorePostOnScroll();
					location.reload();
				},1200);
          	}
        	else
        	{
        		$scope.buttonSavingAnimation('zbtnSinglePostz','Post','onlytext');
        		swal("Error!",
	        		"Something went wrong. Please try again later!",
	        		"error"
	        	)      		
        	}
		});
	};

	$scope.tagPostToFriend = function ()
	{
		if($scope.memberData.user_auto_id>0)
		{
			$scope.friendData.user_auto_id=$scope.memberData.user_auto_id;
			$scope.friendData.searchFriend=$scope.tagPostData.searchFriend;

			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetAllFriendList",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	$scope.allFriendListObj=aryreturnData.data.friendListData;

	        	$('#tagPostToFriendModal').modal('show');
				$('#postModal').modal('hide');
			});			
	    }		
	};


	$scope.GetLimitFriendForTimeline = function ()
	{
		if($scope.memberData.user_auto_id>0)
		{
			$scope.friendData.user_auto_id=$scope.memberData.user_auto_id;
			$scope.friendData.limit=9;

			var formData = new FormData();
			formData.append('friendData',angular.toJson($scope.friendData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetAllFriendList",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	$scope.limitTimelineFriendListObj=aryreturnData.data.friendListData;
			});			
	    }		
	};	

	$scope.GetLimitPhotoForTimeline = function ()
	{
		if($scope.memberData.user_auto_id>0)
		{
			$scope.photoScrollData={};
			$scope.photoScrollData.row=0;
			$scope.photoScrollData.rowperpage=9;

			var formData = new FormData();
			formData.append('photoScrollData',angular.toJson($scope.photoScrollData));
	        $http({
	            method: 'POST',
	            url     : varBaseUrl+"post/ajaxGetPhotoList",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
		        data:formData,
	        }).success(function(returnData)
	        {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.limitTimelinePhotoListObj=aryreturnData.data.photoScrollData;
	        	}
	        	else
	        	{
	        		swal("Error!",
		        		"Something went wrong. Please try again later!",
		        		"error"
		        	)
	        	}
			});
	    }		
	};


	$scope.aryPostTagFriend = [];
	$scope.setTagFriendToPost = function(memberId)
	{
		if($scope.aryPostTagFriend.length>0)
		{
		  if($.inArray(memberId, $scope.aryPostTagFriend) != -1){
		    $scope.aryPostTagFriend.splice( $.inArray(memberId, $scope.aryPostTagFriend), 1 );
		  }else{
		    $scope.aryPostTagFriend.push(memberId);
		  }
		}else{
		  $scope.aryPostTagFriend.push(memberId);
		}
	};


	$scope.closeTagPostModal = function ()
	{
		$('#postModal').modal('show');
		$('#tagPostToFriendModal').modal('hide');
	};

	$scope.singlePostData.uploaddata=[];
	$scope.singlePostPreviewImages=[];
	var postImgPreHTML="";
	potImagePreviewIncree=0;
	$scope.$on("postFileSelected", function (event, args)
  	{
	    $scope.$apply(function () {
	      var validFormats = ['jpg','jpeg','png']; //'csv','doc','docx','txt','pdf','xls','xlsx',
	      angular.forEach(args, function(vald, key) {
	        validExt=0;
	        validSize=0;
	        var imagesName=vald.name ;
	        var valExt=imagesName.substring(imagesName.lastIndexOf('.') + 1).toLowerCase();
	        if (validFormats.indexOf(valExt) !== -1)
	        {
	          validExt=1;
	        }

	        if(parseInt(vald.size)>0 ) //&& parseInt(vald.size)<=1000000
	        {
	          validSize=1;
	        }

	        if (validExt==1 && validSize==1)
	        {
	        	var img = $('<img/>', {
		          id: 'postPreview'
		        });
		        var reader = new FileReader();
		        reader.onload = function (e) {
					img.attr('src', e.target.result);
					img.attr('class', 'img-fluid rounded w-100');
					if(potImagePreviewIncree==0)
					{
						img.attr('style', 'width: 291px; height:391px;');    
					}
					else
					{
						img.attr('style', 'width: 291px; height:187px;');
					}
					$scope.singlePostPreviewImages.push($(img)[0].outerHTML);
					potImagePreviewIncree++;
		        }        
		        reader.readAsDataURL(vald);
	          	$scope.singlePostData.uploaddata.push(args.file);
	        }
	      });
	    });

		$timeout(function() //187
		{
			if ($scope.isNullOrEmptyOrUndefined($scope.singlePostPreviewImages[0])==false)
			{
				postImgPreHTML='<div class="d-flex" id="post_image_preview_container">\
	                 <div class="col-md-6">\
	                    <a href="javascript:void();">'+$scope.singlePostPreviewImages[0]+'</a>\
	                 </div>';

	            if ($scope.isNullOrEmptyOrUndefined($scope.singlePostPreviewImages[1])==false)
				{
		            postImgPreHTML+='<div class="col-md-6 row m-0 p-0">';

			            postImgPreHTML+='<div class="col-sm-12">\
			                       <a href="javascript:void();">'+$scope.singlePostPreviewImages[1]+'</a>\
			                    </div>';
			            if ($scope.isNullOrEmptyOrUndefined($scope.singlePostPreviewImages[2])==false)
						{
			            postImgPreHTML+='<div class="col-sm-12 mt-3">\
			                       <a href="javascript:void();">'+$scope.singlePostPreviewImages[2]+'</a>\
			                    </div>';
			            }
		            postImgPreHTML+='</div>';
		        }

		        postImgPreHTML+='</div>';

		        if ($scope.singlePostPreviewImages.length>3)
				{
		        	postImgPreHTML+='<div class="col-md-6" style="font-size:62px;">\
	                    <a href="javascript:void();"> +'+($scope.singlePostPreviewImages.length-3)+'</a>\
	                 </div>';
	            }
			}
			$("#post_image_preview_container").html(postImgPreHTML);
		},200);
  	});


	$scope.loadingPost = true;
	$scope.postExist = true;
	$scope.rowlimit = 3;
	$scope.row = 0;
    $scope.rowperpage = $scope.rowlimit;
	$scope.getMorePostOnScroll = function ()
    {
    	$scope.postScrollData={};

    	if($scope.aryPostScroll.length>0)
    	{
    		$scope.postScrollData.row=$scope.aryPostScroll.length;
    	}
    	else
    	{
    		$scope.postScrollData.row=$scope.row;
    	}
    	$scope.postScrollData.rowperpage=$scope.rowperpage;

    	//if($scope.postExist==true)
    	//{
	    	var formData = new FormData();
			formData.append('postScrollData',angular.toJson($scope.postScrollData));
	        $http({
	            method: 'POST',
	            url     : varBaseUrl+"post/ajaxGetPostList",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
		        data:formData,
	        }).then(function successCallback(returnData)
	        {
	            aryreturnData=angular.fromJson(returnData);
	            aryreturnData=aryreturnData.data;
	         	if(aryreturnData.status=='1')
	        	{
		            $scope.row=$scope.row+$scope.rowlimit;
	        		angular.forEach(aryreturnData.data.postScrollData,function(item)
					{
						if( $.grep( $scope.aryPostScroll, function(olditem){ return olditem.post_id===item.post_id; }).length){

						}  
						else
						{
							$scope.aryPostScroll.push(item);
						}					
					});
	
	        		$scope.loadingPost = false;
	        		if(aryreturnData.data.postExist<=0)
	        		{
	        			$scope.postExist = false;
	        		}

	        		// console.log("KANU")
	        		// console.log($scope.aryPostScroll)
	        	}
	        	else
	        	{
	        		// swal("Error!",
		        	// 	"No Data Found!",
		        	// 	"error"
		        	// )
	        	}
	        });
	    //}
    }
	// we call the function twice to populate the list
	$scope.getMorePostOnScroll();

	$scope.hideTimelinePost = function(timelineId)
    {	
    	//console.log($scope.aryPostScroll)
		$scope.postStatusData={}
		$scope.postStatusData.timelineId=timelineId;
		$scope.postStatusData.status="H";

		var formData = new FormData();
		formData.append('postStatusData',angular.toJson($scope.postStatusData));
		//alert("fd")
		$http({
            method  : 'POST',
            url     : varBaseUrl+"post/hideTimelinePost",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData){
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$scope.postStatusData={}
				var result = $scope.aryPostScroll.filter(function(v,i)
				{  
				    if (v.id === timelineId){ $scope.aryPostScroll.splice(i,1) } 
				}); 
        		//console.log($scope.aryPostScroll)
        	}
        	else
        	{
        		console.log("Hiding from timeline Failed!")
        	}
		});
	};

	$scope.likeTimelinePost = function(timelineId,post_id)
    {	
		$scope.postStatusData={}
		$scope.postStatusData.post_id=post_id;
		var formData = new FormData();
		formData.append('postStatusData',angular.toJson($scope.postStatusData));
		$http({
            method  : 'POST',
            url     : varBaseUrl+"post/likeTimelinePost",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData){
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$scope.postStatusData={}
        		var strDeleted=aryreturnData.data.strDeleted;
        		var postLikeData=aryreturnData.data.postLikeData;

        		var result = $scope.aryPostScroll.filter(function(v,i)
				{  
				    if (v.id === timelineId){
				     $scope.aryPostScroll[i].indv_post_like_unlike=strDeleted ;
				     $scope.aryPostScroll[i].post_like_data=postLikeData ;
				 	} 
				}); 

        		//console.log($scope.aryPostScroll)
        	}
        	else
        	{
        		console.log("Like Unlike Failed!")
        	}
		});
	};

	$scope.commentTimelinePost = function(valuePS)
    {	
    	
    	timelineId=valuePS.id;
    	post_id=valuePS.post_id;
    	member_comment=$.trim(valuePS.member_comment);

		$scope.postCommentData={}
		$scope.postCommentData.post_id=post_id;
		$scope.postCommentData.timelineId=timelineId;
		$scope.postCommentData.member_comment=member_comment;

		if(member_comment!="")
		{
			var formData = new FormData();
			formData.append('postCommentData',angular.toJson($scope.postCommentData));
			$http({
	            method  : 'POST',
	            url     : varBaseUrl+"post/commentTimelinePost",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData){
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.postCommentData={};

	        		var postCommentData=aryreturnData.data.postCommentData;
	        		var postAllCommentData=aryreturnData.data.postAllCommentData;
	        		var result = $scope.aryPostScroll.filter(function(v,i)
					{  
					    if (v.id === timelineId)
					    {
					    	// alert(v.id+" -- "+timelineId)
					    	// console.log($scope.aryPostScroll);
					    	$scope.aryPostScroll[i].post_comment_data=postCommentData ;
					    	$scope.aryPostScroll[i].all_post_comment_data=postAllCommentData ;
					    	$scope.aryPostScroll[i].member_comment='' ;
					 	} 
					}); 


	        	}
	        	else
	        	{
	        		console.log("Commenting Failed!")
	        	}
			});
	    }
	};

	$scope.OpenPostPopUp = function (id) {
		$('#exampleModal_'+id).modal('show');
	};


	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
});