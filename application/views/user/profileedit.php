<div id="content-page" class="content-page" ng-controller="profileController" ng-init="getMemberData('<?php echo $this->session->userdata('user_auto_id'); ?>');">
    <div class="container">
       <div class="row">
          <div class="col-lg-12">
             <div class="iq-card">
                <div class="iq-card-body p-0">
                   <div class="iq-edit-list">
                      <ul class="iq-edit-profile d-flex nav nav-pills">
                         <li class="col-md-3 p-0">
                            <a class="nav-link active" data-toggle="pill" href="#personal-information">
                            Personal Information
                            </a>
                         </li>
                         <li class="col-md-3 p-0">
                            <a class="nav-link" data-toggle="pill" href="#chang-pwd">
                            Change Password
                            </a>
                         </li>
                         <li class="col-md-3 p-0">
                            <a class="nav-link" data-toggle="pill" href="#emailandsms">
                            Email and SMS
                            </a>
                         </li>
                         <li class="col-md-3 p-0">
                            <a class="nav-link" data-toggle="pill" href="#manage-contact">
                            Manage Contact
                            </a>
                         </li>
                      </ul>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-lg-12">
             <div class="iq-edit-list-data">
                <div class="tab-content">
                   <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                      <div class="iq-card">
                         <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                               <h4 class="card-title">Personal Information</h4>
                            </div>
                         </div>
                         <div class="iq-card-body">
                            <form autocomplete="off">
                               <input ng-model="memberData.id" id="id" type="hidden">
                               <div class="zjsonMemberDataz hiddenimportant"><?php echo $jsonMemberData; ?></div>
                               

                               <div class="form-group row align-items-center">
                                  <div class="col-md-12">
                                     <div class="profile-img-edit">
                                          <div id="uploaded_image">
                                            <img class="profile-pic" ng-if="memberData.profile_image == '' || !memberData.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" style="margin:0 auto; width:74%;">
                                            <img class="profile-pic" ng-if="memberData.profile_image && memberData.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{memberData.profile_image}}" style="margin:0 auto; width:74%; height:149px;">
                                          </div>
                                          <div class="clear50"></div>
                                          
                                          <span class="upload-img-cont"><strong>Note:</strong> Please Upload JPG, JPEG or PNG Image With a Dimension of 254 X 254 Pixel Only</span>
                                          <div class="clear20"></div>
                                          <div class="col-md-12 padding-lr0">

                                            <div class="input-group image-preview">
                                              <input type="text" class="form-control image-preview-filename" disabled="disabled"> 
                                              <span class="input-group-btn" style="position:relative;top:-2px;">
                                                <button type="button" class="btn btn-success image-preview-clear" style="display:none;" ng-click="clearProfileImage();">
                                                  <i class="fa fa-times" aria-hidden="true">DELETE</i> 
                                                </button>
                                                <br><br>
                                                <div class="btn btn-success image-preview-input">
                                                  <span class="glyphicon glyphicon-folder-open"></span>
                                                  <span class="image-preview-input-title">Browse</span>
                                                  <input type="file" class="" accept="image/png, image/jpeg, image/gif" name="input-file-preview" single-file-upload/> 
                                                </div>
                                              </span>
                                            </div>
                                          </div>
                                     </div>

                                  </div>
                               </div>
                               <div class="row align-items-center">
                                  <div class="form-group col-sm-6" ng-if="memberData.membership_type=='RM'">
                                     <label for="first_name">First Name:</label>
                                     <input type="text" ng-model="memberData.first_name" id="first_name" class="form-control">
                                     <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.first_name)==true)? 'First Name Required' : ''}}</div>
                                  </div>
                                  <div class="form-group col-sm-6" ng-if="memberData.membership_type=='RM'">
                                     <label for="last_name">Last Name:</label>
                                     <input type="text" ng-model="memberData.last_name" id="last_name" class="form-control">
                                     <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.last_name)==true)? 'Last Name Required' : ''}}</div>
                                  </div>

                                  <div class="form-group col-sm-6" ng-if="memberData.membership_type=='CM'">
                                     <label for="church_name" >Church Name:</label>
                                     <input class="form-control" ng-model="memberData.church_name" id="church_name" type="text">
                                     <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.church_name)==true)? 'Church Name Required' : ''}}</div>
                                  </div>

                                  <div class="form-group col-sm-6" ng-if="memberData.membership_type=='CM'">
                                     <label for="type">Church Type:</label>
                                     <select ng-model="memberData.type" id="type" class="form-control form-control-primary">
                                        <option value="0">Select Church Type</option>
                                        <?php foreach($churchTypeData as $key=>$val) : ?>
                                             <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                         <?php endforeach; ?>
                                    </select>
                                  </div>

                                  <div class="form-group col-sm-6">
                                     <label for="user_email">Email:</label>
                                     <input type="text" ng-disabled="true" ng-model="memberData.user_email" id="user_email" class="form-control" style="background: transparent;" emailvalidate >
                                  </div>
                                  
                                  <div class="form-group col-sm-6" ng-if="memberData.membership_type=='RM'">
                                     <label for="gender">Gender:</label>
                                     <select ng-model="memberData.gender" id="gender" class="form-control form-control-primary">
                                          <option value="">Select Gender</option>
                                          <option value="M">Male</option>
                                          <option value="F">Female</option>
                                          <option value="T">Transgender</option>
                                      </select>
                                      <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.gender)==true)? 'gender Required' : ''}}</div>
                                  </div>
                                  <div class="form-group col-sm-6">
                                    <label for="dob">{{(memberData.membership_type=='RM')? 'Date Of Birth' : 'Foundation Date'}}:</label>
                                    <input class="form-control" readonly="true" style="background: transparent;" ng-model="memberData.dob" id="dob" type="text" autocomplete="false"  dobdate>

                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberData.membership_type=='RM' && memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.dob)==true)? 'Date Of Birth Required' : ''}}</div>
                                     <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberData.membership_type=='CM' && memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.dob)==true)? 'Foundation Date Required' : ''}}</div>
                                  </div>

                                  <div class="form-group col-sm-6" ng-if="memberData.membership_type=='CM'">
                                    <label for="trustee_board">Trustee Board:</label>
                                    <input class="form-control" ng-model="memberData.trustee_board" id="trustee_board" type="text">
                                  </div>

                                  <div class="form-group col-sm-6" ng-if="memberData.membership_type=='RM'">
                                     <label for="marital_status">Marital Status:</label>
                                     <select ng-model="memberData.marital_status" id="marital_status" class="form-control form-control-primary">
                                        <option value="">Select Marital Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Separated">Separated </option>
                                      </select>
                                  </div>

                                  <div class="form-group col-sm-12">
                                     <label for="address">Address:</label>
                                     <textarea class="form-control" ng-model="memberData.address" id="address" autocomplete="off" rows="5" style="line-height: 22px;"></textarea>
                                  </div>

                                  <div class="form-group col-sm-6">
                                     <label>Country:</label>
                                     <select ng-model="memberData.country" id="country" ng-change="getStateData(memberData.country)" class="form-control form-control-primary">
                                        <option value="0">Select Country</option>
                                        <option ng-repeat="option in countryData" value="{{option.id}}">{{option.name}}
                                    </select>
                                  </div>
                                  <div class="form-group col-sm-6">
                                     <label>State:</label>
                                      <select ng-disabled="!memberData.country"  ng-model="memberData.state" id="state"  ng-change="getCityData(memberData.state)" style="background: transparent;" class="form-control form-control-primary">
                                        <option value="0">Select State</option>
                                        <option ng-repeat="option in stateData" value="{{option.id}}">{{option.name}}
                                      </select>
                                  </div>
                                  <div class="form-group col-sm-6">
                                     <label for="cname">City:</label>
                                      <select ng-disabled="!memberData.state" ng-model="memberData.city" id="city" style="background: transparent;" class="form-control form-control-primary">
                                          <option value="0">Select City</option>
                                          <option ng-repeat="option in cityData" value="{{option.id}}">{{option.name}}
                                      </select>
                                  </div>

                                  <div class="form-group col-sm-6">
                                    <label for="dob">Postal Code:</label>
                                    <input class="form-control" ng-model="memberData.postal_code" id="postal_code"  autocomplete="off" type="text">
                                  </div>
                                  
                               </div>
                               <button type="button" class="btn btn-primary mr-2" ng-click="submitMember();">Submit</button>
                               <button type="button" ng-click="resetForm();" class="btn iq-bg-danger">Reset</button>
                            </form>
                         </div>
                      </div>
                   </div>
                   <div class="tab-pane fade" id="chang-pwd" role="tabpanel">
                      <div class="iq-card">
                         <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                               <h4 class="card-title">Change Password</h4>
                            </div>
                         </div>
                         <div class="iq-card-body">
                            <form>
                               <div class="form-group">
                                  <label for="current_password">Current Password:</label>
                                  <!-- <a href="javascripe:void();" class="float-right">Forgot Password</a> -->
                                  <input type="password" ng-model="memberData.current_password" id="current_password" maxlength="15" class="form-control">
                                  <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.current_password)==true)? 'Current Password Required' : ''}}</div>
                                   <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataOldNotMtchCheck==true)? 'Old Password doesnt match!' : ''}}</div>
                               </div>
                               
                               <div class="form-group">
                                  <label for="npass">New Password:</label>
                                  <input type="password" ng-model="memberData.new_password" id="new_password" maxlength="15" class="form-control">
                                  <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.new_password)==true)? 'New Password Required' : ''}}</div>
                               </div>

                               <div class="form-group">
                                  <label for="vpass">Verify Password:</label>
                                  <input type="Password" ng-model="memberData.verify_password" id="verify_password" maxlength="15" class="form-control">
                                  <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.verify_password)==true)? 'Verify Password Required' : ''}}</div>

                                  <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataPassNotMtchCheck==true)? 'Verify Password Not Matched' : ''}}</div>
                               </div>

                               <button type="button" class="btn btn-primary mr-2" ng-click="submitChangePasswordInfo();">Submit</button>
                               <button type="button" ng-click="resetChangePasswordForm();" class="btn iq-bg-danger">Reset</button>
                            </form>
                         </div>
                      </div>
                   </div>
                   <div class="tab-pane fade" id="emailandsms" role="tabpanel">
                      <div class="iq-card">
                         <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                               <h4 class="card-title">Email and SMS</h4>
                            </div>
                         </div>
                         <div class="iq-card-body">
                            <form>
                               <div class="form-group row align-items-center">
                                  <label class="col-md-3" for="emailnotification">Email Notification:</label>
                                  <div class="col-md-9 custom-control custom-switch">
                                     <input type="checkbox" class="custom-control-input" id="emailnotification" checked="">
                                     <label class="custom-control-label" for="emailnotification"></label>
                                  </div>
                               </div>
                               <div class="form-group row align-items-center">
                                  <label class="col-md-3" for="smsnotification">SMS Notification:</label>
                                  <div class="col-md-9 custom-control custom-switch">
                                     <input type="checkbox" class="custom-control-input" id="smsnotification" checked="">
                                     <label class="custom-control-label" for="smsnotification"></label>
                                  </div>
                               </div>
                               <div class="form-group row align-items-center">
                                  <label class="col-md-3" for="npass">When To Email</label>
                                  <div class="col-md-9">
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="email01">
                                        <label class="custom-control-label" for="email01">You have new notifications.</label>
                                     </div>
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="email02">
                                        <label class="custom-control-label" for="email02">You're sent a direct message</label>
                                     </div>
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="email03" checked="">
                                        <label class="custom-control-label" for="email03">Someone adds you as a connection</label>
                                     </div>
                                  </div>
                               </div>
                               <div class="form-group row align-items-center">
                                  <label class="col-md-3" for="npass">When To Escalate Emails</label>
                                  <div class="col-md-9">
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="email04">
                                        <label class="custom-control-label" for="email04"> Upon new order.</label>
                                     </div>
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="email05">
                                        <label class="custom-control-label" for="email05"> New membership approval</label>
                                     </div>
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="email06" checked="">
                                        <label class="custom-control-label" for="email06"> Member registration</label>
                                     </div>
                                  </div>
                               </div>
                               <button type="submit" class="btn btn-primary mr-2">Submit</button>
                               <button type="reset" class="btn iq-bg-danger">Cancle</button>
                            </form>
                         </div>
                      </div>
                   </div>
                   <div class="tab-pane fade" id="manage-contact" role="tabpanel">
                      <div class="iq-card">
                         <div class="iq-card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                               <h4 class="card-title">Manage Contact</h4>
                            </div>
                         </div>
                         <div class="iq-card-body">
                            <form>
                               <div class="form-group" ng-if="memberData.membership_type=='CM'">
                                  <label for="contact_person">Contact Person:</label>
                                  <input type="text"  ng-model="memberData.contact_person" id="contact_person" class="form-control">
                               </div>

                               <div class="form-group">
                                  <label for="contact_mobile">Contact Number:</label>
                                  <input type="text" ng-model="memberData.contact_mobile" id="contact_mobile" maxlength="15" class="form-control" phone-masking valid-number>
                               </div>
                               <div class="form-group">
                                  <label for="contact_alt_mobile">Alt. Contact Number:</label>
                                  <input type="text" ng-model="memberData.contact_alt_mobile" id="contact_alt_mobile" maxlength="15" class="form-control" phone-masking valid-number>
                               </div>
                               <div class="form-group">
                                  <label for="alt_email">Alt. Email:</label>
                                  <input type="text" ng-model="memberData.alt_email" id="alt_email" class="form-control" emailvalidate >
                               </div>
                               <div class="form-group" ng-if="memberData.membership_type=='CM'">
                                  <label for="website">Website:</label>
                                  <input type="text" ng-model="memberData.website" id="website" class="form-control">
                               </div>
                               <button type="button" class="btn btn-primary mr-2" ng-click="submitContactInfo();">Submit</button>
                               <button type="button" ng-click="resetConatctForm();" class="btn iq-bg-danger">Reset</button>
                            </form>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>