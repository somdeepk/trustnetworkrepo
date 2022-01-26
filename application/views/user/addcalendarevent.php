<div class="col-md-12 " ng-init="baseencoded_eventData='<?php echo base64_encode(json_encode($resultEventDetails)) ;?>'">
   <div class="row">
      <div class="col-md-6 <?php if($enableEventForm=='N'){ ?> blurEvent <?php } ?>">
         <div class="form-group">
           <label class="labelred field-icon">Event Type</label>
           <select class="form-control" ng-model='eventData.event_type' ng-class="((validator==true) && isNullOrEmptyOrUndefined(eventData.event_type)==true)? 'error-red-bd' : ''">
             <option value=""> Select</option>
             <option value="Appointment">Appointment</option>
             <option value="Meeting">Meeting</option>
             <option value="Task">Task</option>
             <option value="Event">Event</option>
           </select>
         </div>
         <div  class="form-group" >
           <label class="labelred  field-icon">Friends</label>
           <a href="javascript:void();" ng-click="inviteFriendToEvent();"><div ng-class="((validator==true) && isNullOrEmptyOrUndefined(totalInvitedFriend)==true)? 'error-red-bd' : ''" class="iq-bg-primary rounded p-2 pointer mr-3"><img src="<?php echo base_url();?>assets/images/small/08.png" alt="icon" class="img-fluid"> Invite Friend (s) &nbsp;&nbsp;<font style="color: #d8db30;font-weight: bold;" ng-show="totalInvitedFriend>0">[ Total Invited: {{totalInvitedFriend}} ]</font></div></a>
         </div>
         <div class="form-group">
           <label class="labelred field-icon">Event Title</label>
           <input class="form-control" type="text" ng-model='eventData.event_title' ng-class="((validator==true) && isNullOrEmptyOrUndefined(eventData.event_title)==true)? 'error-red-bd' : ''" maxlength="80">
         </div>
         <div class="form-group">
           <label class="labelred field-icon">Event Description</label>
           <textarea class="form-control" id="" rows="3" ng-model='eventData.event_desc' ng-class="((validator==true) && isNullOrEmptyOrUndefined(eventData.event_desc)==true)? 'error-red-bd' : ''"></textarea>
         </div>
         <div class="form-group">
            <div id="time-range">
                <input type="hidden" id='event_start_time' value="09:00:00">
                <input type="hidden" id='event_end_time' value="17:00:00">
                <p><i class="fa fa-clock-o" aria-hidden="true"></i> Time Range: <span class="slider-time">9:00 AM</span> - <span class="slider-time2">5:00 PM</span>
                </p>
                <div class="sliders_step1">
                  <div id="slider-range"></div>
                </div>
            </div>
         </div>
         <div class="form-group">
           <div class="form-check">
              <input class="form-check-input" style="float:left" type="checkbox" id="chk_all_day_event" <?php if(isset($resultEventDetails['all_day_event']) && $resultEventDetails['all_day_event']==1){ echo "checked"; } ?> >
              <label class="form-check-label" for="chk_all_day_event">
                All Day Event
              </label>
            </div>
         </div>
         <div class="form-group text-right">
            <button type="button" class="btn btn-primary zeventSubmitButtonz <?php if($enableEventForm=='N'){ ?> cssdisabled <?php } ?>" id="eventSubmitButton" ng-click="submiCalendarEvent()">Submit</button>
         </div>
      </div>

      <div class="col-md-6" style="max-height: 675px;overflow: scroll;padding-left: 22px">
            <div class="activity-timeline" >
               <h6 class="mb-4" style="margin-left:-20px;">Events This Week</h6>
               <div class="month-sec" >                
                 <?php 
                 if(count($resultUserThisWeekEvents)>0)
                 {
                  foreach ($resultUserThisWeekEvents as $ek => $ev)
                  {
                ?>
                 <div class="row my-timeline small">
                    <div class="col-md-3 timeline-dot task-added small">
                       <?php echo $ev['disEventTime']; ?>
                    </div>
                    <div class="col-md-9 d-flex">
                       <span class="float-left task-icon"><i class="fa fa-tasks"></i></span>
                       <div class="timeline-text small">
                          <?php if($ev['is_editable']=='N'){ ?>
                            <p class="text-upper" style="font-size: 12px;color:#FFF;padding-left: 8px"><?php echo $ev['event_title']; ?></p>
                          <?php }else{ ?>
                            <p class="text-upper" style="font-size: 12px;color:#FFF;padding-left: 8px"><a href="javascript:void(0);" style="color: #FFF;text-decoration: none;" ng-click="editFromThisWeekEvent(<?php echo $ev['id']; ?>)" style=""><?php echo $ev['event_title']; ?> &nbsp;&nbsp;<i style="font-size: 12px" class="fa fa-edit fa-lg"></i></a></p>
                          <?php } ?>
                          <p> 
                            <?php echo $ev['event_desc']; ?> 
                          </p>
                          <p>Duration: <?php echo $ev['disEventDuration']; ?></p>
                       </div>
                    </div>
                 </div>
                 <?php
                  }
                 }
                 else
                 {
                 ?>
                 <div class="row my-timeline small">Hurray!! No event is present in this week.</div>

                 <?php
                 }
                 ?>
               </div>
          </div>
      </div>
   </div>
</div>
<script>

<?php 
if(isset($resultEventDetails) && count($resultEventDetails)>0)
{ 
?>
  $( document ).ready(function()
  {
    setTimeout(function () {
      $('#event_start_time').val('<?php echo $resultEventDetails['event_start_time']; ?>');
      $('#event_end_time').val('<?php echo $resultEventDetails['event_end_time']; ?>');
      $("#slider-range").slider({
          range: true,
          min: 0,
          max: 1440,
          step: 15,
          values: [<?php echo $resultEventDetails['starttimeminute']; ?>, <?php echo $resultEventDetails['endtimeminute']; ?>],
      });
      $('.slider-time').html('<?php echo $resultEventDetails['display_event_start_time']; ?>');
      $('.slider-time2').html('<?php echo $resultEventDetails['display_event_end_time']; ?>');

     }, 300);
  });
<?php  
}
?>
$( "#chk_all_day_event" ).click(function()
{
  if($('#chk_all_day_event').is(':checked'))
  {
    $('#event_start_time').val('00:00:00');
    $('#event_end_time').val('23:59:00');
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 1440,
        step: 15,
        values: [0, 1440],
    });
    $('.slider-time').html('12:00 AM');
    $('.slider-time2').html('11:59 PM');
  }
});

$("#slider-range").slider({
    range: true,
    min: 0,
    max: 1440,
    step: 15,
    values: [540, 1020],
    slide: function (e, ui) {
        var hours1 = Math.floor(ui.values[0] / 60);
        var minutes1 = ui.values[0] - (hours1 * 60);

        if (hours1.length == 1) hours1 = '0' + hours1;
        if (minutes1.length == 1) minutes1 = '0' + minutes1;
        if (minutes1 == 0) minutes1 = '00';

        if(hours1==0)
        {
          tempHour1='00';
          tempMinute1=minutes1;
        }
        else if(hours1==24)
        {
          tempHour1=23;
          tempMinute1=59;
        }
        else if(hours1<10)
        {
          tempHour1='0'+hours1;
          tempMinute1=minutes1;
        }
        else
        {
          tempHour1=hours1;
          tempMinute1=minutes1;
        }

        if (hours1 >= 12) {
            if (hours1 == 12) {
                hours1 = hours1;
                minutes1 = minutes1 + " PM";
            } else {
                hours1 = hours1 - 12;
                minutes1 = minutes1 + " PM";
            }
        } else {
            hours1 = hours1;
            minutes1 = minutes1 + " AM";
        }
        if (hours1 == 0) {
            hours1 = 12;
            minutes1 = minutes1;
        }

        $('.slider-time').html(hours1 + ':' + minutes1);

        var hours2 = Math.floor(ui.values[1] / 60);
        var minutes2 = ui.values[1] - (hours2 * 60);

        if (hours2.length == 1) hours2 = '0' + hours2;
        if (minutes2.length == 1) minutes2 = '0' + minutes2;
        if (minutes2 == 0) minutes2 = '00';

        if(hours2==24)
        {
          tempHour2=23;
          tempMinute2=59;
        }
        else if(hours2<10)
        {
          tempHour2='0'+hours2;
          tempMinute2=minutes2;
        }
        else
        {
          tempHour2=hours2;
          tempMinute2=minutes2;
        }

        if (hours2 >= 12) {
            if (hours2 == 12) {
                hours2 = hours2;
                minutes2 = minutes2 + " PM";
            } else if (hours2 == 24) {
                hours2 = 11;
                minutes2 = "59 PM";
            } else {
                hours2 = hours2 - 12;
                minutes2 = minutes2 + " PM";
            }
        } else {
            hours2 = hours2;
            minutes2 = minutes2 + " AM";
        }

        $('.slider-time2').html(hours2 + ':' + minutes2);
        if(hours1=='12' && minutes1=='00 AM' && hours2=='11' && minutes2=='59 PM' )
        {
          $('#chk_all_day_event').prop('checked',true)
        }
        else
        {
          $('#chk_all_day_event').prop('checked',false)
        }
        $('#event_start_time').val(tempHour1 + ':' + tempMinute1 + ':00');
        $('#event_end_time').val(tempHour2 + ':' + tempMinute2 + ':00');
    }
});
</script>