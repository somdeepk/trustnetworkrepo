<?php
if ($this->session -> userdata('email') == "" && $this->session -> userdata('login') != true)
{
  redirect('user/login');
}
$memberIsApproved=$this->session -> userdata('is_approved');
$membershipType=$this->session -> userdata('membership_type');
$isAdmin=$this->session -> userdata('is_admin');
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
                  <li class="active"><a href="<?php echo base_url();?>user/index" class="iq-waves-effect"><i class="las la-newspaper"></i><span>Newsfeed</span></a></li>
                  <li><a href="profile.html" class="iq-waves-effect"><i class="las la-user"></i><span>Profile</span></a></li>
                  <li><a href="profile-event.html" class="iq-waves-effect"><i class="las la-film"></i><span>Events</span></a></li>

                  <?php if($membershipType=="RM"){ ?>
                  <li><a href="<?php echo base_url();?>user/friendrequest" class="iq-waves-effect"><i class="las la-anchor"></i><span>Friend Request</span></a></li>
                  <li><a href="<?php echo base_url();?>user/friendlist" class="iq-waves-effect"><i class="las la-anchor"></i><span>Friend List</span></a></li>
                  <?php }else{ ?>
                      <li><a href="<?php echo base_url();?>user/churchrequest" class="iq-waves-effect"><i class="las la-anchor"></i><span>Church Request</span></a></li>
                      <li><a href="<?php echo base_url();?>user/churchlist" class="iq-waves-effect"><i class="las la-anchor"></i><span>Church List</span></a></li>
                      <li><a href="<?php echo base_url();?>user/memberrequest" class="iq-waves-effect"><i class="las la-anchor"></i><span>Member Request</span></a></li>
                      <li><a href="<?php echo base_url();?>user/memberlist" class="iq-waves-effect"><i class="las la-anchor"></i><span>Member List</span></a></li>
                  <?php } ?>

                   <li><a href="profile-video.html" class="iq-waves-effect"><i class="las la-video"></i><span>Photo/Video</span></a></li>
                   
                  <li>
                    <a href="#group" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="las la-users"></i><span>Group</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="group" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                       <?php if($membershipType=="CM" || $membershipType=="CC" || $isAdmin=="Y"){ ?>
                       <li><a href="<?php echo base_url();?>user/churchmember"><i class="ri-tablet-line"></i>Church Members</a></li>
                       <?php } ?>
                       <li ng-repeat="(key, value) in allGroupObj"><a href="#"><i class="ri-device-line"></i>{{value.name}}</a></li>
                       <!-- <li><a href="#"><i class="ri-toggle-line"></i>School Friends</a></li>
                       <li><a href="#"><i class="ri-toggle-line"></i>College Friends</a></li>
                       <li><a href="#"><i class="ri-checkbox-line"></i>Friends</a></li>
                       <li><a href="#"><i class="ri-radio-button-line"></i>Prayer Friends</a></li> -->
                    </ul>
                  </li>
                  <li>
                    
                    <a href="#Task" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false"><i class="ri-focus-2-line"></i><span>Set Task <!-- Assigned --></span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <?php if($membershipType=="CM" || $isAdmin=="Y"){ ?>
                    <ul id="Task" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                       <li><a href="javascript:void(0);" ng-click="set_task('1')"><i class="ri-tablet-line"></i>Level 1</a></li>
                       <li><a href="javascript:void(0);" ng-click="set_task('2')"><i class="ri-tablet-line"></i>Level 2</a></li>
                       <li><a href="javascript:void(0);" ng-click="set_task('3')"><i class="ri-tablet-line"></i>Level 3</a></li>
                       <li><a href="javascript:void(0);" ng-click="set_task('4')"><i class="ri-tablet-line"></i>Level 4</a></li>
                       <li><a href="javascript:void(0);" ng-click="set_task('5')"><i class="ri-tablet-line"></i>Level 5</a></li>
                       <li><a href="javascript:void(0);" ng-click="set_task('6')"><i class="ri-tablet-line"></i>Level 6</a></li>
                    </ul>
                    <?php }elseif($membershipType=="RM" && $isAdmin=="N"){ ?>
                    <ul id="Task" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                       <li ng-repeat="(key, value) in allTaskLevelObj" ><a ng-class="(value.is_disabled == 'Y') ? 'cssdisabled' : ''" href="javascript:void(0);" ng-click="set_task(key)"><i class="ri-tablet-line"></i>Level {{key}}</a></li>
                    </ul>
                    <?php } ?>

                     <!-- ng-disabled="value.is_disabled=='Y'"  -->
                  </li>    
                  <li><a href="#" class="iq-waves-effect"><i class="las la-video"></i><span>Awards</span></a></li>
                  <li><a href="#" class="iq-waves-effect"><i class="lab la-rocketchat"></i><span>Messenger</span></a></li>
                  <li><a href="#" class="iq-waves-effect"><i class="ri-compasses-line"></i><span>Community Forum</span></a></li>
                  <li><a href="#" class="iq-waves-effect"><i class="las la-check-circle"></i><span>Support</span></a></li>
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
                 <img src="<?php echo base_url();?>assets/images/logo.png" class="img-fluid" alt="">
                 <span>Follow Me</span>
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
                 <form action="#" class="searchbox">
                    <input type="text" class="text search-input" placeholder="Type here to search...">
                    <a class="search-link" href="#"><i class="ri-search-line"></i></a>
                 </form>
                <?php } ?>
              </div>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"  aria-label="Toggle navigation">
              <i class="ri-menu-3-line"></i>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                 <?php if ($memberIsApproved=="Y"){ ?>
                 <ul class="navbar-nav ml-auto navbar-list">
                    <li>
                       <a href="profile.html" class="iq-waves-effect d-flex align-items-center">
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
                    <li class="nav-item">
                       <a class="search-toggle iq-waves-effect" href="#"><i class="ri-group-line"></i></a>
                       <div class="iq-sub-dropdown iq-sub-dropdown-large">
                          <div class="iq-card shadow-none m-0">
                             <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                   <h5 class="mb-0 text-white">Friend Request<small class="badge  badge-light float-right pt-1">4</small></h5>
                                </div>
                                <div class="iq-friend-request">
                                   <div class="iq-sub-card iq-sub-card-big d-flex align-items-center justify-content-between" >
                                      <div class="d-flex align-items-center">
                                         <div class="">
                                            <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/01.jpg" alt="">
                                         </div>
                                         <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Jaques Amole</h6>
                                            <p class="mb-0">40  friends</p>
                                         </div>
                                      </div>
                                      <div class="d-flex align-items-center">
                                         <a href="javascript:void();" class="mr-3 btn btn-primary rounded">Confirm</a>
                                         <a href="javascript:void();" class="mr-3 btn btn-secondary rounded">Delete Request</a>
                                      </div>
                                   </div>
                                </div>
                                <div class="iq-friend-request">
                                   <div class="iq-sub-card iq-sub-card-big d-flex align-items-center justify-content-between" >
                                      <div class="d-flex align-items-center">
                                         <div class="">
                                            <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/02.jpg" alt="">
                                         </div>
                                         <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Lucy Tania</h6>
                                            <p class="mb-0">12  friends</p>
                                         </div>
                                      </div>
                                      <div class="d-flex align-items-center">
                                         <a href="javascript:void();" class="mr-3 btn btn-primary rounded">Confirm</a>
                                         <a href="javascript:void();" class="mr-3 btn btn-secondary rounded">Delete Request</a>
                                      </div>
                                   </div>
                                </div>
                                <div class="iq-friend-request">
                                   <div class="iq-sub-card iq-sub-card-big d-flex align-items-center justify-content-between" >
                                      <div class="d-flex align-items-center">
                                         <div class="">
                                            <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/03.jpg" alt="">
                                         </div>
                                         <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Manny Petty</h6>
                                            <p class="mb-0">3  friends</p>
                                         </div>
                                      </div>
                                      <div class="d-flex align-items-center">
                                         <a href="javascript:void();" class="mr-3 btn btn-primary rounded">Confirm</a>
                                         <a href="javascript:void();" class="mr-3 btn btn-secondary rounded">Delete Request</a>
                                      </div>
                                   </div>
                                </div>
                                <div class="iq-friend-request">
                                   <div class="iq-sub-card iq-sub-card-big d-flex align-items-center justify-content-between" >
                                      <div class="d-flex align-items-center">
                                         <div class="">
                                            <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/04.jpg" alt="">
                                         </div>
                                         <div class="media-body ml-3">
                                            <h6 class="mb-0 ">Marsha Mello</h6>
                                            <p class="mb-0">15  friends</p>
                                         </div>
                                      </div>
                                      <div class="d-flex align-items-center">
                                         <a href="javascript:void();" class="mr-3 btn btn-primary rounded">Confirm</a>
                                         <a href="javascript:void();" class="mr-3 btn btn-secondary rounded">Delete Request</a>
                                      </div>
                                   </div>
                                </div>
                                <div class="text-center">
                                   <a href="#" class="mr-3 btn text-primary">View More Request</a>
                                </div>
                             </div>
                          </div>
                       </div>
                    </li>
                    <li class="nav-item">
                       <a href="#" class="search-toggle iq-waves-effect">
                          <div id="lottie-beil"></div>
                          <span class="bg-danger dots"></span>
                       </a>

                      <!--  ng-repeat="(key, value) in allVideoListObj" -->
                       <div class="iq-sub-dropdown" ng-controller="notificationController" ng-init="get_all_notifiction(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('parent_id'); ?>','<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>');">
                          <div class="iq-card shadow-none m-0">
                             <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                   <h5 class="mb-0 text-white">All Notifications<small class="badge  badge-light float-right pt-1">{{allNotificationObj.length}}</small></h5>
                                </div>
                                <a ng-repeat="(key, value) in allNotificationObj" href="#" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                        <i class="{{value.stricon}}"></i>
                                         <!-- <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/01.jpg" alt=""> -->
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">{{value.strtext}}</h6>
                                         <small class="float-right font-size-12">{{value.strdate}}</small>
                                         <p class="mb-0">{{value.strcaption}}</p>
                                      </div>
                                   </div>
                                </a>
                                <!-- <a href="#" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                         <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/02.jpg" alt="">
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">New customer is join</h6>
                                         <small class="float-right font-size-12">5 days ago</small>
                                         <p class="mb-0">Cyst Bni</p>
                                      </div>
                                   </div>
                                </a>
                                <a href="#" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                         <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/03.jpg" alt="">
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">Two customer is left</h6>
                                         <small class="float-right font-size-12">2 days ago</small>
                                         <p class="mb-0">Cyst Bni</p>
                                      </div>
                                   </div>
                                </a>
                                <a href="#" class="iq-sub-card" >
                                   <div class="media align-items-center">
                                      <div class="">
                                         <img class="avatar-40 rounded" src="<?php echo base_url();?>assets/images/user/04.jpg" alt="">
                                      </div>
                                      <div class="media-body ml-3">
                                         <h6 class="mb-0 ">New Mail from Fenny</h6>
                                         <small class="float-right font-size-12">3 days ago</small>
                                         <p class="mb-0">Cyst Bni</p>
                                      </div>
                                   </div>
                                </a> -->
                             </div>
                          </div>
                       </div>
                    </li>
                    <li class="nav-item dropdown">
                       <a href="#" class="search-toggle iq-waves-effect">
                          <div id="lottie-mail"></div>
                          <span class="bg-primary count-mail"></span>
                       </a>
                       <div class="iq-sub-dropdown">
                          <div class="iq-card shadow-none m-0">
                             <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                   <h5 class="mb-0 text-white">All Messages<small class="badge  badge-light float-right pt-1">5</small></h5>
                                </div>
                                <a href="#" class="iq-sub-card" >
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
                                <a href="#" class="iq-sub-card" >
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
                                <a href="#" class="iq-sub-card" >
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
                                <a href="#" class="iq-sub-card" >
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
                                <a href="#" class="iq-sub-card" >
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
                       <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
                       <i class="ri-arrow-down-s-fill"></i>
                       </a>
                       <div class="iq-sub-dropdown iq-user-dropdown">
                          <div class="iq-card shadow-none m-0">
                             <div class="iq-card-body p-0 ">
                                <?php if ($memberIsApproved=="Y"){ ?>
                                <div class="bg-primary p-3 line-height">
                                   <h5 class="mb-0 text-white line-height">Hello Bni Cyst</h5>
                                   <span class="text-white font-size-12">Available</span>
                                </div>
                                <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
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
                                <a href="account-setting.html" class="iq-sub-card iq-bg-info-hover">
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
                                </a>
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
                          <h6 class="mb-0"><a href="#">Anna Sthesia</a></h6>
                          <p class="mb-0">Just Now</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/02.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="#">Paul Molive</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/03.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="#">Anna Mull</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/04.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="#">Paige Turner</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/11.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="#">Bob Frapples</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/02.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="#">Barb Ackue</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-online">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/03.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="#">Greta Life</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-away">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/12.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="#">Ira Membrit</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center mb-4">
                       <div class="iq-profile-avatar status-away">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/01.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="#">Pete Sariya</a></h6>
                          <p class="mb-0">Admin</p>
                       </div>
                    </div>
                    <div class="media align-items-center">
                       <div class="iq-profile-avatar">
                          <img class="rounded-circle avatar-50" src="<?php echo base_url();?>assets/images/user/02.jpg" alt="">
                       </div>
                       <div class="media-body ml-3">
                          <h6 class="mb-0"><a href="#">Monty Carlo</a></h6>
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