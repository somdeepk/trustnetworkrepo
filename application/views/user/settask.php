<div id="content-page" class="content-page" ng-controller="taskController" ng-init="getTaskData(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('parent_id'); ?>','<?php echo $this->session->userdata('membership_type'); ?>');">
  
  

  <!-- Start Video Section-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
         <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title">
                  <input ng-model="taskData.user_auto_id" id="user_auto_id" type="hidden">
                  <input ng-model="taskData.parent_id" id="parent_id" type="hidden">
                  <input type="hidden" id="hidden_task_level" value="<?php echo $task_level; ?>">
                  <div id="jsonTaskVideoLevelData" class="hiddenimportant"><?php echo $taskMin3VideoLevelData; ?></div>
                  <h4 class="card-title">Set Task</h4>
               </div>
            </div>
         </div>
      </div>

      <div class="col-sm-12">
         <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title">
                  <h4 class="card-title">Upload Video</h4>
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
                                <div id="uploaded_image">
                                  <video ng-if="value.video_number>0" width="100%" height="200" controls>
                                    <source src="{{value.video_path_with_video}}" type="{{value.video_type}}">
                                  </video>

                                  <div class="text-center"><img ng-if="value.video_number==0" class="profile-pic" src="<?php echo IMAGE_URL;?>taskvideo/no-video.png" alt="No Video" style="width:;height:149px; margin: 0 auto;"></div>
                                </div>

                                <div class="clear50"></div>
                                
                                <span class="upload-img-cont"><strong>Note:</strong> Please Upload mp4, wmv, avi, 3gp, mov, mpeg Only</span>
                                <div class="clear20"></div>
                                <div class="d-flex align-items-center">

                                  <div class="input-group image-preview"> 
                                    <span class="input-group-btn" style="position:relative;top:-2px;">
                                      <button type="button" class="btn btn-success image-preview-clear" style="display:none;" ng-click="clearProfileImage();">
                                        <i class="fa fa-times" aria-hidden="true"></i> 
                                      </button>
                                      
                                      <div class="btn btn-success image-preview-input mt-3" style="width: 160px;">
                                        <span class="glyphicon glyphicon-folder-open"></span>
                                        <span class="image-preview-input-title_1">Browse</span>
                                        <input type="file" accept="video/mp4, video/wmv, video/avi, video/3gp, video/mov, video/mpeg" name="input_file_upload_{{key+1}}" id="input_file_upload_{{key+1}}" single-file-upload/ class="w-100 video-upload-input"> 
                                      </div>
                                    </span>
                                  </div>
                                  <button type="button" ng-click="uploadVideo(key+1)" class="btn btn-primary zuploadtaskvideonz_{{key+1}}" style="height: 30px;">Upload</button>
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