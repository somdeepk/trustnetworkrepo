<section class="sign-in-page" ng-controller="signupController">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-md-6 text-center">
                        <div class="sign-in-detail text-white">
                            <a class="sign-in-logo" href="#"><img src="<?php echo base_url();?>assets/images/logo-full.png" class="img-fluid" alt="logo"></a>
                            <p style="color:#000;">Successful ministry in the 21st Century is evolving at a rapid rate. We believe it will take a delicate combination of both technolgy and biblical teaching to continuing growing body the body of Christ and the individuals who attend the local church.</p>
                            <p  style="color:#000;"><em style="color:#0391c0; font-weight:400;">The FOLLOW ME NOW-Making Disciples</em> web-based six-month module systems help churches disciple individuals.</p>
                        </div>

                    </div>
                    <div class="col-md-6 bg-white">
                        <div class="sign-in-from">
                            <h8 class="mb-0">Sign Up</h8>
                            <form class="mt-4">
                            
                                <div class="form-group">
                                    <select ng-model="signupData.membership_type" id="membership_type" class="form-control mb-0">
                                    <option value="">Select Membership</option>
                                    <option value="RM">Free Membership</option>
                                    <option value="CC">City Church</option>
                                    <option value="CM">Church Membership</option>
                                    </select>
                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.membership_type)==true)? 'Membership Type Required' : ''}}</div>
                                </div>

                                <div class="form-group" ng-if="signupData.membership_type=='RM'">
                                    <select ng-model="signupData.church_id" id="church_id" class="form-control form-control-primary">
                                        <option value="">Select Church</option>
                                        <?php 
                                        if(count($all_church_data)>0)
                                        {
                                            foreach($all_church_data as $k=>$v)
                                            {
                                        ?>
                                                <option value="<?php echo $v['id']; ?>"><?php echo $v['first_name']; ?></option>
                                        <?php 
                                            }
                                        }
                                        ?>
                                    </select>

                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && signupData.membership_type=='RM' && isNullOrEmptyOrUndefined(signupData.church_id)==true)? 'Church Required' : ''}}</div>
                                </div>
                                <div class="form-group" ng-if="signupData.membership_type=='CM'">
                                    <input type="text" ng-model="signupData.church_name" id="church_name" class="form-control mb-0" placeholder="Enter Church Name">

                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && signupData.membership_type=='CM' && isNullOrEmptyOrUndefined(signupData.church_name)==true)? 'Church name Required' : ''}}</div>                                    
                                </div>                                
                                
                                <div class="form-group" ng-if="(signupData.membership_type=='RM' || signupData.membership_type=='CC')">
                                    <input type="text" ng-model="signupData.first_name" id="first_name" class="form-control mb-0" placeholder="Your First Name">

                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && ( signupData.membership_type=='RM' || signupData.membership_type=='CC') && isNullOrEmptyOrUndefined(signupData.first_name)==true)? 'First Name Required' : ''}}</div>

                                </div>
                                <div class="form-group" ng-if="(signupData.membership_type=='RM' || signupData.membership_type=='CC')">
                                    <input type="text" ng-model="signupData.last_name" id="last_name"class="form-control mb-0" placeholder="Your Last Name">
                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && (signupData.membership_type=='RM' || signupData.membership_type=='CC') && isNullOrEmptyOrUndefined(signupData.last_name)==true)? 'Last Name Required' : ''}}</div>
                                </div>

                                <div class="form-group" ng-if="(signupData.membership_type=='RM' || signupData.membership_type=='CC')">
                                    <select ng-model="signupData.gender" id="gender" class="form-control mb-0">
                                        <option value="">Select Gender</option>
                                        <option value="M">Male</option>
                                        <option value="F">Female</option>
                                        <option value="T">Transgender</option>
                                   </select>

                                   <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && (signupData.membership_type=='RM' || signupData.membership_type=='CC') && isNullOrEmptyOrUndefined(signupData.gender)==true)? 'Gender Required' : ''}}</div>

                                </div>

                                <div class="form-group" ng-if="(signupData.membership_type=='RM' || signupData.membership_type=='CC')">
                                    <input type="text" ng-model="signupData.dob" id="dob" class="form-control mb-0" readonly="true" placeholder="Date Of Birth" dobdatesignup>
                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && (signupData.membership_type=='RM' || signupData.membership_type=='CC') && isNullOrEmptyOrUndefined(signupData.dob)==true)? 'Date Of Birth Required' : ''}}</div>
                                </div>



                                <div class="form-group">
                                    <input type="text" ng-model="signupData.user_email" id="user_email" class="form-control mb-0" placeholder="Enter email" emailvalidate>
                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.user_email)==true)? 'Email Required' : ''}}</div>
                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(InvalidEmailCheck==true)? 'Invalid Email' : ''}}</div>
                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataEmailDupCheck==true)? 'This Email already Exist' : ''}}</div>
                                </div>
                                <div class="form-group">
                                    <input type="password" ng-model="signupData.password" id="password" maxlength="15" class="form-control mb-0" placeholder="Password">
                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.password)==true)? 'Password Required' : ''}}</div>
                                </div>

                                <div class="d-inline-block w-100">
                                    <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                                        <input type="checkbox" ng-model="signupData.toc" id="toc" class="custom-control-input">
                                        <label class="custom-control-label" for="toc">I accept <a href="#" >Terms and Conditions</a></label>
                                    </div>
                                    <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(signupDataCheck==true && isNullOrEmptyOrUndefined(signupData.toc)==true)? 'Please Accept  T&C' : ''}}</div>
                                    <button type="submit" class="btn btn-primary float-right"  ng-click="submitSignup();">Sign Up</button>
                                </div>
                                <div class="sign-info">
                                    <span class="dark-color d-inline-block line-height-2">Already Have Account ? <a href="<?php echo base_url();?>user/login">Log In</a></span>
                                    <ul class="iq-social-media">
                                        <li><a href="#"><i class="ri-facebook-box-line"></i></a></li>
                                        <li><a href="#"><i class="ri-google-line"></i></a></li>
                                        <li><a href="#"><i class="ri-twitter-line"></i></a></li>
                                        <li><a href="#"><i class="ri-instagram-line"></i></a></li>
                                    </ul>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</section>