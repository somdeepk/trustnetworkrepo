mainApp.controller('taskController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
	
	$scope.parseInt = parseInt ;
	$scope.parseFloat = parseFloat 
		
    $scope.taskData={};
    $scope.videoIncree=0;
    $scope.videoDataCheck=false ;
    $scope.emptyVideoCheck=false ;
    $scope.videoExtensionCheck=false ;
    $scope.session_is_admin='N';
    $scope.allVideoListObj={};
    $scope.allLiveStreamVideoData={};
    $scope.liveStreamData={};
    $scope.agoraData={};
    $scope.goliveStreamData={};
    $scope.files = [];
    $scope.liveStreamingMemberListObj={};
    $scope.examData={};
    $scope.allExamListObj={};

	

    $scope.call_member_watch_task_video_by_level = function ()
	{
		//alert("fdf")
		$interval(function()
	    {
			$('.zminThreeVideoz').each(function(index, value)
			{
				tempid=this.id;	
				membershiptype=$(this).attr("data-membershiptype");
				is_admin=$(this).attr("data-isadmin");
				if(is_admin=='N' && membershiptype=='RM')
				{
					video = $('#'+tempid).get(0);
					if(video.currentTime>0)
					{										
						$scope.track_member_watch_task_video_by_level(tempid);
						//video.ended==true
					}
				}			
			});
		}, 2000);

		//Start ajax call and see is leader started any video streaming
		$interval(function()
	    {
	    	/*$scope.get_live_stream_video_by_level();
	    	$scope.get_live_streaming_member_by_leve();*/
	    }, 20000);
	    //End ajax call and see is leader started any video streaming

		$timeout(function()
		{
			if($('.zgoLivez').length>0)
			{
				$('.zgoLivez').each(function(index, value)
				{
					if($(this).hasClass("blink_me"))
					{
						tempthis=this;	
						islive=1;
					}		
				});

				if(islive==1)
				{
					$(".zgoLivez").addClass('cssdisabled');
					$(tempthis).removeClass('cssdisabled');
				}
			}
		

		},300);

	};

	$scope.getTaskData = function (user_auto_id,parent_id,membership_type,is_admin)
	{
		//alert("")
		hidden_leader_id=$('#hidden_leader_id').val();	
		hidden_course_id=$('#hidden_course_id').val();	
		hidden_task_level=$('#hidden_task_level').val();	
		jsonTaskVideoLevelData=$('#jsonTaskVideoLevelData').html();	
		jsonLiveStreamVideoData=$('#jsonLiveStreamVideoData').html();	

		if (($scope.isNullOrEmptyOrUndefined(jsonTaskVideoLevelData)==false))
		{
			$scope.allVideoListObj=jQuery.parseJSON(jsonTaskVideoLevelData);
		}
		if (($scope.isNullOrEmptyOrUndefined(jsonLiveStreamVideoData)==false))
		{
			$scope.allLiveStreamVideoData=jQuery.parseJSON(jsonLiveStreamVideoData);
		}

		$scope.session_is_admin=is_admin;
		$scope.taskData.leader_id=hidden_leader_id;
		$scope.taskData.course_id=hidden_course_id;
		$scope.taskData.task_level=hidden_task_level;
		$scope.taskData.user_auto_id=user_auto_id;
		$scope.taskData.parent_id=parent_id;
		$scope.taskData.membership_type=membership_type;

		$scope.call_member_watch_task_video_by_level();
		$scope.getAllTaskLevelExam();
	};



    //listen for the file selected event
    $scope.$on("fileSelected", function (event, args) {
        $scope.$apply(function () {            
            /*var img = $('<img/>', {
              id: 'dynamic',
              width:200,
              height:150
            });    */  
            $scope.files[0] = args.file;
            /*var reader = new FileReader();
            // Set preview image into the popover data-content
            reader.onload = function (e) {
                $(".image-preview-input-title").text("Change");
                $(".image-preview-clear").show();
                $(".image-preview-filename").val($scope.files[0].name);   
                img.attr('src', e.target.result);
                $("#uploaded_image").html($(img)[0].outerHTML);
            }        
            reader.readAsDataURL($scope.files[0]);*/
        });
    });

    $scope.uploadVideo = function(video_number)
    {
		$scope.videoIncree=video_number ;
		$scope.videoDataCheck=true ;
		$timeout(function()
		{
			$scope.videoDataCheck=false ;
		},2000);

		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.files[0])==true))
		{
			$scope.emptyVideoCheck=true ;
			$timeout(function()
			{
				$scope.emptyVideoCheck=false ;
			},2000);
            validator++ ;
		}
		else
		{
			$validExtenson=0;
			if ($scope.files[0].type=='video/mp4' || $scope.files[0].type=='video/wmv' || $scope.files[0].type=='video/avi' || $scope.files[0].type=='video/3gp' || $scope.files[0].type=='video/mov' || $scope.files[0].type=='video/mpeg')
			{
				$validExtenson=1;
			}
			
			if($validExtenson==0)
			{
				$scope.videoExtensionCheck=true ;
				$timeout(function()
				{
					$scope.videoExtensionCheck=false ;
				},3500);
	            validator++ ;
			}
		}
		
		if (Number(validator)==0)
		{	

			$scope.taskData.old_video=$scope.allVideoListObj[(video_number-1)].video_name;
			$scope.buttonSavingAnimation('zuploadtaskvideonz_'+video_number,'Uploading..','loader');
			$scope.taskData.video_number=video_number;

			var formData = new FormData();
			formData.append('taskData',angular.toJson($scope.taskData));
			angular.forEach($scope.files,function(file){           
				formData.append('file[]',file);
			}); 

			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxaddupdatevideo",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            	{
            		$scope.files = [];
            		$('#input_file_upload_'+video_number).val("");

            		$scope.allVideoListObj=aryreturnData.data.taskMin3VideoLevelData;

            		$scope.buttonSavingAnimation('zuploadtaskvideonz_'+video_number,'Uploaded!','onlytext');
            		$timeout(function()
					{
						$scope.buttonSavingAnimation('zuploadtaskvideonz_'+video_number,'Upload','onlytext');
					},1200);
            	}
            	else
            	{
            		$scope.files = [];
            		$('#input_file_upload_'+video_number).val("");
            		$scope.buttonSavingAnimation('zuploadtaskvideonz_'+video_number,'Upload','onlytext');
            		swal("Error!",
		        		"Video Set Failed!",
		        		"error"
		        	)
            	}
			});
		}
	};

	/*$scope.clearProfileImage = function()
	{
		$scope.files = [];
		$scope.memberData.profile_image = '';
		$("#uploaded_image").html('<img src="'+varBaseUrl+'assets/images/member-no-imgage.jpg" class="img-responsive border-blk"  style="margin:0 auto; width:74%;">');
		$('.image-preview').attr("data-content","").popover('hide');
		$('.image-preview-filename').val("");
		$('.image-preview-clear').hide();
		$('.image-preview-input_1 input:file').val("");
		$(".image-preview-input-title_1").text("Browse"); 
	};	*/


	$scope.uploadliveStreamVideo = function()
	{
		$scope.files = [];
		$scope.liveStreamData={}
		$scope.liveStreamData.id=0;

		$('#file_ls_video_upload').val("");
		$('.zheadslz').html("Add Stream Schedule");
		$('#uploadliveStreamVideoModal').modal('show');
	};

	$scope.submitLiveStreamVideo = function()
    {
		$scope.liveStreamDataCheck=true ;
		$timeout(function()
		{
			$scope.liveStreamDataCheck=false ;
		},2000);

		//alert($scope.liveStreamData.start_time)
		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.liveStreamData.video_title)==true) || ($scope.liveStreamData.video_title=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.liveStreamData.start_time)==true) || ($scope.liveStreamData.start_time=='¿'))
		{
			validator++ ;
		}
		/*if (($scope.isNullOrEmptyOrUndefined($scope.liveStreamData.end_time)==true) || ($scope.liveStreamData.end_time=='¿'))
		{
			validator++ ;
		}*/
		/*if (($scope.isNullOrEmptyOrUndefined($scope.files[0])==true))
		{
			$scope.emptyLiveStreamVideoCheck=true ;
			$timeout(function()
			{
				$scope.emptyLiveStreamVideoCheck=false ;
			},2000);
            validator++ ;
		}
		else
		{
			$validExtenson=0;
			if ($scope.files[0].type=='video/mp4' || $scope.files[0].type=='video/wmv' || $scope.files[0].type=='video/avi' || $scope.files[0].type=='video/3gp' || $scope.files[0].type=='video/mov' || $scope.files[0].type=='video/mpeg')
			{
				$validExtenson=1;
			}
			
			if($validExtenson==0)
			{
				$scope.emptyLiveStreamVideoExtensionCheck=true ;
				$timeout(function()
				{
					$scope.emptyLiveStreamVideoExtensionCheck=false ;
				},3500);
	            validator++ ;
			}
		}
		*/
		if (Number(validator)==0)
		{
			$scope.buttonSavingAnimation('zuploadlivestreamvideoz','Submitting..','loader');
			$scope.liveStreamData.course_id=$scope.taskData.course_id;
			$scope.liveStreamData.task_level=$scope.taskData.task_level;
			$scope.liveStreamData.user_auto_id=$scope.taskData.user_auto_id;
			$scope.liveStreamData.parent_id=$scope.taskData.parent_id;
			$scope.liveStreamData.membership_type=$scope.taskData.membership_type;

			var formData = new FormData();
			formData.append('LSVideoData',angular.toJson($scope.liveStreamData));
			angular.forEach($scope.files,function(file){           
				formData.append('file[]',file);
			}); 

			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxaddupdatestreamvideo",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            	{            		
            		$scope.buttonSavingAnimation('zuploadlivestreamvideoz','Submited!','onlytext');
            		$timeout(function()
					{
						$scope.buttonSavingAnimation('zuploadlivestreamvideoz','Submit Schedule','onlytext');
						$scope.files = [];
	            		$scope.liveStreamData={}
	            		$('#file_ls_video_upload').val("");
	            		$scope.allLiveStreamVideoData=aryreturnData.data.liveStreamVideoData;
					},1200);
					$timeout(function()
					{
						$('#uploadliveStreamVideoModal').modal('hide');
					},1800);					
            	}
            	else
            	{
            		$scope.files = [];
            		$scope.liveStreamData={}
            		$('#file_ls_video_upload').val("");
            		$scope.buttonSavingAnimation('zuploadlivestreamvideoz','Submit Schedule','onlytext');
            		$('#uploadliveStreamVideoModal').modal('hide');
            		swal("Error!",
		        		"Live Stream Video Set Failed!",
		        		"error"
		        	)		        	
            	}
			});
		}
	};

	$scope.editStreamVideo = function(valobj)
    {	
    	$scope.files = [];
		$scope.liveStreamData={}
		$('#file_ls_video_upload').val("");
		if(valobj.is_admin=="Y")
		{
			$('.zheadslz').html("Edit Stream Schedule");
		}
		else
		{
			$('.zheadslz').html("View Stream Schedule");
		}
		

    	$scope.liveStreamData.id=valobj.id;
    	//$scope.liveStreamData.old_video=valobj.video_name;
    	$scope.liveStreamData.video_title=valobj.video_title;
    	$scope.liveStreamData.start_time=valobj.start_time;
    	//$scope.liveStreamData.end_time=valobj.end_time;
    	$scope.liveStreamData.description=valobj.description;
    	$('#uploadliveStreamVideoModal').modal('show');    	
	};

	$scope.activeInactiveStreamVideo = function(valobj)
    {	
    	var id=valobj.id;
    	var status=valobj.status;

    	if($(".zactiveInactiveStreamVideoz_"+id).hasClass('btn-success')){
    		strText="Inactivating..";
    		strStatus='0';
    	}else{
    		strText="Activating..";
    		strStatus='1';
    	}

    	$scope.buttonSavingAnimation('zactiveInactiveStreamVideoz_'+id,strText,'loader');		
		$timeout(function()
		{
			$scope.liveStreamStatusData={}
			$scope.liveStreamStatusData.id=id;
			$scope.liveStreamStatusData.strStatus=strStatus;
			var formData = new FormData();
			formData.append('LSVideoData',angular.toJson($scope.liveStreamStatusData));
			//alert("fd")
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxActiveInactiveStreamVideo",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData){
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		if(strStatus=='1')
	        		{
	        			$(".zactiveInactiveStreamVideoz_"+id).removeClass('btn-primary');
    					$(".zactiveInactiveStreamVideoz_"+id).addClass('btn-success');
						$(".zactiveInactiveStreamVideoz_"+id).css("background-color",'#49f0d3');
						$(".zactiveInactiveStreamVideoz_"+id).css("bordr-color",'#49f0d3');
	        			$(".zactiveInactiveStreamVideoz_"+id).html('<i class="ri-lock-unlock-fill"></i>Active');
	        		}else{
	        			$(".zactiveInactiveStreamVideoz_"+id).removeClass('btn-success');
	        			$(".zactiveInactiveStreamVideoz_"+id).addClass('btn-primary');
	        			$(".zactiveInactiveStreamVideoz_"+id).css("background-color",'#50b5ff');
	        			$(".zactiveInactiveStreamVideoz_"+id).css("bordr-color",'#2aa3fb');
	        			$(".zactiveInactiveStreamVideoz_"+id).html('<i class="ri-lock-2-fill"></i>Inactive')
	        		};     		
	        	}
	        	else
	        	{
	        		if($(".zactiveInactiveStreamVideoz_"+id).hasClass('btn-success'))
	        		{
			    		$(".zactiveInactiveStreamVideoz_"+id).html('<i class="ri-lock-unlock-fill"></i>Active')
			    	}else{
			    		$(".zactiveInactiveStreamVideoz_"+id).html('<i class="ri-lock-2-fill"></i>Inactive')
			    	}
	        		swal("Error!",
		        		"Status Changed Failed!",
		        		"error"
		        	)
	        	}
			});
		},1200);
	};

	$scope.deleteStreamVideo = function(valobj)
    {	
    	swal({
	      title: "Attention",
	      text: "Are you sure to delete this schedule",
	      icon: "warning",
	      buttons: true,
	      dangerMode: true,
	    })
	    .then((willDelete) =>
	    {
	    	if (willDelete)
	    	{
		    	var id=valobj.id;

		    	$scope.buttonSavingAnimation('zdeleteStreamVideoz_'+id,"Deleting..",'loader');		
				$timeout(function()
				{

					$scope.liveStreamStatusData={}
					$scope.liveStreamStatusData.id=id;
					$scope.liveStreamStatusData.course_id=$scope.taskData.course_id;
					$scope.liveStreamStatusData.task_level=$scope.taskData.task_level;
					$scope.liveStreamStatusData.user_auto_id=$scope.taskData.user_auto_id;
					$scope.liveStreamStatusData.parent_id=$scope.taskData.parent_id;
					$scope.liveStreamStatusData.membership_type=$scope.taskData.membership_type;

					var formData = new FormData();
					formData.append('LSVideoData',angular.toJson($scope.liveStreamStatusData));
					//alert("fd")
					$http({
			            method  : 'POST',
			            url     : varGlobalAdminBaseUrl+"ajaxDeleteStreamVideo",
			            transformRequest: angular.identity,
			            headers: {'Content-Type': undefined},                     
			            data:formData, 
			        }).success(function(returnData){
						aryreturnData=angular.fromJson(returnData);
			        	if(aryreturnData.status=='1')
			        	{
			        		$scope.allLiveStreamVideoData=aryreturnData.data.liveStreamVideoData;
			        	}
			        	else
			        	{
			        		$(".zdeleteStreamVideoz_"+id).html('<i class="ri-delete-bin-fill"></i>Delete')
			        		swal("Error!",
				        		"Deletion Failed!",
				        		"error"
				        	)
			        	}
					});
				},1200);
			}
		});
	};


	$scope.getLeaderStreamAndVideo = function()
    {	
    	$scope.get_live_stream_video_by_level();
    	$scope.get_task_min_three_video_by_level();
    }
	$scope.get_live_stream_video_by_level = function(valobj)
    {   	
		$scope.liveStreamStatusData={}
		$scope.liveStreamStatusData.leader_id=$scope.taskData.leader_id;
		$scope.liveStreamStatusData.course_id=$scope.taskData.course_id;
		$scope.liveStreamStatusData.task_level=$scope.taskData.task_level;
		$scope.liveStreamStatusData.user_auto_id=$scope.taskData.user_auto_id;
		$scope.liveStreamStatusData.parent_id=$scope.taskData.parent_id;
		$scope.liveStreamStatusData.membership_type=$scope.taskData.membership_type;

		var formData = new FormData();
		formData.append('LSVideoData',angular.toJson($scope.liveStreamStatusData));
		//alert("fd")
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxGetLeaderWiseLiveStreamVideo",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData){
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$scope.allLiveStreamVideoData=aryreturnData.data.liveStreamVideoData;
        	}
        	else
        	{
        		swal("Error!",
	        		"Something went wrong on fetching leader task!",
	        		"error"
	        	)
        	}
		});
	};

	$scope.get_live_streaming_member_by_leve = function()
    {   	
    	if($scope.session_is_admin=='Y' && $scope.taskData.membership_type=='RM')
    	{
			$scope.liveStreamStatusData={}
			$scope.liveStreamStatusData.is_admin=$scope.session_is_admin;
			$scope.liveStreamStatusData.course_id=$scope.taskData.course_id;
			$scope.liveStreamStatusData.task_level=$scope.taskData.task_level;
			$scope.liveStreamStatusData.user_auto_id=$scope.taskData.user_auto_id;
			$scope.liveStreamStatusData.parent_id=$scope.taskData.parent_id;
			$scope.liveStreamStatusData.membership_type=$scope.taskData.membership_type;

			var formData = new FormData();
			formData.append('LSVideoData',angular.toJson($scope.liveStreamStatusData));
			//alert("fd")
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetLiveStreamingMember",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData){
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.liveStreamingMemberListObj=aryreturnData.data.liveStreamMemberData;
	        		//console.log($scope.liveStreamingMemberListObj)
	        	}
	        	else
	        	{
	        		swal("Error!",
		        		"Something went wrong on fetching leader task!",
		        		"error"
		        	)
	        	}
			});
	    }
	};

	$scope.get_task_min_three_video_by_level = function(valobj)
    {   	

		$scope.liveStreamStatusData={}
		$scope.liveStreamStatusData.leader_id=$scope.taskData.leader_id;
		$scope.liveStreamStatusData.course_id=$scope.taskData.course_id;
		$scope.liveStreamStatusData.task_level=$scope.taskData.task_level;
		$scope.liveStreamStatusData.user_auto_id=$scope.taskData.user_auto_id;
		$scope.liveStreamStatusData.parent_id=$scope.taskData.parent_id;
		$scope.liveStreamStatusData.membership_type=$scope.taskData.membership_type;

		var formData = new FormData();
		formData.append('LSVideoData',angular.toJson($scope.liveStreamStatusData));
		//alert("fd")
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxGetLeaderWiseMinThreeVideo",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData){
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$scope.allVideoListObj=aryreturnData.data.taskMin3VideoLevelData;
        	}
        	else
        	{
        		swal("Error!",
	        		"Something went wrong on fetching leader task!",
	        		"error"
	        	)
        	}
		});
	};


	$scope.track_member_watch_task_video_by_level = function(tempid)
    {
		video = $('#'+tempid).get(0);

    	ary_task_level_video_id=tempid.split("_");
		task_level_video_id=ary_task_level_video_id[1];

		$scope.liveStreamStatusData={}
		$scope.liveStreamStatusData.video_viewed_time=video.currentTime
		$scope.liveStreamStatusData.video_ended=video.ended;
		$scope.liveStreamStatusData.task_level_video_id=task_level_video_id;
		$scope.liveStreamStatusData.leader_id=$scope.taskData.leader_id;
		$scope.liveStreamStatusData.user_auto_id=$scope.taskData.user_auto_id;
		$scope.liveStreamStatusData.course_id=$scope.taskData.course_id;
		$scope.liveStreamStatusData.task_level=$scope.taskData.task_level;
		$scope.liveStreamStatusData.parent_id=$scope.taskData.parent_id;
		$scope.liveStreamStatusData.membership_type=$scope.taskData.membership_type;

		var formData = new FormData();
		formData.append('LSVideoData',angular.toJson($scope.liveStreamStatusData));
		//alert("fd")
		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxTrackMemberWatchTaskVideo",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData){
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
            	if(aryreturnData.data.video_ended>=1)
        		{
        			$scope.allVideoListObj=aryreturnData.data.taskMin3VideoLevelData;
        			video.currentTime=0;
        		}        		
        	}
        	else
        	{
        		swal("Error!",
	        		"Something went wrong on tracking member watch video!",
	        		"error"
	        	)
        	}
		});
	};

	$scope.goLivePopup = function(valobj)
	{
		//alert(valobj.is_admin)
		if($('.zbtnGoLivez').hasClass('cssdisabled') || $('.zbtnJoinLivez').hasClass('cssdisabled'))
		{
			$('.zpalyericonz').addClass('hiddenimportant');
		}
		else
		{
			$('.zpalyericonz').removeClass('hiddenimportant');
		}		

		if(valobj.is_admin=='Y')
		{
			$('.zbtnJoinLivez').addClass('hiddenimportant');
			$('.zbtnLeaveNowLivez').addClass('hiddenimportant');
			//$('.zbtnCancelGoLivez').addClass('hiddenimportant');
			$('.zbtnGoLivez').removeClass('hiddenimportant');
			$('.zbtnLeaveLivez').removeClass('hiddenimportant');

			//
			//$('.zhostpalyerz').removeClass('hiddenimportant');
			//$('.zaudiancepalyerz').addClass('hiddenimportant');
		}
		else
		{
			$('.zbtnJoinLivez').removeClass('hiddenimportant');
			$('.zbtnLeaveNowLivez').removeClass('hiddenimportant');
			//$('.zbtnCancelGoLivez').removeClass('hiddenimportant');			
			$('.zbtnGoLivez').addClass('hiddenimportant');
			$('.zbtnLeaveLivez').addClass('hiddenimportant');

			//$('.zhostpalyerz').addClass('hiddenimportant');
			//$('.zaudiancepalyerz').removeClass('hiddenimportant');
		}

		$('#goLiveModal').modal('show');
		$scope.agoraData.appid='8d3e71062f014643834a6290706da0a4';
		$scope.agoraData.channel='AID'+valobj.id+'TLID'+valobj.task_level_id;
		$scope.agoraData.task_level_stream_video_aid=valobj.id;
	};

	$scope.join_leave_streaming = function(flag)
    {
    	if(flag=='J')
    	{
    		$('.zpalyericonz').addClass('hiddenimportant');
	    	$('.zhostpalyerz').addClass('hiddenimportant');
			$('.zaudiancepalyerz').removeClass('hiddenimportant');
			$scope.member_join_leave_streaming(flag);
    	}
    	else
    	{
    		leave_live_streaming();
    		$scope.member_join_leave_streaming(flag);
	    	$timeout(function()
			{
				location.reload();
			},100);
    	}
    };

	$scope.member_join_leave_streaming = function(join_leave_flag)
    {
    	$scope.goliveStreamData={};
    	$scope.goliveStreamData.id=$scope.agoraData.task_level_stream_video_aid;
    	$scope.goliveStreamData.user_auto_id=$scope.taskData.user_auto_id;
    	$scope.goliveStreamData.join_leave_flag=join_leave_flag;
    	var formData = new FormData();
		formData.append('goliveStreamData',angular.toJson($scope.goliveStreamData));

		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxJoinStreaming",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData){
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		console.log("Streaming Joined")
        	}
        	else
        	{
        		swal("Error!",
	        		"Streaming Joining is Failed!",
	        		"error"
	        	)
        	}
		});

    };

	$scope.start_leave_live_streaming = function(is_live)
    {	
        $scope.goliveStreamData={};	
		$scope.goliveStreamData.id=$scope.agoraData.task_level_stream_video_aid;
		$scope.goliveStreamData.is_live=is_live;
		$scope.goliveStreamData.leader_id=$scope.taskData.leader_id;
		$scope.goliveStreamData.user_auto_id=$scope.taskData.user_auto_id;
		$scope.goliveStreamData.course_id=$scope.taskData.course_id;
		$scope.goliveStreamData.task_level=$scope.taskData.task_level;
		$scope.goliveStreamData.parent_id=$scope.taskData.parent_id;
		$scope.goliveStreamData.membership_type=$scope.taskData.membership_type;

		var formData = new FormData();
		formData.append('goliveStreamData',angular.toJson($scope.goliveStreamData));

		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"ajaxStartLeaveLiveStreaming",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData){
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$(".zgoLivez").addClass('cssdisabled');
        		$(".zgoLivez").removeClass('blink_me');
        		$(".zactiveInactiveStreamVideoz").removeClass('cssdisabled');
				$(".zeditStreamVideoz").removeClass('cssdisabled');
				$(".zdeleteStreamVideoz").removeClass('cssdisabled');

        		if(is_live=='N')
        		{
        			leave_live_streaming()
        			location.reload();
        		}
        		else if(is_live=='Y')
		        {
		        	$('.zpalyericonz').addClass('hiddenimportant');
		        	$('.zhostpalyerz').removeClass('hiddenimportant');
					$('.zaudiancepalyerz').addClass('hiddenimportant');

					$(".zgoLivez_"+$scope.agoraData.task_level_stream_video_aid).removeClass('cssdisabled');
					$(".zgoLivez_"+$scope.agoraData.task_level_stream_video_aid).addClass('blink_me');
					$(".zactiveInactiveStreamVideoz_"+$scope.agoraData.task_level_stream_video_aid).addClass('cssdisabled');
					$(".zeditStreamVideoz_"+$scope.agoraData.task_level_stream_video_aid).addClass('cssdisabled');
					$(".zdeleteStreamVideoz_"+$scope.agoraData.task_level_stream_video_aid).addClass('cssdisabled');
				}        		
        	}
        	else
        	{
        		swal("Error!",
	        		"Streaming Starting is Failed!",
	        		"error"
	        	)
        	}
		});
	};

	$scope.giveBadgeToMember = function(valobj,no_of_badge)
    {			
		$scope.goliveStreamData={};
		$scope.goliveStreamData.member_id=valobj.member_id;
		$scope.goliveStreamData.course_id=valobj.course_id;
		$scope.goliveStreamData.task_level=valobj.task_level;
		$scope.goliveStreamData.no_of_badge=no_of_badge;

		var formData = new FormData();
		formData.append('goliveStreamData',angular.toJson($scope.goliveStreamData));

		$http({
            method  : 'POST',
            url     : varGlobalAdminBaseUrl+"giveBadgeToMember",
            transformRequest: angular.identity,
            headers: {'Content-Type': undefined},                     
            data:formData, 
        }).success(function(returnData){
			aryreturnData=angular.fromJson(returnData);
        	if(aryreturnData.status=='1')
        	{
        		$scope.get_live_streaming_member_by_leve();
        	}
        	else
        	{
        		swal("Error!",
	        		"Badge Give to Member Failed!",
	        		"error"
	        	)
        	}
		});
	};

	//$scope.allQuestionnaireObj=[];

	$scope.create_question_object = function()
	{
		var temp={};
		temp.question='';
		temp.correct_ans=0;
		temp.options=[];
	
		for (let i = 0; i < 4; i++)
		{
			var temp2={};
			temp2.optionval='';
			temp.options.push(temp2);
		}
		return temp;
	};

	$scope.createQuestionnaire = function()
	{
		$scope.allQuestionnaireObj=[];
		$scope.examData={};
		temp=$scope.create_question_object();
		$scope.allQuestionnaireObj.push(temp);
		$('.zheadSQz').html("Create Question Set");
		$('#createQuestionnaireModal').modal('show');
	};

	$scope.addQuestion = function()
	{
		if($scope.allQuestionnaireObj.length>2)
		{
			$('#createQuestionnaireModal').modal('hide');
			swal("Attention",
        		"Maximum 3 Questions are allowed!",
        		"warning"
        	)
			.then((value) => {
			  $('#createQuestionnaireModal').modal('show');
			});
		}
		else
		{
			temp=$scope.create_question_object();
			$scope.allQuestionnaireObj.push(temp);
		}		
	};

	$scope.deleteQuestion = function(index)
	{
		$scope.allQuestionnaireObj.splice(index,1);
	};

	$scope.addQuestionOption = function(index)
	{
		if($scope.allQuestionnaireObj[index].options.length>5)
		{
			$('#createQuestionnaireModal').modal('hide');
			swal("Attention",
        		"Maximum 6 Options are allowed!",
        		"warning"
        	)
			.then((value) => {
			  $('#createQuestionnaireModal').modal('show');
			});

		}
		else
		{
			var temp2={};
			temp2.optionval='';
			$scope.allQuestionnaireObj[index].options.push(temp2);
		}
	};

	$scope.deleteQuestionOption = function(index,index2)
	{
		$scope.allQuestionnaireObj[index].options.splice(index2,1);
		if($scope.allQuestionnaireObj[index].correct_ans==index2)
		{
			$scope.allQuestionnaireObj[index].correct_ans=0;
		}

	};

	$scope.submitQuestionnaire = function()
    {
    	var validator=0;

    	$scope.examDataCheck=true ;
		$timeout(function()
		{
			$scope.examDataCheck=false ;
		},2000);

		if (($scope.isNullOrEmptyOrUndefined($scope.examData.exam_title)==true) || ($scope.examData.exam_title=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.examData.start_time)==true) || ($scope.examData.start_time=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.examData.end_time)==true) || ($scope.examData.end_time=='¿'))
		{
			validator++ ;
		}

	   	$('.zExamQuestionz').each(function(index, value)
		{
			$(this).removeClass('redBorder');	
			question=jQuery.trim($(this).val());
			if (question=='')
			{
				$(this).addClass('redBorder');
				validator++ ;				
			}
		});

		$('.zExamQuestionOptionz').each(function(index, value)
		{
			$(this).removeClass('redBorder');	
			question=jQuery.trim($(this).val());
			if (question=='')
			{
				$(this).addClass('redBorder');
				validator++ ;				
			}
		});

    	if (Number(validator)==0)
		{
			$scope.buttonSavingAnimation('zsubmitquestionnairez','Submitting..','loader');
			$scope.examData.course_id=$scope.taskData.course_id;
			$scope.examData.task_level=$scope.taskData.task_level;
			$scope.examData.user_auto_id=$scope.taskData.user_auto_id;
			$scope.examData.parent_id=$scope.taskData.parent_id;
			$scope.examData.membership_type=$scope.taskData.membership_type;
			$scope.examData.aryQuestionnaire=$scope.allQuestionnaireObj;

			var formData = new FormData();
			formData.append('examData',angular.toJson($scope.examData));

			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxaddupdateexam",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
	        	{            		
	        		$scope.buttonSavingAnimation('zsubmitquestionnairez','Submited!','onlytext');
	        		$timeout(function()
					{
						$scope.buttonSavingAnimation('zsubmitquestionnairez','Submit Questionnaire','onlytext');
	            		$scope.examData={}
	            		$scope.allExamListObj=aryreturnData.data.allExamListObj;
					},1200);

					$timeout(function()
					{
						$('#createQuestionnaireModal').modal('hide');

						$scope.getAllTaskLevelExam();
					},1800);					
	        	}
	        	else
	        	{
	        		$scope.examData={}
	        		$scope.buttonSavingAnimation('zsubmitquestionnairez','Submit Questionnaire','onlytext');
	        		$('#createQuestionnaireModal').modal('hide');
	        		swal("Error!",
		        		"Exam Set Failed!",
		        		"error"
		        	)		        	
	        	}
			});
	    }
	};

	$scope.activeInactiveExam = function(valobj)
    {	
    	var id=valobj.id;
    	var status=valobj.status;

    	if($(".zactiveInactiveExamz_"+id).hasClass('btn-success')){
    		strText="Inactivating..";
    		strStatus='0';
    	}else{
    		strText="Activating..";
    		strStatus='1';
    	}

    	$scope.buttonSavingAnimation('zactiveInactiveExamz_'+id,strText,'loader');		
		$timeout(function()
		{
			$scope.examStatusData={}
			$scope.examStatusData.id=id;
			$scope.examStatusData.strStatus=strStatus;
			var formData = new FormData();
			formData.append('ExamData',angular.toJson($scope.examStatusData));
			//alert("fd")
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxActiveInactiveExam",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData){
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		if(strStatus=='1')
	        		{
	        			$(".zactiveInactiveExamz_"+id).removeClass('btn-primary');
    					$(".zactiveInactiveExamz_"+id).addClass('btn-success');
						$(".zactiveInactiveExamz_"+id).css("background-color",'#49f0d3');
						$(".zactiveInactiveExamz_"+id).css("bordr-color",'#49f0d3');
	        			$(".zactiveInactiveExamz_"+id).html('<i class="ri-lock-unlock-fill"></i>Active');
	        		}else{
	        			$(".zactiveInactiveExamz_"+id).removeClass('btn-success');
	        			$(".zactiveInactiveExamz_"+id).addClass('btn-primary');
	        			$(".zactiveInactiveExamz_"+id).css("background-color",'#50b5ff');
	        			$(".zactiveInactiveExamz_"+id).css("bordr-color",'#2aa3fb');
	        			$(".zactiveInactiveExamz_"+id).html('<i class="ri-lock-2-fill"></i>Inactive')
	        		};     		
	        	}
	        	else
	        	{
	        		if($(".zactiveInactiveExamz_"+id).hasClass('btn-success'))
	        		{
			    		$(".zactiveInactiveExamz_"+id).html('<i class="ri-lock-unlock-fill"></i>Active')
			    	}else{
			    		$(".zactiveInactiveExamz_"+id).html('<i class="ri-lock-2-fill"></i>Inactive')
			    	}
	        		swal("Error!",
		        		"Status Changed Failed!",
		        		"error"
		        	)
	        	}
			});
		},1200);
	};

	$scope.deleteExam = function(valobj)
    {	
    	swal({
	      title: "Attention",
	      text: "Are you sure to delete this exam",
	      icon: "warning",
	      buttons: true,
	      dangerMode: true,
	    })
	    .then((willDelete) =>
	    {
	    	if (willDelete)
	    	{
		    	var id=valobj.id;
		    	var task_level_id=valobj.task_level_id;

		    	$scope.buttonSavingAnimation('zdeleteExamz_'+id,"Deleting..",'loader');		
				$timeout(function()
				{

					$scope.examDeleteData={}
					$scope.examDeleteData.id=id;
					$scope.examDeleteData.task_level_id=task_level_id;

					var formData = new FormData();
					formData.append('examDeleteData',angular.toJson($scope.examDeleteData));
					//alert("fd")
					$http({
			            method  : 'POST',
			            url     : varGlobalAdminBaseUrl+"ajaxDeleteExam",
			            transformRequest: angular.identity,
			            headers: {'Content-Type': undefined},                     
			            data:formData, 
			        }).success(function(returnData){
						aryreturnData=angular.fromJson(returnData);
			        	if(aryreturnData.status=='1')
			        	{
			        		$scope.allExamListObj=aryreturnData.data.allExamListObj;
			        	}
			        	else
			        	{
			        		$(".zdeleteExamz_"+id).html('<i class="ri-delete-bin-fill"></i>Delete')
			        		swal("Error!",
				        		"Deletion Failed!",
				        		"error"
				        	)
			        	}
					});
				},1200);
			}
		});
	};

	$scope.getAllTaskLevelExam = function()
	{
		if($scope.taskData.user_auto_id>0)
		{
			$scope.examListData={};
			$scope.examListData.course_id=$scope.taskData.course_id;
			$scope.examListData.task_level=$scope.taskData.task_level;
			$scope.examListData.user_auto_id=$scope.taskData.user_auto_id;
			$scope.examListData.parent_id=$scope.taskData.parent_id;

			
			var formData = new FormData();
			formData.append('examListData',angular.toJson($scope.examListData));
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxGetAllTaskLevelExam",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$scope.allExamListObj=aryreturnData.data.allExamListObj;
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

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
});
