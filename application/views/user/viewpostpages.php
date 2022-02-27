<style type="text/css">
div.postWhenScrollContainer{
  height:1600px;
  /*background: #123213;
  color: #fff;*/
  overflow:auto;
  /*border-radius: 5px;
  margin:0 auto;
  padding: 0.5em;
  border: 1px dashed #11BD6D;*/
 }
</style>
<!-- Main Contents -->
<div class="main_content" ng-controller="indexController">
    <div class="mcontainer ">
        <div class="uk-switcher lg:mt-0 mt-0" id="timeline-tab" style="touch-action: pan-y pinch-zoom;">
            <!-- Timeline -->
            <div class="md:flex md:space-x-1 lg:mx-2 uk-active">                            
                <div class="space-y-5 flex-shrink-0 lg:w-4/6 lg:px-5 space-y-7 postWhenScrollContainer"  when-scrolled="getMorePostOnScroll()">
                  <div class="text-2xl">General Wall</div>
                  <!-- Start create post Open Modal  -->
                  <div class="card lg:mx-0 p-4" uk-toggle="target: #create-post-modal">
                     <div class="flex space-x-3">
                         <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" ng-src="<?php echo IMAGE_URL;?>images/{{(loggedUserDataObj.profile_image  == '' || !loggedUserDataObj.profile_image )? 'member-no-imgage.jpg':'members/'+loggedUserDataObj.profile_image }}" class="w-10 h-10 rounded-full">
                         <input placeholder="What's Your Mind ? {{loggedUserDataObj.first_name}}!" class="bg-gray-100 hover:bg-gray-200 flex-1 h-10 px-6 rounded-full"> 
                     </div>                      

                     <div class="grid grid-flow-col pt-3 -mx-1 -mb-1 font-semibold text-sm">
                          <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                              <svg class="bg-blue-100 h-9 mr-2 p-1.5 rounded-full text-blue-600 w-9 -my-0.5 hidden lg:block" data-tippy-placement="top" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-tippy="" data-original-title="Tooltip">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                              Photo/Video 
                          </div>
                          <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                              <svg class="bg-green-100 h-9 mr-2 p-1.5 rounded-full text-green-600 w-9 -my-0.5 hidden lg:block" uk-tooltip="title: Messages ; pos: bottom ;offset:7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" title="" aria-expanded="false"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                              Tag Friend 
                          </div>
                          <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                              <svg class="bg-red-100 h-9 mr-2 p-1.5 rounded-full text-red-600 w-9 -my-0.5 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                              Fealing /Activity 
                          </div>
                     </div> 
                  </div>
                  <!-- End create post Open Modal  -->

                  <div class="card lg:mx-0 uk-animation-slide-bottom-small" ng-repeat="(keyPS, valuePS) in aryPostScroll">
                     <!-- post header-->
                     <div class="flex justify-between items-center lg:p-4 p-2.5">
                        <div class="flex flex-1 items-center space-x-4">
                           <a href="#">
                           <img ng-src="<?php echo IMAGE_URL;?>images/{{(valuePS.post_data.profile_image == '' || !valuePS.post_data.profile_image)? 'member-no-imgage.jpg':'members/'+valuePS.post_data.profile_image}}" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                           </a>
                           <div class="flex-1 font-semibold capitalize">
                              <a href="#" class="text-black dark:text-gray-100"> {{valuePS.post_data.first_name+' '+valuePS.post_data.last_name}} <font style="color:#000">{{valuePS.post_data.tag_string_dispaly}} </font> </a>
                              <div class="text-gray-700 flex items-center space-x-2">
                                 <span> {{valuePS.post_data.display_create_date}} </span> 
                                 <ion-icon name="people" role="img" class="md hydrated" aria-label="people"></ion-icon>
                              </div>
                           </div>
                        </div>
                        <div>
                           <a href="#" aria-expanded="false"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                           <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 uk-drop" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                              <ul class="space-y-1">
                                 <li> 
                                    <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                    <i class="uil-share-alt mr-1"></i> Share
                                    </a> 
                                 </li>
                                 <!-- <li> 
                                    <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                    <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                    </a> 
                                 </li> -->
                                 <li> 
                                    <a href="javascript:void();" ng-click="changeCommonPostStatus(valuePS,'hide_post')" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                    <i class="uil-postcard mr-1"></i> Hide Post
                                    </a> 
                                 </li>
                                 <li> 
                                    <a href="javascript:void();" ng-click="changeCommonPostStatus(valuePS,'disabled_comments')" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                    <i ng-class="(valuePS.disabled_comments==0)?'uil-comment-alt-message':'uil-comment-slash'" class=" mr-1"></i> {{(valuePS.disabled_comments==0)?'Disable comments':'Enable comments'}}
                                    </a> 
                                 </li>
                                 <li> 
                                    <a href="javascript:void();" ng-click="changeCommonPostStatus(valuePS,'add_favorites')" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                    <i ng-class="(valuePS.add_favorites==0)?'uil-heart':'uil-heart-medical'" class=" mr-1"></i> {{(valuePS.add_favorites==0)?'Add favorites':'Make Unafvorite '}}
                                    </a> 
                                 </li> 

                                 <li ng-if="valuePS.from_member_id==loggedUserDataObj.id">
                                    <hr class="-mx-2 my-2 dark:border-gray-800">
                                 </li>
                                 <li ng-if="valuePS.from_member_id==loggedUserDataObj.id"> 
                                    <a href="javascript:void();" ng-click="changeCommonPostStatus(valuePS,'deleted')" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                    <i class="uil-trash-alt mr-1"></i> Delete
                                    </a> 
                                 </li>
                              </ul>
                           </div>
                        </div>
                      </div>

                      <div class="p-4 space-y-3">
                        <div class="flex space-x-4 lg:font-bold">
                          <p><a href="javascript:void();" ng-click="OpenPostPopUp(valuePS.id)">{{valuePS.post_data.post}}</a></p>
                        </div>
                      </div>
                     

                      <div ng-if="valuePS.post_file_data.length" uk-lightbox="">
                        <div class="grid grid-cols-2 gap-2 px-5">

                          <a href="javascript:void();" class="col-span-2" ng-if="(isNullOrEmptyOrUndefined(valuePS.post_file_data[0].file_name)==false)">
                            <video ng-if="(CheckImageOrVideo(valuePS.post_file_data[0].file_type)=='video')" class="w-full lg:h-64 h-40 uk-responsive-width" width="100%" height="200" controls >
                              <source src="{{ valuePS.post_file_data[0].file_type_url | trustUrl}}" type="{{valuePS.post_file_data[0].file_type}}">
                            </video>
                            
                            <img ng-if="(CheckImageOrVideo(valuePS.post_file_data[0].file_type)=='image')" ng-src="<?php echo IMAGE_URL;?>images/postfiles/{{valuePS.post_file_data[0].file_name}}" alt="" class="rounded-md w-full lg:h-76 object-cover">
                          </a>

                          <a href="javascript:void();" ng-if="(isNullOrEmptyOrUndefined(valuePS.post_file_data[1].file_name)==false)">
                            <video ng-if="(CheckImageOrVideo(valuePS.post_file_data[1].file_type)=='video')" class="w-full lg:h-64 h-40 uk-responsive-width" width="100%" height="200" controls >
                              <source src="{{ valuePS.post_file_data[1].file_type_url | trustUrl}}" type="{{valuePS.post_file_data[1].file_type}}">
                            </video>
                            <img ng-if="(CheckImageOrVideo(valuePS.post_file_data[1].file_type)=='image')" ng-src="<?php echo IMAGE_URL;?>images/postfiles/{{valuePS.post_file_data[1].file_name}}" alt="" class="rounded-md w-full h-full">
                          </a>

                          <a href="javascript:void();" ng-if="(isNullOrEmptyOrUndefined(valuePS.post_file_data[2].file_name)==false)" class="relative">
                            <video ng-if="(CheckImageOrVideo(valuePS.post_file_data[2].file_type)=='video')" class="w-full lg:h-64 h-40 uk-responsive-width" width="100%" height="200" controls >
                              <source src="{{ valuePS.post_file_data[2].file_type_url | trustUrl}}" type="{{valuePS.post_file_data[2].file_type}}">
                            </video>
                            <img ng-if="(CheckImageOrVideo(valuePS.post_file_data[2].file_type)=='image')" ng-src="<?php echo IMAGE_URL;?>images/postfiles/{{valuePS.post_file_data[2].file_name}}" alt="" class="rounded-md w-full h-full">
                            <div ng-if="valuePS.post_file_data.length>3" class="absolute bg-gray-900 bg-opacity-30 flex justify-center items-center text-white rounded-md inset-0 text-2xl"> + {{valuePS.post_file_data.length-3}} more </div>
                          </a>
                        </div>
                      </div>
                      <div class="p-4 space-y-3">
                        <div class="flex space-x-4 lg:font-bold">
                           <a href="javascript:void()" ng-click="likeTimelinePost(valuePS.id,valuePS.post_id)" class="flex items-center space-x-2">
                              <div ng-class="(valuePS.indv_post_like_unlike==0)?'text-black':'text-gray-400'" class="p-2 rounded-full   lg:bg-gray-100 dark:bg-gray-600">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                 </svg>
                              </div>
                              <div> Bless</div>
                           </a>
                           <a href="#" class="flex items-center space-x-2">
                              <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                                 </svg>
                              </div>
                              <div> Comment</div>
                           </a>
                           <a href="#" class="flex items-center space-x-2 flex-1 justify-end">
                              <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                    <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                                 </svg>
                              </div>
                              <div> Share</div>
                           </a>
                        </div>
                        <div ng-if="valuePS.post_like_data.length>0" class="flex items-center space-x-3 pt-2">
                           <div class="flex items-center">
                              <img ng-if="valuePS.post_like_data.length>0" ng-src="<?php echo IMAGE_URL;?>images/{{(valuePS.post_like_data[0].profile_image  == '' || !valuePS.post_like_data[0].profile_image )? 'member-no-imgage.jpg':'members/'+valuePS.post_like_data[0].profile_image }}" title="{{valuePS.post_like_data[0].first_name+' '+valuePS.post_like_data[0].last_name}}" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">

                              <img ng-if="valuePS.post_like_data.length>1" ng-src="<?php echo IMAGE_URL;?>images/{{(valuePS.post_like_data[1].profile_image  == '' || !valuePS.post_like_data[1].profile_image )? 'member-no-imgage.jpg':'members/'+valuePS.post_like_data[1].profile_image }}" title="{{valuePS.post_like_data[1].first_name+' '+valuePS.post_like_data[1].last_name}}" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">

                              <img ng-if="valuePS.post_like_data.length>2" ng-src="<?php echo IMAGE_URL;?>images/{{(valuePS.post_like_data[2].profile_image  == '' || !valuePS.post_like_data[2].profile_image )? 'member-no-imgage.jpg':'members/'+valuePS.post_like_data[2].profile_image }}" title="{{valuePS.post_like_data[2].first_name+' '+valuePS.post_like_data[2].last_name}}" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                           </div>
                           <div class="dark:text-gray-100">
                              Blessed<strong> {{valuePS.post_like_data[0].first_name+' '+valuePS.post_like_data[0].last_name}}</strong>
                              {{(valuePS.post_like_data.length>1)? 'and '+(valuePS.post_like_data.length-1)+' others' :''}}

                               
                           </div>
                        </div>
                        <div class="border-t py-4 space-y-4 dark:border-gray-600">
                           <div class="flex">
                              <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                 <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                              </div>
                              <div>
                                 <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12 dark:bg-gray-800 dark:text-gray-100">
                                    <p class="leading-6">
                                       In ut odio libero vulputate 
                                       <urna class="i uil-heart"></urna>
                                       <i class="uil-grin-tongue-wink"> </i> 
                                    </p>
                                    <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                 </div>
                                 <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                    <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                    <a href="#"> Replay </a>
                                    <span> 3d </span>
                                 </div>
                              </div>
                           </div>
                           <div class="flex">
                              <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                 <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                              </div>
                              <div>
                                 <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12 dark:bg-gray-800 dark:text-gray-100">
                                    <p class="leading-6"> sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. David !<i class="uil-grin-tongue-wink-alt"></i> </p>
                                    <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                 </div>
                                 <div class="text-xs flex items-center space-x-3 mt-2 ml-5">
                                    <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                    <a href="#"> Replay </a>
                                    <span> 3d </span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <a href="#" class="hover:text-blue-600 hover:underline">  Veiw 8 more Comments </a>
                        <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                           <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5">
                           <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                              <a href="#">
                                 <ion-icon name="happy-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="happy outline"></ion-icon>
                              </a>
                              <a href="#">
                                 <ion-icon name="image-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="image outline"></ion-icon>
                              </a>
                              <a href="#">
                                 <ion-icon name="link-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="link outline"></ion-icon>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div ng-if="aryPostScroll.length<=0" style="text-align: center;" uk-lightbox="">
                    No post found! Write What's Your Mind..
                  </div>
                 

                  <div class="flex justify-center mt-6">
                    <a href="javascript:void();" ng-show="loadingPost  && postExist" class="bg-white font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                         <img src="<?php echo base_url();?>assets/images/page-load-loader.gif" alt="loader" style="height: 100px;">
                    </a>
                  </div>               

                </div>

                <!-- Sidebar -->
                <div class="w-full space-y-6">
                
                                           
                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold"> Church Members </h4>
                                <p class="text-sm"> 451 Members</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <!-- <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a> -->
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>
                    
                    
                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold">Virtual Members</h4>
                                <p class="text-sm"> 210 Members</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <!-- <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a> -->
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>
                    
                    
                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold">Churches</h4>
                                <p class="text-sm"> 10 Church</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <!-- <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a> -->
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>
                    
                                                
                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold">Favourite</h4>
                                <p class="text-sm"> 143 Favourite</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <!-- <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a> -->
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>

                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold">Fans</h4>
                                <p class="text-sm"> 143 Fans</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <!-- <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a> -->
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>
                </div>
            </div>                  
        </div>
    </div>

    <!-- Start Create Post Poup -->
    <div  id="create-post-modal" class="create-post is-story uk-modal uk-flex uk-close" uk-modal="">
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
    
            <div class="text-center py-3 border-b">
                <h3 class="text-lg font-semibold"> Create Post </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 right-2 uk-icon uk-close" type="button" uk-close="" uk-tooltip="title: Close ; pos: bottom ;offset:7" title="" aria-expanded="false"><svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line></svg></button>
            </div>
            <div class="flex flex-1 items-start space-x-4 p-5">
                <img ng-src="<?php echo IMAGE_URL;?>images/{{(loggedUserDataObj.profile_image  == '' || !loggedUserDataObj.profile_image )? 'member-no-imgage.jpg':'members/'+loggedUserDataObj.profile_image }}" class="bg-gray-200 border border-white rounded-full w-11 h-11">
                <div class="flex-1 pt-2">
                    <textarea class="uk-textare text-black shadow-none focus:shadow-none font-medium resize-none" rows="5" placeholder="What's Your Mind ? {{loggedUserDataObj.first_name}}!" ng-model="singlePostData.post"></textarea>
                </div>
    
            </div>
            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-2 shadow-sm items-center">
                    <div class="lg:block hidden ml-1"> Add to your post </div>
                    <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">
                    
                        
                      <div class="image-attach">
                        <input type="file" accept=".jpg, .jpeg, .png" multiple name="input-file-preview" post-file-upload class="ng-scope zPostFileUploadz">
                        <svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                      </div>

                      <div class="image-attach">
                        <input type="file" accept="video/mp4, video/wmv, video/avi, video/3gp, video/mov, video/mpeg" multiple name="input-file-preview" post-file-upload class="ng-scope zPostFileUploadz">
                        <svg class="text-red-600 h-9 p-1.5 rounded-full bg-red-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"> </path></svg>
                      </div>

                        <svg ng-click="tagPostToFriend();" class="text-green-600 h-9 p-1.5 rounded-full bg-green-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>

                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"> </path></svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden="" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"> </path></svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden="" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <!-- <svg class="text-purple-600 h-9 p-1.5 rounded-full bg-purple-100 w-9 cursor-pointer" id="veiw-more" hidden="" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path> </svg> -->
                       
                        <!-- view more -->
                        <svg class="hover:bg-gray-200 h-9 p-1.5 rounded-full w-9 cursor-pointer" id="veiw-more" uk-toggle="target: #veiw-more; animation: uk-animation-fade" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"> </path></svg>
                    
                    </div>
                </div>
            </div>
            <div class="flex items-center w-full justify-between border-t p-3">
    
                <div class="btn-group bootstrap-select mt-0 story">
                
                <div class="dropdown-menu open" role="combobox">
                <ul class="dropdown-menu inner" role="listbox" aria-expanded="false">
                <li data-original-index="0" class="selected"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="true"><span class="text">Only me</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>
                <li data-original-index="1"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">Every one</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>
                <li data-original-index="2"><a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><span class="text">People I Follow </span><span class="glyphicon glyphicon-ok check-mark"></span></a></li>
                </ul>
                </div>
                <!-- <select class="selectpicker mt-0 p-2 story" tabindex="-98">
                    <option>Only me</option>
                    <option>Every one</option>
                    <option>People I Follow </option>
                    People Follow Me
                </select> -->
              </div>
    
                <div class="flex space-x-2">
                    <!-- <a href="#" class="bg-red-100 flex font-medium h-9 items-center justify-center px-5 rounded-md text-red-600 text-sm">
                        <svg class="h-5 pr-1 rounded-full text-red-500 w-6 fill-current" id="veiw-more" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false" style=""> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Live </a> -->
                    <a href="javascript:void();" ng-click="submitPost();" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium zbtnSinglePostz">
                      Post </a>    
                </div>
            </div>
            <div class="flex items-center w-full justify-between border-t p-3" id="post_image_preview_container">
            </div>
        </div>
    </div>
    <!-- End Create Post Poup -->


    <!-- Start tag To Friend Poup -->
    <div class="modal fade" id="tagPostToFriendModal" tabindex="-1" role="dialog" aria-labelledby="postTag-modalLabel" aria-hidden="true" style="display: none;">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Tag Friend1</h5>
                  <button type="button" class="btn btn-secondary" ng-click="closeTagPostModal()"><i class="fa-solid fa-xmark"></i></button>
               </div>
               <div class="modal-body">
                  <div class="d-flex align-items-center">
                     <div class="user-img">
                        <i class="ri-search-line"></i>
                     </div>
                     <form class="post-text mb-2 min-w-ful" action="javascript:void();" style="width: 100%;">
                        <input type="text" class="form-control rounded min-w-ful" ng-model="tagPostData.searchFriend" ng-keyup="tagPostToFriend()" placeholder="Search friend" style="border:1px solid #ccc;">
                     </form>
                  </div>

                  <div class="iq-card-body">
                     <ul class="media-story m-0 p-0">
                        <li class="d-flex mb-4 align-items-center" ng-repeat="(key, value) in allFriendListObj" style="cursor:pointer;" ng-click="setTagFriendToPost(value.id)">
                           <img ng-src="<?php echo IMAGE_URL;?>images/{{(value.profile_image  == '' || !value.profile_image )? 'member-no-imgage.jpg':'members/'+value.profile_image }}" class="bg-gray-200 border border-white rounded-full w-11 h-11">
                           <div class="stories-data ml-3 mr-3">
                              <h5>{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h5>
                           </div>
                           <i style="font-size: 22px;cursor: pointer;border: none;" class="ml-auto" ng-class="(aryPostTagFriend.indexOf(value.id) !== -1) ? 'fa fa-check-square-o' : 'fa fa-square-o'"></i>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
    </div>
    <!-- End tag To Friend Poup -->
</div>