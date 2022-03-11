<div id="content-page" class="content-page" ng-controller="editProfileController" ng-init="getMemberData('<?php echo $this->session->userdata('user_auto_id'); ?>');">
  <!-- Start Image Croping Modal -->
  <div id="uploadimageModal" class="modal" role="dialog" style="z-index:999999 ">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
            <!-- <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Upload & Crop Images</h4> 
            </div> -->
            <div class="modal-body">
              <div class="row">
              <div class="col-md-12 text-center">
                <div id="image_demo" style="width:100%; margin-top:30px"></div>
              </div>
              
          </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-success zCropImagez">Crop & Upload Image</button>
              <button type="button" class="btn btn-secondary" ng-click="clearProfileImage();" data-dismiss="modal">Cancel</button>
            </div>
        </div>
      </div>
  </div>
  <!-- End Image Croping Modal -->

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
                                        <img class="profile-pic" ng-if="memberData.profile_image == '' || !memberData.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" style="margin:0 auto;height:149px;">
                                        <img class="profile-pic" ng-if="memberData.profile_image && memberData.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{memberData.profile_image}}" style="margin:0 auto;height:149px;">
                                      </div>

                                      <div class="p-image">
                                         <i class="ri-pencil-line upload-button"></i>
                                         <input class="file-upload" name="upload_image" id="upload_image" type="file" accept="image/*"/>
                                         <input type="text" ng-model="memberData.hidden_image_encode" class="hiddenimportant" />
                                         <input type="text" ng-model="memberData.profile_image" class="hiddenimportant" />
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
                                          <!-- <option value="T">Transgender</option> -->
                                      </select>
                                      <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(memberDataCheck==true && isNullOrEmptyOrUndefined(memberData.gender)==true)? 'gender Required' : ''}}</div>
                                  </div>

                                  <div class="form-group col-sm-6">
                                    <label for="dob">{{(memberData.membership_type=='RM')? 'Date Of Birth' : 'Foundation Date'}}:</label>
                                    <input class="form-control" readonly="true" style="background: transparent;" ng-model="memberData.dob" id="dob" type="text" autocomplete="off"  dobdate>

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


                                  <div class="form-group col-sm-6" ng-if="memberData.membership_type=='RM'">
                                     <label for="other_name">Other Name:</label>
                                     <input type="text" ng-model="memberData.other_name" maxlength="50" class="form-control">
                                  </div>

                                  <div class="form-group col-sm-12" ng-if="memberData.membership_type=='RM'">
                                     <label for="interested_in">Interested In (comma separated values):</label>
                                     <input type="text" ng-model="memberData.interested_in" id="interested_in" class="form-control">
                                  </div>

                                  <div class="form-group col-sm-12" ng-if="memberData.membership_type=='RM'">
                                     <label for="language">Language (comma separated values):</label>
                                     <input type="text" ng-model="memberData.language" id="language" class="form-control">
                                  </div>

                                  <div class="form-group col-sm-12">
                                     <label for="about_you">About You:</label>
                                     <textarea class="form-control" ng-model="memberData.about_you" id="about_you" autocomplete="off" rows="2" style="line-height: 22px;"></textarea>
                                  </div>

                                  <div class="form-group col-sm-12">
                                     <label for="favorite_quote">Favorite Quotes:</label>
                                     <textarea class="form-control" ng-model="memberData.favorite_quote" id="favorite_quote" autocomplete="off" rows="3" style="line-height: 22px;"></textarea>
                                  </div>

                                  
                               </div>

                               <button type="button" class="btn btn-primary mr-2 zsubmitMemberz" style="width:80px" ng-click="submitMember();">Submit</button>

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

                               <button type="button" class="btn btn-primary mr-2 zsubmitMemberz" style="width:80px" ng-click="submitChangePasswordInfo();">Submit</button>
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
                                  <label class="col-md-3" for="email_notify">Email Notification:</label>
                                  <div class="col-md-9 custom-control custom-switch">
                                     <input type="checkbox" class="custom-control-input" ng-model="memberData.email_notify" id="email_notify" ng-checked="memberData.email_notify == true" ng-value="false">
                                     <label class="custom-control-label" for="email_notify"></label>
                                  </div>
                               </div>
                               <div class="form-group row align-items-center">
                                  <label class="col-md-3" for="sms_notify">SMS Notification:</label>
                                  <div class="col-md-9 custom-control custom-switch">
                                     <input type="checkbox" class="custom-control-input" ng-model="memberData.sms_notify" id="sms_notify" ng-checked="memberData.sms_notify == true" ng-value="false">
                                     <label class="custom-control-label" for="sms_notify"></label>
                                  </div>
                               </div>
                               <div class="form-group row align-items-center">
                                  <label class="col-md-3">When To Email</label>
                                  <div class="col-md-9">
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" ng-model="memberData.email_on_new_notify" id="email_on_new_notify" ng-checked="memberData.email_on_new_notify == true" ng-value="false">
                                        <label class="custom-control-label" for="email_on_new_notify">You have new notifications.</label>
                                     </div>
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" ng-model="memberData.email_on_direcr_msg" id="email_on_direcr_msg" ng-checked="memberData.email_on_direcr_msg == true" ng-value="false">
                                        <label class="custom-control-label" for="email_on_direcr_msg">You're sent a direct message</label>
                                     </div>
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" ng-model="memberData.email_on_add_cnction" id="email_on_add_cnction" ng-checked="memberData.email_on_add_cnction== true" ng-value="false">
                                        <label class="custom-control-label" for="email_on_add_cnction">Someone adds you as a connection</label>
                                     </div>
                                  </div>
                               </div>
                               <div ng-if="memberData.membership_type=='CM'" class="form-group row align-items-center">
                                  <label class="col-md-3" for="npass">When To Escalate Emails</label>
                                  <div class="col-md-9">
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" ng-model="memberData.escalate_email_on_new_order" id="escalate_email_on_new_order" ng-checked="memberData.escalate_email_on_new_order == true'" ng-value="false">
                                        <label class="custom-control-label" for="escalate_email_on_new_order"> Upon new order.</label>
                                     </div>
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" ng-model="memberData.escalate_email_on_new_member_approval" id="escalate_email_on_new_member_approval" ng-checked="memberData.escalate_email_on_new_member_approval == true" ng-value="false">
                                        <label class="custom-control-label" for="escalate_email_on_new_member_approval"> New membership approval</label>
                                     </div>
                                     <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" ng-model="memberData.escalate_email_on_member_registration" id="escalate_email_on_member_registration" ng-checked="memberData.escalate_email_on_member_registration == true" ng-value="false">
                                        <label class="custom-control-label" for="escalate_email_on_member_registration"> Member registration</label>
                                     </div>
                                  </div>
                               </div>
                               <button type="button" class="btn btn-primary mr-2 zsubmitMemberz" style="width:80px"  ng-click="submitNotification();">Submit</button>
                               <!-- <button type="button" ng-click="resetNotification();" class="btn iq-bg-danger">Reset</button> -->
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
                               <button type="button" class="btn btn-primary mr-2 zsubmitMemberz" style="width:80px"  ng-click="submitContactInfo();">Submit</button>
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