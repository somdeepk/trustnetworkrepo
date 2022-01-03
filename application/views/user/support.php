<div id="content-page" class="content-page" ng-controller="supportController" ng-init="initSupport();" >
  <div class="container">
    <div class="row">
      <div class="col-lg-8 row m-0 p-0">
        <div class="col-sm-12">
          <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-header d-flex justify-content-between">
              <div class="iq-header-title">
                <h4 class="card-title">Create Support Ticket</h4>
              </div>
            </div>
            <div class="iq-card-body">
              <div class="row">
                <div class="form-group col-sm-6">
                  <label>Report To:</label>
                  <select class="form-control form-control-primary" ng-model="supportData.manageSupport.report_to">
                    <?php 
                    if ($membershipType=='CC' || $membershipType=='CM') {
                    ?>
                    <option value="0">Super Admin</option>
                    <?php
                    } else if ($parent_leader_id>0) {
                    ?>
                    <option value="0">Super Admin</option>
                    <option value="<?php echo $parent_leader_id ;?>">Group Admin</option>
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
                  <a href="javascript:void(0);" class="btn btn-request" style="float:right;" ng-click="submitTicket();">Submit</a>
                </div>              
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

