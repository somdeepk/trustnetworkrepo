<div id="content-page" class="content-page" ng-controller="supportController" ng-init="initSupport();" >
  <div class="container">
    <div class="row">
      <div class="col-lg-8 row m-0 p-0" ng-hide="isNullOrEmptyOrUndefined(supportData.manageTicket.switch)==false">
        <div class="col-sm-12">
          <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">{{(parseInt(supportData.manageSupport.id)>0)? 'Edit' : 'Create'}} Support Ticket</h4>
              </div>
            </div>
            <div class="iq-card-body">
              <div class="row">
                <div class="form-group col-sm-6">
                  <label>Report To:</label>
                  <select class="form-control form-control-primary" ng-model="supportData.manageSupport.report_to">
                    <option value="">Select Assignee</option>
                    <?php 
                    if ($membershipType=='CC' || $membershipType=='CM') {
                    ?>
                    <option value="0">Super Admin</option>
                    <?php
                    } else if ($membershipType=='RM' && $parent_leader_id>0) {
                    ?>
                    <option value="0">Super Admin</option>
                    <option value="<?php echo $parent_id ;?>">My Church</option>
                    <option value="<?php echo $parent_leader_id ;?>">Leader</option>
                    <?php
                    } else if ($membershipType=='RM' && $parent_leader_id==0) {
                    ?>
                    <option value="0">Super Admin</option>
                    <option value="<?php echo $parent_id ;?>">My Church</option>
                    <?php
                    } else {
                    ?>
                    <option value="0">Super Admin</option>
                    <?php
                    }
                    ?>
                  </select>
                  <div class="col-md-12 padding-lr0" style="color:#d43f3a;"></div>
                </div>
                <div class="form-group col-sm-12">
                  <label>Ticket Title:</label>
                  <input type="text" maxlength="200" class="form-control" ng-model="supportData.manageSupport.subject" />
                  <div class="col-md-12 padding-lr0" style="color:#d43f3a;"></div>
                </div>
                <div class="form-group col-sm-12">
                  <label>Ticket Description:</label>
                   <textarea class="form-control" autocomplete="off" rows="3" style="line-height: 22px;" ng-model="supportData.manageSupport.description"></textarea>
                </div>
                <div class="form-group col-sm-12">
                  <button type="button" class="btn btn-primary mr-2 zsubmitTicketz" style="width:80px; float: right;" ng-click="submitTicket();">Submit</button>
                </div>              
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8 row m-0 p-0" ng-show="isNullOrEmptyOrUndefined(supportData.manageTicket.switch)==false">
        <div class="col-sm-12">
          <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="col-sm-8">
                <div class="iq-header-title">
                View Ticket
                </div>
              </div>
              <div class="col-sm-4">
                <button type="button" class="btn btn-primary mr-2 zsubmitTicketz" style="width:80px; float: right;" ng-click="backToUsual();">Back</button>
              </div>
            </div>
            <div class="iq-card-body">
              <div class="row">
                <div class="form-group col-sm-12">
                  <p style="font-weight: bold; font-size: 16px;">
                    {{supportData.manageTicket.ticketSubject}}
                  </p>
                </div>
                <div class="form-group col-sm-12" style="border-bottom: 1px solid #fff;">
                  <textarea class="form-control" autocomplete="off" rows="5" style="line-height: 22px; background: transparent; border: none; resize: none; font-weight: bold; font-size: 14px;" readonly ng-model="supportData.manageTicket.ticketDescription"></textarea>
                </div>
                <div class="form-group col-sm-12">
                  <label>Response:</label>
                   <textarea class="form-control" autocomplete="off" rows="3" style="line-height: 22px;" ng-model="supportData.manageTicket.response"></textarea>
                </div>
                <div class="form-group col-sm-12">
                  <button type="button" class="btn btn-primary mr-2 zsubmitTicketz" style="width:80px; float: right;" ng-click="submitResponse();">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="iq-card">
          <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
              <h4 class="card-title">My Tickets</h4>
            </div>
            <!--<div class="iq-card-header-toolbar d-flex align-items-center">
              <div class="dropdown">
                 <span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" role="button">
                 <i class="ri-more-fill"></i>
                 </span>
                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="">
                    <a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
                    <a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                    <a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                    <a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>
                    <a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>
                 </div>
              </div>
            </div>-->
          </div>
          <div class="iq-card-body" ng-if="parseInt(supportData.listSupport.myTickets.length)>0">
            <ul class="media-story m-0 p-0">
              <li class="d-flex mb-4 align-items-center" ng-repeat="myTicket in supportData.listSupport.myTickets">
                <div class="stories-data ml-3" ng-click="viewTicketDetails(myTicket);" style="cursor: pointer;" title="View Ticket Details">
                  <h5>{{myTicket.myTicketSubject}}</h5>
                  <p class="mb-0">To {{myTicket.responseToName}}</p>
                  <p class="mb-0">{{myTicket.myTicketCreation}}</p>
                </div>
              </li>
            </ul>
          </div>
          <div class="iq-card-body" ng-if="isNullOrEmptyOrUndefined(supportData.listSupport.myTickets)==true || parseInt(supportData.listSupport.myTickets.length)==0">
            <ul class="media-story m-0 p-0">
              <li class="d-flex mb-4 align-items-center ">
                 <div class="stories-data ml-3">
                    <h5>No Records Found</h5>
                 </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="iq-card">
          <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
              <h4 class="card-title">Assigned Tickets</h4>
            </div>
          </div>
          <div class="iq-card-body" ng-if="parseInt(supportData.listSupport.assignedTickets.length)>0">
            <ul class="media-story m-0 p-0">
              <li class="d-flex mb-4 align-items-center" ng-repeat="assignTicket in supportData.listSupport.assignedTickets">
                <div class="stories-data ml-3" ng-click="viewTicketDetails(assignTicket);" style="cursor: pointer;" title="View Ticket Details">
                  <h5>{{assignTicket.assignTicketSubject}}</h5>
                  <p class="mb-0">From {{assignTicket.ticketCameFromName}}</p>
                  <p class="mb-0">{{assignTicket.assignTicketCreation}}</p>
                </div>
              </li>
            </ul>
          </div>
          <div class="iq-card-body" ng-if="isNullOrEmptyOrUndefined(supportData.listSupport.assignedTickets)==true || parseInt(supportData.listSupport.assignedTickets.length)==0">
            <ul class="media-story m-0 p-0">
              <li class="d-flex mb-4 align-items-center ">
                 <div class="stories-data ml-3">
                    <h5>No Records Found</h5>
                 </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

