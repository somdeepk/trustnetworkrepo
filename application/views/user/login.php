<div class="lg:flex max-w-5xl min-h-screen mx-auto p-6 py-10" ng-controller="loginController" ng-init="getLoginData();">
    <div class="zjsonCookieRememberMez hiddenimportant"><?php echo $jsonCookieRememberMe; ?></div>
        <div class="flex flex-col items-center lg: lg:flex-row lg:space-x-10">
            
            <div class="lg:mb-12 flex-1 lg:text-left text-center">
                <img src="<?php echo base_url();?>assets/images/logo-full.png" alt="" class="lg:mx-0 lg:w-52 mx-auto w-40">
                <p class="font-medium lg:mx-0 md:text-2xl mt-6 mx-auto sm:w-3/4 text-xl"> Connect with friends and the world around you on <span class="redtext">Christ</span><span class="blacktext">tube</span>.</p>
                <p class="leading-6"> To communicate their messages and faith in a 100% Christ - centered environment while advancing the kingdom of God.</p>
            </div>
            <div class="lg:mt-0 lg:w-96 md:w-1/2 sm:w-2/3 mt-10 w-full">
                <form class="p-6 space-y-4 relative bg-white shadow-lg rounded-lg"> 

                    <input type="text" ng-class="(loginDataCheck==true && isNullOrEmptyOrUndefined(loginData.email)==true)? 'redBorder' : ''}}" placeholder="Email or Username" ng-model="loginData.email" id="email" emailvalidate class="with-border">

                    <input type="password" ng-model="loginData.password" id="password" ng-class="(loginDataCheck==true && isNullOrEmptyOrUndefined(loginData.password)==true)? 'Password Required' : ''" placeholder="Password" class="with-border">

                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(loginDataInvalidCheck==true)? invalidLoginMsg : ''}}</div>

                    <button type="button" ng-click="submitLogin();" class="bg-blue-600 font-semibold p-3 rounded-md text-center text-white w-full">
                        Log In
                    </button>

                   <!--  <input type="checkbox" class="custom-control-label" ng-model="loginData.remember_me" id="remember_me" ng-checked="loginData.remember_me == true" ng-value="false">
                    <label class="custom-control-label" for="remember_me">Remember Me</label> -->

                    <a href="#" class="text-blue-500 text-center block"> Forgot Password? </a>


                    <hr class="pb-3.5">
                    <div class="flex">
                        <a href="<?php echo base_url();?>user/signup" type="button" class="bg-green-600 hover:bg-green-500 hover:text-white font-semibold py-3 px-5 rounded-md text-center text-white mx-auto" uk-toggle>
                            Create New Account
                        </a>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm"> <a href="#" class="font-semibold hover:underline"> Create a Page </a> for a celebrity, band or business </div>
            </div>
    
        </div>
    </div>