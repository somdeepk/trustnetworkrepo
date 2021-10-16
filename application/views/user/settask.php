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


  <!-- Start Go Live Modal -->
  <div id="goLiveModal" class="modal" role="dialog" style="z-index:999999 ">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="ri-broadcast-fill"></i>  Live Streaming</h4> 
          </div>
          <form id="join-form" name="join-form">
            <div class="modal-body">
              
              <div class="container">                
                  <div class="row join-info-group hiddenimportant">
                    <input type="hiddens" ng-model="agoraData.appid" id="appid" value=""> <!-- AppID(Mandatory) -->
                    <input type="hiddens" ng-model="agoraData.channel" id="channel" value=""> <!-- Channel(Mandatory) -->
                    <input type="hiddens" ng-model="agoraData.token" id="token" value=""> <!-- Token(optional) -->
                    <input type="hiddens" ng-model="agoraData.uid" id="uid"> <!-- User ID(optional) -->
                  </div>

                  <div class="row video-group">
                    <div class="col">
                     <!--  <p id="local-player-name" class="player-name"></p> -->
                      <div id="local-player" class="player"></div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col">
                      <div id="remote-playerlist"></div>
                    </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <!--  <div class="btn-group">
              <button id="audience-join" type="button" class="btn btn-primary btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Join as audience
              </button> -->
              <button class="btn btn-info zbtnGoLivez" id="host-join" ><i class="ri-broadcast-fill"></i> Start Live Streaming</button>
              <button class="btn btn-warning" id="leave" >Leave Live Streaming</button>
              <!-- <button type="button" class="btn btn-secondary zbtnCancelGoLivez" data-dismiss="modal">Cancel</button> -->
            </div>

            <div class="modal-footer hiddenimportant">
              <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Congratulations!</strong><span> You can invite others to watch your live by click </span><a href="" target="_blank">here</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
  </div>
  <!-- End Go Live Modal -->

  <!-- Start Video Section-->
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
         <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title w-100">
                  <input ng-model="taskData.user_auto_id" id="user_auto_id" type="hidden">
                  <input ng-model="taskData.parent_id" id="parent_id" type="hidden">
                  <input type="hidden" id="hidden_leader_id" value="<?php echo $argument['leader_id']; ?>">
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
            <div class="iq-header-title w-100">
              <div class="form-group col-sm-12" ng-if="taskData.membership_type=='CM' || taskData.membership_type=='CC'">
              <label for="type"><strong>Select Leader To View Task:</strong></label>
              <select ng-model="taskData.leader_id" id="leader_id" ng-change="getLeaderStreamAndVideo()" class="form-control form-control-primary">
              <!-- <option value="0">Church Leader</option> -->
              <?php foreach($allChurchAdminData as $key=>$val) : ?>
              <option value="<?php echo $val['id']; ?>"><?php echo $val['first_name']." ".$val['last_name']; ?></option>
              <?php endforeach; ?>
              </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-12">               
         <div class="iq-card">
            <div class="iq-card-header d-flex justify-content-between">
               <div class="iq-header-title">
                  <h4 class="card-title">Live Stream Schedule(s)</h4>
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
                        
                        <a href="javascript:void();" ng-click="goLivePopup(value);" ng-if="session_is_admin=='Y'" class="mr-3 btn btn-info rounded zgoLivez_{{value.id}}"><i class="ri-broadcast-fill"></i> Go Live</a>


                        <a href="javascript:void();" ng-click="activeInactiveStreamVideo(value);" ng-if="session_is_admin=='Y'" ng-class="(value.status=='1') ? 'btn-success' : 'btn-primary'" class="mr-3 btn rounded zactiveInactiveStreamVideoz_{{value.id}}"><i ng-if="value.status=='0'" class="ri-lock-2-fill"></i><i ng-if="value.status=='1'" class="ri-lock-unlock-fill"></i>{{(value.status=='1')? 'Active' : 'Inactive'}}</a>
                        
                        <a href="javascript:void();" ng-click="editStreamVideo(value);" ng-class="(value.status=='1' || value.status=='0') ? 'btn-primary' : 'btn-primary'" class="mr-3 btn rounded zeditStreamVideoz_{{value.id}}">
                          <i ng-if="session_is_admin=='Y'" class="ri-edit-2-fill"></i> <i ng-if="session_is_admin=='N'" class="ri-eye-line"></i>{{(session_is_admin=='Y')? 'Edit' : 'View'}}
                        </a>

                        <a href="javascript:void();" ng-click="deleteStreamVideo(value);" ng-if="session_is_admin=='Y'" ng-class="(value.status=='1' || value.status=='0') ? 'btn-danger' : 'btn-danger'" class="mr-3 btn rounded zdeleteStreamVideoz_{{value.id}}"><i class="ri-delete-bin-fill"></i>Delete</a>
                     </div>
                  </li>
                  <li ng-if="allLiveStreamVideoData.length<=0" class="d-flex align-items-center" style="text-align: center ">
                    There is no Live Stream Schedule.
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

      <style>
        .videodisabledcontainer{
          width: 100px;
          height: 100px;
          position: relative;
        }
        .videodisabledoverlay{
          background-color: #c3bebe;
          position: absolute;
          width: 267%;
          height: 175%;
          top: 25px;
          left: 0;
          z-index: 999;
          opacity: 0.7;
          text-align: center;
          padding-top: 54px;
          font-size: 37px;              
          font-weight: bold;
          pointer-events: none;
        }
        .viewedverlay{
          color: #558527;
        }
        .blockverlay{
          color: red;
        }
        .nopointer
        {
          pointer-events: none;
        }

        .videodisabled{
          position: absolute;
          width: 267%;
          height: 100%;
          top: 0;
          left: 0;
        }
      </style>

      <div ng-repeat="(key, value) in allVideoListObj" class="col-md-4"> <!-- ng-if="taskData.membership_type!='CM'"  -->
         <div class="iq-card">
            <div class="iq-card-body profile-page profile-page-wrap p-0">
               <div class="profile-header-image">
                 
                  <div class="profile-info p-4">
                     <div class="user-detail">
                        <div class="d-flex flex-wrap justify-content-between align-items-start">
                           <div class="profile-detail d-flex"> 
                              <!--left-->
                              <div class="col-sm-12 padding-lr0 mb10" ng-class="(session_is_admin=='N' && value.membershipType=='RM') ? 'videodisabledcontainer': ''">
                                <strong>Video {{parseInt(key)+1}}</strong>

                                <div ng-if="(session_is_admin=='N' && value.membershipType=='RM' && value.view_status!='open')" class="videodisabledoverlay" ng-class="(value.view_status=='viewed') ? 'viewedverlay' : 'blockverlay'"><i ng-if="(value.view_status=='block')" class="ri-lock-2-fill"></i><i ng-if="(value.view_status=='viewed')" class="ri-eye-fill"></i> {{value.view_txt}} </div>

                                <div id="uploaded_image" ng-class="(session_is_admin=='N' && value.membershipType=='RM') ? 'videodisabled': ((value.video_number==0) ? ' height209' : '')" >
                                  <video class="zminThreeVideoz" id="vid_{{value.task_level_video_id}}" data-membershiptype="{{value.membershipType}}" data-isadmin="{{session_is_admin}}" ng-class="(session_is_admin=='N' && value.membershipType=='RM' && value.view_status!='open') ? 'nopointer': ''" ng-if="value.video_number>0" width="100%" height="200" controls>
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
<script type="text/javascript">
// create Agora client
var client = AgoraRTC.createClient({mode: "live", codec: "vp8"});
var localTracks = {
    videoTrack: null,
    audioTrack: null
};
var remoteUsers = {};
// Agora client options
var options = {
    appid: null,
    channel: null,
    uid: null,
    token: null,
    role: "audience", // host or audience
    audienceLatency: 2
};

// the demo can auto join channel with params in url
$(() => {
    var urlParams = new URL(location.href).searchParams;
    options.appid = urlParams.get("appid");
    options.channel = urlParams.get("channel");
    options.token = urlParams.get("token");
    options.uid = urlParams.get("uid");
    if (options.appid && options.channel) {
        $("#uid").val(options.uid);
        $("#appid").val(options.appid);
        $("#token").val(options.token);
        $("#channel").val(options.channel);
        $("#join-form").submit();
    }
})

$("#host-join").click(function (e) {
    //$(".zbtnCancelGoLivez").addClass('hiddenimportant');
    options.role = "host"
})

$("#lowLatency").click(function (e) {
    options.role = "audience"
    options.audienceLatency = 1
    $("#join-form").submit()
})

$("#ultraLowLatency").click(function (e) {
    options.role = "audience"
    options.audienceLatency = 2
    $("#join-form").submit()
})

$("#join-form").submit(async function (e) {
    e.preventDefault();
    $("#host-join").attr("disabled", true);
    $("#audience-join").attr("disabled", true);
    try {
        options.appid = $("#appid").val();
        options.token = $("#token").val();
        options.channel = $("#channel").val();
        options.uid = Number($("#uid").val());
        await join();
        if (options.role === "host") {
            $("#success-alert a").attr("href", `index.html?appid=${options.appid}&channel=${options.channel}&token=${options.token}`);
            if (options.token) {
                $("#success-alert-with-token").css("display", "block");
            } else {
                $("#success-alert a").attr("href", `index.html?appid=${options.appid}&channel=${options.channel}&token=${options.token}`);
                $("#success-alert").css("display", "block");
            }
        }
    } catch (error) {
        console.error(error);
    } finally {
        $("#leave").attr("disabled", false);
    }
})

$("#leave").click(function (e) {
    leave();
    //$(".zbtnCancelGoLivez").removeClass('hiddenimportant');
})

async function join() {
    // create Agora client

    if (options.role === "audience") {
        client.setClientRole(options.role, {level: options.audienceLatency});
        // add event listener to play remote tracks when remote user publishs.
        client.on("user-published", handleUserPublished);
        client.on("user-unpublished", handleUserUnpublished);
    }
    else{
        client.setClientRole(options.role);
    }

    // join the channel
    options.uid = await client.join(options.appid, options.channel, options.token || null, options.uid || null);

    if (options.role === "host") {
        // create local audio and video tracks
        localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
        localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();
        // play local video track
        localTracks.videoTrack.play("local-player");
        //$("#local-player-name").text(`localTrack(${options.uid})`);
        // publish local tracks to channel
        await client.publish(Object.values(localTracks));
        console.log("publish success");
    }
}

async function leave() {
    for (trackName in localTracks) {
        var track = localTracks[trackName];
        if (track) {
            track.stop();
            track.close();
            localTracks[trackName] = undefined;
        }
    }

    // remove remote users and player views
    remoteUsers = {};
    $("#remote-playerlist").html("");

    // leave the channel
    await client.leave();

    //$("#local-player-name").text("");
    $("#host-join").attr("disabled", false);
    //$("#audience-join").attr("disabled", false);
    $("#leave").attr("disabled", true);
    location.reload();
    //console.log("client leaves channel success");
}

async function subscribe(user, mediaType) {
    const uid = user.uid;
    // subscribe to a remote user
    await client.subscribe(user, mediaType);
    console.log("subscribe success");
    if (mediaType === 'video') {
        const player = $(`
      <div id="player-wrapper-${uid}">
        <p class="player-name">remoteUser(${uid})</p>
        <div id="player-${uid}" class="player"></div>
      </div>
    `);
        $("#remote-playerlist").append(player);
        user.videoTrack.play(`player-${uid}`, {fit:"contain"});
    }
    if (mediaType === 'audio') {
        user.audioTrack.play();
    }
}

function handleUserPublished(user, mediaType) {
    const id = user.uid;
    remoteUsers[id] = user;
    subscribe(user, mediaType);
}

function handleUserUnpublished(user) {
    const id = user.uid;
    delete remoteUsers[id];
    $(`#player-wrapper-${id}`).remove();
}
</script>