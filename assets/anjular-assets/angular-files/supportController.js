mainApp.controller('supportController', function ($rootScope, $timeout, $interval, $scope, $http, $compile, $filter, spinnerService, ngDialog, $sce) {
  $scope.supportData={};
  $scope.supportData.manageTicket={};
  $scope.supportData.manageSupport={};
  $scope.supportData.manageSupport.id='0';
  $scope.supportData.listSupport={};

  $scope.initSupport = function() {
    $scope.supportData={};
    $scope.supportData.manageTicket={};
    $scope.supportData.manageSupport={};
    $scope.supportData.listSupport={};
    $scope.supportData.manageSupport.id='0';
    $scope.supportData.manageSupport.parent_id='0';
    $scope.supportData.manageSupport.report_to='';
    $scope.checkDailyReport();
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
      $scope.buttonSavingAnimation('zsubmitTicketz','Saving..','loader');
      var formData = new FormData();
      formData.append('manageSupport',angular.toJson($scope.supportData.manageSupport));
      $http({
          method  : 'POST',
          url     : varGlobalAdminBaseUrl+"ajaxsubmitticket",
          transformRequest: angular.identity,
          headers: {'Content-Type': undefined},                     
          data:formData, 
      }).success(function(returnData) {
        $scope.buttonSavingAnimation('zsubmitTicketz','Saved!','onlytext');
        $scope.checkDailyReport();
        $timeout(function()
        {
          $scope.supportData.manageSupport={};
          $scope.supportData.manageSupport.id='0';
          $scope.supportData.manageSupport.report_to='';
          $scope.buttonSavingAnimation('zsubmitTicketz','Submit','onlytext');
        },1200);
      });
    }
  };

  $scope.MyInterval = $interval( function() { $scope.checkDailyReport(); }, 5000);

  $scope.checkDailyReport = function() {
    $http({
        method  : 'POST',
        url     : varGlobalAdminBaseUrl+"ajaxgetallticket",
        transformRequest: angular.identity,
        headers: {'Content-Type': undefined},                     
    }).success(function(returnData) {
      $scope.supportData.listSupport=returnData ;
    });
  };

  $scope.viewTicketDetails = function(ticketData) {
    $scope.supportData.manageTicket={};
    $scope.supportData.manageTicket.ticketId=($scope.isNullOrEmptyOrUndefined(ticketData.assignTicketId)==false)? ticketData.assignTicketId : (($scope.isNullOrEmptyOrUndefined(ticketData.myTicketId)==false)? ticketData.myTicketId : 0);
    $scope.supportData.manageTicket.ticketSubject=($scope.isNullOrEmptyOrUndefined(ticketData.assignTicketSubject)==false)? ticketData.assignTicketSubject : (($scope.isNullOrEmptyOrUndefined(ticketData.myTicketSubject)==false)? ticketData.myTicketSubject : '');
    $scope.supportData.manageTicket.ticketDescription=($scope.isNullOrEmptyOrUndefined(ticketData.assignTicketDescription)==false)? ticketData.assignTicketDescription : (($scope.isNullOrEmptyOrUndefined(ticketData.myTicketDescription)==false)? ticketData.myTicketDescription : '');
    $scope.supportData.manageTicket.ticketChildCount=($scope.isNullOrEmptyOrUndefined(ticketData.assignTicketChildCount)==false)? ticketData.assignTicketChildCount : (($scope.isNullOrEmptyOrUndefined(ticketData.myTicketChildCount)==false)? ticketData.myTicketChildCount : 0);
    $scope.supportData.manageTicket.ticketResponseTo=($scope.isNullOrEmptyOrUndefined(ticketData.myTicketRespTo)==false)? ticketData.myTicketRespTo : (($scope.isNullOrEmptyOrUndefined(ticketData.ticketCameFromId)==false)? ticketData.ticketCameFromId : 0);
    $scope.supportData.manageTicket.ticketType=($scope.isNullOrEmptyOrUndefined(ticketData.assignTicketId)==false)? 'A' : (($scope.isNullOrEmptyOrUndefined(ticketData.myTicketId)==false)? 'M' : '');
    $scope.supportData.manageTicket.response='';
    if ($scope.supportData.manageTicket.ticketType=='M' && parseInt($scope.supportData.manageTicket.ticketId)>0 && parseInt($scope.supportData.manageTicket.ticketChildCount)==0) {
      $scope.supportData.manageSupport.id=$scope.supportData.manageTicket.ticketId;
      $scope.supportData.manageSupport.parent_id='0';
      $scope.supportData.manageSupport.report_to=$scope.supportData.manageTicket.ticketResponseTo;
      $scope.supportData.manageSupport.subject=$scope.supportData.manageTicket.ticketSubject;
      $scope.supportData.manageSupport.description=$scope.supportData.manageTicket.ticketDescription;
    } else {
      $scope.supportData.manageTicket.switch=1;
      $scope.supportData.manageTicket.responseList=[];
      var formData = new FormData();
      formData.append('parentTicketId',angular.toJson($scope.supportData.manageTicket.ticketId));
      $http({
        method  : 'POST',
        url     : varGlobalAdminBaseUrl+"ajaxgetticketresponse",
        transformRequest: angular.identity,
        headers: {'Content-Type': undefined},                     
        data:formData, 
      }).success(function(returnData) {
        $scope.supportData.manageTicket.responseList=returnData.returnval;
        console.log($scope.supportData.manageTicket.responseList);
      });
    }
    //console.log($scope.supportData.manageSupport);
    //console.log($scope.supportData.manageTicket);
  };

  $scope.submitResponse = function() {
    var formData = new FormData();
    formData.append('manageTicket',angular.toJson($scope.supportData.manageTicket));
    $http({
      method  : 'POST',
      url     : varGlobalAdminBaseUrl+"ajaxsubmitresponse",
      transformRequest: angular.identity,
      headers: {'Content-Type': undefined},                     
      data:formData, 
    }).success(function(returnData) {
      if ($scope.isNullOrEmptyOrUndefined(returnData.retId)==false) {
        $scope.supportData.manageTicket={};
        $scope.checkDailyReport();
        $timeout(function()
        {
          $scope.supportData.manageSupport={};
          $scope.supportData.manageSupport.id='0';
          $scope.supportData.manageSupport.report_to='';
        },1200);
      }
      //console.log(returnData);
    });
  };

  $scope.backToUsual = function() {
    $scope.supportData.manageTicket={};
    $scope.supportData.manageSupport={};
    $scope.supportData.manageSupport.id='0';
    $scope.supportData.manageSupport.report_to='';
  };

  $scope.isNullOrEmptyOrUndefined = function (value) {
    return !value;
  };

  $scope.parseInt = parseInt ;
  $scope.parseFloat = parseFloat ;   

});