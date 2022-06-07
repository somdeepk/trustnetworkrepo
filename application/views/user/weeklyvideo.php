<div id="content-page" class="content-page" ng-controller="videoController" ng-init="initiateVideo(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('parent_id'); ?>','<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>');">
  
  
  <!-- Start Image Croping Modal -->
  <div id="uploadWeeklyVideoModal" class="modal" role="dialog" style="z-index:999999 ">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title zheadslz">Add Weekly Video</h4> 
            </div>
            <div class="modal-body">
              <div class="row">
                  <!--left-->
                  <div class="form-group col-sm-6">
                     <label for="first_name">Video Title:</label>
                     <input type="text" ng-model="weeklyVideoData.video_title" id="video_title" maxlength="100" class="form-control">
                     <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(weeklyVideoDataCheck==true && isNullOrEmptyOrUndefined(weeklyVideoData.video_title)==true)? 'Video Title Required' : ''}}</div>
                  </div>

                  <div class="form-group col-sm-6">
                     <label for="first_name">Video Type:</label>
                     <select ng-model="weeklyVideoData.video_type" id="video_type" class="form-control form-control-primary">
                      <option value="">Select</option> 
                      <option value="Teaching Video">Teaching Video</option> 
                      <option value="Sharing Video">Sharing Video</option> 
                      <option value="Announcement Video">Announcement Video</option> 
                     </select>
                     <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(weeklyVideoDataCheck==true && isNullOrEmptyOrUndefined(weeklyVideoData.video_type)==true)? 'Video Type Required' : ''}}</div>
                  </div>
                  <div class="form-group col-sm-6">

                    <label for="dob">Start Time:</label>
                    <input class="form-control" style="background: transparent;" ng-model="weeklyVideoData.start_time" id="weeklyVideoStartTime" type="text" autocomplete="off" startdatetimeweeklyvideo>
                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(weeklyVideoDataCheck==true && isNullOrEmptyOrUndefined(weeklyVideoData.start_time)==true)? 'Start Time Required' : ''}}</div>
                  </div>

                  <div class="form-group col-sm-6">
                    <label for="dob">End Time:</label>
                    <input class="form-control"  style="background: transparent;" ng-model="weeklyVideoData.end_time" id="weeklyVideoEndTime" type="text" autocomplete="off" enddatetimeweeklyvideo >
                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(weeklyVideoDataCheck==true && isNullOrEmptyOrUndefined(weeklyVideoData.end_time)==true)? 'End Time Required' : ''}}</div>
                  </div>                                  
                  <div class="form-group col-sm-12">
                    <div id="browsecontainer">
                        <div id="browseFileToUpload" style="font-size: 22px;cursor: pointer;">
                          <i  class="las la-file-upload"></i> Browse To Upload Video Files
                        </div>
                      </div>
                  </div>

                  <div class="form-group col-sm-12">
                    <div class="flex items-center w-full justify-between border-t p-3" id="post_image_preview_container">
                    </div>                    
                  </div>

              </div>
            </div>
            <div class="modal-footer">
              <button ng-if="session_is_admin=='Y'" class="btn btn-success zuploadWeeklyVideoz" ng-click="submitWeeklyVideo()" >Submit</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
               <div class="iq-header-title">
                  <h4 class="card-title">List Of Weekly Video(s)</h4>
               </div>
               <div id="jsonWeeklyVideoData" class="hiddenimportant"><?php echo $weeklyVideoData; ?></div>
               <a href="javascript:void();" ng-click="uploadWeeklyVideo();" ng-if="session_is_admin=='Y'" ng-class="(session_is_admin=='Y') ? 'btn-primary' : ''" class="mr-3 btn rounded"><i class="lab la-youtube"></i></i>Add New Video</a>
            </div>
            <div class="iq-card-body">
              <div class="table-respnsive">
                <table class="table table-striped">
                <thead>
                  <tr >
                    <th>Title</th>
                    <th>Type</th>
                    <th>Star Time</th>
                    <th>End Time</th>
                    <th>Action</th>                    
                  </tr>
                </thead>
                <tbody>
                  <tr  ng-repeat="(key, value) in allWeeklyVideoData">                    
                    <td><h6>{{value.video_title}}</h6></td>
                    <td><h6>{{value.video_type}}</h6></td>
                    <td><h6>{{value.display_start_time}}</h6></td>
                    <td><h6>{{value.display_end_time}}</h6></td>
                    <td>
                      <div class="d-flex align-items-center">
                        
                        <a href="javascript:void();" ng-click="activeInactiveWeeklyVideo(value);" ng-if="session_is_admin=='Y'" ng-class="(value.status=='1') ? 'btn-success' : 'btn-primary'" class="mr-3 btn rounded zactiveInactiveWeeklyVideoz zactiveInactiveWeeklyVideoz_{{value.id}}"><i ng-if="value.status=='0'" class="ri-lock-2-fill"></i><i ng-if="value.status=='1'" class="ri-lock-unlock-fill"></i>{{(value.status=='1')? 'Active' : 'Inactive'}}</a>
                        
                       <!--  <a href="javascript:void();" ng-click="editStreamVideo(value);" class="mr-3 btn btn-primary rounded zeditStreamVideoz zeditStreamVideoz_{{value.id}}">
                          <i ng-if="session_is_admin=='Y'" class="ri-edit-2-fill"></i> Edit
                        </a> -->


                        <a href="javascript:void();" ng-click="deleteWeeklyVideo(value);" ng-if="session_is_admin=='Y'" ng-class="(value.is_live=='Y') ? 'cssdisabled' : ''" class="mr-3 btn  btn-danger rounded zdeleteWeeklyVideoz zdeleteWeeklyVideoz_{{value.id}}"><i class="ri-delete-bin-fill"></i>Delete</a>
                     </div>
                    </td>
                  </tr>
                  <tr  ng-if="allWeeklyVideoData.length<=0" >                    
                    <td colspan="5">
                      There is no Weekly Schedule
                    </td>
                    
                  </tr>
                </tbody>
              </table>
              </div>
              
               
            </div>
         </div>
      </div>



    </div>
  </div>
  <!-- End Video Section-->
</div>