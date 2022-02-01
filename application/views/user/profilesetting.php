<!-- Main Contents -->
<div class="main_content" ng-controller="profileSettingController" ng-init="baseencoded_profileSettingData='<?php echo base64_encode(json_encode($profileSettingData)) ;?>'; initProfileSetting();">
    <div class="mcontainer">
        <div class="bg-white lg:divide-x lg:flex lg:shadow-md rounded-md shadow lg:rounded-xl overflow-hidden lg:m-0 -mx-4">
            <div class="lg:w-1/3">
               <nav class="responsive-nav setting-nav setting-menu"
                  uk-sticky="top:30 ; offset:80 ; media:@m ;bottom:true; animation: uk-animation-slide-top">
                  <h4 class="mb-0 p-3 uk-visible@m "> Profile Setting </h4>
                  <ul class="tabs">
                     <li class="tab-link current" data-tab="tab-1"><a href="#"> <i class="uil-cog"></i> General </a></li>
                     <li class="tab-link" data-tab="tab-2"><a href="#"> <i class="uil-scenery"></i> Profile Picture & Cover</a></li>
                     <li tab-link data-tab="tab-3"><a href="#"> <i class="uil-user"></i> Profile Question  </a></li>
                     <li tab-link data-tab="tab-4"><a href="#"> <i class="uil-unlock-alt"></i> Password </a></li>
                     <li tab-link data-tab="tab-5"><a href="#"> <i class="uil-user"></i> Create Groups</a></li>
                     <li tab-link data-tab="tab-6"><a href="#"> <i class="uil-unlock-alt"></i> Create Pages</a></li>
                     <li tab-link data-tab="tab-7"><a href="#"> <i class="uil-shield-check"></i> Security</a></li>
                     <li tab-link data-tab="tab-8"><a href="#"> <i class="uil-dollar-alt"></i> Privacy Settings</a></li>
                     <li tab-link data-tab="tab-9"><a href="#"> <i class="uil-usd-circle"></i> Notifications and Settings</a></li>
                     <li tab-link data-tab="tab-10"><a href="#"> <i class="uil-trash-alt"></i> Delete account</a></li>
                  </ul>
               </nav>
            </div>

            <div id="tab-1" class="tab-content current lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <div class="lg:px-10 lg:py-4">
                     <h3 class="font-bold mb-2 text-xl">General</h3>
                     <p class=""> This information will be dispalyed publicly so be carful what you share. </p>
                  </div>
                  <!-- form body -->
                  <div class="lg:py-4 lg:px-10 flex-1 space-y-4 ">
                     <div class="line" ng-if="generalData.membership_type=='RM'">
                        <input class="line__input" type="text" id="first_name"  autocomplete="off" ng-model="generalData.first_name" maxlength="25" ng-class="(generalDataCheck==true && isNullOrEmptyOrUndefined(generalData.first_name)==true)? 'redBorder' : ''">
                        <span for="username" class="line__placeholder">First Name</span>
                     </div>
                     <div class="line" ng-if="generalData.membership_type=='RM'">
                        <input class="line__input" type="text" id="last_name" autocomplete="off" ng-model="generalData.last_name" maxlength="25" ng-class="(generalDataCheck==true && isNullOrEmptyOrUndefined(generalData.last_name)==true)? 'redBorder' : ''">
                        <span for="username" class="line__placeholder">Last Name</span>
                     </div>
                     <div class="line" ng-if="generalData.membership_type=='PM'">
                        <input class="line__input" type="text" id="first_name" autocomplete="off" ng-model="generalData.first_name" maxlength="25">
                        <span for="username" class="line__placeholder">Church Name</span>
                     </div>

                     <div class="line">
                        <input class="line__input" type="text" id="user_email" autocomplete="off" ng-model="generalData.user_email" emailvalidate ng-disabled="true" maxlength="25">
                        <span for="username" class="line__placeholder">Email </span>
                     </div>
                     <div class="line h-32" ng-if="generalData.membership_type=='RM'">
                        <textarea class="line__input h-32" autocomplete="off" type="text" id="note" ng-model="generalData.about_church"></textarea>
                        <span for="username" class="line__placeholder">About Church </span>
                     </div>
                     <div class="line">
                        <input class="line__input" id="address" autocomplete="off" type="text" ng-model="generalData.address">
                        <span for="username" class="line__placeholder">Address </span>
                     </div>
                     
                     <!-- <div class="line">
                        <select ng-model="generalData.country" id="country" ng-change="getStateData(generalData.country)" class="form-control">
                            <option value="0">Select Country</option>
                            <option ng-repeat="option in countryData" value="{{option.id}}">{{option.name}}
                        </select>
                     </div>
                     <div class="line">
                        <select ng-disabled="!generalData.country"  ng-model="generalData.state" id="state"  ng-change="getCityData(generalData.state)" style="background: transparent;" class="form-control form-control-primary">
                         <option value="0">Select State</option>
                         <option ng-repeat="option in stateData" value="{{option.id}}">{{option.name}}
                       </select>
                     </div>
                     <div class="line">
                        <select ng-disabled="!generalData.state" ng-model="generalData.city" id="city" style="background: transparent;" class="form-control form-control-primary">
                           <option value="0">Select City</option>
                           <option ng-repeat="option in cityData" value="{{option.id}}">{{option.name}}
                       </select>
                     </div> -->
                     <div class="line">
                        <input class="line__input" autocomplete="off" ng-model="generalData.postal_code" id="postal_code" type="text">
                        <span for="username" class="line__placeholder">Zip Code </span>
                     </div>
                  </div>
                  <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3"><!-- 
                     <button class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </button> -->
                     <button type="button" ng-click="submitProfileGeneralData()" class="zsubmitGeneralDataz button bg-blue-700"> Save </button>
                  </div>
               </div>
            </div>

            <div id="tab-2" class="tab-content lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <div class="lg:px-10 lg:py-8 p-6">
                     <h3 class="font-bold mb-2 text-xl">Profile Picture and Cover Image</h3>
                     <p class=""> This information will be dispalyed publicly so be carful what you share. </p>
                     <form>
                        <div class="lg:px-10 flex-1 space-y-4 ">
                           <div uk-form-custom="" class="w-full py-3 uk-form-custom">
                              <label for="">Upload Profile Picture </label>
                              <div class="bg-gray-100 border-2 border-dashed flex flex-col h-32 items-center justify-center relative w-full rounded-lg dark:bg-gray-800 dark:border-gray-600">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-12">
                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                    <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                                 </svg>
                              </div>
                              <input type="file">
                           </div>
                        </div>
                        <div class="lg:px-10 flex-1 space-y-4 ">
                           <div uk-form-custom="" class="w-full py-3 uk-form-custom">
                              <label for="">Upload Cover Picture </label>
                              <div class="bg-gray-100 border-2 border-dashed flex flex-col h-32 items-center justify-center relative w-full rounded-lg dark:bg-gray-800 dark:border-gray-600">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-12">
                                    <path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path>
                                    <path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path>
                                 </svg>
                              </div>
                              <input type="file">
                           </div>
                        </div>
                     </form>
                  </div>
                  <!-- form body -->
                  <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                     <button class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </button>
                     <button type="button" class="button bg-blue-700"> Save </button>
                  </div>
               </div>
            </div>                    
                                
            <div id="tab-3" class="tab-content lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <div class="lg:px-10 lg:py-4">
                     <h3 class="font-bold mb-2 text-xl"> Profile Question</h3>
                     <p class=""> This information will be dispalyed publicly so be carful what you share. </p>
                  </div>
                  <!-- form body -->
                  <form>
                     <div class="lg:py-4 lg:px-10 flex-1 space-y-4 ">
                        <h3>What is the name of your church?</h3>
                        <div class="line">
                           <input class="line__input" type="text"  ng-model="questionData.q1" ng-class="(questionDataCheck==true && isNullOrEmptyOrUndefined(questionData.q1)==true)? 'redBorder' : ''">
                        </div>

                        <h3>What is the name of the Pastor?</h3>
                        <div class="line">
                           <input class="line__input" type="text"  ng-model="questionData.q2" ng-class="(questionDataCheck==true && isNullOrEmptyOrUndefined(questionData.q2)==true)? 'redBorder' : ''">
                        </div>

                        <h3>Do you have a denomination affiliation?</h3>
                        <div class="line">
                           <input class="line__input" type="text"  ng-model="questionData.q3" ng-class="(questionDataCheck==true && isNullOrEmptyOrUndefined(questionData.q3)==true)? 'redBorder' : ''">
                        </div>

                        <h3>What are your service times?</h3>
                        <div class="line">
                           <input class="line__input" type="text"  ng-model="questionData.q4" ng-class="(questionDataCheck==true && isNullOrEmptyOrUndefined(questionData.q4)==true)? 'redBorder' : ''">
                        </div>

                        <h3>Please provide us with information of your church founder?</h3>
                        <div class="line">
                           <input class="line__input" type="text"  ng-model="questionData.q5" ng-class="(questionDataCheck==true && isNullOrEmptyOrUndefined(questionData.q5)==true)? 'redBorder' : ''">
                        </div>

                        <h3>How many ministries do you have?</h3>
                        <div class="line">
                           <input class="line__input" type="text"  ng-model="questionData.q6" ng-class="(questionDataCheck==true && isNullOrEmptyOrUndefined(questionData.q6)==true)? 'redBorder' : ''">
                        </div>

                        <h3>Would your Pastor be interested in taking speaking engagements?</h3>
                        <div class="line">
                           <input class="line__input" type="text"  ng-model="questionData.q7" ng-class="(questionDataCheck==true && isNullOrEmptyOrUndefined(questionData.q7)==true)? 'redBorder' : ''">
                        </div>

                     </div>
                  </form>
                  <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                     <button type="button" ng-click="submitQuestionData()" class="zsubmitQuestionDataz button bg-blue-700"> Save </button>
                  </div>
               </div>
            </div>                                 
                                     
            <div id="tab-4" class="tab-content lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <div class="lg:px-10 lg:py-4">
                     <h3 class="font-bold mb-2 text-xl"> Password</h3>
                     <p class=""> This information will be dispalyed publicly so be carful what you share. </p>
                  </div>
                  <!-- form body -->
                  <form>
                     <div class="lg:py-4 lg:px-10 flex-1 space-y-4 ">
                        <div class="line">
                           <input class="line__input" id="password" autocomplete="off" name="password" type="text" onKeyUp="this.setAttribute('value', this.value);" value="">
                           <span for="username" class="line__placeholder"> Current Password   </span>
                        </div>
                        <div class="line">
                           <input class="line__input" id="password" autocomplete="off" name="password" type="text" onKeyUp="this.setAttribute('value', this.value);" value="">
                           <span for="username" class="line__placeholder"> New Password </span>
                        </div>
                        <div class="line">
                           <input class="line__input" id="password" autocomplete="off" name="password" type="text" onKeyUp="this.setAttribute('value', this.value);" value="">
                           <span for="username" class="line__placeholder">Confirm Password </span>
                        </div>
                     </div>
                  </form>
                  <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                     <button class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </button>
                     <button type="button" class="button bg-blue-700"> Save </button>
                  </div>
               </div>
            </div>                    

            <div id="tab-5" class="tab-content lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <div class="lg:px-10 lg:py-4">
                     <h3 class="font-bold mb-2 text-xl">  Create Groups</h3>
                     <p class=""> This information will be dispalyed publicly so be carful what you share. </p>
                  </div>
                  <!-- form body -->
                  <form>
                     <div class="lg:py-4 lg:px-10 flex-1 space-y-4 ">
                        <div class="line">
                           <input class="line__input" id="password" autocomplete="off" name="password" type="text" onKeyUp="this.setAttribute('value', this.value);" value="">
                           <span for="username" class="line__placeholder"> Group Name   </span>
                        </div>
                        <div class="line h-32"> 
                           <textarea class="line__input h-32"  id="" name="" type="text" onKeyUp="this.setAttribute('value', this.value);" value="" autocomplete="off"></textarea>
                           <span for="username" class="line__placeholder"> Group description </span> 
                        </div>
                        <div class="px-2 space-y-2">
                           <label for="" class="font-semibold text-base"> Choose Privacy </label> 
                           <div> Anyone can see who's in the group and what they post. </div>
                           <select id="" name=""  class="shadow-none selectpicker with-border">
                              <option data-icon="uil-bullseye"> Private </option>
                              <option data-icon="uil-chat-bubble-user">My Following</option>
                              <option data-icon="uil-globe" selected>Puplic</option>
                           </select>
                        </div>
                     </div>
                  </form>
                  <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                     <button class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </button>
                     <button type="button" class="button bg-blue-700"> Create Now </button>
                  </div>
               </div>
            </div>                           

            <div id="tab-6" class="tab-content lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <form>
                     <div class="max-w-2xl m-auto shadow-md rounded-md bg-white">
                        <!-- form header -->
                        <div class="text-center border-b border-gray-100 py-6">
                           <h3 class="font-bold text-xl"> Create New Page </h3>
                        </div>
                        <!-- form body -->
                        <div class="p-5 space-y-7">
                           <div class="line">
                              <input class="line__input" id="" name="" type="text" onKeyUp="this.setAttribute('value', this.value);" value="" autocomplete="off">
                              <span for="username" class="line__placeholder"> Page Name </span>
                           </div>
                           <div class="flex items-center">
                              <div class="-mr-1 bg-gray-100 border px-3 py-3 rounded-l-md">  https://christtube.com/   </div>
                              <input type="text" class="with-border" placeholder="">
                           </div>
                           <div>
                              <label for=""> Page Category </label>
                              <select id="" name="" class="shadow-none selectpicker with-border ">
                                 <option value="1">Church Information</option>
                                 <option value="2"> Statement of faith </option>
                                 <option value="3"> Church Members </option>
                                 <option value="4"> Our Connections </option>
                                 <option value="5"> Core Value </option>
                                 <option value="6">Our Pastor</option>
                                 <option value="7"> Our Leaderships</option>
                              </select>
                           </div>
                           <div class="line h-32"> 
                              <textarea class="line__input h-32" id="" name="" type="text" onKeyUp="this.setAttribute('value', this.value);" value="" autocomplete="off"></textarea>
                              <span for="username" class="line__placeholder"> Page description </span> 
                           </div>
                        </div>
                        <!-- form footer -->
                        <div class="border-t flex justify-between lg:space-x-10 p-7 bg-gray-50 rounded-b-md">
                           <p class="text-sm leading-6"> You can add images, contact info and other details after you create the Page. </p>
                           <button type="button" class="button lg:w-1/2">
                           Create Now
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>    
                
            <div id="tab-7" class="tab-content lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <div class="lg:px-10 lg:py-4">
                     <h3 class="font-bold mb-2 text-xl"> Security</h3>
                     <p class=""> This information will be dispalyed publicly so be carful what you share. </p>
                  </div>
                  <!-- form body -->
                  <div class="bg-white rounded-md lg:shadow-md shadow">
                     <div class="space-y-4 p-6">
                        <div class="flex justify-between items-center">
                           <div>
                              <h4> Who can follow me ?</h4>
                              <div> Everyone can follow me </div>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4> Show my activities  </h4>
                              <div> Show my all activity in my profile </div>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox"><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4> Encrypted notification emails </h4>
                              <div> Add extra security to notification emails from Facebook (only you can decrypt these emails) </div>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4> Allow Commenting </h4>
                              <div> Only Fiernds and members can comment on post </div>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox"><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                     <button class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </button>
                     <button type="button" class="button bg-blue-700"> Save </button>
                  </div>
               </div>
            </div>                        
                                
            <div id="tab-8" class="tab-content lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <div class="lg:px-10 lg:py-4">
                     <h3 class="font-bold mb-2 text-xl">  Privacy Settings</h3>
                     <p class=""> This information will be dispalyed publicly so be carful what you share. </p>
                  </div>
                  <!-- form body -->
                  <div class="bg-white rounded-md lg:shadow-md shadow">
                     <div class="space-y-4 p-6">
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Who can see your future posts?</h4>
                              <div>Public</div>
                              <div hidden>
                                 <select id="alert" name="alert"  class="shadow-none selectpicker with-border ">
                                    <option value="0">Public</option>
                                    <option value="1">Firends</option>
                                    <option value="2">Members</option>
                                    <option value="3">Groups</option>
                                    <option value="3">Only Me</option>
                                 </select>
                              </div>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <div><a href="">Edit</a></div>
                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Who can see the people, Pages and lists you follow?</h4>
                              <div>Public</div>
                              <div hidden>
                                 <select id="alert" name="alert"  class="shadow-none selectpicker with-border ">
                                    <option value="0">Public</option>
                                    <option value="1">Firends</option>
                                    <option value="2">Members</option>
                                    <option value="3">Groups</option>
                                    <option value="3">Only Me</option>
                                 </select>
                              </div>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <div><a href="">Edit</a></div>
                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Who can send you friend requests?</h4>
                              <div>Public</div>
                              <div hidden>
                                 <select id="alert" name="alert"  class="shadow-none selectpicker with-border ">
                                    <option value="0">Public</option>
                                    <option value="1">Firends</option>
                                    <option value="2">Members</option>
                                    <option value="3">Groups</option>
                                    <option value="3">Only Me</option>
                                 </select>
                              </div>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <div><a href="">Edit</a></div>
                              </div>
                           </div>
                        </div>
                        <hr>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Who can look you up using the email address or location you provided?</h4>
                              <div>Public</div>
                              <div hidden>
                                 <select id="alert" name="alert"  class="shadow-none selectpicker with-border ">
                                    <option value="0">Public</option>
                                    <option value="1">Firends</option>
                                    <option value="2">Members</option>
                                    <option value="3">Groups</option>
                                    <option value="3">Only Me</option>
                                 </select>
                              </div>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <div><a href="">Edit</a></div>
                              </div>
                           </div>
                        </div>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Who can look you up data of birth you provided?</h4>
                              <div>Public</div>
                              <div hidden>
                                 <select id="alert" name="alert"  class="shadow-none selectpicker with-border ">
                                    <option value="0">Public</option>
                                    <option value="1">Firends</option>
                                    <option value="2">Members</option>
                                    <option value="3">Groups</option>
                                    <option value="3">Only Me</option>
                                 </select>
                              </div>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <div><a href="">Edit</a></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                     <button class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </button>
                     <button type="button" class="button bg-blue-700"> Save </button>
                  </div>
               </div>
            </div>

            <div id="tab-9" class="tab-content lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <div class="lg:px-10 lg:py-4">
                     <h3 class="font-bold mb-2 text-xl"> Notifications and Settings</h3>
                     <p class=""> This information will be dispalyed publicly so be carful what you share. </p>
                  </div>
                  <!-- form body -->
                  <div class="lg:py-4 lg:px-10 flex-1 space-y-4 ">
                     <div class="relative cursor-pointer" uk-toggle="target: #comment; animation: uk-animation-fade">
                        <div class="bg-gray-50 rounded-lg px-5 py-4 font-semibold text-base"> Comments<br>
                           <label class="">Push, emails, SMS</label>
                        </div>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-up right-4 text-xl top-1/2 transform text-gray-400   " id="comment" aria-hidden="true" style="" hidden=""></i>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-down right-4 text-xl top-1/2 transform text-gray-400  " id="comment" aria-hidden="false" style=""></i>
                     </div>
                     <div class=" m-0 sm:space-y-8 space-y-4 p-5" id="comment" aria-hidden="false" style="" hidden="">
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Email</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Push</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="lg:py-4 lg:px-10 flex-1 space-y-4 ">
                     <div class="relative cursor-pointer" uk-toggle="target: #people; animation: uk-animation-fade">
                        <div class="bg-gray-50 rounded-lg px-5 py-4 font-semibold text-base"> People you may know<br>
                           <label class="">Push, emails, SMS</label>
                        </div>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-up right-4 text-xl top-1/2 transform text-gray-400   " id="people" aria-hidden="true" style="" hidden=""></i>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-down right-4 text-xl top-1/2 transform text-gray-400  " id="people" aria-hidden="false" style=""></i>
                     </div>
                     <div class=" m-0 sm:space-y-8 space-y-4 p-5" id="people" aria-hidden="false" style="" hidden="">
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Email</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Push</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="lg:py-4 lg:px-10 flex-1 space-y-4 ">
                     <div class="relative cursor-pointer" uk-toggle="target: #birthdays; animation: uk-animation-fade">
                        <div class="bg-gray-50 rounded-lg px-5 py-4 font-semibold text-base"> Birthdays<br>
                           <label class="">Push, emails, SMS</label>
                        </div>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-up right-4 text-xl top-1/2 transform text-gray-400   " id="birthdays" aria-hidden="true" style="" hidden=""></i>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-down right-4 text-xl top-1/2 transform text-gray-400  " id="birthdays" aria-hidden="false" style=""></i>
                     </div>
                     <div class=" m-0 sm:space-y-8 space-y-4 p-5" id="birthdays" aria-hidden="false" style="" hidden="">
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Email</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Push</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="lg:py-4 lg:px-10 flex-1 space-y-4 ">
                     <div class="relative cursor-pointer" uk-toggle="target: #events; animation: uk-animation-fade">
                        <div class="bg-gray-50 rounded-lg px-5 py-4 font-semibold text-base"> Events<br>
                           <label class="">Push, emails, SMS</label>
                        </div>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-up right-4 text-xl top-1/2 transform text-gray-400   " id="events" aria-hidden="true" style="" hidden=""></i>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-down right-4 text-xl top-1/2 transform text-gray-400  " id="events" aria-hidden="false" style=""></i>
                     </div>
                     <div class=" m-0 sm:space-y-8 space-y-4 p-5" id="events" aria-hidden="false" style="" hidden="">
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Email</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Push</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                     <button class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </button>
                     <button type="button" class="button bg-blue-700"> Save </button>
                  </div>
               </div>
            </div>         

            <div id="tab-10" class="tab-content lg:w-2/3">
               <div class="lg:flex lg:flex-col justify-between lg:h-full">
                  <!-- form header -->
                  <div class="lg:px-10 lg:py-4">
                     <h3 class="font-bold mb-2 text-xl">Delete account</h3>
                     <p class=""> This information will be dispalyed publicly so be carful what you share. </p>
                  </div>
                  <!-- form body -->
                  <div class="lg:py-4 lg:px-10 flex-1 space-y-4 ">
                     <div class="relative cursor-pointer" uk-toggle="target: #acc; animation: uk-animation-fade">
                        <div class="bg-gray-50 rounded-lg px-5 py-4 font-semibold text-base"> Events<br>
                           <label class="">Push, emails, SMS</label>
                        </div>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-up right-4 text-xl top-1/2 transform text-gray-400   " id="acc" aria-hidden="true" style="" hidden=""></i>
                        <i class="-translate-y-1/2 absolute icon-feather-chevron-down right-4 text-xl top-1/2 transform text-gray-400  " id="acc" aria-hidden="false" style=""></i>
                     </div>
                     <div class=" m-0 sm:space-y-8 space-y-4 p-5" id="acc" aria-hidden="false" style="" hidden="">
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>In Active Account</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                        <div class="flex justify-between items-center">
                           <div>
                              <h4>Delete Account</h4>
                           </div>
                           <div class="switches-list -mt-8 is-large">
                              <div class="switch-container">
                                 <label class="switch"><input type="checkbox" checked><span class="switch-button"></span> </label>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                     <button class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </button>
                     <button type="button" class="button bg-blue-700"> Save </button>
                  </div>
               </div>
            </div>        
            
        </div>

    </div>
</div>

<script type="text/javascript">
$(document).ready(function()
{
   $('ul.tabs li').click(function()
   {
      var tab_id = $(this).attr('data-tab');
      $('ul.tabs li').removeClass('current');
      $('.tab-content').removeClass('current');

      $(this).addClass('current');
      $("#"+tab_id).addClass('current');
   })
})
</script>
