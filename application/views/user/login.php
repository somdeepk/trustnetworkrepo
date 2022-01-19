<section class="sign-in-page" ng-controller="loginController" ng-init="getLoginData();">
    <div class="container">
        <div class="sign-up-inner">
        <div class="row no-gutters">
            <div class="col-md-6 order-md-2 pt-0">
                <div class="sign-in-from">
                    <a class="sign-in-logo d-block d-md-none" href="javascript:void();"><img src="<?php echo base_url();?>assets/images/logo-full.png" class="img-fluid" alt="logo"></a>
                    <h2 class="mb-0"><strong>Sign in</strong></h2>
                    <p>Enter your email address and password to access admin panel.</p>
                    <form class="mt-4">
                        <div class="form-group">
                            <div class="zjsonCookieRememberMez hiddenimportant"><?php echo $jsonCookieRememberMe; ?></div>

                            <label for="exampleInputEmail1">Email address</label>
                            <input class="form-control  mb-0" ng-model="loginData.email" id="email" placeholder="Enter email" type="text" emailvalidate>
                            <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(loginDataCheck==true && isNullOrEmptyOrUndefined(loginData.email)==true)? 'Email Required' : ''}}</div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <a href="javascript:void();" class="float-right"><strong>Forgot password?</strong></a>
                            <input type="password" class="form-control mb-0" ng-model="loginData.password" id="password" placeholder="Password">
                            <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(loginDataCheck==true && isNullOrEmptyOrUndefined(loginData.password)==true)? 'Password Required' : ''}}</div>


                            <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(loginDataInvalidCheck==true)? invalidLoginMsg : ''}}</div>
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                <input type="checkbox" class="custom-control-input" ng-model="loginData.remember_me" id="remember_me" ng-checked="loginData.remember_me == true" ng-value="false">
                                <label class="custom-control-label" for="remember_me">Remember Me</label>
                            </div>
                            <button type="button" class="btn btn-primary float-right" ng-click="submitLogin();">Sign in</button>
                        </div>
                        <div class="sign-info">
                            <span class="dark-color d-inline-block line-height-2">Don't have an account? <a href="<?php echo base_url();?>user/signup"><strong>Sign up</strong></a></span>
                            <ul class="iq-social-media">
                                <li><a href="javascript:void();"><i class="ri-facebook-box-line"></i></a></li>
                                <li><a href="javascript:void();"><i class="ri-google-line"></i></a></li>
                                <li><a href="javascript:void();"><i class="ri-twitter-line"></i></a></li>
                                <!-- <li><a href="javascript:void();"><i class="ri-instagram-line"></i></a></li> -->
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="sign-in-detail text-white">
                    <a class="sign-in-logo d-none d-md-block" href="javascript:void();"><img src="<?php echo base_url();?>assets/images/logo-full.png" class="img-fluid" alt="logo"></a>
                    <p style="color:#000;">Successful ministry in the 21st Century is evolving at a rapid rate. We believe it will take a delicate combination of both technolgy and biblical teaching to continuing growing body the body of Christ and the individuals who attend the local church.</p>
                    <p  style="color:#000;"><em style="color:#0391c0; font-weight:400;">The FOLLOW ME NOW-Making Disciples</em> web-based six-month module systems help churches disciple individuals.</p>
                    
                </div>
            </div>
            
        </div>
    </div>
    </div>
</section>