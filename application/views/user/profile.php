<style type="text/css">
div.postWhenScrollContainer{
  height:1200px;
  /*background: #123213;
  color: #fff;*/
  overflow:auto;
  /*border-radius: 5px;
  margin:0 auto;
  padding: 0.5em;
  border: 1px dashed #11BD6D;*/
 }
 div.photoWhenScrollContainer{
  height:450px;
  /*background: #123213;
  color: #fff;*/
  overflow:auto;
  /*border-radius: 5px;
  margin:0 auto;
  padding: 0.5em;
  border: 1px dashed #11BD6D;*/
 }
</style>
<div id="content-page" class="content-page">
  
  <div class="container">
     <div class="row">
        <div ng-controller="profileController" ng-init="selectprofileTab(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>','<?php echo $this->session->userdata('parent_id'); ?>','<?php echo $this->session->userdata('cover_image'); ?>');">
          <div class="col-sm-12">
             <div class="iq-card">
                <div class="iq-card-body profile-page p-0">
                   <div class="profile-header">
                      <div class="cover-container">
                          <input ng-model="friendData.user_auto_id" id="user_auto_id" type="hidden">
                          <input ng-model="friendData.membership_type" id="membership_type" type="hidden">
                          <input ng-model="friendData.is_admin" id="is_admin" type="hidden">
                          <input ng-model="friendData.parent_id" id="parent_id" type="hidden">
                          <input id="hidden_profile_tab" type="hidden" value="<?php echo $profileTab; ?>">


                          <!-- Start Cover Image Section -->
                          <input type="hidden" ng-model="coverImageData.encode_cover_image" />
                          <input type="hidden" ng-model="coverImageData.exist_cover_image" />
                          

                          <div class="zCoverImgContainerz">
                            <img alt="Cover Image" class="rounded img-fluid" ng-if="coverImageData.exist_cover_image == '' || !coverImageData.exist_cover_image" src="<?php echo IMAGE_URL;?>images/members/coverimages/cover-no-image.jpg">
                            <img alt="Cover Image" class="rounded img-fluid" ng-if="coverImageData.exist_cover_image && coverImageData.exist_cover_image != ''" src="<?php echo IMAGE_URL;?>images/members/coverimages/{{coverImageData.exist_cover_image}}">
                          </div>
                          <div class="zCropCoverImagez hiddenimportant" class="" style="width:100%;"></div>
                          <!-- End Cover Image Section -->
                         
                          <ul class="header-nav d-flex flex-wrap justify-end p-0 m-0 crop-list">
                            <li style="z-index: 99">
                              <a class="file-upload-icon zeditCoverz" style="position: relative;" href="javascript:void();"><i class="ri-pencil-line">
                              <input style="position: absolute;left: 0;opacity: 0;" name="upload_cover_image" id="btnUploadCoverImage" type="file" accept="image/*"/></i>
                              </a>

                              <i class="ri-crop-line zCropCancelz hiddenimportant" ng-click="cropCoverImage();"></i>
                              <i class="ri-close-circle-line zCropCancelz hiddenimportant" ng-click="clearCoverImage();" ></i>
                            </li>
                            <!-- <li><a href="javascript:void();"><i class="ri-settings-4-line"></i></a></li> -->
                          </ul>
                      </div>
                      <div class="user-detail d-flex align-items-center text-center mb-3">
                        <div class="profile-img user-profile-img zProfileImgContainerz">
                            <img src="<?php if(!empty($this->session->userdata('profile_image'))){ echo IMAGE_URL.'images/members/'.$this->session->userdata('profile_image'); }else{ echo IMAGE_URL.'images/member-no-imgage.jpg'; } ?>" alt="profile-img" class="img-fluid" />
                         </div>
                         
                         <div class="profile-detail ml-2">
                            <h3 class=""><?php echo $this->session->userdata('first_name'); ?> <span ng-if="friendData.is_admin == 'Y'" style="font-size: 13px;line-height: 10px;margin-top: 18px;position: relative;color: #b03ae8">(<i class="ri-admin-line"> Leader</i> ) </span></h3>
                            <?php if($this->session->userdata('maxmemberlevel')){ ?>
                              <p class="mb-0" style="font-size: 14px;"><?php echo  $this->session->userdata('coursename').": ".$this->session->userdata('maxmemberlevel'); ?>
                                <?php if($this->session->userdata('totbadge')>0){ ?>
                                  &nbsp;&nbsp;(<i style="font-size: 12px;color:#ffa100" class="ri-award-fill"></i> <font style="font-size: 12px;color:#ffa100" ><?php echo $this->session->userdata('totbadge'); ?></font>)
                                <?php } ?>
                              </p>
                             <?php } ?>
                            
                         </div>
                      </div>
                      <div class="profile-info p-4 d-flex align-items-center justify-content-between position-relative">
                         <div class="social-links">
                            <!-- <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                               <li class="text-center pr-3">
                                  <a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/icon/08.png" class="img-fluid rounded" alt="facebook"></a>
                               </li>
                               <li class="text-center pr-3">
                                  <a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/icon/09.png" class="img-fluid rounded" alt="Twitter"></a>
                               </li>
                               <li class="text-center pr-3">
                                  <a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/icon/10.png" class="img-fluid rounded" alt="Instagram"></a>
                               </li>
                               <li class="text-center pr-3">
                                  <a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/icon/11.png" class="img-fluid rounded" alt="Google plus"></a>
                               </li>
                               <li class="text-center pr-3">
                                  <a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/icon/12.png" class="img-fluid rounded" alt="You tube"></a>
                               </li>
                               <li class="text-center pr-3">
                                  <a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/icon/13.png" class="img-fluid rounded" alt="linkedin"></a>
                               </li>
                            </ul> -->
                         </div>
                         <div class="social-info">
                            <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                               <li class="text-center pl-3">
                                  <h6>Posts</h6>
                                  <p class="mb-0">690 <!-- {{clickProfileTab}} --></p>
                               </li>
                               <li class="text-center pl-3">
                                  <h6>Followers</h6>
                                  <p class="mb-0">206</p>
                               </li>
                               <li class="text-center pl-3">
                                  <h6>Following</h6>
                                  <p class="mb-0">100</p>
                               </li>
                            </ul>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
             <div class="iq-card" >
                <div class="iq-card-body p-0">
                   <div class="user-tabing">
                      <ul class="nav nav-pills d-flex align-items-center justify-content-around profile-feed-items p-0 m-0">
                         <li class="p-0">
                            <a class="nav-link" data-toggle="pill" ng-class="(clickProfileTab=='timelineTab') ? 'active' : ''"  href="javascript:void(0)" ng-click="tabPointer('timelineTab')">Timeline</a>
                         </li>
                         <li class="p-0">
                            <a class="nav-link" data-toggle="pill" ng-class="(clickProfileTab=='aboutTab') ? 'active' : ''" href="javascript:void(0)" ng-click="tabPointer('aboutTab')">About</a>
                         </li>
                         <li class="p-0">
                            <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="tabPointer('friendlistTab'); friendData.activeSubFrndTab='all'; getAllFriendList()" ng-class="(clickProfileTab=='churchlistTab' || clickProfileTab=='memberlistTab' || clickProfileTab=='friendlistTab' || friendData.activeSubFrndTab=='all') ? 'active' : ''" >Friends</a>
                         </li>
                         <li class="p-0">
                            <a class="nav-link" data-toggle="pill" ng-class="(clickProfileTab=='photoTab') ? 'active' : ''" href="javascript:void(0)" ng-click="tabPointer('photoTab')">Photos</a>
                         </li>
                         <li class="p-0">
                            <a class="nav-link" data-toggle="pill" ng-class="(clickProfileTab=='eventsTab') ? 'active' : ''" href="javascript:void(0)" ng-click="tabPointer('eventsTab')">Events</a>
                         </li>
                      </ul>
                   </div>
                </div>
             </div>           
          </div>
          
          <!-- Start Friend Request-->
          <div class="container" ng-class="(clickProfileTab == 'friendrequestTab' || clickProfileTab == 'churchrequestTab' || clickProfileTab == 'memberrequestTab') ? '' : 'hiddenimportant'">
           <div class="row">
              <div class="col-sm-12">               
                 <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                       <div class="iq-header-title">
                          <h4 class="card-title">Friend Request</h4>
                       </div>
                    </div>
                    <div class="iq-card-body">
                       <ul class="request-list list-inline m-0 p-0">
                          <li ng-repeat="(key, value) in allFriendRequestObj" class="d-flex align-items-center">
                             <div class="user-img img-fluid">
                              <img class="rounded-circle avatar-40" ng-if="value.profile_image == '' || !value.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" alt="no Images"  >
                              <img class="rounded-circle avatar-40" ng-if="value.profile_image && value.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{value.profile_image}}" alt="{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}">
                             </div>
                             <div class="media-support-info ml-3">
                                <h6>{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h6>
                               <!--  <p class="mb-0">40  friends</p> -->
                             </div>
                             <div class="d-flex align-items-center">
                                <a href="javascript:void();" ng-click="confirmFriendRequest(value.member_friends_aid);" class="mr-3 btn btn-primary rounded zconfirmFriendRequestz_{{value.member_friends_aid}}">Confirm</a>
                                <a href="javascript:void();" ng-click="deleteFromFriendRequest(value.member_friends_aid);" class="mr-3 btn btn-secondary rounded zdeleteFromFriendRequestz_{{value.member_friends_aid}}">Delete Request</a>
                             </div>
                          </li>
                          <li ng-if="allFriendRequestObj.length<=0" class="d-flex align-items-center" style="text-align: center ">
                            There is not any friend request.
                          </li>
                          <!-- <li class="d-block text-center">
                             <a href="javascript:void();" class="btn btn-request">View More Request</a>
                          </li> -->
                       </ul>
                    </div>
                 </div>
                 <div class="iq-card">                
                    <div class="iq-card-header d-flex justify-content-between">
                       <div class="iq-header-title">
                          <h4 class="card-title">People You May Know</h4>
                       </div>
                    </div>
                    <div class="iq-card-body">
                       <ul class="request-list m-0 p-0">
                          <li ng-repeat="(key, value) in peopleYouMayNowObj" class="d-flex align-items-center">
                             <div class="user-img img-fluid">
                              <img class="rounded-circle avatar-40" ng-if="value.profile_image == '' || !value.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" alt="no Images"  >
                              <img class="rounded-circle avatar-40" ng-if="value.profile_image && value.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{value.profile_image}}" alt="{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}">
                              </div>
                             <div class="media-support-info ml-3">
                                <h6>{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h6>
                                <!-- <p class="mb-0">4 friends</p> -->
                             </div>
                             <div class="d-flex align-items-center">
                                <a href="javascript:void();" ng-disabled="value.request_status=='1'" ng-click="sendFriendRequest(value.id);" class="mr-3 btn btn-primary rounded zsendFriendRequestz_{{value.id}}"><i ng-if="value.request_status != '1'"class="ri-user-add-line"></i>{{(value.request_status=='1')? 'Request Send!' : 'Add Friend'}}</a>
                                <a href="javascript:void();"  ng-click="removeFromSuggestion(value.id);" class="mr-3 btn btn-secondary rounded zRemoveFromSuggestionz_{{value.id}}" >Remove</a>
                             </div>
                          </li>
                          <li ng-if="peopleYouMayNowObj.length<=0" class="d-flex align-items-center" style="text-align: center ">
                            No suggestion found!
                          </li>
                          
                       </ul>
                    </div>
                 </div>
              </div>
           </div>
          </div>
          <!-- END Friend Request-->

          <!-- Start Friend List-->
          <div class="container" ng-class="(clickProfileTab == 'friendlistTab' || clickProfileTab == 'churchlistTab' || clickProfileTab == 'memberlistTab') ? '' : 'hiddenimportant'">
             <div class="row">
                <div class="col-sm-12">
                   <div class="iq-card">
                      <div class="iq-card-header d-flex justify-content-between">
                         <div class="iq-header-title">
                            <h4 class="card-title">Friends List</h4>
                         </div>
                      </div>
                   </div>
                </div>

                <div class="col-sm-12 <?php if($this->session->userdata('membership_type')=='RM'){ ?> hiddenimportant <?php } ?>" >
                  <div class="iq-card" >
                    <div class="iq-card-body p-0">
                       <div class="user-tabing">
                          <ul class="nav nav-pills d-flex align-items-center justify-content-center profile-feed-items p-0 m-0">
                            
                             <li class="col-sm-4 p-0">
                                <a class="nav-link" data-toggle="pill" href="javascript:void(0)"  ng-click="tabPointer('friendlistTab'); friendData.activeSubFrndTab='all'; getAllFriendList()" ng-class="clickProfileTab=='friendlistTab' ? 'active' : ''" >All Friends</a>
                             </li>
                             <li class="col-sm-4 p-0">
                                <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-class="(clickProfileTab=='churchlistTab') ? 'active' : ''" ng-click="tabPointer('churchlistTab'); getAllFriendList()">Church Friends</a>
                             </li>
                             <li class="col-sm-4 p-0">
                                <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-class="(clickProfileTab=='memberlistTab') ? 'active' : ''" ng-click="tabPointer('memberlistTab'); getAllFriendList()">Member Friends</a>
                             </li>
                          </ul>
                       </div>
                    </div>
                 </div>     
               </div>

             </div>
          </div>

          <div class="container" ng-class="(clickProfileTab == 'friendlistTab' || clickProfileTab == 'churchlistTab' || clickProfileTab == 'memberlistTab') ? '' : 'hiddenimportant'">
             <div class="row">
                <div class="col-md-6"  ng-repeat="(key, value) in allFriendListObj">
                   <div class="iq-card">
                      <div class="iq-card-body profile-page p-0">
                         <div class="profile-header-image">
                            <div class="cover-container">
                               <img src="<?php echo base_url();?>assets/images/page-img/profile-bg2.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                            </div>
                            <div class="profile-info p-4">
                               <div class="user-detail">
                                  <div class="d-flex flex-wrap justify-content-between align-items-start">
                                     <div class="profile-detail d-flex">
                                        <div class="profile-img pr-4">
                                            <img style="width: 130px;height: 110px;" class="avatar-130 img-fluid" ng-if="value.profile_image == '' || !value.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" alt="no Images"  >
                                            <img style="width: 130px;height: 110px;" class="avatar-130 img-fluid" ng-if="value.profile_image && value.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{value.profile_image}}" alt="{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}">
                                        </div>
                                        <div class="user-data-block">
                                           <h4 class="">{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h4>
                                           <h6>{{value.user_email}}</h6>
                                           <p>{{(isNullOrEmptyOrUndefined(value.church_first_name)==false)? value.church_first_name : '&nbsp;'}}</p>
                                        </div>
                                     </div>
                                     <button type="submit" class="btn btn-primary">Followings</button>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-md-12" ng-if="allFriendListObj.length<=0"  style="text-align: center ">
                  No Friend Found!
                </div>
             </div>
          </div> 
          <!-- End Friend List-->

          <!-- Start Church Member Request-->
          <div class="container" ng-class="(clickProfileTab == 'churchmemberTab') ? '' : 'hiddenimportant'">
           <div class="row">
              <div class="col-sm-12">               
                 <div class="iq-card">                
                    <div class="iq-card-header d-flex justify-content-between">
                       <div class="iq-header-title">
                          <h4 class="card-title">Church Member</h4>
                       </div>
                    </div>
                    <div class="iq-card-body">
                       <ul class="request-list m-0 p-0">
                          <li class="d-flex align-items-center">
                             <div class="media-support-info ml-4">
                                <h6>Name</h6>
                             </div>
                             
                             <div class="media-support-info ml-4">
                                <h6>Leader Name</h6>
                             </div>
                             <div class="media-support-info ml-4">
                                <h6>Age Group</h6>
                             </div>
                             <div class="media-support-info text-right">
                                Action
                             </div>
                          </li>

                          <li ng-repeat="(key, value) in allChurchMemberListObj" class="d-flex align-items-center">
                             <div class="user-img img-fluid">
                              <img class="rounded-circle avatar-40" ng-if="value.profile_image == '' || !value.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" alt="no Images"  >
                              <img class="rounded-circle avatar-40" ng-if="value.profile_image && value.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{value.profile_image}}" alt="{{value.first_name+' '+value.last_name}}">
                              </div>
                             <div class="media-support-info ml-3">
                                <h6>{{value.first_name+' '+value.last_name}}</h6>
                                <p class="mb-0">{{value.user_email}}</p>
                             </div>
                             
                             <div class="media-support-info ml-4">
                                <h6>{{(value.is_admin=='Y')? 'SELF' : (isNullOrEmptyOrUndefined(value.admin_first_name)==false)? value.admin_first_name : ''}}</h6>
                             </div>
                             <div class="media-support-info ml-4">
                                <h6>{{value.agegroup_name}}</h6>
                             </div>
                             <div class="d-flex align-items-center">
                                
                                <a ng-if="(friendData.membership_type == 'CM' || friendData.membership_type == 'CC') && value.is_admin == 'Y'" href="javascript:void();" ng-click="toggleChurchAdmin(value);" class="mr-3 btn btn-success rounded zmakeChurchAdminz_{{value.id}}"><i class="ri-admin-line"></i>Church Leader</a>

                                <div ng-if="(friendData.membership_type == 'CM' || friendData.membership_type == 'CC') && value.is_admin == 'N'" class="iq-card-header-toolbar d-flex align-items-center">
                                  <div class="dropdown">
                                    <a href="javascript:void();" class="dropdown-toggle mr-3 btn btn-primary rounded zmakeChurchAdminz_{{value.id}}" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" role="button"><i class="ri-user-add-line"></i>Create Leader</a>
                                     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="">
                                        <a ng-repeat="(keyAG, valueAG) in allAgeGroupObj" ng-click="toggleChurchAdmin(value,valueAG.id);" class="dropdown-item" href="javascript:void();"><i class="ri-group-2-fill"></i> {{valueAG.agegroup_name}}</a>
                                     </div>
                                  </div>
                               </div>

                                <a data-toggle="tooltip" title="Hooray!" ng-if="(friendData.membership_type == 'RM' && friendData.is_admin =='Y') " href="javascript:void();" ng-click="toggleSetMemberLevel(value);" ng-class="(value.maxmemberlevel>0) ? 'btn-success' : 'btn-primary'" class="mr-3 btn rounded ztoggleSetMemberLevelz_{{value.id}}"><i ng-if="value.maxmemberlevel>0" class="ri-stack-fill"></i><i ng-if="value.maxmemberlevel<=0" class="ri-stack-line"></i>{{(value.maxmemberlevel>0)? 'Unset Level [ '+value.coursename+': '+value.maxmemberlevel+' ]' : 'Set Level'}}</a>
                             </div>
                          </li>
                          <li ng-if="allChurchMemberListObj.length<=0" class="d-flex align-items-center" style="text-align: center ">
                            No suggestion found! 
                          </li>
                       </ul>
                    </div>
                 </div>
              </div>
           </div>
          </div>
          <!-- END Church Member-->
          <!-- Start About Me-->

          <div class="container" ng-class="(clickProfileTab == 'aboutTab') ? '' : 'hiddenimportant'">
           <div class="iq-card">
              <div class="iq-card-body">
                 <div class="row">
                   <!--  <div class="col-md-3">
                       <ul class="nav nav-pills basic-info-items list-inline d-block p-0 m-0">
                          <li>
                             <a class="nav-link active" data-toggle="pill" href="#basicinfo">Contact and Basic Info</a>
                          </li>
                          <li>
                             <a class="nav-link" data-toggle="pill" href="#family">Family and Relationship</a>
                          </li>
                          <li>
                             <a class="nav-link" data-toggle="pill" href="#work">Work and Education</a>
                          </li>
                          <li>
                             <a class="nav-link" data-toggle="pill" href="#lived">Places You've Lived</a>
                          </li>
                          <li>
                             <a class="nav-link" data-toggle="pill" href="#details">Details About You</a>
                          </li>
                       </ul>
                    </div> -->
                    <div class="col-md-12 pl-4">
                       <div class="tab-content">
                          <div class="tab-pane fade active show" id="basicinfo" role="tabpanel">
                             <h4>Contact Information</h4>
                             <hr>
                             <div class="row">
                                <div class="col-3">
                                   <h6>Email</h6>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0"><?php echo $this->session->userdata('user_email'); ?></p>
                                </div>
                                <div class="col-3">
                                   <h6>Mobile</h6>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0">
                                    <?php 
                                    $str_contact_mobile=(!empty(trim($this->session->userdata('contact_mobile'))))? trim($this->session->userdata('contact_mobile')):$this->session->userdata('contact_alt_mobile');
                                    echo $str_contact_mobile;
                                    ?>                                     
                                   </p>
                                </div>
                                <!-- <div class="col-3">
                                   <h6>Address</h6>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0">United States of America</p>
                                </div> -->
                             </div>
                             <h4 class="mt-3">Websites and Social Links</h4>
                             <hr>
                             <div class="row">
                                <?php 
                                $str_website=(!empty(trim($this->session->userdata('website'))))? trim($this->session->userdata('website')):'';
                                ?>

                                <?php if(!empty($str_website)){ ?>
                                <div class="col-3">
                                   <h6>Website</h6>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0">
                                    <?php
                                    echo $str_website;
                                    ?>  
                                   </p>
                                </div>
                                <?php } ?>
       <!--                          <div class="col-3">
                                   <h6>Social Link</h6>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0">www.bootstrap.com</p>
                                </div> -->
                             </div>
                             <h4 class="mt-3">Basic Information</h4>
                             <hr>
                             <div class="row">
                                <div class="col-3">
                                  <?php if($this->session->userdata('membership_type')=='RM'){ ?>
                                   <h6>Birth Date</h6>
                                  <?php }else{ ?>
                                    <h6>Foundation Date</h6>
                                  <?php } ?>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0">
                                    <?php echo date('d M',strtotime($this->session->userdata('dob'))); ?>
                                   </p>
                                </div>
                                <div class="col-3">
                                  <?php if($this->session->userdata('membership_type')=='RM'){ ?>
                                   <h6>Birth Year</h6>
                                  <?php }else{ ?>
                                    <h6>Foundation Year</h6>
                                  <?php } ?>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0"><?php echo date('Y',strtotime($this->session->userdata('dob'))); ?></p>
                                </div>

                                <?php 
                                if(!empty($this->session->userdata('gender')))
                                {
                                ?>
                                <div class="col-3">
                                   <h6>Gender</h6>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0">
                                    <?php 
                                      if(!empty($this->session->userdata('gender')) && $this->session->userdata('gender')=='M')
                                      {
                                        echo "Male";
                                      }
                                      elseif(!empty($this->session->userdata('gender')) && $this->session->userdata('gender')=='F')
                                      {
                                        echo "Female";
                                      }
                                    ?>
                                    </p>
                                </div>
                                <?php
                                }
                                ?>
                               <!--  <div class="col-3">
                                   <h6>interested in</h6>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0">Designing</p>
                                </div>
                                <div class="col-3">
                                   <h6>language</h6>
                                </div>
                                <div class="col-9">
                                   <p class="mb-0">English, French</p>
                                </div> -->
                             </div>
                          </div>
                          <div class="tab-pane fade" id="family" role="tabpanel">
                             <h4 class="mb-3">Relationship</h4>
                             <ul class="suggestions-lists m-0 p-0">
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><i class="ri-add-fill"></i></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Add Your Relationship Status</h6>
                                   </div>
                                </li>
                             </ul>
                             <h4 class="mt-3 mb-3">Family Members</h4>
                             <ul class="suggestions-lists m-0 p-0">
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><i class="ri-add-fill"></i></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Add Family Members</h6>
                                   </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><img src="<?php echo base_url();?>assets/images/user/01.jpg" alt="story-img" class="rounded-circle avatar-40"></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Paul Molive</h6>
                                      <p class="mb-0">Brothe</p>
                                   </div>
                                   <div class="edit-relation"><a href="javascript:void();"><i class="ri-edit-line mr-2"></i>Edit</a></div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><img src="<?php echo base_url();?>assets/images/user/02.jpg" alt="story-img" class="rounded-circle avatar-40"></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Anna Mull</h6>
                                      <p class="mb-0">Sister</p>
                                   </div>
                                   <div class="edit-relation"><a href="javascript:void();"><i class="ri-edit-line mr-2"></i>Edit</a></div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><img src="<?php echo base_url();?>assets/images/user/03.jpg" alt="story-img" class="rounded-circle avatar-40"></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Paige Turner</h6>
                                      <p class="mb-0">Cousin</p>
                                   </div>
                                   <div class="edit-relation"><a href="javascript:void();"><i class="ri-edit-line mr-2"></i>Edit</a></div>
                                </li>
                             </ul>
                          </div>
                          <div class="tab-pane fade" id="work" role="tabpanel">
                             <h4 class="mb-3">Work</h4>
                             <ul class="suggestions-lists m-0 p-0">
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><i class="ri-add-fill"></i></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Add Work Place</h6>
                                   </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><img src="<?php echo base_url();?>assets/images/user/01.jpg" alt="story-img" class="rounded-circle avatar-40"></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Themeforest</h6>
                                      <p class="mb-0">Web Designer</p>
                                   </div>
                                   <div class="edit-relation"><a href="javascript:void();"><i class="ri-edit-line mr-2"></i>Edit</a></div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><img src="<?php echo base_url();?>assets/images/user/02.jpg" alt="story-img" class="rounded-circle avatar-40"></div>
                                   <div class="media-support-info ml-3">
                                      <h6>iqonicdesign</h6>
                                      <p class="mb-0">Web Developer</p>
                                   </div>
                                   <div class="edit-relation"><a href="javascript:void();"><i class="ri-edit-line mr-2"></i>Edit</a></div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><img src="<?php echo base_url();?>assets/images/user/03.jpg" alt="story-img" class="rounded-circle avatar-40"></div>
                                   <div class="media-support-info ml-3">
                                      <h6>W3school</h6>
                                      <p class="mb-0">Designer</p>
                                   </div>
                                   <div class="edit-relation"><a href="javascript:void();"><i class="ri-edit-line mr-2"></i>Edit</a></div>
                                </li>
                             </ul>
                             <h4 class="mb-3">Professional Skills</h4>
                             <ul class="suggestions-lists m-0 p-0">
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><i class="ri-add-fill"></i></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Add Professional Skills</h6>
                                   </div>
                                </li>
                             </ul>
                             <h4 class="mt-3 mb-3">College</h4>
                             <ul class="suggestions-lists m-0 p-0">
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><i class="ri-add-fill"></i></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Add College</h6>
                                   </div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><img src="<?php echo base_url();?>assets/images/user/01.jpg" alt="story-img" class="rounded-circle avatar-40"></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Lorem ipsum</h6>
                                      <p class="mb-0">USA</p>
                                   </div>
                                   <div class="edit-relation"><a href="javascript:void();"><i class="ri-edit-line mr-2"></i>Edit</a></div>
                                </li>
                             </ul>
                          </div>
                          <div class="tab-pane fade" id="lived" role="tabpanel">
                             <h4 class="mb-3">Current City and Hometown</h4>
                             <ul class="suggestions-lists m-0 p-0">
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><img src="<?php echo base_url();?>assets/images/user/01.jpg" alt="story-img" class="rounded-circle avatar-40"></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Georgia</h6>
                                      <p class="mb-0">Georgia State</p>
                                   </div>
                                   <div class="edit-relation"><a href="javascript:void();"><i class="ri-edit-line mr-2"></i>Edit</a></div>
                                </li>
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><img src="<?php echo base_url();?>assets/images/user/02.jpg" alt="story-img" class="rounded-circle avatar-40"></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Atlanta</h6>
                                      <p class="mb-0">Atlanta City</p>
                                   </div>
                                   <div class="edit-relation"><a href="javascript:void();"><i class="ri-edit-line mr-2"></i>Edit</a></div>
                                </li>
                             </ul>
                             <h4 class="mt-3 mb-3">Other Places Lived</h4>
                             <ul class="suggestions-lists m-0 p-0">
                                <li class="d-flex mb-4 align-items-center">
                                   <div class="user-img img-fluid"><i class="ri-add-fill"></i></div>
                                   <div class="media-support-info ml-3">
                                      <h6>Add Place</h6>
                                   </div>
                                </li>
                             </ul>
                          </div>
                          <div class="tab-pane fade" id="details" role="tabpanel">
                             <h4 class="mb-3">About You</h4>
                             <p>Hi, I’m Bni, I’m 26 and I work as a Web Designer for the iqonicdesign.</p>
                             <h4 class="mt-3 mb-3">Other Name</h4>
                             <p>Bini Rock</p>
                             <h4 class="mt-3 mb-3">Favorite Quotes</h4>
                             <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
          </div>
          <!-- End About Me-->
        </div>

        <!-- Start TimeLine Tab-->
        <div ng-controller="indexController" ng-init="initiateData(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>','<?php echo $this->session->userdata('parent_id'); ?>');" ng-class="(clickProfileTab == 'timelineTab') ? '' : 'hiddenimportant'">
          <div when-scrolled="getMorePostOnScroll()" class="postWhenScrollContainer">             
            <div class="container" >
              <div class="tab-pane fade active show" >
                 <div class="iq-card-body p-0">
                    <div class="row">
                       <div class="col-lg-4">
                          <!-- <div class="iq-card">
                             <div class="iq-card-body">
                                <a href="javascript:void();"><span class="badge badge-pill badge-primary font-weight-normal ml-auto mr-1"><i class="ri-star-line"></i></span> 27 Items for yoou</a>
                             </div>
                          </div> -->
                          <div class="iq-card">
                             <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                   <h4 class="card-title">Life Event</h4>
                                </div>
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                   <p class="m-0"><a href="javacsript:void();"> Create </a></p>
                                </div>
                             </div>
                             <div class="iq-card-body">
                                <div class="row">
                                   <div class="col-sm-12">
                                      <div class="event-post position-relative">
                                         <a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/07.jpg" alt="gallary-image" class="img-fluid rounded"></a>
                                         <div class="job-icon-position">
                                            <div class="job-icon bg-primary p-2 d-inline-block rounded-circle"><i class="ri-briefcase-line"></i></div>
                                         </div>
                                         <div class="iq-card-body text-center p-2">
                                            <h5>Started New Job at Apple</h5>
                                            <p>January 24, 2019</p>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="col-sm-12">
                                      <div class="event-post position-relative">
                                         <a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/06.jpg" alt="gallary-image" class="img-fluid rounded"></a>
                                         <div class="job-icon-position">
                                            <div class="job-icon bg-primary p-2 d-inline-block rounded-circle"><i class="ri-briefcase-line"></i></div>
                                         </div>
                                         <div class="iq-card-body text-center p-2">
                                            <h5>Freelance Photographer</h5>
                                            <p>January 24, 2019</p>
                                         </div>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                          <div class="iq-card">
                             <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                   <h4 class="card-title">Photos</h4>
                                </div>
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                   <p class="m-0"><a href="javacsript:void();">Add Photo </a></p>
                                </div>
                             </div>
                             <div class="iq-card-body">
                                <ul class="profile-img-gallary d-flex flex-wrap p-0 m-0">
                                   <li class="col-md-4 col-6 pl-2 pr-0 pb-3"><a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/g1.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                   <li class="col-md-4 col-6 pl-2 pr-0 pb-3"><a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/g2.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                   <li class="col-md-4 col-6 pl-2 pr-0 pb-3"><a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/g3.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                   <li class="col-md-4 col-6 pl-2 pr-0 pb-3"><a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/g4.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                   <li class="col-md-4 col-6 pl-2 pr-0 pb-3"><a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/g5.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                   <li class="col-md-4 col-6 pl-2 pr-0 pb-3"><a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/g6.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                   <li class="col-md-4 col-6 pl-2 pr-0 pb-0"><a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/g7.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                   <li class="col-md-4 col-6 pl-2 pr-0 pb-0"><a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/g8.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                   <li class="col-md-4 col-6 pl-2 pr-0 pb-0"><a href="javascript:void();"><img src="<?php echo base_url();?>assets/images/page-img/g9.jpg" alt="gallary-image" class="img-fluid" /></a></li>
                                </ul>
                             </div>
                          </div>
                          <div class="iq-card">
                             <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                   <h4 class="card-title">Friends</h4>
                                </div>
                                <!-- <div class="iq-card-header-toolbar d-flex align-items-center">
                                   <p class="m-0"><a href="javacsript:void();">Add New </a></p>
                                </div> -->
                             </div>
                             <div class="iq-card-body">
                                <ul class="profile-img-gallary d-flex flex-wrap p-0 m-0">
                                   <li ng-repeat="(key, value) in limitTimelineFriendListObj" class="col-md-4 col-6 pl-2 pr-0 pb-3">
                                      <a href="javascript:void();">
                                        <img style="width:86px;height:86px;" class="img-fluid" ng-if="value.profile_image == '' || !value.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" alt="no Images"  >
                                        <img style="width:86px;height:86px;" class="img-fluid" ng-if="value.profile_image && value.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{value.profile_image}}" alt="{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}">
                                      <h6 class="mt-2">{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h6>
                                   </li>                                   
                                </ul>
                             </div>
                          </div>
                       </div>

                       <div class="col-lg-8">

                        <div class="modal fade" id="tagPostToFriendModal" tabindex="-1" role="dialog" aria-labelledby="postTag-modalLabel" aria-hidden="true" style="display: none;">
                         <div class="modal-dialog" role="document">
                            <div class="modal-content">
                               <div class="modal-header">
                                  <h5 class="modal-title">Create Post</h5>
                                  <button type="button" class="btn btn-secondary" ng-click="closeTagPostModal()"><i class="ri-close-fill"></i></button>
                               </div>
                               <div class="modal-body">
                                  <div class="d-flex align-items-center">
                                     <div class="user-img">
                                        <i class="ri-search-line"></i>
                                     </div>
                                     <form class="post-text ml-3 w-100" action="javascript:void();">
                                        <input type="text" class="form-control rounded" ng-model="tagPostData.searchFriend" ng-keyup="tagPostToFriend()" placeholder="Search friend" style="border:none;">
                                     </form>
                                  </div>

                                  <div class="iq-card-body">
                                     <ul class="media-story m-0 p-0">
                                        <li class="d-flex mb-4 align-items-center" ng-repeat="(key, value) in allFriendListObj" style="cursor:pointer;" ng-click="setTagFriendToPost(value.id)">
                                           <img class="rounded-circle img-fluid" ng-if="value.profile_image == '' || !value.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" alt="no Images"  >
                                           <img class="rounded-circle img-fluid" ng-if="value.profile_image && value.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{value.profile_image}}" alt="{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}">
                                           <div class="stories-data ml-3">
                                              <h5>{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h5>
                                           </div>
                                           <i style="font-size: 22px;cursor: pointer;float: right;" ng-class="(aryPostTagFriend.indexOf(value.id) !== -1) ? 'ri-checkbox-line' : 'ri-checkbox-blank-line'"></i>

                                        </li>
                                     </ul>
                                  </div>

                               </div>
                            </div>
                         </div>
                        </div>
                          
                        <div class="col-sm-12">
                          <div id="post-modal-data" class="iq-card iq-card-block iq-card-stretch iq-card-height">
                             <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                   <h4 class="card-title">Create Post</h4>
                                </div>
                             </div>
                             <div class="iq-card-body" data-toggle="modal" data-target="#postModal">
                                <div class="d-flex align-items-center">
                                   <div class="user-img">
                                      <img src="<?php if(!empty($this->session->userdata('profile_image'))){ echo IMAGE_URL.'images/members/'.$this->session->userdata('profile_image'); }else{ echo IMAGE_URL.'images/member-no-imgage.jpg'; } ?>" alt="userimg" class="avatar-60 rounded-circle">
                                   </div>
                                   <form class="post-text ml-3 w-100" action="javascript:void();">
                                      <input type="text" class="form-control rounded" placeholder="Write something here..." style="border:none;">
                                   </form>
                                </div>
                                <hr>
                                <!-- <ul class="post-opt-block d-flex align-items-center list-inline m-0 p-0">
                                   <li class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/07.png" alt="icon" class="img-fluid"> Photo/Video</li>
                                   <li class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/08.png" alt="icon" class="img-fluid"> Tag Friend</li>
                                   <li class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/09.png" alt="icon" class="img-fluid"> Feeling/Activity</li>
                                   <li class="iq-bg-primary rounded p-2 pointer">
                                      <div class="iq-card-header-toolbar d-flex align-items-center">
                                         <div class="dropdown">
                                            <span class="dropdown-toggle" id="post-option" data-toggle="dropdown" >
                                            <i class="ri-more-fill"></i>
                                            </span>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="post-option" style="">
                                               <a class="dropdown-item" href="javascript:void();">Check in</a>
                                            </div>
                                         </div>
                                      </div>
                                   </li>
                                </ul> -->
                             </div>
                             <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="post-modalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                      <div class="modal-header">
                                         <h5 class="modal-title" id="post-modalLabel">Create Post</h5>
                                         <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ri-close-fill"></i></button>
                                      </div>
                                      <div class="modal-body">
                                         <div class="d-flex align-items-center">
                                            <div class="user-img">
                                               <img src="<?php if(!empty($this->session->userdata('profile_image'))){ echo IMAGE_URL.'images/members/'.$this->session->userdata('profile_image'); }else{ echo IMAGE_URL.'images/member-no-imgage.jpg'; } ?>" alt="userimg" class="avatar-60 rounded-circle img-fluid">
                                            </div>
                                            <form class="post-text ml-3 w-100" action="javascript:void();">
                                               <input type="text" class="form-control rounded" ng-model="singlePostData.post" placeholder="Write something here..." style="border:none;">
                                            </form>
                                         </div>
                                         <hr>
                                         <ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
                                            <li class="col-md-6 mb-3">
                                               <div class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/07.png" alt="icon" class="img-fluid"> Photo/Video <input type="file" accept=".jpg, .jpeg, .png" multiple name="input-file-preview" id="post_file_upload" post-file-upload class="ng-scope"></div>
                                            </li>

                                            <li class="col-md-6 mb-3" ng-click="tagPostToFriend();">
                                               <div class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/08.png" alt="icon" class="img-fluid"> Tag Friend</div>
                                            </li>
                                            <li class="col-md-6 mb-3">
                                               <div class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/09.png" alt="icon" class="img-fluid"> Feeling/Activity</div>
                                            </li>
                                            <li class="col-md-6 mb-3">
                                               <div class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/10.png" alt="icon" class="img-fluid"> Check in</div>
                                            </li>
                                         </ul>
                                         <hr>
                                         <!-- <div class="other-option">
                                            <div class="d-flex align-items-center justify-content-between">
                                               <div class="d-flex align-items-center">
                                                  <div class="user-img mr-3">
                                                     <img src="<?php echo base_url();?>assets/images/user/1.jpg" alt="userimg" class="avatar-60 rounded-circle img-fluid">
                                                  </div>
                                                  <h6>Your Story</h6>
                                               </div>
                                               <div class="iq-card-post-toolbar">
                                                  <div class="dropdown">
                                                     <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                     <span class="btn btn-primary">Friend</span>
                                                     </span>
                                                     <div class="dropdown-menu m-0 p-0">
                                                        <a class="dropdown-item p-3" href="javascript:void();">
                                                           <div class="d-flex align-items-top">
                                                              <div class="icon font-size-20"><i class="ri-save-line"></i></div>
                                                              <div class="data ml-2">
                                                                 <h6>Public</h6>
                                                                 <p class="mb-0">Anyone on or off Facebook</p>
                                                              </div>
                                                           </div>
                                                        </a>
                                                        <a class="dropdown-item p-3" href="javascript:void();">
                                                           <div class="d-flex align-items-top">
                                                              <div class="icon font-size-20"><i class="ri-close-circle-line"></i></div>
                                                              <div class="data ml-2">
                                                                 <h6>Friends</h6>
                                                                 <p class="mb-0">Your Friend on facebook</p>
                                                              </div>
                                                           </div>
                                                        </a>
                                                        <a class="dropdown-item p-3" href="javascript:void();">
                                                           <div class="d-flex align-items-top">
                                                              <div class="icon font-size-20"><i class="ri-user-unfollow-line"></i></div>
                                                              <div class="data ml-2">
                                                                 <h6>Friends except</h6>
                                                                 <p class="mb-0">Don't show to some friends</p>
                                                              </div>
                                                           </div>
                                                        </a>
                                                        <a class="dropdown-item p-3" href="javascript:void();">
                                                           <div class="d-flex align-items-top">
                                                              <div class="icon font-size-20"><i class="ri-notification-line"></i></div>
                                                              <div class="data ml-2">
                                                                 <h6>Only Me</h6>
                                                                 <p class="mb-0">Only me</p>
                                                              </div>
                                                           </div>
                                                        </a>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                         </div> -->

                                         <div class="user-post" id="post_image_preview_container"> </div>
                                         <button type="button" ng-click="submitPost();" class="btn btn-primary d-block w-100 mt-3 zbtnSinglePostz">Post</button>
                                      </div>
                                   </div>
                                </div>
                             </div>
                          </div>
                        </div>

                        <div> <!-- infinite-scroll="getMorePostOnScroll()" infinite-scroll-disabled="busy" infinite-scroll-distance="3" -->
                          <div ng-repeat="(keyPS, valuePS) in aryPostScroll" class="col-sm-12">
                             <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                                <div class="iq-card-body">
                                   <div class="user-post-data">
                                      <div class="d-flex flex-wrap">
                                         <div class="media-support-user-img mr-3">
                                            <img class="rounded-circle img-fluid" src="<?php echo IMAGE_URL;?>images/{{(valuePS.post_data.profile_image == '' || !valuePS.post_data.profile_image)? 'member-no-imgage.jpg':'members/'+valuePS.post_data.profile_image}}">
                                         </div>
                                         <div class="media-support-info mt-2">
                                            <h5 class="mb-0 d-inline-block"><a href="javascript:void();" class="">{{valuePS.post_data.first_name+' '+valuePS.post_data.last_name}} </a> <font style="color:#FFF">{{valuePS.post_data.tag_string_dispaly}} </font></h5>
                                            <!-- <p class="mb-0 d-inline-block">Add New Post</p> -->
                                            <p class="mb-0 text-primary">{{valuePS.post_data.display_create_date}}<!--  ----{{valuePS.id}} --></p>
                                         </div>
                                         <div class="iq-card-post-toolbar">
                                            <div class="dropdown">
                                               <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                               <i class="ri-more-fill"></i>
                                               </span>
                                               <div class="dropdown-menu m-0 p-0">
                                                  <!-- <a class="dropdown-item p-3" href="javascript:void();">
                                                     <div class="d-flex align-items-top">
                                                        <div class="icon font-size-20"><i class="ri-save-line"></i></div>
                                                        <div class="data ml-2">
                                                           <h6>Save Post</h6>
                                                           <p class="mb-0">Add this to your saved items</p>
                                                        </div>
                                                     </div>
                                                  </a> -->
                                                  <a class="dropdown-item p-3" href="javascript:void();" ng-click="hideTimelinePost(valuePS.id)">
                                                     <div class="d-flex align-items-top">
                                                        <div class="icon font-size-20"><i class="ri-close-circle-line"></i></div>
                                                        <div class="data ml-2">
                                                           <h6>Hide Post</h6>
                                                           <p class="mb-0">Stop showing post on your timeline</p>
                                                        </div>
                                                     </div>
                                                  </a>
                                                  <!-- <a class="dropdown-item p-3" href="javascript:void();">
                                                     <div class="d-flex align-items-top">
                                                        <div class="icon font-size-20"><i class="ri-user-unfollow-line"></i></div>
                                                        <div class="data ml-2">
                                                           <h6>Unfollow User</h6>
                                                           <p class="mb-0">Stop seeing posts but stay friends.</p>
                                                        </div>
                                                     </div>
                                                  </a> -->
                                                  <!-- <a class="dropdown-item p-3" href="javascript:void();">
                                                     <div class="d-flex align-items-top">
                                                        <div class="icon font-size-20"><i class="ri-notification-line"></i></div>
                                                        <div class="data ml-2">
                                                           <h6>Notifications</h6>
                                                           <p class="mb-0">Turn on notifications for this post</p>
                                                        </div>
                                                     </div>
                                                  </a> -->
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                   <div class="mt-3">
                                      <p>{{valuePS.post_data.post}}</p>
                                   </div>
                                   <div ng-if="valuePS.post_file_data.length" class="user-post">
                                      <div class="d-flex" data-toggle="modal" data-target="#exampleModal_{{valuePS.id}}">

                                         <div class="col-md-6" ng-show="(isNullOrEmptyOrUndefined(valuePS.post_file_data[0].file_name)==false)">
                                            <a href="javascript:void();">
                                               <img src="<?php echo IMAGE_URL;?>images/postfiles/{{valuePS.post_file_data[0].file_name}}" class="img-fluid rounded w-100" style="width: 291px; height:391px;">
                                            </a>
                                         </div>

                                         <div class="col-md-6 row m-0 p-0" ng-show="(isNullOrEmptyOrUndefined(valuePS.post_file_data[1].file_name)==false)">
                                            <div class="col-sm-12">
                                               <a href="javascript:void();"><img src="<?php echo IMAGE_URL;?>images/postfiles/{{valuePS.post_file_data[1].file_name}}" class="img-fluid rounded w-100" style="width: 291px; height:187px;"></a>
                                            </div>
                                            <div class="col-sm-12 mt-3" ng-show="(isNullOrEmptyOrUndefined(valuePS.post_file_data[2].file_name)==false)">
                                               <a href="javascript:void();"><img src="<?php echo IMAGE_URL;?>images/postfiles/{{valuePS.post_file_data[2].file_name}}" class="img-fluid rounded w-100" style="width: 291px; height:187px;"></a>
                                            </div>
                                         </div>
                                      </div>
                                      <div ng-if="valuePS.post_file_data.length>3" class="col-md-6" style="font-size:62px;">
                                         <a href="javascript:void();"> + {{valuePS.post_file_data.length-3}}</a>
                                      </div>
                                   </div>

                                   <div class="modal fade" id="exampleModal_{{valuePS.id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">                  
                                      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                      <div class="modal-content iq-dark-box">
                                      <div class="modal-header">
                                         <div class="user-post-data">
                                            <div class="d-flex flex-wrap">
                                               <div class="media-support-user-img mr-3">
                                                  <img class="rounded-circle img-fluid" src="<?php echo IMAGE_URL;?>images/{{(valuePS.post_data.profile_image == '' || !valuePS.post_data.profile_image)? 'member-no-imgage.jpg':'members/'+valuePS.post_data.profile_image}}">
                                               </div>
                                               <div class="media-support-info mt-2">
                                                  <h5 class="mb-0 d-inline-block"><a href="javascript:void();" class="">{{valuePS.post_data.first_name+' '+valuePS.post_data.last_name}} </a> <font style="color:#FFF">{{valuePS.post_data.tag_string_dispaly}} </font></h5>
                                                  <!-- <p class="mb-0 d-inline-block">Add New Post</p> -->
                                                  <p class="mb-0 text-primary">{{valuePS.post_data.display_create_date}}<!--  ----{{valuePS.id}} --></p>
                                               </div>                                       
                                            </div>
                                         </div>
                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true">&times;</span>
                                         </button>
                                      </div>
                                      <div class="modal-body">
                                         <div class="row">
                                         <div class="col-md-12">
                                            <p>{{valuePS.post_data.post}}</p>
                                         </div>

                                         <div ng-if="valuePS.post_file_data.length" class="col-md-6">
                                            <div class="col-md-12"  ng-repeat="(keyFileData, valueFileData) in valuePS.post_file_data">
                                               <a href="javascript:void();">
                                                  <img src="<?php echo IMAGE_URL;?>images/postfiles/{{valueFileData.file_name}}" class="img-fluid rounded w-100">
                                               </a>
                                            </div>
                                         </div>

                                         <div class="col-md-6">
                                         <div class="comment-area mt-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                               <div class="like-block position-relative d-flex align-items-center">
                                                  <div class="d-flex align-items-center">
                                                     <div class="like-data">
                                                        <div class="dropdown">
                                                           <span style="cursor:pointer" ng-click="likeTimelinePost(valuePS.id,valuePS.post_id)" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                              <img  ng-show="valuePS.indv_post_like_unlike==0" src="<?php echo base_url();?>assets/images/icon/01.png" class="img-fluid" alt="">
                                                              <img ng-show="valuePS.indv_post_like_unlike==1" src="<?php echo base_url();?>assets/images/icon/like2.png" class="img-fluid" alt="">
                                                           </span>
                                                           <!-- <div class="dropdown-menu">
                                                              <a class="ml-2 mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Like"><img src="<?php echo base_url();?>assets/images/icon/01.png" class="img-fluid" alt=""></a>
                                                              <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Love"><img src="<?php echo base_url();?>assets/images/icon/02.png" class="img-fluid" alt=""></a>
                                                              <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Happy"><img src="<?php echo base_url();?>assets/images/icon/03.png" class="img-fluid" alt=""></a>
                                                              <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="HaHa"><img src="<?php echo base_url();?>assets/images/icon/04.png" class="img-fluid" alt=""></a>
                                                              <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Think"><img src="<?php echo base_url();?>assets/images/icon/05.png" class="img-fluid" alt=""></a>
                                                              <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sade"><img src="<?php echo base_url();?>assets/images/icon/06.png" class="img-fluid" alt=""></a>
                                                              <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Lovely"><img src="<?php echo base_url();?>assets/images/icon/07.png" class="img-fluid" alt=""></a>
                                                           </div> -->
                                                        </div>
                                                     </div>

                                                     <div class="total-like-block ml-2 mr-3">
                                                        <div class="dropdown">
                                                           <span style="cursor:pointer" ng-click="likeTimelinePost(valuePS.id,valuePS.post_id)" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                           {{(valuePS.post_like_data.length>0)? valuePS.post_like_data.length+' Likes':''}} 
                                                           </span>
                                                           <div ng-if="valuePS.post_like_data.length>0" class="dropdown-menu">
                                                              <a style="cursor: default;" ng-repeat="(keyLikeName, valueLikeName) in valuePS.post_like_data" class="dropdown-item" href="javascript:void();">{{valueLikeName.first_name+' '+valueLikeName.last_name}}</a>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </div>

                                                  <div ng-if='valuePS.all_post_comment_data.length>0' class="total-comment-block">
                                                     <div class="dropdown">
                                                        <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                        {{valuePS.all_post_comment_data.length}} Comment
                                                        </span>
                                                        <div class="dropdown-menu">
                                                           <a class="dropdown-item" ng-repeat="(keyComments, valueComments) in valuePS.post_comment_data" href="javascript:void();">{{valueComments.first_name+' '+valueComments.last_name}}</a>
                                                           <a ng-if='valuePS.all_post_comment_data.length>3' class="dropdown-item" href="javascript:void();">Other</a>
                                                        </div>
                                                     </div>
                                                  </div>
                                               </div>
                                               <!-- <div class="share-block d-flex align-items-center feather-icon mr-3">
                                                  <a href="javascript:void();"><i class="ri-share-line"></i>
                                                  <span class="ml-1">99 Share</span></a>
                                               </div> -->
                                            </div>

                                            <div ng-if='valuePS.all_post_comment_data.length>0'>
                                               <hr>
                                               <ul class="post-comments p-0 m-0">
                                                  <li class="mb-2" ng-repeat="(keyComments, valueComments) in valuePS.all_post_comment_data">
                                                     <div class="d-flex flex-wrap">
                                                        <div class="user-img">
                                                           <img src="<?php echo IMAGE_URL;?>images/{{(valueComments.profile_image == '' || !valueComments.profile_image)? 'member-no-imgage.jpg':'members/'+valueComments.profile_image}}" alt="userimg" class="avatar-35 rounded-circle img-fluid">
                                                        </div>
                                                        <div class="comment-data-block ml-3">
                                                           <h6>{{valueComments.first_name+' '+valueComments.last_name}}</h6>
                                                           <p class="mb-0">{{valueComments.member_comment}}</p>
                                                           <div class="d-flex flex-wrap align-items-center comment-activity">
                                                              <!-- <a href="javascript:void();">like</a>
                                                              <a href="javascript:void();">reply</a>
                                                              <a href="javascript:void();">translate</a> -->
                                                              <span> {{valueComments.comment_date}} </span>
                                                           </div>
                                                        </div>
                                                     </div>
                                                  </li>
                                               </ul>
                                            </div>

                                            <form class="comment-text d-flex align-items-center mt-3" action="javascript:void(0);">
                                               <input type="text" class="form-control rounded" ng-model="valuePS.member_comment" maxlength="300" placeholder="Enter Your Comment">
                                               <div class="comment-attagement d-flex">
                                                  <!-- <a href="javascript:void();"><i class="ri-link mr-3"></i></a>
                                                  <a href="javascript:void();"><i class="ri-user-smile-line mr-3"></i></a> 
                                                  <a href="javascript:void();"><i class="ri-camera-line mr-3"></i></a>-->
                                                  <a href="javascript:void();" ng-click="commentTimelinePost(valuePS)"><i class="ri-send-plane-2-fill mr-3"></i></a>
                                               </div>
                                            </form>
                                         </div>
                                         </div>
                                         </div>
                                      </div>

                                      </div>
                                      </div>
                                   </div>
                                   <div class="comment-area mt-3">
                                      <div class="d-flex justify-content-between align-items-center">
                                         <div class="like-block position-relative d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                               <div class="like-data">
                                                  <div class="dropdown">                                           
                                                     <img style="cursor: default;" src="<?php echo base_url();?>assets/images/icon/01.png" class="img-fluid" alt="">
                                                 
                                                  </div>
                                               </div>
                                               <div class="total-like-block ml-2 mr-3">
                                                  <div class="dropdown">
                                                     <span style="cursor: default;">
                                                     {{(valuePS.post_like_data.length>0)? valuePS.post_like_data.length+' Likes':''}} 
                                                     </span>
                                                     <div ng-if="valuePS.post_like_data.length>0" class="dropdown-menu">
                                                        <a style="cursor: default;" ng-repeat="(keyLikeName, valueLikeName) in valuePS.post_like_data" class="dropdown-item" href="javascript:void();">{{valueLikeName.first_name+' '+valueLikeName.last_name}}</a>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>
                                            <div ng-if='valuePS.all_post_comment_data.length>0' class="total-comment-block">
                                               <div class="dropdown">
                                                  <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                  {{valuePS.all_post_comment_data.length}} Comment
                                                  </span>
                                                  <div class="dropdown-menu">
                                                     <a class="dropdown-item" ng-repeat="(keyComments, valueComments) in valuePS.post_comment_data" href="javascript:void();">{{valueComments.first_name+' '+valueComments.last_name}}</a>
                                                     <a ng-if='valuePS.all_post_comment_data.length>3' class="dropdown-item" href="javascript:void();">Other</a>
                                                  </div>
                                               </div>
                                            </div>
                                         </div>
                                         <!-- <div class="share-block d-flex align-items-center feather-icon mr-3">
                                            <a href="javascript:void();"><i class="ri-share-line"></i>
                                            <span class="ml-1">99 Share</span></a>
                                         </div> -->
                                      </div>
                                      <hr>
                                      
                                      <div class="d-flex justify-content-between align-items-center">
                                         <div class="like-block position-relative d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                               <div class="like-data">
                                                  <div class="dropdown">
                                                     <span style="cursor:pointer" ng-click="likeTimelinePost(valuePS.id,valuePS.post_id)" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                        <img  ng-show="valuePS.indv_post_like_unlike==0" src="<?php echo base_url();?>assets/images/icon/01.png" class="img-fluid" alt="">
                                                        <img ng-show="valuePS.indv_post_like_unlike==1" src="<?php echo base_url();?>assets/images/icon/like2.png" class="img-fluid" alt="">
                                                     </span>
                                                    <!--  <div class="dropdown-menu">
                                                        <a class="ml-2 mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Like"><img src="<?php echo base_url();?>assets/images/icon/01.png" class="img-fluid" alt=""></a>
                                                        <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Love"><img src="<?php echo base_url();?>assets/images/icon/02.png" class="img-fluid" alt=""></a>
                                                        <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Happy"><img src="<?php echo base_url();?>assets/images/icon/03.png" class="img-fluid" alt=""></a>
                                                        <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="HaHa"><img src="<?php echo base_url();?>assets/images/icon/04.png" class="img-fluid" alt=""></a>
                                                        <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Think"><img src="<?php echo base_url();?>assets/images/icon/05.png" class="img-fluid" alt=""></a>
                                                        <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sade"><img src="<?php echo base_url();?>assets/images/icon/06.png" class="img-fluid" alt=""></a>
                                                        <a class="mr-2" href="javascript:void();" data-toggle="tooltip" data-placement="top" title="" data-original-title="Lovely"><img src="<?php echo base_url();?>assets/images/icon/07.png" class="img-fluid" alt=""></a>
                                                     </div> -->
                                                  </div>
                                               </div>
                                               <div class="total-like-block ml-2 mr-3">
                                                  <div class="dropdown">
                                                     <span style="cursor:pointer" ng-click="likeTimelinePost(valuePS.id,valuePS.post_id)" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                     Likes
                                                     </span>
                                                  </div>
                                               </div>
                                            </div>
                                            <!-- <div class="total-comment-block">
                                               <div class="dropdown">
                                                  <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                                  Comment
                                                  </span>
                                                 </div>
                                            </div> -->
                                         </div>
                                         <!-- <div class="share-block d-flex align-items-center feather-icon mr-3">
                                            <a href="javascript:void();"><i class="ri-share-line"></i>
                                            <span class="ml-1">Share Now</span></a>
                                         </div> -->
                                      </div>

                                      <div ng-if='valuePS.post_comment_data.length>0'>
                                         <hr>
                                         <ul class="post-comments p-0 m-0">
                                            <li class="mb-2" ng-repeat="(keyComments, valueComments) in valuePS.post_comment_data">
                                               <div class="d-flex flex-wrap">
                                                  <div class="user-img">
                                                     <img src="<?php echo IMAGE_URL;?>images/{{(valueComments.profile_image == '' || !valueComments.profile_image)? 'member-no-imgage.jpg':'members/'+valueComments.profile_image}}" alt="userimg" class="avatar-35 rounded-circle img-fluid">
                                                  </div>
                                                  <div class="comment-data-block ml-3">
                                                     <h6>{{valueComments.first_name+' '+valueComments.last_name}}</h6>
                                                     <p class="mb-0">{{valueComments.member_comment}}</p>
                                                     <div class="d-flex flex-wrap align-items-center comment-activity">
                                                        <!-- <a href="javascript:void();">like</a>
                                                        <a href="javascript:void();">reply</a>
                                                        <a href="javascript:void();">translate</a> -->
                                                        <span> {{valueComments.comment_date}} </span>
                                                     </div>
                                                  </div>
                                               </div>
                                            </li>
                                            
                                         </ul>
                                      </div>
                                      <form class="comment-text d-flex align-items-center mt-3" action="javascript:void(0);">
                                         <input type="text" class="form-control rounded" ng-model="valuePS.member_comment" maxlength="300" placeholder="Enter Your Comment">
                                         <div class="comment-attagement d-flex">
                                            <!-- <a href="javascript:void();"><i class="ri-link mr-3"></i></a>
                                            <a href="javascript:void();"><i class="ri-user-smile-line mr-3"></i></a> 
                                            <a href="javascript:void();"><i class="ri-camera-line mr-3"></i></a>-->
                                            <a href="javascript:void();" ng-click="commentTimelinePost(valuePS)"><i class="ri-send-plane-2-fill mr-3"></i></a>
                                         </div>
                                      </form>
                                   </div>
                                </div>
                             </div>
                          </div>
                        </div>

                        <div ng-show="loadingPost && postExist" class="col-sm-12 text-center">
                           <img src="<?php echo base_url();?>assets/images/page-img/page-load-loader.gif" alt="loader" style="height: 100px;">
                        </div>
                       </div>
                    </div>
                 </div>
              </div>
            </div>
          </div>          
        </div>
        <!-- END Time Line Tab-->


        <!-- Start Photo Section Tab-->
        <div ng-controller="photoController" ng-init="initiateData(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>','<?php echo $this->session->userdata('parent_id'); ?>');" ng-class="(clickProfileTab == 'photoTab') ? '' : 'hiddenimportant'">
          <div when-scrolled="getMorePhotoOnScroll()" class="photoWhenScrollContainer">             
              <div class="container">
                <div class="tab-pane fade active show">
                   <div class="iq-card">
                      <div class="iq-card-body">
                         <h4 class="card-title">Photos of You</h4>
                         <div class="friend-list-tab mt-2">
                            <!-- <ul class="nav nav-pills d-flex align-items-center justify-content-left friend-list-items p-0 mb-2">
                               <li>
                                  <a class="nav-link active" data-toggle="pill" href="#photosofyou">Photos of You</a>
                               </li>
                               <li>
                                  <a class="nav-link" data-toggle="pill" href="#your-photos">Your Photos</a>
                               </li>
                            </ul> -->
                            <div class="tab-content">
                               <div class="tab-pane fade active show" id="photosofyou" role="tabpanel">
                                  <div class="iq-card-body p-0">
                                     <div class="row">
                                        <div class="col-md-6 col-lg-3 mb-3" ng-repeat="(keyPhto, valuePhto) in aryPhotoScroll">
                                           <div class="user-images position-relative overflow-hidden">
                                              <a href="javascript:void();">
                                              <img style="width: 224px;height: 149px;" ng-src="{{valuePhto.all_file_n_photo_path}}" class="img-fluid rounded" alt="Responsive image">
                                              </a>

                                              <div class="image-hover-data">
                                                 <div class="product-elements-icon">
                                                    <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                       <li><a style="font-size: 15px;" href="javascript:void();" class="pr-3 text-white">{{valuePhto.display_upload_date}} <i class="ri-time-line"></i></a></li><!-- 
                                                       <li><a href="javascript:void();" class="pr-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                       <li><a href="javascript:void();" class="pr-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li> -->
                                                    </ul>
                                                 </div>
                                              </div>
                                              <!-- <div class="image-hover-data">
                                                 <div class="product-elements-icon">
                                                    <ul class="d-flex align-items-center m-0 p-0 list-inline">
                                                       <li><a href="javascript:void();" class="pr-3 text-white"> 60 <i class="ri-thumb-up-line"></i> </a></li>
                                                       <li><a href="javascript:void();" class="pr-3 text-white"> 30 <i class="ri-chat-3-line"></i> </a></li>
                                                       <li><a href="javascript:void();" class="pr-3 text-white"> 10 <i class="ri-share-forward-line"></i> </a></li>
                                                    </ul>
                                                 </div>
                                              </div>
                                              <a href="javascript:void();" class="image-edit-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit or Remove"><i class="ri-edit-2-fill"></i></a> -->

                                           </div>
                                        </div>
                                        <div  ng-show="loadingPhoto && photoExist" class="col-md-12 text-center">
                                           <img src="<?php echo base_url();?>assets/images/page-img/page-load-loader.gif" alt="loader" style="height: 100px;">
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
         <!-- End Photo Section Tab-->
     </div>
  </div>
</div>