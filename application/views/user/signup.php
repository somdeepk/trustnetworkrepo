<div class="lg:flex max-w-5xl min-h-screen mx-auto p-6 py-10" ng-controller="signupController">
    <div class="flex flex-col items-center lg: lg:flex-row lg:space-x-10">
        <div class="lg:mb-12 flex-1 lg:text-left text-center">
            <img src="<?php echo base_url();?>assets/images/logo-full.png" alt="" class="lg:mx-0 lg:w-52 mx-auto w-40">
            <p class="font-medium lg:mx-0 md:text-2xl mt-6 mx-auto sm:w-3/4 text-xl"><span class="redtext">Christ</span><span class="blacktext">tube</span> Helps Christians Globally </p>
            <p class="leading-6"> To communicate their messages and faith in a 100% Christ - centered environment while advancing the kingdom of God.</p>
            <p class="font-medium lg:mx-0 md:text-2xl mt-6 mx-auto sm:w-3/4 text-xl">Register and get one account across all services</p>
        </div>
        <div ng-cloak class="lg:mt-0 lg:w-96 md:w-1/2 sm:w-2/3 mt-10 w-full bg-white shadow-lg rounded-lg">
            <form class="p-7 space-y-5">
            
                <div class="gap-5">
                    <div>
                        <select ng-model="signupData.membership_type" id="membership_type" ng-class="(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.membership_type)==true)? 'redBorder' : ''" ng-click="getMembershipOption('MR')" class="mt-2 mb-2 with-border ">
                            <option ng-repeat="(key, value) in obj_membership_type" value="{{key}}">{{value}}</option>
                        </select>
                    </div>
                    
                    
                    <div>
                        <select ng-model="signupData.membership_option" id="membership_option" ng-class="(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.membership_option)==true)? 'redBorder' : ''" class="mt-2 mb-2 with-border">
                            <option ng-repeat="(key, value) in obj_membership_option" value="{{key}}">{{value}}</option>
                        </select>

                    </div>
                    
                    <div>
                        <select ng-if="signupData.membership_type=='PM'" ng-class="(signupDataCheck==true && signupData.membership_type=='PM' && isNullOrEmptyOrUndefined(signupData.church_type)==true)? 'redBorder' : ''" ng-model="signupData.church_type" id="church_type" class="mt-2 mb-2 with-border">
                            <option value="">Select Churche Type</option>
                            <option value="Local Churche">Local Churches</option>
                            <option value="Local Ministrie">Local Ministries</option>
                            <option value="Global Ministries">Global Ministries</option>
                            <option value="Missions Group">Missions Group</option>
                            <option value="Churches">Churches</option>
                            <option value="Fellowships">Fellowships</option>
                            <option value="Conferences">Conferences</option>
                            <option value="Missions">Missions</option>
                            <option value="Para Church">Para Church</option>
                        </select>
                    </div>
                    
                    <div>
                        <input ng-if="signupData.membership_type=='PM'" type="text" ng-model="signupData.church_name" id="church_name" placeholder="Church Name" ng-class="(signupDataCheck==true && signupData.membership_type=='PM' && isNullOrEmptyOrUndefined(signupData.church_name)==true)? 'redBorder' : ''" maxlength="25" class="with-border mt-2 mb-2 pl-1">

                        <input ng-if="signupData.membership_type=='RM'" ng-model="signupData.first_name" id="first_name"  ng-class="(signupDataCheck==true && signupData.membership_type=='RM' && isNullOrEmptyOrUndefined(signupData.first_name)==true)? 'redBorder' : ''" type="text" placeholder="First Name" maxlength="25" class="with-border mt-2 mb-2 pl-1">

                        <input ng-if="signupData.membership_type=='RM'" ng-model="signupData.last_name" id="last_name" maxlength="25" ng-class="(signupDataCheck==true && signupData.membership_type=='RM' && isNullOrEmptyOrUndefined(signupData.last_name)==true)? 'redBorder' : ''" type="text" placeholder="Last Name" class="with-border mt-2 mb-2 pl-1">


                        <input type="text" placeholder="Phone Number"  ng-class="(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.mobile)==true)? 'redBorder' : ''" ng-model="signupData.mobile" id="mobile" autocomplete="off" maxlength="15"  phone-masking class="with-border mt-2 mb-2 pl-1"> <!-- mobileformat -->

                        <input type="text" placeholder="{{(signupData.membership_type=='PM')? 'Date of Establishment' : 'DOB'}}" autocomplete="off" readonly="true" ng-class="(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.dob)==true)? 'redBorder' : ''" ng-model="signupData.dob" id="dob" class="with-border mt-2 mb-2 bootCal " dobdatesignup>

                        <input type="text" placeholder="Email Id" ng-model="signupData.user_email" id="user_email" emailvalidate class="with-border mt-2 mb-2 pl-1" ng-class="(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.user_email)==true)? 'redBorder' : ''" maxlength="50">
                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(InvalidEmailCheck==true)? 'Invalid Email' : ''}}</div>
                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataEmailDupCheck==true)? 'This Email already Exist' : ''}}</div>

                        <input type="password" ng-model="signupData.password" id="password" ng-class="(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.password)==true)? 'redBorder' : ''" maxlength="10" class="with-border mt-2 mb-2 pl-1">

                    </div>
                </div>
                <p class="text-xs text-gray-400 pt-3">By clicking Sign Up, you agree to our
                    <a href="#" class="text-blue-500">Terms</a>, 
                    <a href="#">Data Policy</a> and 
                    <a href="#">Cookies Policy</a>. 
                     You may receive SMS Notifications from us and can opt out any time.
                </p>
                <div class="flex mt-10">
                    <button type="button" ng-click="submitSignup();" class="bg-blue-600 font-semibold mx-auto px-10 py-3 rounded-md ml-0 text-white">
                        Get Started
                    </button>
                </div>
            </form>
            <div class="pl-7 mb-5 text-sm"> <a href="<?php echo base_url();?>user/login" class="font-semibold hover:underline"> Login </a> if you registered login here </div>
        </div>
    </div>
</div>
