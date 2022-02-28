<section class="sign-in-page" ng-controller="loginController" ng-init="getLoginData();">
    <div class="container">
        <div class="sign-up-inner">
        <div class="row no-gutters">
            <div class="col-md-6 order-md-2 pt-0">
                <div class="sign-in-from">
                    <a class="sign-in-logo d-block d-md-none" href="javascript:void();"><img src="<?php echo base_url();?>assets/images/logo-full.png" class="img-fluid" alt="logo"></a>
                    <h2 class="mb-0"><strong>Forgot Password?</strong></h2>
                    <p>Enter your email address to reset password.</p>
                    <form class="mt-4">
                        <div class="form-group">
                            <div class="zjsonCookieRememberMez hiddenimportant"><?php echo $jsonCookieRememberMe; ?></div>

                            <label for="exampleInputEmail1">Email address</label>
                            <input class="form-control  mb-0" ng-model="loginData.email" id="email" placeholder="Enter email" type="text" emailvalidate>
                            <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(loginDataCheck==true && isNullOrEmptyOrUndefined(loginData.email)==true)? 'Email Required' : ''}}</div>

                            <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(loginDataInvalidCheck==true && isNullOrEmptyOrUndefined(invalidLoginMsg)==false)? 'This email is not registered!' : ''}}</div>
                            
                            <div class="col-md-12 padding-lr0" style="color:#20ab43;" >{{(loginDataInvalidCheck==true && isNullOrEmptyOrUndefined(successResetMsg)==false)? successResetMsg : ''}}</div>
                        </div>
                       
                        <div class="d-inline-block w-100">
                            <button type="button" class="btn btn-primary float-right" ng-click="resetPassword();">Reset Password</button>
                        </div>

                        <div class="sign-info">
                            <span class="dark-color d-inline-block line-height-2">Don't have an account? <a href="<?php echo base_url();?>user/signup"><strong>Sign up</strong></a></span>
                            <ul class="iq-social-media">
                                <li><a href="javascript:void();"><i class="ri-facebook-box-line"></i></a></li>
                                <li><a href="javascript:void();"><i class="ri-google-line"></i></a></li>
                                <li><a href="javascript:void();"><i class="ri-twitter-line"></i></a></li>
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