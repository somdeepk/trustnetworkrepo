<!-- Main Contents -->
<div class="main_content" ng-controller="connectionController">
    <div class="mcontainer">
        <div class="uk-switcher lg:mt-0 mt-0" id="timeline-tab" style="touch-action: pan-y pinch-zoom;">
          <!-- Timeline -->
          <div class="md:flex md:space-x-1 lg:mx-2 uk-active">                            
            <div class="space-y-5 flex-shrink-0 lg:w-4/6 lg:px-5 space-y-7">
               <!-- create post  -->

              <!-- Start Friend Request-->
              <div class="card">
                <div class="card-header">
                    <div class="text-2xl">{{(sgtnType=='frndSgtn')? 'Friend Request' : (sgtnType=='memberSgtn')? 'Member Request' : 'Church Request'}}</div>
                </div>           
                <div class="card-body">
                   <ul class="request-list list-inline m-0 p-0">
                      <li class="d-flex align-items-center  justify-content-between flex-wrap" ng-repeat="(key, value) in allFriendRequestObj">
                         <div class="user-img img-fluid flex-shrink-0">
                          <img class="rounded-circle avatar-40" ng-src="<?php echo IMAGE_URL;?>images/{{(value.profile_image  == '' || !value.profile_image )? 'member-no-imgage.jpg':'members/'+value.profile_image }}">
                         </div>
                         <div class="flex-grow-1 ml-3">
                           <h6>{{(value.membership_type=='PM')? value.first_name : value.first_name+' '+value.last_name}}</h6>
                           <p class="mb-0">{{(value.membership_type=='RM')? value.church_first_name:''}}</p>
                         </div>

                         <div class="d-flex align-items-center mt-2 mt-md-0">                          
                            <div class="confirm-click-btn">
                               <a href="javascript:void();"  ng-click="confirmFriendRequest(value.member_friends_aid);" class="bg-blue-600 flex flex-1 h-8 px-3 mr-3 items-center justify-center rounded-md text-white capitalize zconfirmFriendRequestz_{{value.member_friends_aid}}">Confirm</a>
                            </div>
                            <a href="javascript:void();" ng-click="deleteFromFriendRequest(value.member_friends_aid);" class="btn btn-secondary rounded zdeleteFromFriendRequestz_{{value.member_friends_aid}}" >Delete Request</a>
                         </div>
                      </li>

                      <li ng-if="allFriendRequestObj.length<=0" class="d-block text-center mb-0 pb-0">
                        There is not any request.
                      </li>

                      <!-- <li class="d-block text-center mb-0 pb-0">
                         <a href="#" class="me-3 btn">View More Request</a>
                      </li> -->
                   </ul>
                </div>
              </div>
              <!-- End Friend Request-->


              <!-- Start People You May Now Tab -->
              <div class="card">
                <div class="card-header">
                    <div class="text-2xl">{{(sgtnType=='frndSgtn')? 'People' : (sgtnType=='memberSgtn')? 'People' : 'Churches'}} You May Know</div>
                </div>           
                <div class="card-body">
                   <ul class="request-list list-inline m-0 p-0">
                      <li class="d-flex align-items-center  justify-content-between flex-wrap" ng-repeat="(key, value) in peopleYouMayNowObj">
                         <div class="user-img img-fluid flex-shrink-0">
                          <img class="rounded-circle avatar-40" ng-src="<?php echo IMAGE_URL;?>images/{{(value.profile_image  == '' || !value.profile_image )? 'member-no-imgage.jpg':'members/'+value.profile_image }}">
                         </div>
                         <div class="flex-grow-1 ml-3">
                           <h6>{{(value.membership_type=='PM')? value.first_name : value.first_name+' '+value.last_name}}</h6>
                           <p class="mb-0">{{(value.membership_type=='RM')? value.church_first_name:''}}</p>
                         </div>

                         <div class="d-flex align-items-center mt-2 mt-md-0">                          
                            <div class="confirm-click-btn">
                               <a href="javascript:void();" ng-class="(value.request_status=='1')? 'cssBtnDisabled':''" ng-click="sendFriendRequest(value.id);" class="bg-blue-600 flex flex-1 h-8 px-3 mr-3 items-center justify-center rounded-md text-white capitalize zsendFriendRequestz_{{value.id}}"><i ng-if="value.request_status != '1'" class="fa fa-user-plus"></i>&nbsp;{{(value.request_status=='1')? 'Request Send!' : (value.membership_type=='PM')? 'Add Connection' : 'Add Friend'}}</a>
                            </div>
                            <a href="javascript:void();" ng-click="removeFromSuggestion(value.id);" class="btn btn-secondary rounded zRemoveFromSuggestionz_{{value.id}}" >Remove</a>
                         </div>
                      </li>
                      <!-- <li class="d-block text-center mb-0 pb-0">
                         <a href="#" class="me-3 btn">View More Request</a>
                      </li> -->

                      <li ng-if="peopleYouMayNowObj.length<=0" class="d-block text-center mb-0 pb-0">
                        No suggestion found!
                      </li>
                   </ul>
                </div>
              </div>
              <!-- End People You May Now Tab -->




            </div>

            <!-- Sidebar -->
            <div class="w-full space-y-6">
                  <div class="widget card p-5 border-t">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h4 class="text-lg font-semibold">Big News Feeds</h4>
                        </div>
                        <a href="#" class="text-blue-600 "> See all</a>
                    </div>
                  <div>                  
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-3.jpg" class="absolute w-full h-full inset-0 " alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize"> News heading  </a>
                          <div class="text-sm text-gray-500 mt-0.5">20th Dec 2021</div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-4.jpg" class="absolute w-full h-full inset-0 " alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize"> News heading </a>
                          <div class="text-sm text-gray-500 mt-0.5"> 20th Dec 2021 </div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-2.jpg" class="absolute w-full h-full inset-0" alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize">  News heading  </a>
                          <div class="text-sm text-gray-500 mt-0.5">20th Dec 2021</div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-1.jpg" class="absolute w-full h-full inset-0" alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize"> News heading    </a>
                          <div class="text-sm text-gray-500 mt-0.5"> 20th Dec 2021</div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>              
                </div>
            </div>
            
            <div class="widget card p-5 border-t">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h4 class="text-lg font-semibold">Spotlight News Feeds</h4>
                    </div>
                    <a href="#" class="text-blue-600 "> See all</a>
                </div>
                <div>
              
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-3.jpg" class="absolute w-full h-full inset-0 " alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize"> News heading  </a>
                          <div class="text-sm text-gray-500 mt-0.5">20th Dec 2021</div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>

                  </div>
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-4.jpg" class="absolute w-full h-full inset-0 " alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize"> News heading </a>
                          <div class="text-sm text-gray-500 mt-0.5"> 20th Dec 2021 </div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-2.jpg" class="absolute w-full h-full inset-0" alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize">  News heading  </a>
                          <div class="text-sm text-gray-500 mt-0.5">20th Dec 2021</div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-1.jpg" class="absolute w-full h-full inset-0" alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize"> News heading    </a>
                          <div class="text-sm text-gray-500 mt-0.5"> 20th Dec 2021</div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>
          
                </div>
            </div>

            <div class="widget card p-5 border-t">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <h4 class="text-lg font-semibold">Suggested News Feeds</h4>
                    </div>
                    <a href="#" class="text-blue-600 "> See all</a>
                </div>
                <div>
              
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-3.jpg" class="absolute w-full h-full inset-0 " alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize"> News heading  </a>
                          <div class="text-sm text-gray-500 mt-0.5">20th Dec 2021</div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>

                  </div>
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-4.jpg" class="absolute w-full h-full inset-0 " alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize"> News heading </a>
                          <div class="text-sm text-gray-500 mt-0.5"> 20th Dec 2021 </div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-2.jpg" class="absolute w-full h-full inset-0" alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize">  News heading  </a>
                          <div class="text-sm text-gray-500 mt-0.5">20th Dec 2021</div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>
                  <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                      <a href="timeline-group.html" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                          <img src="<?php echo base_url();?>assets/images/group/group-1.jpg" class="absolute w-full h-full inset-0" alt="">
                      </a>
                      <div class="flex-1">
                          <a href="timeline-page.html" class="text-base font-semibold capitalize"> News heading    </a>
                          <div class="text-sm text-gray-500 mt-0.5"> 20th Dec 2021</div>
                      </div>
                      <a href="timeline-page.html" class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold bg-blue-500 text-white">
                          View
                      </a>
                  </div>
          
                </div>
            </div>  
            </div>
          </div>
        </div>
    </div>
</div>