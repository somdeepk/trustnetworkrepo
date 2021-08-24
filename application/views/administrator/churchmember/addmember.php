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
                                <div class="zjsonMemberDataz hiddenimportant"><?php echo $jsonMemberData; ?></div>
                                <div class="col-sm-12">
                                    <div class="product-edit">
                                        <div class="tab-content">
                                            <div class="tab-pane active" >
                                                <div class="row">
                                                    <!--left-->
                                                    <div class="col-sm-3 padding-lr0 mb10">
                                                      <div id="uploaded_image">
                                                        <img ng-if="memberData.profile_image == '' || !memberData.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" class="img-responsive border-blk"  style="margin:0 auto; width:74%;">
                                                        <img ng-if="memberData.profile_image && memberData.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{memberData.profile_image}}" class="img-responsive border-blk"  style="margin:0 auto; width:74%; height:149px;">
                                                      </div>
                                                      <div class="clear50"></div>
                                                      
                                                      <span class="upload-img-cont"><strong>Note:</strong> Please Upload JPG, JPEG or PNG Image With a Dimension of 254 X 254 Pixel Only</span>
                                                      <div class="clear20"></div>
                                                      <div class="col-md-12 padding-lr0">

                                                        <div class="input-group image-preview">
                                                          <input type="text" class="form-control image-preview-filename" disabled="disabled"> 
                                                          <span class="input-group-btn" style="position:relative;top:-2px;">
                                                            <button type="button" class="btn btn-success image-preview-clear" style="display:none;" ng-click="clearProfileImage();">
                                                              <i class="fa fa-times" aria-hidden="true"></i> 
                                                            </button>
                                                            <br><br>
                                                            <div class="btn btn-success image-preview-input">
                                                              <span class="glyphicon glyphicon-folder-open"></span>
                                                              <span class="image-preview-input-title">Browse</span>
                                                              <input type="file" accept="image/png, image/jpeg, image/gif" name="input-file-preview" single-file-upload/> 
                                                            </div>
                                                          </span>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!--/left-->

                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <select ng-disabled="memberData.id>0" ng-model="memberData.membership_type" id="membership_type" class="form-control form-control-primary">
                                                                <option value="">Select Membership Type</option>
                                                                <option value="RM">Regular Membership</option>
                                                                <option value="CM">Church Membership</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.membership_type)==true)? 'Membership Type Required' : ''}}</div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4" ng-if="memberData.membership_type=='RM'">
                                                        <div class="input-group">
                                                            
                                                            <input class="form-control" ng-model="memberData.first_name" id="first_name" placeholder="First Name" type="text">
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.first_name)==true)? 'First Name Required' : ''}}</div>
                                                    </div>
                                                    <div class="col-sm-4" ng-if="memberData.membership_type=='RM'">
                                                        <div class="input-group">
                                                            
                                                            <input class="form-control" ng-model="memberData.last_name" id="last_name" placeholder="Last Name" type="text">
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.last_name)==true)? 'Last Name Required' : ''}}</div>
                                                    </div>

                                                    <div class="col-sm-4" ng-if="memberData.membership_type=='RM'">
                                                        <div class="input-group">
                                                            <select ng-model="memberData.church_id" id="church_id" class="form-control form-control-primary">
                                                                <option value="">Select Church</option>
                                                                <?php 
                                                                if(count($all_church_data)>0)
                                                                {
                                                                    foreach($all_church_data as $k=>$v)
                                                                    {
                                                                ?>
                                                                        <option value="<?php echo $v['id']; ?>"><?php echo $v['first_name']; ?></option>
                                                                <?php 
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && memberData.membership_type=='RM' && isNullOrEmptyOrUndefined(memberData.church_id)==true)? 'Church Required' : ''}}</div>
                                                    </div>

                                                </div>
                                                <div class="row">

                                                    <div class="col-sm-6" ng-if="memberData.membership_type=='CM'">
                                                        <div class="input-group">
                                                            
                                                            <input class="form-control" ng-model="memberData.church_name" id="church_name" placeholder="Church Name" type="text">
                                                        </div>
                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.church_name)==true)? 'Church Name Required' : ''}}</div>
                                                    </div>

                                                    


                                                    <div class="col-sm-6" ng-if="memberData.membership_type=='CM'">
                                                        <select ng-model="memberData.type" id="type" class="form-control form-control-primary">
                                                            <option value="0">Select Church Type</option>
                                                            <?php foreach($churchTypeData as $key=>$val) : ?>
                                                                 <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                             <?php endforeach; ?>

                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4" ng-if="memberData.membership_type=='RM'">
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

                                                    <div class="col-sm-4" ng-if="memberData.membership_type=='RM'">
                                                        <div class="input-group">
                                                            <select ng-model="memberData.marital_status" id="marital_status" class="form-control form-control-primary">
                                                                <option value="">Select Marital Status</option>
                                                                <option value="Single">Single</option>
                                                                <option value="Married">Married</option>
                                                                <option value="Widowed">Widowed</option>
                                                                <option value="Divorced">Divorced</option>
                                                                <option value="Separated">Separated </option>
                                                            </select>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input class="form-control" autocomplete="off" ng-model="memberData.dob" id="dob" readonly="true" placeholder="{{(memberData.membership_type=='RM')? 'Date Of Birth' : 'Foundation Date'}}" type="text" dobdate>
                                                        </div>

                                                         <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberData.membership_type=='RM' && memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.dob)==true)? 'Date Of Birth Required' : ''}}</div>
                                                         <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberData.membership_type=='CM' && memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.dob)==true)? 'Foundation Date Required' : ''}}</div>

                                                    </div>

                                                    <div class="col-sm-6" ng-if="memberData.membership_type=='CM'">
                                                        <div class="input-group">
                                                            
                                                            <input class="form-control" ng-model="memberData.trustee_board" id="trustee_board" placeholder="Trustee Board" type="text">
                                                        </div>
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
                                                                            
                                                                            <input class="form-control" ng-disabled="memberData.id>0" ng-model="memberData.user_email" id="user_email" placeholder="Email" type="text" emailvalidate>
                                                                        </div>
                                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.user_email)==true)? 'Email Required' : ''}}</div>

                                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(InvalidEmailCheck==true)? 'Invalid Email' : ''}}</div>

                                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataEmailDupCheck==true)? 'This Email already Exist' : ''}}</div>
                                                                    </div>


                                                                    <div class="col-sm-6" ng-if="memberData.membership_type=='CM'">
                                                                        <div class="input-group">
                                                                            
                                                                            <input class="form-control" ng-model="memberData.contact_person" id="contact_person" placeholder="Contact Person" type="text">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="input-group">
                                                                            
                                                                            <input class="form-control" ng-model="memberData.contact_mobile" id="contact_mobile" placeholder="Contact Number" type="text" maxlength="15" type="text" phone-masking valid-number>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="input-group">
                                                                            
                                                                            <input class="form-control" ng-model="memberData.contact_alt_mobile" id="contact_alt_mobile" placeholder="Alt. Contact Number" maxlength="15" type="text" phone-masking valid-number>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-4">
                                                                        <div class="input-group">
                                                                            <input class="form-control" ng-model="memberData.alt_email" id="alt_email" placeholder="Alt. Email" type="text" emailvalidate>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4" ng-if="memberData.membership_type=='CM'">
                                                                        <div class="input-group">
                                                                            
                                                                            <input type="text" ng-model="memberData.website" id="website" class="form-control" placeholder="Website">
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
                                                                        <select ng-model="memberData.country" id="country" ng-change="getStateData(memberData.country)" class="form-control form-control-primary">
                                                                            <option value="0">Select Country</option>
                                                                            <option ng-repeat="option in countryData" value="{{option.id}}">{{option.name}}
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <select ng-disabled="!memberData.country" ng-model="memberData.state" id="state"  ng-change="getCityData(memberData.state)" class="form-control form-control-primary">
                                                                            <option value="0">Select State</option>
                                                                            <option ng-repeat="option in stateData" value="{{option.id}}">{{option.name}}
                                                                        </select>
                                                                    </div>
                                                                    
                                                                </div>

                                                                <div class="row">
                                                                    
                                                                    <div class="col-sm-6">
                                                                        <select ng-disabled="!memberData.state" ng-model="memberData.city" id="city" class="form-control form-control-primary">
                                                                            <option value="0">Select City</option>
                                                                            <option ng-repeat="option in cityData" value="{{option.id}}">{{option.name}}
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="input-group">
                                                                            
                                                                            <input class="form-control" ng-model="memberData.postal_code" id="postal_code" placeholder="Postal Code" type="text">
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
             

   

