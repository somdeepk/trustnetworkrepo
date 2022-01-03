mainApp.controller('supportController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
  $scope.supportData={};
  $scope.supportData.manageSupport={};
  $scope.supportData.manageSupport.id='0';
  $scope.supportData.listSupport=[];

  $scope.initSupport = function() {
    $scope.supportData={};
    $scope.supportData.manageSupport={};
    $scope.supportData.listSupport=[];
    $scope.supportData.manageSupport.id='0';
    $scope.supportData.manageSupport.parent_id='0';
    $scope.supportData.manageSupport.report_to='0';
  };

  $scope.submitTicket = function() {
    var checkError=[];
    var errorCount=0;
    if ($scope.isNullOrEmptyOrUndefined($scope.supportData.manageSupport.report_to)==true) {
      checkError.push('Report To Person');
      errorCount++;
    }
    if ($scope.isNullOrEmptyOrUndefined($scope.supportData.manageSupport.subject)==true) {
      checkError.push('Subject');
      errorCount++;
    }
    if ($scope.isNullOrEmptyOrUndefined($scope.supportData.manageSupport.description)==true) {
      checkError.push('Description');
      //swal("Error!", "Description Required", "error");
      errorCount++;
    }
    if (parseInt(errorCount)>0) {
      var tjoin=checkError.join(" and ");
      swal("Error!", tjoin+" Required", "error");
    } else {
      //console.log(varGlobalAdminBaseUrl);
      var formData = new FormData();
      formData.append('manageSupport',angular.toJson($scope.supportData.manageSupport));
      $http({
          method  : 'POST',
          url     : varGlobalAdminBaseUrl+"ajaxsubmitticket",
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined},                     
          data:formData, 
      }).success(function(returnData) {
        console.log(returnData);
        //aryreturnData=angular.fromJson(returnData);
      });
    }
  };

  $scope.isNullOrEmptyOrUndefined = function (value) {
    return !value;
  };     

});