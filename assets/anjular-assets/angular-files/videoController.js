mainApp.controller('videoController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {

	$scope.parseInt = parseInt;
	$scope.parseFloat = parseFloat;

	$scope.videoData={};
    $scope.weeklyVideoData={};

    $scope.initiateVideo = function (user_auto_id,parent_id,membership_type,is_admin)
	{
		// jsonLiveStreamVideoData=$('#jsonLiveStreamVideoData').html();	
		// if (($scope.isNullOrEmptyOrUndefined(jsonLiveStreamVideoData)==false))
		// {
		// 	$scope.allLiveStreamVideoData=jQuery.parseJSON(jsonLiveStreamVideoData);
		// }

		$scope.session_is_admin=is_admin;  
		$scope.videoData.user_auto_id=user_auto_id;
		$scope.videoData.parent_id=parent_id;
		$scope.videoData.membership_type=membership_type; 
	};

	$scope.uploadWeeklyVideo = function()
	{
		$scope.weeklyVideoData={} 
		$('.zheadslz').html("Add Weekly Video");
		$('#uploadWeeklyVideoModal').modal('show');
	};
	

	$scope.weeklyVideoData.uploaddata=[];
  	var uploader = new plupload.Uploader({
	    runtimes: "html5",
	    browse_button: "browseFileToUpload",
	    container: document.getElementById('browsecontainer'), // ... or DOM Element itsel
	    url: varBaseUrl+"post/ajaxsubmitweeklyvideofiles",
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
	      	$scope.weeklyVideoData.uploaddata=[];
	        plupload.each(files, (file) => {
				$scope.weeklyVideoData.uploaddata.push(file);
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
  		$scope.buttonSavingAnimation('zuploadWeeklyVideoz','Submited','onlytext');
		$timeout(function()
		{
			$scope.buttonSavingAnimation('zuploadWeeklyVideoz','Submit','onlytext');
			$scope.weeklyVideoData={}; 
			$("#post_image_preview_container").html('');
			$scope.weeklyVideoData.uploaddata=[]; 
		},1200);
  	};

	$scope.submitWeeklyVideo = function()
    {
		$scope.weeklyVideoDataCheck=true ;
		$timeout(function()
		{
			$scope.weeklyVideoDataCheck=false ;
		},2000);

		//alert($scope.liveStreamData.start_time)
		var validator=0;
		if (($scope.isNullOrEmptyOrUndefined($scope.weeklyVideoData.video_title)==true) || ($scope.weeklyVideoData.video_title=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.weeklyVideoData.video_type)==true) || ($scope.weeklyVideoData.video_type=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.weeklyVideoData.start_time)==true) || ($scope.weeklyVideoData.start_time=='¿'))
		{
			validator++ ;
		}
		if (($scope.isNullOrEmptyOrUndefined($scope.weeklyVideoData.end_time)==true) || ($scope.weeklyVideoData.end_time=='¿'))
		{
			validator++ ;
		}

		if (Number(validator)==0)
		{
			$scope.buttonSavingAnimation('zuploadWeeklyVideoz','Submitting..','loader');
 			$scope.weeklyVideoData.user_auto_id=$scope.videoData.user_auto_id;
			$scope.weeklyVideoData.parent_id=$scope.videoData.parent_id;
			$scope.weeklyVideoData.membership_type=$scope.videoData.membership_type;

			var formData = new FormData();
			formData.append('weeklyVideoData',angular.toJson($scope.weeklyVideoData)); 

			$http({
                method  : 'POST',
                url     : varGlobalAdminBaseUrl+"ajaxaddupdatestreamvideoxx",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
				$scope.lastPostId=aryreturnData.data.lastPostId;
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success' && $scope.lastPostId>0)
            	{            		
            		if($scope.weeklyVideoData.uploaddata.length>0)
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
            		$scope.files = [];
            		$scope.liveStreamData={}
            		$('#file_ls_video_upload').val("");
            		$scope.buttonSavingAnimation('zuploadWeeklyVideoz','Submit','onlytext');
            		$('#uploadliveStreamVideoModal').modal('hide');
            		console.log("Live Stream Video Set Failed!")		        	
            	}
			});
		}
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
	        		console.log("Status Changed Failed!")
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
			        		console.log("Deletion Failed!")
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
