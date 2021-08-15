<div ng-controller="churchController" ng-init="getGroupData('<?php echo $id; ?>');">
            <div class="page-header">
                <div class="page-header-title">
                    <h4>Group</h4>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index-2.html">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>administrator/grouplist">Group</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Add Group</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page header end -->
            <!-- Page body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Product edit card start -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Add Group</h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <input ng-model="groupData.id" id="id" type="hidden">
                                    <div class="col-sm-12">
                                        <div class="product-edit">
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                    <input class="form-control" ng-model="groupData.groupName" id="groupName" placeholder="Group Name" type="text">
                                                                </div>
                                                                <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(groupDataCheck==true && isNullOrEmptyOrUndefined(groupData.groupName)==true)? 'Group Name Required' : ''}}</div>

                                                            </div>
                                                           <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="icofont icofont-copy-alt"></i></span>
                                                                    <textarea class="form-control" ng-model="groupData.groupDesc" id="groupDesc" placeholder="Address"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <button type="button" ng-click="submitGroup();" class="btn btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product edit card end -->
                    
                </div>
                        <!-- Basic Form Inputs card end -->
</div>
             

   

