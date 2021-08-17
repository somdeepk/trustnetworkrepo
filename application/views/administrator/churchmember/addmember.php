<div ng-controller="churchMemberController" ng-init="getMemberData('<?php echo $id; ?>');">
    <div class="page-header">
        <div class="page-header-title">
            <h4>Member</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>administrator/memberlist">Member</a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Add Member</a>
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
                        <h5>Add Member</h5>
                    </div>
                    <div class="card-block">
                            <div class="row">
                                <input ng-model="memberData.id" id="id" type="hidden">
                                <div class="col-sm-12">
                                    <div class="product-edit">
                                        <div class="tab-content">
                                            <div class="tab-pane active" >
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                            <input class="form-control" ng-model="memberData.first_name" id="first_name" placeholder="First Name" type="text">
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.first_name)==true)? 'First Name Required' : ''}}</div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                            <input class="form-control" ng-model="memberData.middle_name" id="middle_name" placeholder="Middle Name" type="text">
                                                        </div>
                                                        <!-- <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.middle_name)==true)? 'Middle Name Required' : ''}}</div> -->
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                            <input class="form-control" ng-model="memberData.last_name" id="last_name" placeholder="Last Name" type="text">
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.last_name)==true)? 'Last Name Required' : ''}}</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <select ng-model="memberData.gender" id="gender" class="form-control form-control-primary">
                                                                <option value="">Select Gender</option>
                                                                <option value="M">Male</option>
                                                                <option value="F">Female</option>
                                                                <option value="T">Transgender</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.gender)==true)? 'Gender Required' : ''}}</div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <select ng-model="memberData.marital_status" id="marital_status" class="form-control form-control-primary">
                                                                <option value="">Select Marital Status</option>
                                                                <option value="Unmarried">Unmarried</option>
                                                                <option value="Married">Married</option>
                                                                <option value="Divorcee">Divorcee</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.marital_status)==true)? 'Marital Status Required' : ''}}</div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <select ng-model="memberData.blood_group" id="blood_group" class="form-control form-control-primary">
                                                                <option value="">Select Blood Group</option>
                                                                <option value="A+">A+</option>
                                                                <option value="A-">A-</option>
                                                                 <option value="B+">B+</option>
                                                                <option value="B-">B-</option>
                                                                <option value="AB+">AB+</option>
                                                                <option value="AB-">AB-</option>
                                                                <option value="O+">O+</option>
                                                                <option value="O-">O-</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                            <input class="form-control" ng-model="memberData.dob" id="dob" placeholder="Date of Birth" type="text" bootstrap-date>
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.dob)==true)? 'Date of Birth Required' : ''}}</div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="input-group">
                                                            <select ng-model="memberData.membership_type" id="membership_type" class="form-control form-control-primary">
                                                                <option value="">Select Membership Type</option>
                                                                <option value="RM">Regular Membership</option>
                                                                <option value="CM">Church Membership</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.membership_type)==true)? 'Membership Type Required' : ''}}</div>
                                                    </div>

                                                    <div class="col-sm-4" ng-if="memberData.membership_type=='CM'">
                                                        <div class="input-group">
                                                            <select ng-model="memberData.church_id" id="church_id" class="form-control form-control-primary">
                                                                <option value="">Select Membership Type</option>
                                                                <?php 
                                                                if(count($all_church_data)>0)
                                                                {
                                                                    foreach($all_church_data as $k=>$v)
                                                                    {
                                                                ?>
                                                                        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                                                <?php 
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && memberData.membership_type=='CM' && isNullOrEmptyOrUndefined(memberData.church_id)==true)? 'Church Required' : ''}}</div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Contact Information</h5>
                                                            </div>
                                                            <div class="card-block">

                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                            <input class="form-control" ng-model="memberData.contact_email" id="contact_email" placeholder="Email" type="text">
                                                                        </div>
                                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.contact_email)==true)? 'Email Required' : ''}}</div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                            <input class="form-control" ng-model="memberData.contact_mobile" id="contact_mobile" placeholder="Mobile" type="text">
                                                                        </div>
                                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.contact_mobile)==true)? 'Mobile Required' : ''}}</div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                            <input class="form-control" ng-model="memberData.contact_alt_mobile" id="contact_alt_mobile" placeholder="Alternate Mobile" type="text">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Address Details</h5>
                                                            </div>
                                                            <div class="card-block">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-copy-alt"></i></span>
                                                                            <textarea class="form-control" ng-model="memberData.address" id="address" placeholder="Address"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                            <input class="form-control" ng-model="memberData.city" id="city" placeholder="City" type="text">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <select ng-model="memberData.country" id="country" class="form-control form-control-primary">
                                                                            <option value="">Select Country</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    
                                                                    <div class="col-sm-6">
                                                                        <select ng-model="memberData.state" id="state" class="form-control form-control-primary">
                                                                            <option value="">Select State</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                            <input class="form-control" ng-model="memberData.postal_code" id="postal_code" placeholder="Post Code" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="form-group">
                                                        <button type="button" ng-click="submitMember();" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
             

   

