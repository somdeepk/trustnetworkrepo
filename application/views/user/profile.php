<div id="content-page" class="content-page" ng-controller="profileController" ng-init="selectprofileTab(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>','<?php echo $this->session->userdata('parent_id'); ?>','<?php echo $this->session->userdata('cover_image'); ?>');">
  
  <div class="container">
     <div class="row">
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
                        <div class="zCropCoverImagez hiddenimportant" class="" style="width:100%; margin-top:30px"></div>
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
                                <a href="#"><img src="<?php echo base_url();?>assets/images/icon/08.png" class="img-fluid rounded" alt="facebook"></a>
                             </li>
                             <li class="text-center pr-3">
                                <a href="#"><img src="<?php echo base_url();?>assets/images/icon/09.png" class="img-fluid rounded" alt="Twitter"></a>
                             </li>
                             <li class="text-center pr-3">
                                <a href="#"><img src="<?php echo base_url();?>assets/images/icon/10.png" class="img-fluid rounded" alt="Instagram"></a>
                             </li>
                             <li class="text-center pr-3">
                                <a href="#"><img src="<?php echo base_url();?>assets/images/icon/11.png" class="img-fluid rounded" alt="Google plus"></a>
                             </li>
                             <li class="text-center pr-3">
                                <a href="#"><img src="<?php echo base_url();?>assets/images/icon/12.png" class="img-fluid rounded" alt="You tube"></a>
                             </li>
                             <li class="text-center pr-3">
                                <a href="#"><img src="<?php echo base_url();?>assets/images/icon/13.png" class="img-fluid rounded" alt="linkedin"></a>
                             </li>
                          </ul> -->
                       </div>
                       <div class="social-info">
                          <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
                             <li class="text-center pl-3">
                                <h6>Posts</h6>
                                <p class="mb-0">690</p>
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
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="friendData.clickProfileTab='timelineTab'">Timeline</a>
                       </li>
                       <li class="p-0">
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="friendData.clickProfileTab='aboutTab'">About</a>
                       </li>
                       <li class="p-0">
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="friendData.clickProfileTab='friendlistTab'; friendData.activeSubFrndTab='all'; getAllFriendList()" ng-class="(friendData.clickProfileTab=='churchlistTab' || friendData.clickProfileTab=='memberlistTab' || friendData.clickProfileTab=='friendlistTab' || friendData.activeSubFrndTab=='all') ? 'active' : ''" >Friends</a>
                       </li>
                       <li class="p-0">
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="friendData.clickProfileTab='photos'">Photos</a>
                       </li>
                       <li class="p-0">
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="friendData.clickProfileTab='eventsTab'">Events</a>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>           
        </div>
        
        <!-- Start Friend Request-->
        <div class="container" ng-class="(friendData.clickProfileTab == 'friendrequestTab' || friendData.clickProfileTab == 'churchrequestTab' || friendData.clickProfileTab == 'memberrequestTab') ? '' : 'hiddenimportant'">
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
                              <p class="mb-0">40  friends</p>
                           </div>
                           <div class="d-flex align-items-center">
                              <a href="javascript:void();" ng-click="confirmFriendRequest(value.member_friends_aid);" class="mr-3 btn btn-primary rounded zconfirmFriendRequestz_{{value.member_friends_aid}}">Confirm</a>
                              <a href="javascript:void();" ng-click="deleteFromFriendRequest(value.member_friends_aid);" class="mr-3 btn btn-secondary rounded zdeleteFromFriendRequestz_{{value.member_friends_aid}}">Delete Request</a>
                           </div>
                        </li>
                        <li ng-if="allFriendRequestObj.length<=0" class="d-flex align-items-center" style="text-align: center ">
                          There is no more friend request.
                        </li>
                        <li class="d-block text-center">
                           <a href="#" class="btn btn-request">View More Request</a>
                        </li>
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
                              <p class="mb-0">4  friends</p>
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
        <div class="container" ng-class="(friendData.clickProfileTab == 'friendlistTab' || friendData.clickProfileTab == 'churchlistTab' || friendData.clickProfileTab == 'memberlistTab') ? '' : 'hiddenimportant'">
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
                              <a class="nav-link" data-toggle="pill" href="javascript:void(0)"  ng-click="friendData.clickProfileTab='friendlistTab'; friendData.activeSubFrndTab='all'; getAllFriendList()" ng-class="friendData.clickProfileTab=='friendlistTab' ? 'active' : ''" >All Friends</a>
                           </li>
                           <li class="col-sm-4 p-0">
                              <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-class="(friendData.clickProfileTab=='churchlistTab') ? 'active' : ''" ng-click="friendData.clickProfileTab='churchlistTab'; getAllFriendList()">Church Friends</a>
                           </li>
                           <li class="col-sm-4 p-0">
                              <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-class="(friendData.clickProfileTab=='memberlistTab') ? 'active' : ''" ng-click="friendData.clickProfileTab='memberlistTab'; getAllFriendList()">Member Friends</a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>     
             </div>

           </div>
        </div>

        <div class="container" ng-class="(friendData.clickProfileTab == 'friendlistTab' || friendData.clickProfileTab == 'churchlistTab' || friendData.clickProfileTab == 'memberlistTab') ? '' : 'hiddenimportant'">
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
                                          <img class="avatar-130 img-fluid" ng-if="value.profile_image == '' || !value.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" alt="no Images"  >
                                          <img class="avatar-130 img-fluid" ng-if="value.profile_image && value.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{value.profile_image}}" alt="{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}">

                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h4>
                                         <h6>{{value.user_email}}</h6>
                                         <p>{{(isNullOrEmptyOrUndefined(value.church_first_name)==false)? value.church_first_name : ''}}</p>
                                      </div>
                                   </div>
                                   <button type="submit" class="btn btn-primary">Following</button>
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
        <div class="container" ng-class="(friendData.clickProfileTab == 'churchmemberTab') ? '' : 'hiddenimportant'">
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
                                      <a ng-repeat="(keyAG, valueAG) in allAgeGroupObj" ng-click="toggleChurchAdmin(value,valueAG.id);" class="dropdown-item" href="#"><i class="ri-group-2-fill"></i> {{valueAG.agegroup_name}}</a>
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
     </div>
  </div>
</div>