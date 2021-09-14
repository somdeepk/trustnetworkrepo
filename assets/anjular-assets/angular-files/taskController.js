mainApp.controller('taskController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
		
    $scope.taskData={};
    $scope.videoDataCheck=false ;
    $scope.emptyVideoCheck=false ;
    $scope.videoExtensionCheck=false ;
    $scope.allVideoListObj={};
    $scope.files = [];

    $scope.getTaskData = function (user_auto_id,parent_id)
	{
		hidden_task_level=$('#hidden_task_level').val();	
		jsonTaskVideoLevelData=$('#jsonTaskVideoLevelData').html();	

		$scope.allVideoListObj=jQuery.parseJSON(jsonTaskVideoLevelData);
		//console.log('dsd')
		//console.log($scope.allVideoListObj)
		//alert(hidden_task_level)	
		$scope.taskData.task_level=hidden_task_level;
		$scope.taskData.user_auto_id=user_auto_id;
		$scope.taskData.parent_id=parent_id;
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

    $scope.uploadVideo = function(video_number) {

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
				$scope.memberDataCheck=false ;
				aryreturnData=angular.fromJson(returnData);
            	if(aryreturnData.status=='1' && aryreturnData.msg=='success')
            	{
            		$scope.files = [];
            		$('#input_file_upload_1').val("");
            		$scope.buttonSavingAnimation('zuploadtaskvideonz_'+video_number,'Uploaded!','onlytext');
            		$timeout(function()
					{
						$scope.buttonSavingAnimation('zuploadtaskvideonz_'+video_number,'Upload','onlytext');
					},1200);
            	}
            	else
            	{
            		$scope.buttonSavingAnimation('zuploadtaskvideonz_'+video_number,'Upload','onlytext');
            		swal("Error!",
		        		"Video Addition Failed!",
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

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
	
});
