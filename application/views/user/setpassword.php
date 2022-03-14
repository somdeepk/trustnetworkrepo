<div class="lg:flex max-w-5xl min-h-screen mx-auto p-6 py-10" ng-controller="loginController" ng-init="getLoginData();">
    <div class="zjsonCookieRememberMez hiddenimportant"><?php echo $jsonCookieRememberMe; ?></div>
        <div class="flex flex-col items-center lg: lg:flex-row lg:space-x-10">
            
            <div class="lg:mb-12 flex-1 lg:text-left text-center">
                <img src="<?php echo base_url();?>assets/images/logo-full.png" alt="" class="lg:mx-0 lg:w-52 mx-auto w-40">
                <p class="font-medium lg:mx-0 md:text-2xl mt-6 mx-auto sm:w-3/4 text-xl"> Connect with friends and the world around you on <span class="redtext">Christ</span><span class="blacktext">tube</span>.</p>
                <p class="leading-6"> To communicate their messages and faith in a 100% Christ - centered environment while advancing the kingdom of God.</p>
            </div>
            <div ng-cloak class="lg:mt-0 lg:w-96 md:w-1/2 sm:w-2/3 mt-10 w-full">
                <form class="p-6 space-y-4 relative bg-white shadow-lg rounded-lg"> 
                    
                    <div>
                        
                        <input type="hidden" name="email" id="email" ng-model="loginData.email" value="<?php echo $email;?>">

                        <input type="password" class="form-control mb-0" ng-model="loginData.new_password" id="new_password" placeholder="New Password">

                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >
                            {{(loginDataCheck==true && isNullOrEmptyOrUndefined(loginData.new_password)==true)? 'New Password Required' : ''}}
                        </div>

                        <input type="password" class="form-control mb-0" ng-model="loginData.confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password">

                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >
                            
                            {{(loginDataCheck==true && isNullOrEmptyOrUndefined(loginData.confirm_new_password)==true)? 'Confirm New Password Required' : ''}}

                            {{(loginDataCheck==true && isNullOrEmptyOrUndefined(loginData.confirm_new_password)!=true && loginData.new_password!=loginData.confirm_new_password)? 'New Password and Confirm Password Mismatched' : ''}}

                            {{(loginDataCheck==true && isNullOrEmptyOrUndefined(loginData.confirm_new_password)!=true && loginData.new_password==loginData.confirm_new_password && loginData.confirm_new_password.length<6)? 'Minimum Password length is 6 characters' : ''}}

                            {{(loginDataInvalidCheck==true)? invalidLoginMsg : ''}}

                            {{(notComplexPassword==true)? complexPasswordMsg : ''}}

                        </div>
                                               
                        <button type="button" ng-click="setNewPassword();" class="bg-blue-600 font-semibold p-3 rounded-md text-center text-white w-full" style="margin-top: 10px">
                            Set New Password
                        </button>

                    </div>
                  
                    <hr class="pb-3.5">
                    <div class="flex">
                        <a href="<?php echo base_url();?>user/login" type="button" class="bg-green-600 hover:bg-green-500 hover:text-white font-semibold py-3 px-5 rounded-md text-center text-white mx-auto" uk-toggle>
                            Log In
                        </a>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm"> <a href="#" class="font-semibold hover:underline"> Create a Page </a> for a celebrity, band or business </div>
            </div>
    
        </div>
    </div>