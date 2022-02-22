<!-- Main Contents -->
<div class="main_content" ng-controller="connectionController">
        <div class="mcontainer">
        <div class="uk-switcher lg:mt-0 mt-0" id="timeline-tab" style="touch-action: pan-y pinch-zoom;">


            <!-- Timeline -->
            <div class="md:flex md:space-x-1 lg:mx-2 uk-active">
            
                            
                <div class="space-y-5 flex-shrink-0 lg:w-4/6 lg:px-5 space-y-7">                  
                  <!-- create post  -->       

                  <div class="card-header">
                    <div class="text-2xl">{{(sgtnType=='frndSgtn')? 'Friends' : (sgtnType=='memberSgtn')? 'Members' : 'Connections'}}</div>
                  </div> 

                  <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small flex-wrap">
                    <li class="mb-5" ng-repeat="(key, value) in allFriendListObj">
                        <a href="timeline-page.html" class="uk-link-reset">
                            <div class="card">
                                <img ng-src="<?php echo IMAGE_URL;?>images/{{(value.profile_image  == '' || !value.profile_image )? 'member-no-imgage.jpg':'members/'+value.profile_image }}" class="h-44 object-cover rounded-t-md shadow-sm w-full">
                                <div class="p-4">
                                    <h4 class="text-base font-semibold mb-1"> {{(value.membership_type=='PM')? value.first_name : value.first_name+' '+value.last_name}}</h4>    
                                    <p class="mb-0">{{(value.membership_type=='RM')? value.church_first_name:''}}</p>                                               
                                </div>
                               <!--  <div class="flex mt-3.5 space-x-2">
                                    <div class="flex items-center -space-x-2 -mt-1">
                                        <img alt="Image placeholder" src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" class="border-2 border-white rounded-full w-7">
                                        <img alt="Image placeholder" src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" class="border-2 border-white rounded-full w-7">
                                    </div>
                                    <div class="flex-1 leading-5 text-sm">
                                        <div> <strong>Johnson</strong> and 5 freind are members </div>
                                    </div>
                                </div> -->
                                <div class="flex mt-3.5 space-x-2 text-sm font-medium mb-4">
                                  <!-- <a href="#" class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize">Add Friend</a> -->
                                  <a href="javascript:void();" ng-click="deleteMyFriend(value.id);" class="bg-gray-200 flex flex-1 h-8 items-center justify-center rounded-md capitalize zdeleteMyFriendz_{{value.id}}">
                                  Remove Friend</a>
                                </div>
                            </div>
                        </a>
                    </li>
                    <div class="col-md-12" ng-if="allFriendListObj.length<=0"  style="text-align: center ">
                      No Friend Found!
                    </div>

                  </ul>
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