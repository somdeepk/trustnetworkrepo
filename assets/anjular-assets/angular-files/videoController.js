mainApp.controller('videoController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {

	$scope.parseInt = parseInt;
	$scope.parseFloat = parseFloat;

	$scope.videoData={};
    $scope.weeklyVideoData={};

    $scope.initiateVideo = function (user_auto_id,parent_id,membership_type,is_admin)
	{
		jsonWeeklyVideoData=$('#jsonWeeklyVideoData').html();	
		if (($scope.isNullOrEmptyOrUndefined(jsonWeeklyVideoData)==false))
		{
			$scope.allWeeklyVideoData=jQuery.parseJSON(jsonWeeklyVideoData);
		}

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
	    url: varBaseUrl+"post/ajaxsubmitweeklvideofiles",
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
			$('#uploadWeeklyVideoModal').modal('hide');	        	
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
                url     : varGlobalAdminBaseUrl+"ajaxaddupdateweeklyvideo",
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined},                     
                data:formData, 
            }).success(function(returnData) {
				aryreturnData=angular.fromJson(returnData);
				$scope.lastVideoId=aryreturnData.data.lastVideoId;
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success' && $scope.lastVideoId>0)
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
            		$scope.weeklyVideoData={} 
            		$scope.buttonSavingAnimation('zuploadWeeklyVideoz','Submit','onlytext');
        			console.log("Something went wrong. Please try again later!")   
            		$('#uploadWeeklyVideoModal').modal('hide');	        	
            	}
			});
		}
	};


	$scope.activeInactiveWeeklyVideo = function(valobj)
    {	
    	var id=valobj.id;
    	var status=valobj.status;

    	if($(".zactiveInactiveWeeklyVideoz_"+id).hasClass('btn-success')){
    		strText="Inactivating..";
    		strStatus='0';
    	}else{
    		strText="Activating..";
    		strStatus='1';
    	}

    	$scope.buttonSavingAnimation('zactiveInactiveWeeklyVideoz_'+id,strText,'loader');		
		$timeout(function()
		{
			$scope.liveWeeklyStatusData={}
			$scope.liveWeeklyStatusData.id=id;
			$scope.liveWeeklyStatusData.strStatus=strStatus;
			var formData = new FormData();
			formData.append('LSVideoData',angular.toJson($scope.liveWeeklyStatusData));
			//alert("fd")
			$http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"ajaxActiveInactiveWeeklyVideo",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData){
				aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		if(strStatus=='1')
	        		{
	        			$(".zactiveInactiveWeeklyVideoz_"+id).removeClass('btn-primary');
    					$(".zactiveInactiveWeeklyVideoz_"+id).addClass('btn-success');
						$(".zactiveInactiveWeeklyVideoz_"+id).css("background-color",'#49f0d3');
						$(".zactiveInactiveWeeklyVideoz_"+id).css("bordr-color",'#49f0d3');
	        			$(".zactiveInactiveWeeklyVideoz_"+id).html('<i class="ri-lock-unlock-fill"></i>Active');
	        		}else{
	        			$(".zactiveInactiveWeeklyVideoz_"+id).removeClass('btn-success');
	        			$(".zactiveInactiveWeeklyVideoz_"+id).addClass('btn-primary');
	        			$(".zactiveInactiveWeeklyVideoz_"+id).css("background-color",'#50b5ff');
	        			$(".zactiveInactiveWeeklyVideoz_"+id).css("bordr-color",'#2aa3fb');
	        			$(".zactiveInactiveWeeklyVideoz_"+id).html('<i class="ri-lock-2-fill"></i>Inactive')
	        		};     		
	        	}
	        	else
	        	{
	        		if($(".zactiveInactiveWeeklyVideoz_"+id).hasClass('btn-success'))
	        		{
			    		$(".zactiveInactiveWeeklyVideoz_"+id).html('<i class="ri-lock-unlock-fill"></i>Active')
			    	}else{
			    		$(".zactiveInactiveWeeklyVideoz_"+id).html('<i class="ri-lock-2-fill"></i>Inactive')
			    	}
	        		console.log("Status Changed Failed!")
	        	}
			});
		},1200);
	};

	$scope.deleteWeeklyVideo = function(valobj)
    {	
    	swal({
	      title: "Attention",
	      text: "Are you sure to delete this Video",
	      icon: "warning",
	      buttons: true,
	      dangerMode: true,
	    })
	    .then((willDelete) =>
	    {
	    	if (willDelete)
	    	{
		    	var id=valobj.id;

		    	$scope.buttonSavingAnimation('zdeleteWeeklyVideoz_'+id,"Deleting..",'loader');		
				$timeout(function()
				{

					$scope.liveWeeklyStatusData={}
					$scope.liveWeeklyStatusData.id=id;
					$scope.liveWeeklyStatusData.user_auto_id=$scope.videoData.user_auto_id;
					var formData = new FormData();
					formData.append('LSVideoData',angular.toJson($scope.liveWeeklyStatusData));
					//alert("fd")
					$http({
			            method  : 'POST',
			            url     : varGlobalAdminBaseUrl+"ajaxDeleteWeeklyVideo",
			            transformRequest: angular.identity,
			            headers: {'Content-Type': undefined},                     
			            data:formData, 
			        }).success(function(returnData){
						aryreturnData=angular.fromJson(returnData);
			        	if(aryreturnData.status=='1')
			        	{
			        		$scope.allWeeklyVideoData=aryreturnData.data.weeklyVideoData;
			        	}
			        	else
			        	{
			        		$(".zdeleteWeeklyVideoz_"+id).html('<i class="ri-delete-bin-fill"></i>Delete')
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
