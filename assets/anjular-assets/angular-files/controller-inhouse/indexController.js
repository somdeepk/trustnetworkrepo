mainApp.controller('indexController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
	$scope.parseInt = parseInt ;	
	$scope.singlePostData={};
	// $scope.memberData={};
	$scope.friendData={};
	$scope.tagPostData={};
	$scope.aryPostScroll=[];

	$scope.tagPostToFriend = function ()
	{
		if($rootScope.loggedUserId>0)
		{
			$scope.friendData.loggedUserId=$rootScope.loggedUserId;
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
	        	UIkit.modal("#create-post-modal").hide();
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
		$scope.tagPostData.searchFriend="";
	    UIkit.modal("#create-post-modal").show();
		$('#tagPostToFriendModal').modal('hide');
	};

	$scope.singlePostData.uploaddata=[];
  	var uploader = new plupload.Uploader({
	    runtimes: "html5",
	    browse_button: "browseFileToUpload",
	    container: document.getElementById('browsecontainer'), // ... or DOM Element itsel
	    url: varBaseUrl+"post/ajaxsubmitpostfiles",
	    chunk_size: "10mb",
	    filters: {
	      max_file_size: "5000mb",
	      mime_types: [{title: "All files", extensions: "jpg,jpeg,png,mp4,wmv,avi,mpeg,3gp,mov"}]
	    },
	    init: {
	      PostInit: () => {
			$("#post_image_preview_container").html('');
	      },
	      FilesAdded: (up, files) => {
	      	$scope.singlePostData.uploaddata=[];
	        plupload.each(files, (file) => {
				$scope.singlePostData.uploaddata.push(file);
				let row = document.createElement("div");
				row.id = file.id;
				row.innerHTML = `${file.name} (${plupload.formatSize(file.size)}) <strong></strong>`;
				$("#post_image_preview_container").append(row);
	        });
	        //uploader.start();
	      },
	      UploadProgress: (up, file) => {
	        document.querySelector(`#${file.id} strong`).innerHTML = `${file.percent}%`;
	      },
	      UploadComplete: (up, file) => {
	        $scope.resetSubmitPost();
	      },
	      Error: (up, err) => { console.error(err); }
	    }
	});
	uploader.init();
  	
  	$scope.resetSubmitPost = function()
  	{
  		$scope.buttonSavingAnimation('zbtnSinglePostz','Posted','onlytext');
		$timeout(function()
		{
			$scope.buttonSavingAnimation('zbtnSinglePostz','Post','onlytext');
			$scope.singlePostData={};
			$scope.tagPostData={};
			$scope.aryPostTagFriend = [];
			$("#post_image_preview_container").html('');
			$scope.singlePostData.uploaddata=[];
			$scope.viewPostPages();
		},1200);
  	};

  	$scope.submitPost = function()
  	{
		$scope.singlePostDataCheck=true ;
		$timeout(function()
		{
			$scope.singlePostDataCheck=false ;
		},2000);
		
		$scope.singlePostData.loggedUserId=$rootScope.loggedUserId;

		var formData = new FormData();
		formData.append('singlePostData',angular.toJson($scope.singlePostData));
		formData.append('aryPostTagFriend',angular.toJson($scope.aryPostTagFriend));
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
			$scope.lastPostId=aryreturnData.data.lastPostId;
			console.log('LPIS')
			// console.log($scope.lastPostId)
        	if(aryreturnData.status=='1' && aryreturnData.msg=='success'  && $scope.lastPostId>0)
        	{        		
        		if($scope.singlePostData.uploaddata.length>0)
        		{
					uploader.start();        			
        		}
        		else
        		{
        			$scope.resetSubmitPost();
        		}        		
          	}
        	else
        	{
        		$scope.buttonSavingAnimation('zbtnSinglePostz','Post','onlytext');
        		console.log("Something went wrong. Please try again later!")      		
        	}
		});
	};

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
        		/*console.log("KANU")
        		console.log($scope.aryPostScroll)*/
        	}
        	else
        	{
        		// swal("Error!",
	        	// 	"No Data Found!",
	        	// 	"error"
	        	// )
        	}
        });
    }
	// we call the function twice to populate the list
	$scope.getMorePostOnScroll();

	$scope.likeTimelinePost = function(timelineId,post_id,module_type)
    {
		$scope.postStatusData={}
		$scope.postStatusData.module_id=post_id;
		$scope.postStatusData.module_type=module_type;
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
				    if (v.id === timelineId)
				    {
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
	
	$scope.changeCommonPostStatus = function(valuePS,idfire)
    {
    	var timelineId=valuePS.id;
		$scope.postStatusData={}
		$scope.postStatusData.timelineId=timelineId;
		$scope.postStatusData.post_id=valuePS.post_id;
		$scope.postStatusData.idfire=idfire;

		var tempDisableComment=0;
		var tempAddFavoritest=0;
		if(idfire=='disabled_comments')
		{			
			if(valuePS.disabled_comments==0)
			{
				tempDisableComment=1;
			}
	    }
	    else if(idfire=='add_favorites')
		{			
			if(valuePS.add_favorites==0)
			{
				tempAddFavoritest=1;
			}
	    }
	    $scope.postStatusData.tempDisableComment=tempDisableComment;
	    $scope.postStatusData.tempAddFavoritest=tempAddFavoritest;

		var formData = new FormData();
		formData.append('postStatusData',angular.toJson($scope.postStatusData));

		$http({
            method  : 'POST',
            url     : varBaseUrl+"post/changeCommonPostStatus",
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
				    if (v.id === timelineId)
				    { 
				    	if(idfire=='hide_post' || idfire=='deleted')
    					{
					    	$scope.aryPostScroll.splice(i,1);
					    }
					    else if(idfire=='disabled_comments')
    					{
					    	$scope.aryPostScroll[i].disabled_comments=tempDisableComment ;
					    }
					    else if(idfire=='add_favorites')
    					{
					    	$scope.aryPostScroll[i].add_favorites=tempAddFavoritest ;
					    }
				    } 
				}); 
        	}
        	else
        	{
        		console.log("Post Status Changed Failed!")
        	}
		});
	};

	/*$scope.GetLimitFriendForTimeline = function ()
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
	*/

	/*
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
	*/


	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
});