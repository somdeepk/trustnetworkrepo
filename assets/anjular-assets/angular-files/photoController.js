mainApp.controller('photoController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {

	$scope.memberData={};
	$scope.aryPhotoScroll=[];
	$scope.initiateData = function (user_auto_id,membership_type,is_admin,parent_id)
	{
		$scope.memberData.user_auto_id=user_auto_id;
		$scope.memberData.membership_type=membership_type;
		$scope.memberData.is_admin=is_admin;
		$scope.memberData.parent_id=parent_id;
	};
   
	$scope.loadingPhoto = true;
	$scope.photoExist = true;
	$scope.rowlimit = 12;
	$scope.row = 0;
    $scope.rowperpage = $scope.rowlimit ;
	$scope.getMorePhotoOnScroll = function ()
    {
    	$scope.photoScrollData={};

    	if($scope.aryPhotoScroll.length>0)
    	{
    		$scope.photoScrollData.row=$scope.aryPhotoScroll.length;
    	}
    	else
    	{
    		$scope.photoScrollData.row=$scope.row;
    	}
    	$scope.photoScrollData.rowperpage=$scope.rowperpage;

    	//if($scope.photoExist==true)
    	//{
	    	var formData = new FormData();
			formData.append('photoScrollData',angular.toJson($scope.photoScrollData));
	        $http({
	            method: 'POST',
	            url     : varBaseUrl+"post/ajaxGetPhotoList",
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
	        		angular.forEach(aryreturnData.data.photoScrollData,function(item)
					{
						if( $.grep( $scope.aryPhotoScroll, function(olditem){ return olditem.id===item.id; }).length){

						}  
						else
						{
							$scope.aryPhotoScroll.push(item);
						}					
					});
	
	        		$scope.loadingPhoto = false;
	        		if(aryreturnData.data.photoExist<=0)
	        		{
	        			$scope.photoExist = false;
	        		}

	        		console.log("PHOTO KANU")
	        		console.log($scope.aryPhotoScroll)
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
	$scope.getMorePhotoOnScroll();

	$scope.isNullOrEmptyOrUndefined = function (value) {
		return !value;
	};
});