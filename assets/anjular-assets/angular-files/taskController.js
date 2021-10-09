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
    $scope.files = [];

    $scope.getTaskData = function (user_auto_id,parent_id,membership_type,is_admin)
	{
		hidden_course_id=$('#hidden_course_id').val();	
		hidden_task_level=$('#hidden_task_level').val();	
		jsonTaskVideoLevelData=$('#jsonTaskVideoLevelData').html();	
		jsonLiveStreamVideoData=$('#jsonLiveStreamVideoData').html();	

		$scope.allVideoListObj=jQuery.parseJSON(jsonTaskVideoLevelData);
		$scope.allLiveStreamVideoData=jQuery.parseJSON(jsonLiveStreamVideoData);
		//console.log('dsd')
		//console.log($scope.allVideoListObj)
		//alert(hidden_task_level)	
		$scope.session_is_admin=is_admin;
		$scope.taskData.course_id=hidden_course_id;
		$scope.taskData.task_level=hidden_task_level;
		$scope.taskData.user_auto_id=user_auto_id;
		$scope.taskData.parent_id=parent_id;
		$scope.taskData.membership_type=membership_type;
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

		//alert($scope.liveStreamData.star_time)
		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.liveStreamData.video_title)==true) || ($scope.liveStreamData.video_title=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.liveStreamData.star_time)==true) || ($scope.liveStreamData.star_time=='¿'))
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
			$scope.buttonSavingAnimation('zuploadlivestreamvideoz','Uploading..','loader');
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
    	$scope.liveStreamData.star_time=valobj.star_time;
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

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
});
