<div id="content-page" class="content-page" ng-controller="taskController" ng-init="getTaskData(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('parent_id'); ?>','<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>');">
  
  
  <!-- Start Image Croping Modal -->
  <div id="uploadliveStreamVideoModal" class="modal" role="dialog" style="z-index:999999 ">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title zheadslz">Add Stream Schedule</h4> 
            </div>
            <div class="modal-body">
              <div class="row">
                  <!--left-->
                  <div class="form-group col-sm-6">
                     <label for="first_name">Video Title:</label>
                     <input type="text" ng-model="liveStreamData.video_title" id="video_title" maxlength="100" class="form-control">
                     <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(liveStreamDataCheck==true && isNullOrEmptyOrUndefined(liveStreamData.video_title)==true)? 'Video Title Required' : ''}}</div>
                  </div>
                  <div class="form-group col-sm-6">

                    <label for="dob">Start Time:</label>
                    <input class="form-control" style="background: transparent;" ng-model="liveStreamData.star_time" id="liveStreamStartTime" type="text" autocomplete="off" dateandtimepicker>
                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(liveStreamDataCheck==true && isNullOrEmptyOrUndefined(liveStreamData.star_time)==true)? 'Start Time Required' : ''}}</div>
                  </div>

                  <!-- <div class="form-group col-sm-6">
                    <label for="dob">End Time:</label>
                    <input class="form-control"  style="background: transparent;" ng-model="liveStreamData.end_time" id="liveStreamEndTime" type="text" autocomplete="off" dateandtimepicker >
                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(liveStreamDataCheck==true && isNullOrEmptyOrUndefined(liveStreamData.end_time)==true)? 'End Time Required' : ''}}</div>
                  </div> -->

                  <div class="form-group col-sm-12">
                     <label for="address">Description:</label>
                     <textarea class="form-control" ng-model="liveStreamData.description" id="description" autocomplete="off" rows="3" style="line-height: 22px;"></textarea>
                  </div>

                 <!--  <div ng-if="session_is_admin=='Y'" class="col-sm-12 padding-lr0 mb10">
                    <div id="uploaded_image">
                      <video ng-if="value.video_number>0" width="100%" height="200" controls>
                        <source src="{{value.video_path_with_video}}" type="{{value.video_type}}">
                      </video>
                      <div class="text-center"><img class="profile-pic" src="<?php echo IMAGE_URL;?>taskvideo/no-video.png" alt="No Video" style="width:;height:80px; margin: 0 auto;"></div> 
                    </div>

                    <div class="clear50"></div>
                    <span class="upload-img-cont"><strong>Note:</strong> Please Upload mp4, wmv, avi, 3gp, mov, mpeg Only</span>
                    <div class="clear20"></div>
                    <div class="d-flex align-items-center">
                      <div class="input-group image-preview"> 
                        <span class="input-group-btn" style="position:relative;top:-2px;">
                          <div class="btn btn-success image-preview-input mt-3" style="width: 160px;">
                            <span class="glyphicon glyphicon-folder-open"></span>
                            <span class="image-preview-input-title_1">Browse</span>
                            <input type="file" accept="video/mp4, video/wmv, video/avi, video/3gp, video/mov, video/mpeg" id="file_ls_video_upload" single-file-upload class="w-100"> 
                          </div>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(liveStreamDataCheck==true && emptyLiveStreamVideoCheck==true)? 'Video Required' : ''}}</div>
                  <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(liveStreamDataCheck==true && emptyLiveStreamVideoExtensionCheck==true)? 'Please Upload mp4, wmv, avi, 3gp, mov, mpeg Only' : ''}}</div> -->
                  <!--/left-->                  
              </div>
            </div>
            <div class="modal-footer">
              <button ng-if="session_is_admin=='Y'" class="btn btn-success zuploadlivestreamvideoz" ng-click="submitLiveStreamVideo()" >Submit Schedule</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
      </div>
  </div>
  <!-- End Image Croping Modal -->

  <!-- Start Video Section-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
         <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title w-100">
                  <input ng-model="taskData.user_auto_id" id="user_auto_id" type="hidden">
                  <input ng-model="taskData.parent_id" id="parent_id" type="hidden">
                  <input type="hidden" id="hidden_task_level" value="<?php echo $argument['task_level']; ?>">
                  <input type="hidden" id="hidden_course_id" value="<?php echo $argument['course_id']; ?>">
                  <div id="jsonTaskVideoLevelData" class="hiddenimportant"><?php echo $taskMin3VideoLevelData; ?></div>
                  <div id="jsonLiveStreamVideoData" class="hiddenimportant"><?php echo $liveStreamVideoData; ?></div>
                  <div class="d-flex justify-content-between w-100">
                  <h4 class="card-title"><?php if($argument['isAdmin']=='Y'){ echo "Set"; }elseif($argument['membershipType']=="RM" && $argument['isAdmin']=="N"){ echo "My"; } ?> Task [<?php echo $argument['course_name']; ?> : Level <?php echo $argument['task_level']; ?>]</h4> 
                  <a href="javascript:void();" ng-click="uploadliveStreamVideo();" ng-if="session_is_admin=='Y'" ng-class="(session_is_admin=='Y') ? 'btn-primary' : ''" class="mr-3 btn rounded"><i class="ri-broadcast-fill"></i>Add New Stream Schedule</a>
                </div>


               </div>
            </div>
         </div>
      </div>

      <div class="col-sm-12">               
         <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title">
                  <h4 class="card-title">Live Stream Video(s)</h4>
               </div>
            </div>
            <div class="iq-card-body">
               <ul class="request-list list-inline m-0 p-0">

                  <li class="d-flex align-items-center">
                     <div class="media-support-info ml-4">
                        <h6>Title</h6>
                     </div>
                     <div class="media-support-info ml-4">
                        <h6>Star Time</h6>
                     </div>
                    <!--  <div class="media-support-info ml-3">
                        <h6>End Time</h6>
                     </div> -->
                     <div class="d-flex align-items-center">
                        Action
                     </div>
                  </li>

                  <li ng-repeat="(key, value) in allLiveStreamVideoData" class="d-flex align-items-center">
                     <div class="media-support-info ml-4">
                        <h6>{{value.video_title}}</h6>
                     </div>
                     <div class="media-support-info ml-4">
                        <h6>{{value.display_star_time}}</h6>
                     </div>
                    <!-- <div class="media-support-info ml-3">
                        <h6>{{value.display_end_time}}</h6>
                     </div> -->
                     <div class="d-flex align-items-center">
                        
                        <a href="javascript:void();" ng-click="activeInactiveStreamVideo(value);" ng-if="session_is_admin=='Y'" ng-class="(value.status=='1') ? 'btn-success' : 'btn-primary'" class="mr-3 btn rounded zactiveInactiveStreamVideoz_{{value.id}}"><i ng-if="value.status=='0'" class="ri-lock-2-fill"></i><i ng-if="value.status=='1'" class="ri-lock-unlock-fill"></i>{{(value.status=='1')? 'Active' : 'Inactive'}}</a>
                        
                        <a href="javascript:void();" ng-click="editStreamVideo(value);" ng-class="(value.status=='1' || value.status=='0') ? 'btn-primary' : 'btn-primary'" class="mr-3 btn rounded zeditStreamVideoz_{{value.id}}">
                          <i ng-if="session_is_admin=='Y'" class="ri-edit-2-fill"></i> <i ng-if="session_is_admin=='N'" class="ri-eye-line"></i>{{(session_is_admin=='Y')? 'Edit' : 'View'}}
                        </a>

                        <a href="javascript:void();" ng-click="deleteStreamVideo(value);" ng-if="session_is_admin=='Y'" ng-class="(value.status=='1' || value.status=='0') ? 'btn-danger' : 'btn-danger'" class="mr-3 btn rounded zdeleteStreamVideoz_{{value.id}}"><i class="ri-delete-bin-fill"></i>Delete</a>
                     </div>
                  </li>
                  <li ng-if="allLiveStreamVideoData.length<=0" class="d-flex align-items-center" style="text-align: center ">
                    There is no Live Stream Video.
                  </li>
               </ul>
            </div>
         </div>
      </div>

      <div class="col-sm-12">
         <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title">
                  <h4 class="card-title">Set Video</h4>
               </div>
            </div>
         </div>
      </div>

      <div ng-repeat="(key, value) in allVideoListObj" class="col-md-4"> <!-- ng-if="taskData.membership_type!='CM'"  -->
         <div class="iq-card">
            <div class="iq-card-body profile-page profile-page-wrap p-0">
               <div class="profile-header-image">
                 
                  <div class="profile-info p-4">
                     <div class="user-detail">
                        <div class="d-flex flex-wrap justify-content-between align-items-start">
                           <div class="profile-detail d-flex"> 
                              <!--left-->
                              <div class="col-sm-12 padding-lr0 mb10">
                                <strong>Video {{parseInt(key)+1}}</strong>
                                <div id="uploaded_image" ng-class="(value.video_number==0) ? 'height209' : ''">
                                  <video ng-if="value.video_number>0" width="100%" height="200" controls>
                                    <source src="{{value.video_path_with_video}}" type="{{value.video_type}}">
                                  </video>

                                  <div class="text-center" ng-class="(value.video_number==0) ? 'ptop33' : ''"><img ng-if="value.video_number==0" class="profile-pic" src="<?php echo IMAGE_URL;?>taskvideo/no-video.png" alt="No Video" style="width:;height:149px; margin: 0 auto;"></div>
                                </div>

                                <div ng-if="session_is_admin=='Y'" class="clear50"></div>
                                
                                <span ng-if="session_is_admin=='Y'" class="upload-img-cont"><strong>Note:</strong> Please Upload mp4, wmv, avi, 3gp, mov, mpeg Only</span>
                                <div class="clear20"></div>
                                <div ng-if="session_is_admin=='Y'" class="d-flex align-items-center">

                                  <div class="input-group image-preview mt-3"> 
                                    <span class="input-group-btn" style="position:relative;top:-2px;">
                                      <button type="button" class="btn btn-success image-preview-clear" style="display:none;" ng-click="clearProfileImage();">
                                        <i class="fa fa-times" aria-hidden="true"></i> 
                                      </button>
                                      
                                      <div ng-class="(session_is_admin=='Y') ? 'btn-success' : ''" class="btn  image-preview-input" style="width: 160px;">
                                        <span class="glyphicon glyphicon-folder-open"></span>
                                        <span class="image-preview-input-title_1">Browse</span>
                                        <input type="file" accept="video/mp4, video/wmv, video/avi, video/3gp, video/mov, video/mpeg" name="input_file_upload_{{key+1}}" id="input_file_upload_{{key+1}}" single-file-upload class="w-100 video-upload-input"> 
                                      </div>
                                    </span>
                                  </div>
                                  <button type="button" ng-class="(session_is_admin=='Y') ? 'btn-primary' : ''" ng-click="uploadVideo(key+1)" class="btn mt-3 zuploadtaskvideonz_{{key+1}}" style="height: 36px;">Upload</button>
                                </div>
                              </div>
                              <!--/left-->
                           </div>
                           <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(videoDataCheck==true && videoIncree== (key+1) && emptyVideoCheck==true)? 'Video Required' : ''}}</div>

                           <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(videoDataCheck==true && videoIncree== (key+1) && videoExtensionCheck==true)? 'Please Upload mp4, wmv, avi, 3gp, mov, mpeg Only' : ''}}</div>
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
    </div>
  </div>
  <!-- End Video Section-->
</div>