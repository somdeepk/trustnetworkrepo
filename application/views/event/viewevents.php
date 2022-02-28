<!-- Main Contents -->
<div class="main_content" ng-controller="eventController">
        <div class="mcontainer">
        <div class="uk-switcher lg:mt-0 mt-0" id="timeline-tab" style="touch-action: pan-y pinch-zoom;">
            <!-- Timeline -->
            <div class="md:flex md:space-x-1 lg:mx-2 uk-active">
                            
                <div class="space-y-5 flex-shrink-0 lg:w-4/6 lg:px-5 space-y-7">                  
                  <!-- create post  -->       

                  <div class="card-header">
                    <div class="text-2xl">Events</div>
                  </div> 


                  <!-- Start Event Modal -->
                  <div id="calnedarEventModal" class="modal" role="dialog" style="z-index:999999 ">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Add Event</h4> 
                              <!-- <button type="button" class="btn btn-secondary" ng-click="closeEventModal()"><i class="ri-close-fill"></i></button> -->
                              <button type="button" class="btn btn-secondary" ng-click="closeEventModal()"><i class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="modal-body">
                              <div class="row zcalnedarEventContainerz">
                                                 
                              </div>
                            </div>
                        </div>
                      </div>
                  </div>
                  <!-- End Event Modal -->


                  <!-- Start Invite Friend Modal -->
                  <div class="modal fade" id="inviteFriendToEventModal" tabindex="-1" role="dialog" aria-labelledby="postTag-modalLabel" aria-hidden="true" style="display: none;">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title">Invite Friend</h5>
                              
                              <!-- <button type="button" class="btn btn-secondary" ng-click="closeInviteFriendToEvent()"><i class="ri-close-fill"></i></button> -->                            
                              <button type="button" class="btn btn-secondary" ng-click="closeInviteFriendToEvent()"><i class="fa-solid fa-xmark"></i></button>

                           </div>
                           <div class="modal-body">
                              <div class="d-flex align-items-center">
                                 <div class="user-img">
                                    <i class="ri-search-line"></i>
                                 </div>
                                 <form class="post-text ml-3 w-100" action="javascript:void();">
                                    <input type="text" class="form-control rounded" ng-model="inviteEventData.searchFriend" ng-keyup="inviteFriendToEvent()" placeholder="Search friend" style="border:none;">
                                 </form>
                              </div>

                              <div class="iq-card-body">
                                 <ul class="media-story m-0 p-0">
                                    <li class="d-flex mb-4 align-items-center" ng-repeat="(key, value) in allFriendListObj" style="cursor:pointer;" ng-click="setInviteFriendToEvent(value.id)">
                                       <img class="rounded-circle img-fluid" ng-if="value.profile_image == '' || !value.profile_image" src="<?php echo IMAGE_URL;?>images/member-no-imgage.jpg" alt="no Images"  >
                                       <img class="rounded-circle img-fluid" ng-if="value.profile_image && value.profile_image != ''" src="<?php echo IMAGE_URL;?>images/members/{{value.profile_image}}" alt="{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}">
                                       <div class="stories-data ml-3 mr-3">
                                          <h5>{{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}}</h5>
                                       </div>

                                       <i ng-class="(value.event_accept_reject=='A') ? 'fa fa-thumbs-o-up' : (value.event_accept_reject=='R') ? 'fa fa-thumbs-o-down' : (value.event_accept_reject=='P') ? 'fa fa-link' : ''">                                         
                                         {{(value.event_accept_reject=='A') ? 'Accepted' : (value.event_accept_reject=='R') ? 'Rejected' : (value.event_accept_reject=='P') ? 'Invited' : ''}}
                                       </i>

                                       <i style="font-size: 22px;cursor: pointer;border: none;" class="ml-auto" ng-class="(aryInviteEventFriend.indexOf(value.id) !== -1) ? 'fa fa-check-square-o' : 'fa fa-square-o'"></i>

                                    </li>
                                 </ul>
                              </div>

                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- Start Invite Friend Modal -->     


                  <div class="iq-card-body">

                    <div class="col-md-3">                             
                       <div class="iq-card">
                          <div class="iq-card-header d-flex justify-content-between">
                             <div class="iq-header-title">
                                <h4 class="card-title">Today's Schedule</h4>
                             </div>
                          </div>
                          <div class="iq-card-body">
                             <ul class="m-0 p-0 today-schedule">
                                <li class="d-flex" ng-repeat="(key, value) in loadDateRangeScheduleObj">
                                   <div class="schedule-icon"><i class="ri-checkbox-blank-circle-fill text-primary"></i></div>
                                   <div class="schedule-text"> <span style="color:#50b5ff;">{{value.event_title}}</span>
                                      <span>Started On : {{value.displayStartTime}}</span>
                                      <span>Duration: {{value.disEventDuration}}</span>
                                   </div>
                                </li>

                                <li class="d-flex" ng-if="loadDateRangeScheduleObj.length<=0">
                                  No scheduled for today!
                                </li>
                                
                             </ul>
                          </div>
                       </div>
                       <div class="iq-card">
                          <div class="iq-card-header d-flex justify-content-between">
                             <div class="iq-header-title">
                                <h4 class="card-title" style="font-size: 11px;font-weight: bold;color:#50b5ff;">My <i>Upcoming 7 days</i> Invitation</h4>
                             </div>                                   
                          </div>
                          <div class="iq-card-body">
                             <ul class="media-story m-0 p-0">
                                <li class="d-flex mb-4 align-items-center"  ng-repeat="(key, value) in loadAcceptedInvitedToMeEventsObj">
                                   <div class="stories-data ml-3">
                                       <span><strong style="color:#50b5ff;">Invited From :</strong> {{(value.membership_type=='CM')? value.first_name : value.first_name+' '+value.last_name}} </span>
                                       <br>
                                       <span><strong>Event Type :</strong> {{value.event_type}}</span>
                                       <br>                               
                                       <span class="pb-2"><strong>Title :</strong> {{value.event_title}}</span>
                                       <br>
                                       <span class="pb-2"><strong>Started On :</strong> {{value.displayStartDate}} {{value.displayStartTime}} </span>
                                       <br>
                                       <span class="pb-2"><strong>Duration :</strong> {{value.disEventDuration}}</span> 
                                   </div>
                                </li>
                                
                             </ul>
                          </div>
                       </div>                             
                    </div>
                                    
                    <header class="myCalendar" style="position: relative;">
                    <h4 class="mb-4 text-center">
                      <i class="fa fa-arrow-circle-o-left" aria-hidden="true" style="cursor: pointer;" ng-click="goToDate('prev');"></i>&nbsp;&nbsp;
                        <select ng-change="loadEventCalender();" ng-model="eventCalender.calenderData.selectedMonth" class="noBorderSelect">
                          <option ng-repeat="( monthKey, monthVal) in eventCalender.calenderData.monthArray" value='{{monthVal.monthNum}}'>{{monthVal.monthName}}</option>
                        </select>
                        <select ng-change="loadEventCalender();" ng-model="eventCalender.calenderData.selectedYear" class="noBorderSelect">
                          <option ng-repeat="(yearKey, yearVal) in eventCalender.calenderData.yearArray" value='{{yearVal}}'>{{yearVal}}</option>
                        </select>
                      &nbsp;&nbsp;<i class="fa fa-arrow-circle-o-right"  style="cursor: pointer;" ng-click="goToDate('next');" aria-hidden="true"></i>

                      <button type="button" class="btn btn-success" ng-click="goToDate('today');" style="float: right;">Today</button>
                    </h4>
                    </header>

                    <table class="table" cellspacing="0" cellpadding="0" width="100%" style="margin-bottom:5px;">
                      <tr class="dayHeader">
                        <td class="calenderHeader ftz12"><strong>Mon</strong></td>
                        <td class="calenderHeader ftz12"><strong>Tue</strong></td>
                        <td class="calenderHeader ftz12"><strong>Wed</strong></td>
                        <td class="calenderHeader ftz12"><strong>Thu</strong></td>
                        <td class="calenderHeader ftz12"><strong>Fri</strong></td>
                        <td class="calenderHeader ftz12"><strong>Sat</strong></td>
                        <td class="calenderHeader ftz12"><strong>Sun</strong></td>
                      </tr>
                      <tr class="calDayTr" ng-repeat="calendarVal in eventCalender.calenderData.dateData" >
                        <td style="cursor: pointer;" ng-repeat="datesVal in calendarVal.allDates" class="calDayHgt" ng-class="[(datesVal.activeDate==1)? '' :'greyBG', (datesVal.weekDayNumber==0 || datesVal.weekDayNumber==6)? 'weekendBG' :'', (datesVal.isToday==1)? 'calToday' : '', (datesVal.isEventPresent==1)? 'eventFlag' : 'eventHoverPop']" ng-click="addCalendarEvent(datesVal)">
                          <div class="col-md-12 col-sm-12 padding-lr0 mb10 text-left ftz1" >
                            <strong>{{datesVal.dayNum}} {{(isNullOrEmptyOrUndefined(datesVal.shortMonthNm)==false)? datesVal.shortMonthNm : ''}}</strong>
                          </div>

                          <div class="hover-content"  ng-if="datesVal.dayEventData.length">
                            <div href="javascript:void(0);" class="up-arrow"></div>
                            <div style="margin-bottom:12px" ng-repeat="eveVal in datesVal.dayEventData" >
                              <p>
                                <a href="javascript:void(0);" ng-show="eveVal.is_editable=='Y'" style="color: #000000;text-decoration: none;" ng-click="editCalendarEvent(eveVal.id,datesVal)">{{eveVal.disEventTime}} [{{eveVal.event_type}}] &nbsp;&nbsp;<i style="font-size: 12px" class="fa fa-edit fa-lg"></i></a>
                                <a href="javascript:void(0);" ng-show="eveVal.is_editable=='N'" style="color: #000000;text-decoration: none;">{{eveVal.disEventTime}} [{{eveVal.event_type}}]</a>
                              </p>
                              {{eveVal.event_title}}
                              <br>
                              Duration: {{eveVal.disEventDuration}}
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                  
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