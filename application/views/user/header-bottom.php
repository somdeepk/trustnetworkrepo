<?php
if ($this->session -> userdata('email') == "" && $this->session -> userdata('login') != true)
{
  redirect('user/login');
}
$memberIsApproved=$this->session -> userdata('is_approved');
$membershipType=$this->session -> userdata('membership_type');
$isAdmin=$this->session -> userdata('is_admin');
$actionName=$this->router->fetch_method();

//$user_auto_id=$this->session -> userdata('user_auto_id');
/*echo $user_auto_id."ss<pre>";
print_r($this->session -> userdata);

exit;*/
?>
 <!-- Wrapper START -->
<div class="wrapper">
    <!-- Sidebar  -->
    
      <div class="iq-sidebar" ng-controller="leftMenuController" ng-init="init_left_menu(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('parent_id'); ?>','<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>')">
          <div id="sidebar-scrollbar">
             <?php if ($memberIsApproved=="Y"){ ?>
             <nav class="iq-sidebar-menu">
                <ul id="iq-sidebar-toggle" class="iq-menu">
                  <li <?php echo ($actionName=='index')? 'class="active"' : '' ;?>><a href="<?php echo base_url();?>user/index" class="iq-waves-effect"><i class="las la-newspaper"></i><span>Newsfeed</span></a></li>
                  <li <?php echo ($actionName=='profile')? 'class="active"' : '' ;?>><a href="<?php echo base_url();?>user/profile" class="iq-waves-effect"><i class="las la-user"></i><span>Profile</span></a></li>
                  <li <?php echo ($actionName=='events')? 'class="active"' : '' ;?> ><a href="<?php echo base_url();?>user/events" class="iq-waves-effect"><i class="las la-film"></i><span>Events</span></a></li>

                  <?php if($membershipType=="RM"){ ?>
                  <li <?php echo ($actionName=='friendrequest')? 'class="active"' : '' ;?>><a href="<?php echo base_url();?>user/friendrequest" class="iq-waves-effect"><i class="las la-anchor"></i><span>Friend Request</span></a></li>
                  <li <?php echo ($actionName=='friendlist')? 'class="active"' : '' ;?>><a href="<?php echo base_url();?>user/friendlist" class="iq-waves-effect"><i class="las la-anchor"></i><span>Friend List</span></a></li>
                  <?php }else{ ?>
                      <li <?php echo ($actionName=='churchrequest')? 'class="active"' : '' ;?>><a href="<?php echo base_url();?>user/churchrequest" class="iq-waves-effect"><i class="las la-anchor"></i><span>Church Request</span></a></li>
                      <li <?php echo ($actionName=='churchlist')? 'class="active"' : '' ;?>><a href="<?php echo base_url();?>user/churchlist" class="iq-waves-effect"><i class="las la-anchor"></i><span>Church List</span></a></li>
                      <li <?php echo ($actionName=='memberrequest')? 'class="active"' : '' ;?>><a href="<?php echo base_url();?>user/memberrequest" class="iq-waves-effect"><i class="las la-anchor"></i><span>Member Request</span></a></li>
                      <li <?php echo ($actionName=='memberlist')? 'class="active"' : '' ;?>><a href="<?php echo base_url();?>user/memberlist" class="iq-waves-effect"><i class="las la-anchor"></i><span>Member List</span></a></li>
                  <?php } ?>

                  <li <?php echo ($actionName=='photos')? 'class="active"' : '' ;?>><a href="<?php echo base_url();?>user/photos" class="iq-waves-effect"><i class="las la-video"></i><span>Photo/Video</span></a></li>
                  <li>
                    <a href="#group" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-users"></i><span>Group</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="group" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                       <?php if($membershipType=="CM" || $membershipType=="CC" || $isAdmin=="Y"){ ?>
                       <li><a href="<?php echo base_url();?>user/churchmember"><i class="ri-tablet-line"></i>Church Members</a></li>
                       <?php } ?>
                       <!-- <li ng-repeat="(key, value) in allGroupObj"><a href="javascript:void();"><i class="ri-device-line"></i>{{value.name}}</a></li> -->
                       <!-- <li><a href="javascript:void();"><i class="ri-toggle-line"></i>School Friends</a></li>
                       <li><a href="javascript:void();"><i class="ri-toggle-line"></i>College Friends</a></li>
                       <li><a href="javascript:void();"><i class="ri-checkbox-line"></i>Friends</a></li>
                       <li><a href="javascript:void();"><i class="ri-radio-button-line"></i>Prayer Friends</a></li> -->
                    </ul>
                  </li>
                  <li>
                    
                    
                    <?php if($membershipType=="CM" || $membershipType=="CC" || $isAdmin=="Y"){ ?>
                    <div ng-repeat="(key, value) in allTaskLevelObj">
                      <a href="#Task" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-focus-2-line"></i><span>{{value.course_name}}</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                      <ul id="Task" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                          <li ng-repeat="(key1, value1) in value.levelData"><a href="javascript:void(0);" ng-click="set_task(value.id,key1)"><i class="ri-tablet-line"></i>{{value1.labelname}}</a></li>
                      </ul>
                    </div>
                    <?php }elseif($membershipType=="RM" && $isAdmin=="N"){ ?>
                    <div ng-repeat="(key, value) in allTaskLevelObj">
                      <a href="#Task" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-focus-2-line"></i><span>{{value.course_name}}</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                      <ul id="Task" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                        <li ng-repeat="(key1, value1) in  value.levelData" ><a ng-class="(value1.is_disabled == 'Y') ? 'cssdisabled' : ''" href="javascript:void(0);" ng-click="set_task(value.id,key1)"><i class="ri-tablet-line"></i>{{value1.labelname}}</a></li>
                      </ul>
                    </div>
                    <?php } ?>
                     <!-- ng-disabled="value.is_disabled=='Y'"  -->
                  </li>    
                  <li><a href="javascript:void();" class="iq-waves-effect"><i class="las la-video"></i><span>Awards</span></a></li>
                  <li><a href="javascript:void();" class="iq-waves-effect"><i class="lab la-rocketchat"></i><span>Messenger</span></a></li>
                 <!--  <li><a href="javascript:void();" class="iq-waves-effect"><i class="ri-compasses-line"></i><span>Community Forum</span></a></li> -->
                  <li <?php echo ($actionName=='support')? 'class="active"' : '' ;?>  ><a href="<?php echo base_url();?>user/support" class="iq-waves-effect"><i class="las la-check-circle"></i><span>Support</span></a></li>
                </ul>
             </nav>
             <div class="p-3"></div>
             <?php } ?>
          </div>
      </div>
    
    <!-- TOP Nav Bar -->
    
    <div class="iq-top-navbar">
        <div class="iq-navbar-custom">
           <nav class="navbar navbar-expand-lg navbar-light p-0">


              <div class="iq-navbar-logo d-flex justify-content-between " >

                 <?php if ($memberIsApproved=="N"){ ?>
                 <a href="javascript:void(0);">
                 <img src="<?php echo base_url();?>assets/images/logo.png" class="img-fluid" alt="">
                 <span style="font-size: 14px;color:#ff7575">Thank you for registering with use. We are currently reviewing your registration details. Once approved you will be able to access full range of "Follow Me Now". Thank you for your cooperation.</span>
                 </a>
                <?php } ?>

                <?php if ($memberIsApproved=="Y"){ ?>
                 <a href="<?php echo base_url();?>user/index">
                 <img src="<?php echo base_url();?>assets/images/logo.png" class="img-fluid d-none d-md-block" alt="">
                 <img src="<?php echo base_url();?>assets/images/logomobile.png" class="img-fluid d-block d-md-none" alt="">
                 
                 <!-- <span class="d-none d-md-block">Follow Me</span> -->
                 </a>
                 <div class="iq-menu-bt align-self-center">
                   <div class="wrapper-menu">
                      <div class="main-circle"><i class="ri-menu-line"></i></div>
                   </div>
                </div>
                <?php } ?>
              </div>
              <div class="iq-search-bar">
                 <?php if ($memberIsApproved=="Y"){ ?>
                 <!-- <form action="#" class="searchbox">
                    <input type="text" class="text search-input" placeholder="Type here to search...">
                    <a class="search-link" href="javascript:void();"><i class="ri-search-line"></i></a>
                 </form> -->
                <?php } ?>
              </div>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
              <i class="ri-menu-3-line"></i>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 <?php if ($memberIsApproved=="Y"){ ?>
                 <ul class="navbar-nav ml-auto navbar-list" ng-controller="notificationController" ng-init="get_all_notifiction(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('parent_id'); ?>','<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>','<?php echo $this->session->userdata('admin_id'); ?>');">
                    <li>
                       <a href="<?php echo base_url();?>user/profile" class="iq-waves-effect d-flex align-items-center">
                          <img id="header_profile_images" src="<?php if(!empty($this->session->userdata('profile_image'))){ echo IMAGE_URL.'images/members/'.$this->session->userdata('profile_image'); }else{ echo IMAGE_URL.'images/member-no-imgage.jpg'; } ?>" class="img-fluid rounded-circle mr-3" alt="user">
                          <div class="caption">
                             <h6 class="mb-0 line-height"><?php echo $this->session->userdata('first_name'); ?></h6>
                          </div>
                       </a>
                    </li>
                    <li>
                       <a href="<?php echo base_url();?>user/index" class="iq-waves-effect d-flex align-items-center">
                       <i class="ri-home-line"></i>
                       </a>
                    </li>
                    <li class="nav-item zNotifyPopUpz">
                       <a class="search-toggle iq-waves-effect" href="javascript:void();"><i class="ri-group-line"></i></a>
                       <div class="iq-sub-dropdown iq-sub-dropdown-large">
                          <div class="iq-card shadow-none m-0">
                             <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                   <h5 class="mb-0 text-white">Friend Request <small ng-if="allFriendRequestObj.length" class="badge  badge-light float-right pt-1">{{allFriendRequestObj.length}}</small></h5>
                                </div>
                                <div ng-if="allFriendRequestObj.length" class="iq-friend-request" ng-repeat="(key, value) in allFriendRequestObj">
                                   <div class="iq-sub-card iq-sub-card-big d-flex align-items-center justify-content-between" >
                                      <div class="d-flex align-items-center">
                                         <div class="">
                                            <img class="avatar-40 " ng-if="value.profile_image == '' || !value.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" alt="no Images"  >
                                            <img class="avatar-40 rounded" ng-if="value.profile_image && value.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{value.profile_image}}" alt="{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}">

                                         </div>
                                         <div class="media-body ml-3">
                                            <h6 class="mb-0 ">{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h6>
                                         </div>
                                      </div>
                                      <div class="d-flex align-items-center">
                                         <a href="javascript:void();" ng-click="confirmFriendRequest(value.member_friends_aid);" class="mr-3 btn btn-primary rounded zconfirmFriendRequestz_{{value.member_friends_aid}}">Confirm</a>
                                         <a href="javascript:void();" ng-click="deleteFromFriendRequest(value.member_friends_aid);" class="mr-3 btn btn-secondary rounded zdeleteFromFriendRequestz_{{value.member_friends_aid}}">Delete Request</a>
                                      </div>
                                   </div>
                                </div>
                                
                                <div class="text-center" ng-if="allFriendRequestObj.length<=0">
                                   <a href="javascript:void();#" class="mr-3 btn text-primary">There is not any friend request.</a>
                                </div> 

                                <!-- <div class="text-center">
                                   <a href="javascript:void();" class="mr-3 btn text-primary">View More Request</a>
                                </div> -->
                             </div>
                          </div>
                       </div>
                    </li>
                    <li class="nav-item">
                       <a href="javascript:void();" class="search-toggle iq-waves-effect">
                          <div id="lottie-beil"></div>
                          <span class="bg-danger dots"></span>
                       </a>
                       <div class="iq-sub-dropdown">
                          <div class="iq-card shadow-none m-0">
                             <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                   <h5 class="mb-0 text-white">All Notifications<small ng-if="allNotificationObj.length" class="badge  badge-light float-right pt-1">{{allNotificationObj.length}}</small></h5>
                                </div>
                                <a ng-if="allNotificationObj.length" ng-repeat="(key, value) in allNotificationObj" href="javascript:void();" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                        <i class="{{value.stricon}}"></i>
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">{{value.strtext}}</h6>
                                         <small class="float-right font-size-12">{{value.strdate}}</small>
                                         <p class="mb-0">{{value.strcaption}}</p>
                                      </div>
                                   </div>
                                </a>

                                <div class="text-center" ng-if="allNotificationObj.length<=0">
                                   <a href="javascript:void();#" class="mr-3 btn text-primary">There is not any notification.</a>
                                </div> 

                             </div>
                          </div>
                       </div>
                    </li>
                    <li class="nav-item dropdown">
                       <a href="javascript:void();" class="search-toggle iq-waves-effect">
                          <div id="lottie-mail"></div>
                          <span class="bg-primary count-mail"></span>
                       </a>
                       <div class="iq-sub-dropdown">
                          <div class="iq-card shadow-none m-0">
                             <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                   <h5 class="mb-0 text-white">All Messages<small class="badge  badge-light float-right pt-1">5</small></h5>
                                </div>
                                <a href="javascript:void();" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                         <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/01.jpg" alt="">
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">Bni Emma Watson</h6>
                                         <small class="float-left font-size-12">13 Jun</small>
                                      </div>
                                   </div>
                                </a>
                                <a href="javascript:void();" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                         <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/02.jpg" alt="">
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">Lorem Ipsum Watson</h6>
                                         <small class="float-left font-size-12">20 Apr</small>
                                      </div>
                                   </div>
                                </a>
                                <a href="javascript:void();" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                         <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/03.jpg" alt="">
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">Why do we use it?</h6>
                                         <small class="float-left font-size-12">30 Jun</small>
                                      </div>
                                   </div>
                                </a>
                                <a href="javascript:void();" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                         <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/04.jpg" alt="">
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">Variations Passages</h6>
                                         <small class="float-left font-size-12">12 Sep</small>
                                      </div>
                                   </div>
                                </a>
                                <a href="javascript:void();" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                         <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/05.jpg" alt="">
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">Lorem Ipsum generators</h6>
                                         <small class="float-left font-size-12">5 Dec</small>
                                      </div>
                                   </div>
                                </a>
                             </div>
                          </div>
                       </div>
                    </li>
                 </ul>
                 <?php } ?>
                 <ul class="navbar-list">
                    <li>
                       <a href="javascript:void();" class="search-toggle iq-waves-effect d-flex align-items-center">
                       <i class="ri-arrow-down-s-fill"></i>
                       </a>
                       <div class="iq-sub-dropdown iq-user-dropdown">
                          <div class="iq-card shadow-none m-0">
                             <div class="iq-card-body p-0 ">
                                <?php if ($memberIsApproved=="Y"){ ?>
                                <div class="bg-primary p-3 line-height">
                                   <h5 class="mb-0 text-white line-height">Hello <?php echo $this->session->userdata('user_full_name'); ?></h5>
                                   <!-- <span class="text-white font-size-12">Available</span> -->
                                </div>
                                <a href="<?php echo base_url();?>user/myprofile" class="iq-sub-card iq-bg-primary-hover">
                                   <div class="media align-items-center">
                                      <div class="rounded iq-card-icon iq-bg-primary">
                                         <i class="ri-file-user-line"></i>
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">My Profile</h6>
                                         <p class="mb-0 font-size-12">View personal profile details.</p>
                                      </div>
                                   </div>
                                </a>
                                <a href="<?php echo base_url();?>user/profileedit" class="iq-sub-card iq-bg-warning-hover">
                                   <div class="media align-items-center">
                                      <div class="rounded iq-card-icon iq-bg-warning">
                                         <i class="ri-profile-line"></i>
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">Edit Profile</h6>
                                         <p class="mb-0 font-size-12">Modify your personal details.</p>
                                      </div>
                                   </div>
                                </a>
                                <!-- <a href="account-setting.html" class="iq-sub-card iq-bg-info-hover">
                                   <div class="media align-items-center">
                                      <div class="rounded iq-card-icon iq-bg-info">
                                         <i class="ri-account-box-line"></i>
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">Account settings</h6>
                                         <p class="mb-0 font-size-12">Manage your account parameters.</p>
                                      </div>
                                   </div>
                                </a>
                                <a href="privacy-setting.html" class="iq-sub-card iq-bg-danger-hover">
                                   <div class="media align-items-center">
                                      <div class="rounded iq-card-icon iq-bg-danger">
                                         <i class="ri-lock-line"></i>
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">Privacy Settings</h6>
                                         <p class="mb-0 font-size-12">Control your privacy parameters.</p>
                                      </div>
                                   </div>
                                </a> -->
                                <?php } ?>
                                <div class="d-inline-block w-100 text-center p-3">
                                   <a class="bg-primary iq-sign-btn" href="<?php echo base_url();?>user/logout" role="button">Sign out<i class="ri-login-box-line ml-2"></i></a>
                                </div>
                             </div>
                          </div>
                       </div>
                    </li>
                 </ul>
              </div>
           </nav>
        </div>
    </div>
    <!-- TOP Nav Bar END -->
    <!-- Right Sidebar Panel Start-->
    <div class="right-sidebar-mini right-sidebar">
        <div class="right-sidebar-panel p-0">
           <div class="iq-card shadow-none">
              <?php if ($memberIsApproved=="Y"){ ?>
              <div class="iq-card-body p-0">
                 <div class="media-height p-3">
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/01.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Anna Sthesia</a></h6>
                          <p class="mb-0">Just Now</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/02.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Paul Molive</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/03.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Anna Mull</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/04.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Paige Turner</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/11.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Bob Frapples</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/02.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Barb Ackue</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/03.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Greta Life</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-away">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/12.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Ira Membrit</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-away">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/01.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Pete Sariya</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center">
                       <div class="iq-profile-avatar">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/02.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="javascript:void();">Monty Carlo</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                 </div>
                 <div class="right-sidebar-toggle bg-primary mt-3">
                    <i class="ri-arrow-left-line side-left-icon"></i>
                    <i class="ri-arrow-right-line side-right-icon"><span class="ml-3 d-inline-block">Close Menu</span></i>
                 </div>
              </div>
              <?php } ?>
           </div>
        </div>
    </div>
    <!-- Right Sidebar Panel End-->