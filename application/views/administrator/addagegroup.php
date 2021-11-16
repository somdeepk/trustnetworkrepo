<div ng-controller="churchController" ng-init="getageGroupData('<?php echo $id; ?>');">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Age Group</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>administrator/agegrouplist">Age Group List</a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Add Age Group</a>
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
                        <h5>Add Age Group</h5>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <input ng-model="agegroupData.id" id="id" type="hidden">
                            <div class="col-sm-12">
                                <div class="product-edit">
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                            <input class="form-control" ng-model="agegroupData.agegroup_name" id="agegroup_name" placeholder="Age Group Name" type="text">
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(agegroupDataCheck==true && isNullOrEmptyOrUndefined(agegroupData.agegroupName)==true)? 'Group Name Required' : ''}}</div>

                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <select ng-disabled="memberData.id>0" ng-model="agegroupData.age_range" id="age_range" class="form-control form-control-primary">

                                                                <option value="" >Select Age Range</option>
                                                                <option value="13-18" <?php if(in_array('13-18', array_column($ar_age_group_data, 'age_range'))){ echo "disabled"; } ?>>Teenager (13-18)</option>
                                                                <option value="19-34" <?php if(in_array('19-34', array_column($ar_age_group_data, 'age_range'))){ echo "disabled"; } ?>>Young Adults (19-34)</option>
                                                                <option value="35-48" <?php if(in_array('35-48', array_column($ar_age_group_data, 'age_range'))){ echo "disabled"; } ?>>Middle Age (35-48)</option>
                                                                <option value="49-120" <?php if(in_array('49-120', array_column($ar_age_group_data, 'age_range'))){ echo "disabled"; } ?>>Old Adults (49 and Above)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(agegroupDataCheck==true && isNullOrEmptyOrUndefined(agegroupData.age_range)==true)? 'Age Range Required' : ''}}</div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                   <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icofont icofont-copy-alt"></i></span>
                                                            <textarea class="form-control" ng-model="agegroupData.agegroup_desc" id="agegroup_desc" placeholder="Age Group Description"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <button type="button" ng-click="submitAgeGroup();" class="btn btn-primary">Submit</button>
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
             

   

