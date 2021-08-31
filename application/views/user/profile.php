<div id="content-page" class="content-page" ng-controller="peopleYouMayNowController" ng-init="selectprofileTab(<?php echo $this->session->userdata('user_auto_id'); ?>);">
  <input ng-model="friendData.user_auto_id" id="user_auto_id" type="hiddens">
  <input id="hidden_profile_tab" type="hiddens" value="<?php echo $profileTab; ?>">
  <div class="container">
     <div class="row">
        <div class="col-sm-12">
           <div class="iq-card">
              <div class="iq-card-body profile-page p-0">
                 <div class="profile-header">
                    <div class="cover-container">
                       <img src="<?php echo base_url();?>assets/images/page-img/profile-bg1.jpg" alt="profile-bg" class="rounded img-fluid">
                       <ul class="header-nav d-flex flex-wrap justify-end p-0 m-0">
                          <li><a href="javascript:void();"><i class="ri-pencil-line"></i></a></li>
                          <li><a href="javascript:void();"><i class="ri-settings-4-line"></i></a></li>
                       </ul>
                    </div>
                    <div class="user-detail text-center mb-3">
                       <div class="profile-img">
                          <img src="<?php if(!empty($this->session->userdata('profile_image'))){ echo IMAGE_URL.'images/members/'.$this->session->userdata('profile_image'); }else{ echo IMAGE_URL.'images/member-no-imgage.jpg'; } ?>" alt="profile-img" class="avatar-130 img-fluid" />
                       </div>
                       <div class="profile-detail">
                          <h3 class=""><?php echo $this->session->userdata('first_name'); ?></h3>
                       </div>
                    </div>
                    <div class="profile-info p-4 d-flex align-items-center justify-content-between position-relative">
                       <div class="social-links">
                          <ul class="social-data-block d-flex align-items-center justify-content-between list-inline p-0 m-0">
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
                          </ul>
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
                    <ul class="nav nav-pills d-flex align-items-center justify-content-center profile-feed-items p-0 m-0">
                       <li class="col-sm-3 p-0">
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="clickProfileTab='timelineTab'">Timeline</a>
                       </li>
                       <li class="col-sm-3 p-0">
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="clickProfileTab='aboutTab'">About</a>
                       </li>
                       <li class="col-sm-3 p-0">
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="clickProfileTab='friendsTab'; getAllFriendList()">Friends</a>
                       </li>
                       <li class="col-sm-3 p-0">
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="clickProfileTab='friendrequestTab'">Photos</a>
                       </li>
                       <li class="col-sm-3 p-0">
                          <a class="nav-link" data-toggle="pill" href="javascript:void(0)" ng-click="clickProfileTab='eventsTab'">Events</a>
                       </li>
                    </ul>
                 </div>
              </div>
           </div>           
        </div>
        
        <!-- Start Friend Request-->
        <div class="container" ng-class="clickProfileTab == 'friendrequestTab' ? '' : 'hiddenimportant'" ng-init="getAllFriendRequest('<?php echo $this->session->userdata('user_auto_id'); ?>');">
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
               <div class="iq-card" ng-init="peopleYouMayNowData('<?php echo $this->session->userdata('user_auto_id'); ?>');">                
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
        <div class="container" ng-class="clickProfileTab == 'friendsTab' ? '' : 'hiddenimportant'">
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
           </div>
        </div>

        <div class="container" ng-class="clickProfileTab == 'friendsTab' ? '' : 'hiddenimportant'">
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
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              </li>


              <!-- <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg1.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/06.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Paul Molive</h4>
                                         <h6>@developer</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg4.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/07.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Anna Mull</h4>
                                         <h6>@designer</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg5.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/08.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Paige Turner</h4>
                                         <h6>@tester</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg6.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/09.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Bob Frapples</h4>
                                         <h6>@developer</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg7.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/10.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Barb Ackue</h4>
                                         <h6>@grapfics</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg8.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/13.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Greta Life</h4>
                                         <h6>@fashion</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg9.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/14.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Ira Membrit</h4>
                                         <h6>@designer</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg1.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/15.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Pete Sariya</h4>
                                         <h6>@designer</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
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
                                         <img src="<?php echo base_url();?>assets/images/user/16.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Monty Carlo</h4>
                                         <h6>@designer</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg5.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/17.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Ed Itorial</h4>
                                         <h6>@testen</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg8.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/18.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Paul Issy</h4>
                                         <h6>@r&d</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg7.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/19.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Rick Shaw</h4>
                                         <h6>@coder</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg9.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/07.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Ben Effit</h4>
                                         <h6>@designer</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
                 <div class="iq-card">
                    <div class="iq-card-body profile-page p-0">
                       <div class="profile-header-image">
                          <div class="cover-container">
                             <img src="<?php echo base_url();?>assets/images/page-img/profile-bg4.jpg" alt="profile-bg" class="rounded img-fluid w-100">
                          </div>
                          <div class="profile-info p-4">
                             <div class="user-detail">
                                <div class="d-flex flex-wrap justify-content-between align-items-start">
                                   <div class="profile-detail d-flex">
                                      <div class="profile-img pr-4">
                                         <img src="<?php echo base_url();?>assets/images/user/08.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Justin Case</h4>
                                         <h6>@designer</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
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
              <div class="col-md-6">
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
                                         <img src="<?php echo base_url();?>assets/images/user/09.jpg" alt="profile-img" class="avatar-130 img-fluid" />
                                      </div>
                                      <div class="user-data-block">
                                         <h4 class="">Aaron Ottix</h4>
                                         <h6>@designer</h6>
                                         <p>Lorem Ipsum is simply dummy text of the</p>
                                      </div>
                                   </div>
                                   <button type="submit" class="btn btn-primary">Following</button>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
              </div> -->
           </div>
        </div> 
        <!-- End Friend List-->



     </div>
  </div>
</div>