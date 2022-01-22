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
</style>
<div ng-controller="indexController" ng-init="initiateData(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>','<?php echo $this->session->userdata('parent_id'); ?>');">

   <div id="content-page" when-scrolled="getMorePostOnScroll()" class="content-page postWhenScrollContainer">
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
                           <div class="stories-data ml-3 mr-3">
                              <h5>{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h5>
                           </div>
                           <i style="font-size: 22px;cursor: pointer;float: right; border: none;" ng-class="(aryPostTagFriend.indexOf(value.id) !== -1) ? 'ri-checkbox-line' : 'ri-checkbox-blank-line'"></i>

                        </li>
                     </ul>
                  </div>

               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="row">
            <div class="col-lg-8 row m-0 p-0">
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
                                       <div class="iq-bg-primary rounded p-2 pointer mr-3 photo-upload-field"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/07.png" alt="icon" class="img-fluid"> Photo/Video <input type="file" accept=".jpg, .jpeg, .png" multiple name="input-file-preview" id="post_file_upload" post-file-upload class="ng-scope"></div>
                                    </li>

                                    <li class="col-md-6 mb-3" ng-click="tagPostToFriend();">
                                       <div class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/08.png" alt="icon" class="img-fluid"> Tag Friend</div>
                                    </li>
                                    <!-- <li class="col-md-6 mb-3">
                                       <div class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/09.png" alt="icon" class="img-fluid"> Feeling/Activity</div>
                                    </li>
                                    <li class="col-md-6 mb-3">
                                       <div class="iq-bg-primary rounded p-2 pointer mr-3"><a href="javascript:void();"></a><img src="<?php echo base_url();?>assets/images/small/10.png" alt="icon" class="img-fluid"> Check in</div>
                                    </li> -->
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
                              <p><a href="javascript:void();" data-toggle="modal" data-target="#exampleModal_{{valuePS.id}}">{{valuePS.post_data.post}}</a></p>
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
                                       <div ng-if="valuePS.post_file_data.length>3" class="photo-count-value" style="font-size:62px;">
                                         <a href="javascript:void();"> + {{valuePS.post_file_data.length-3}}</a>
                                      </div>
                                       <a href="javascript:void();"><img src="<?php echo IMAGE_URL;?>images/postfiles/{{valuePS.post_file_data[2].file_name}}" class="img-fluid rounded w-100" style="width: 291px; height:187px;"></a>
                                    </div>
                                 </div>
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
                                    <div ng-if='valuePS.all_post_comment_data.length>0'class="total-comment-block">
                                       <div class="dropdown">
                                          <span class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
                                          <a href="javascript:void();" data-toggle="modal" data-target="#exampleModal_{{valuePS.id}}">{{valuePS.all_post_comment_data.length}} Comment</a>
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

            </div>
            <div class="col-lg-4">               
               <div class="iq-card">
                  <div class="iq-card-header d-flex justify-content-between">
                     <div class="iq-header-title">
                        <h4 class="card-title">Events</h4>
                     </div>
                     <div class="iq-card-header-toolbar d-flex align-items-center">
                        <div class="dropdown">
                           <span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" role="button">
                           <i class="ri-more-fill"></i>
                           </span>
                           <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="">
                              <a class="dropdown-item" href="javascript:void();"><i class="ri-eye-fill mr-2"></i>View</a>
                              <a class="dropdown-item" href="javascript:void();"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
                              <a class="dropdown-item" href="javascript:void();"><i class="ri-pencil-fill mr-2"></i>Edit</a>
                              <a class="dropdown-item" href="javascript:void();"><i class="ri-printer-fill mr-2"></i>Print</a>
                              <a class="dropdown-item" href="javascript:void();"><i class="ri-file-download-fill mr-2"></i>Download</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="iq-card-body">
                     <ul class="media-story m-0 p-0">
                        <li class="d-flex mb-4 align-items-center ">
                           <img src="<?php echo base_url();?>assets/images/page-img/s4.jpg" alt="story-img" class="rounded-circle img-fluid">
                           <div class="stories-data ml-3">
                              <h5>Web Workshop</h5>
                              <p class="mb-0">1 hour ago</p>
                           </div>
                        </li>
                        <li class="d-flex align-items-center">
                           <img src="<?php echo base_url();?>assets/images/page-img/s5.jpg" alt="story-img" class="rounded-circle img-fluid">
                           <div class="stories-data ml-3">
                              <h5>Fun Events and Festivals</h5>
                              <p class="mb-0">1 hour ago</p>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>

               
               <div class="iq-card">
                  <div class="iq-card-header d-flex justify-content-between">
                     <div class="iq-header-title">
                        <h4 class="card-title">Upcoming Birthday</h4>
                     </div>
                  </div>
                  <div class="iq-card-body">
                     <?php if(count($aryUpcomingBirthDay)>0){ ?>
                     <ul class="media-story m-0 p-0 ">
                        <?php foreach($aryUpcomingBirthDay as $keyBD=>$valBD){ ?>
                        <li class="d-flex mb-4 align-items-center">
                           <img src="<?php echo IMAGE_URL;?>images/<?php if($valBD['profile_image']!=""){ echo "members/".$valBD['profile_image']; }else{ echo "member-no-imgage.jpg"; } ?>" alt="story-img" class="rounded-circle img-fluid">
                           <div class="stories-data ml-3">
                              <h5><?php echo $valBD['first_name']." ".$valBD['last_name']; ?></h5>
                              <p class="mb-0"><?php echo $valBD['dispTimeString']; ?></p>
                           </div>
                        </li>
                        <?php } ?>
                     </ul>
                  <?php }else{ ?>
                     <ul class="media-story m-0 p-0">
                        <li class="d-flex mb-4 align-items-center">There is not any Upcoming Birthday with in a Month!
                        </li>
                     </ul>
                  <?php } ?>
                  </div>
               </div>               
            </div>
            <div ng-show="loadingPost  && postExist" class="col-sm-12 text-center">
               <img src="<?php echo base_url();?>assets/images/page-img/page-load-loader.gif" alt="loader" style="height: 100px;">
            </div>
         </div>
      </div>
   </div>
</div>