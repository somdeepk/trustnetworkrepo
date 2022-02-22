<?php
if ($this->session -> userdata('email') == "" && $this->session -> userdata('login') != true)
{
  redirect('user/login');
}
?>
 <!-- Wrapper START -->
<div class="wrapper">

	<!-- Header -->
	<header>
	    <div class="header_wrap">
	        <div class="header_inner mcontainer">
	            <div class="left_side">

	                <span class="slide_menu" uk-toggle="target: #wrapper ; cls: is-collapse is-active">
	                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M3 4h18v2H3V4zm0 7h12v2H3v-2zm0 7h18v2H3v-2z" fill="currentColor"></path></svg>
	                </span>

	                <div id="logo">
	                    <a href="feed.html">
	                        <img src="<?php echo base_url();?>assets/images/logo-full.png" alt="">
	                        <img src="<?php echo base_url();?>assets/images/logo-full.png" class="logo_mobile" alt="">
	                    </a>
	                </div>
	            </div>

	          	<!-- search icon for mobile -->
	            <div class="header-search-icon" uk-toggle="target: #wrapper ; cls: show-searchbox"> </div>
	            <div class="header_search"><i class="uil-search-alt"></i>
	                <input value="" type="text" class="form-control" placeholder="Search for Friends , Videos and more.." autocomplete="off">
	                <div uk-drop="mode: click" class="header_search_dropdown">

	                    <h4 class="search_title"> Recently </h4>
	                    <ul>
	                        <li>
	                            <a href="#">
	                                <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="list-avatar">
	                                <div class="list-name">  Erica Jones </div>
	                            </a>
	                        </li>
	                        <li>
	                            <a href="#">
	                                <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="list-avatar">
	                                <div class="list-name">  Coffee  Addicts </div>
	                            </a>
	                        </li>
	                        <li>
	                            <a href="#">
	                                <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="list-avatar">
	                                <div class="list-name"> Mountain Riders </div>
	                            </a>
	                        </li>
	                        <li>
	                            <a href="#">
	                                <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="list-avatar">
	                                <div class="list-name"> Property Rent And Sale  </div>
	                            </a>
	                        </li>
	                        <li>
	                            <a href="#">
	                                <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="list-avatar">
	                                <div class="list-name">  Erica Jones </div>
	                            </a>
	                        </li>
	                    </ul>

	                </div>
	            </div>

	            <div class="right_side">

	                <div class="header_widgets">

	                    <a href="#" class="is_icon" uk-tooltip="title: Notifications">
	                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
	                        <span>3</span>
	                    </a>
	                    <div uk-drop="mode: click" class="header_dropdown">
	                         <div  class="dropdown_scrollbar" data-simplebar>
	                             <div class="drop_headline">
	                                 <h4>Notifications </h4>
	                                 <div class="btn_action">
	                                    <a href="#" data-tippy-placement="left" title="Notifications">
	                                        <ion-icon name="settings-outline"></ion-icon>
	                                    </a>
	                                    <a href="#" data-tippy-placement="left" title="Mark as read all">
	                                        <ion-icon name="checkbox-outline"></ion-icon>
	                                    </a>
	                                </div>
	                             </div>
	                             <ul>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar">
	                                             <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="">
	                                         </div>
	                                         <span class="drop_icon bg-gradient-primary">
	                                             <i class="icon-feather-thumbs-up"></i>
	                                         </span>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Adrian Mohani</strong> Like Your Comment On Video
	                                                <span class="text-link">Learn Prototype Faster </span>
	                                             </p>
	                                             <time> 2 hours ago </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li class="not-read">
	                                     <a href="#">
	                                         <div class="drop_avatar status-online"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="">
	                                         </div>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Stella Johnson</strong> Replay Your Comments in
	                                                <span class="text-link">Adobe XD Tutorial</span>
	                                             </p>
	                                             <time> 9 hours ago </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="">
	                                         </div>
	                                         <span class="drop_icon bg-gradient-primary">
	                                            <i class="icon-feather-thumbs-up"></i>
	                                        </span>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Alex Dolgove</strong> Added New Review In Video
	                                                <span class="text-link">Full Stack PHP Developer</span>
	                                             </p>
	                                             <time> 12 hours ago </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="">
	                                         </div>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Jonathan Madano</strong> Shared Your Discussion On Video
	                                                <span class="text-link">Css Flex Box </span>
	                                             </p>
	                                             <time> Yesterday </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="">
	                                         </div>
	                                         <span class="drop_icon bg-gradient-primary">
	                                            <i class="icon-feather-thumbs-up"></i>
	                                        </span>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Adrian Mohani</strong> Like Your Comment On Course
	                                                <span class="text-link">Javascript Introduction </span>
	                                             </p>
	                                             <time> 2 hours ago </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar status-online"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="">
	                                         </div>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Stella Johnson</strong> Replay Your Comments in
	                                                <span class="text-link">Programming for Games</span>
	                                             </p>
	                                             <time> 9 hours ago </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="">
	                                         </div>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Stella Johnson</strong> Replay Your Comments in
	                                                <span class="text-link">Programming for Games</span>
	                                             </p>
	                                             <time> 9 hours ago </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="">
	                                         </div>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Alex Dolgove</strong> Added New Review In Course
	                                                <span class="text-link">Full Stack PHP Developer</span>
	                                             </p>
	                                             <time> 12 hours ago </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="">
	                                         </div>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Jonathan Madano</strong> Shared Your Discussion On Course
	                                                <span class="text-link">Css Flex Box </span>
	                                             </p>
	                                             <time> Yesterday </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="">
	                                         </div>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Adrian Mohani</strong> Like Your Comment On Course
	                                                <span class="text-link">Javascript Introduction </span>
	                                             </p>
	                                             <time> 2 hours ago </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                                 <li>
	                                     <a href="#">
	                                         <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="">
	                                         </div>
	                                         <div class="drop_text">
	                                             <p>
	                                                <strong>Stella Johnson</strong> Replay Your Comments in
	                                                <span class="text-link">Programming for Games</span>
	                                             </p>
	                                             <time> 9 hours ago </time>
	                                         </div>
	                                     </a>
	                                 </li>
	                             </ul>
	                         </div>
	                    </div>

	                    <!-- Start Message Pop -->
	                    <a href="#" class="is_icon" uk-tooltip="title: Message">
	                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path></svg>
	                        <span>4</span>
	                    </a>
	                    <div uk-drop="mode: click" class="header_dropdown is_message">
	                        <div  class="dropdown_scrollbar" data-simplebar>
	                            <div class="drop_headline">
	                                 <h4>Messages </h4>
	                                <div class="btn_action">
	                                    <a href="#" data-tippy-placement="left" title="Notifications">
	                                        <ion-icon name="settings-outline" uk-tooltip="title: Message settings ; pos: left"></ion-icon>
	                                    </a>
	                                    <a href="#" data-tippy-placement="left" title="Mark as read all">
	                                        <ion-icon name="checkbox-outline"></ion-icon>
	                                    </a>
	                                </div>
	                            </div>
	                            <input type="text" class="uk-input" placeholder="Search in Messages">
	                            <ul>
	                                <li class="un-read">
	                                    <a href="#">
	                                        <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-7.jpg" alt="">
	                                        </div>
	                                        <div class="drop_text">
	                                            <strong> Stella Johnson </strong> <time>12:43 PM</time>
	                                            <p>  Alex will explain you how ...  </p>
	                                        </div>
	                                    </a>
	                                </li>
	                                <li>
	                                    <a href="#">
	                                        <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="">
	                                        </div>
	                                        <div class="drop_text">
	                                            <strong> Adrian Mohani </strong> <time> 6:43 PM</time>
	                                            <p> Thanks for The Answer sit amet...  </p>
	                                        </div>
	                                    </a>
	                                </li>
	                                <li>
	                                    <a href="#">
	                                        <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="">
	                                        </div>
	                                        <div class="drop_text">
	                                            <strong>Alia Dolgove </strong> <time> Wed </time>
	                                            <p>  Alia just joined Messenger!  </p>
	                                        </div>
	                                    </a>
	                                </li>
	                                <li>
	                                    <a href="#">
	                                        <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="">
	                                        </div>
	                                        <div class="drop_text">
	                                            <strong> Jonathan Madano </strong> <time> Sun</time>
	                                            <p>  Replay Your Comments insit amet consectetur </p>
	                                        </div>
	                                    </a>
	                                </li>
	                                <li class="un-read">
	                                    <a href="#">
	                                        <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="">
	                                        </div>
	                                        <div class="drop_text">
	                                            <strong> Stella Johnson </strong> <time>12:43 PM</time>
	                                            <p>  Alex will explain you how ...  </p>
	                                        </div>
	                                    </a>
	                                </li>
	                                <li>
	                                    <a href="#">
	                                        <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="">
	                                        </div>
	                                        <div class="drop_text">
	                                            <strong> Adrian Mohani </strong> <time> 6:43 PM</time>
	                                            <p> Thanks for The Answer sit amet...  </p>
	                                        </div>
	                                    </a>
	                                </li>
	                                <li>
	                                    <a href="#">
	                                        <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="">
	                                        </div>
	                                        <div class="drop_text">
	                                            <strong>Alia Dolgove </strong> <time> Wed </time>
	                                            <p>  Alia just joined Messenger!  </p>
	                                        </div>
	                                    </a>
	                                </li>
	                                <li>
	                                    <a href="#">
	                                        <div class="drop_avatar"> <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="">
	                                        </div>
	                                        <div class="drop_text">
	                                            <strong> Jonathan Madano </strong> <time> Sun</time>
	                                            <p>  Replay Your Comments insit amet consectetur </p>
	                                        </div>
	                                    </a>
	                                </li>
	                            </ul>
	                        </div>
	                        <a href="#" class="see-all"> See all in Messages</a>
	                    </div>
	                    <!-- End Message Pop -->


	                    <a href="#">
	                        <img ng-src="<?php echo IMAGE_URL;?>images/{{(loggedUserDataObj.profile_image  == '' || !loggedUserDataObj.profile_image )? 'member-no-imgage.jpg':'members/'+loggedUserDataObj.profile_image }}" class="is_avatar" alt="{{(loggedUserDataObj.membership_type=='PM')? loggedUserDataObj.first_name : loggedUserDataObj.first_name+' '+loggedUserDataObj.last_name}}" title="{{(loggedUserDataObj.membership_type=='PM')? loggedUserDataObj.first_name : loggedUserDataObj.first_name+' '+loggedUserDataObj.last_name}}">
	                    </a>
	                    <div uk-drop="mode: click;offset:5" class="header_dropdown profile_dropdown">

	                        <a  href="javascript:void(0);" class="user">
	                            <div class="user_avatar">
	                                <img ng-src="<?php echo IMAGE_URL;?>images/{{(loggedUserDataObj.profile_image  == '' || !loggedUserDataObj.profile_image )? 'member-no-imgage.jpg':'members/'+loggedUserDataObj.profile_image }}" alt="{{(loggedUserDataObj.membership_type=='PM')? loggedUserDataObj.first_name : loggedUserDataObj.first_name+' '+loggedUserDataObj.last_name}}">
	                            </div>
	                            <div class="user_name">
	                                <div>  {{(loggedUserDataObj.membership_type=='PM')? loggedUserDataObj.first_name : loggedUserDataObj.first_name+' '+loggedUserDataObj.last_name}} </div>
	                                <span> {{loggedUserDataObj.user_email}}</span>
	                            </div>
	                        </a>

	                        <a href="javascript:void(0);" ng-click="viewProfileSetting()">
	                            <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
	                            Profile Settings
	                        </a>
	                        <a href="javascript:void(0);" ng-click="viewProfileSetting('zTabPrivSettZ')">
	                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
	                                <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"  clip-rule="evenodd" />
	                            </svg>
	                            Privacy Settings
	                        </a>
	                        <a href="reportform.html">
	                            <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
	                            Report A Problem
	                        </a>
	                        <a href="activitylog.html" id="night-mode" class="btn-night-mode">
	                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
	                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
	                              </svg>
	                             Activity Log
	                        </a>
	                        <a href="<?php echo base_url();?>user/logout">
	                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
	                            </svg>
	                            Log Out
	                        </a>


	                    </div>

	                </div>

	            </div>
	        </div>
	    </div>
	</header>

	<!-- sidebar -->
	<div class="sidebar" ng-controller="menuController" ng-init="initiateMenuPointer('<?php echo $this->session->userdata('user_auto_id'); ?>');">
	    <div class="sidebar_inner" data-simplebar>
	        <ul>
	            <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);" > 
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-600"> 
	                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
	                </svg>
	                <span> Newsfeeds </span> </a> 
	            </li>
	            <li class="active-submenu"><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> 
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-yellow-500">
	                  <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"></path>
	                </svg> 
	                <span> Wall </span> </a> 
	                <ul>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);" ng-click="viewPostPages()">General Wall</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Prayer Wall</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Praise Report Wall</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Testimonial Wall</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">My Followers Wall</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Fans Wall</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Favourite Wall</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">My Church Members</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">My Virtual Church Members</a></li>
	                </ul>
	            </li>
	            
	            <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> 
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-green-500">
	                    <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
	                </svg>  <span>  Communication </span></a> 
	                 <ul>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Photos</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Events</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">News  </a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" ng-show="loggedUserDataObj.membership_type=='RM'" href="javascript:void(0);" ng-click="viewConnection('frndSgtn')">Friend Suggestion</a></li>

	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" ng-show="loggedUserDataObj.membership_type=='PM'" href="javascript:void(0);" ng-click="viewConnection('virtualMemberSgtn')">Virtual Member Suggestion</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" ng-show="loggedUserDataObj.membership_type=='PM'" href="javascript:void(0);" ng-click="viewConnection('chrchMemberSgtn')">Church Member Suggestion</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" ng-show="loggedUserDataObj.membership_type=='PM'" href="javascript:void(0);" ng-click="viewConnection('chrchSgtn')">Church Suggestion</a></li>

	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" ng-show="loggedUserDataObj.membership_type=='RM'" href="javascript:void(0);" ng-click="viewFriends('frndSgtn')">Friends</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" ng-show="loggedUserDataObj.membership_type=='PM'" href="javascript:void(0);" ng-click="viewFriends('chrchSgtn')">Connections</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" ng-show="loggedUserDataObj.membership_type=='PM'" href="javascript:void(0);" ng-click="viewFriends('virtualMemberSgtn')">Virtual Members</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" ng-show="loggedUserDataObj.membership_type=='PM'" href="javascript:void(0);" ng-click="viewFriends('chrchMemberSgtn')">Church Members</a></li>
	                </ul>
	            </li> 
	            <li id="more-veiw" ><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> 
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-500">
	                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
	                    <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
	                </svg>
	               <span> Mailbox</span> </a> 
	                <ul>
	                    <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Inbox</a></li>
	                    <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Compose</a></li>
	                    <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Sent</a></li>
	                    <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Trash</a></li>
	                </ul>
	            </li>
	            
	            <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-red-500">
	                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm8 8v2h1v-2h-1zm-2-2H7v4h6v-4zm2 0h1V9h-1v2zm1-4V5h-1v2h1zM5 5v2H4V5h1zm0 4H4v2h1V9zm-1 4h1v2H4v-2z" clip-rule="evenodd" />
	                </svg>
	                <span> Featured Apps</span></a> 
	                 <ul>
	                    <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Video Tube</a></li>
	                    <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Live Events</a></li>
	                    <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Audio Tube</a></li>
	                    <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Rhemes</a></li>
	                    <li><a class="blurMenu" ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">Donation</a></li>
	                </ul>  
	            </li> 
	            
	            <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> 
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-blue-500">
	                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
	                </svg><span> Groups </span></a> 
	                  <ul>
	                    <li ng-repeat="(key, value) in loggedUserDataObj.GroupData"><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">{{value.name}}</a></li>
	                </ul> 
	            </li>
	        </ul>
	        <ul class="side_links" data-sub-title="Security">

	           
	            <li><a href="feed.html"> <ion-icon name="settings-outline" class="side-icon"></ion-icon>  <span> Setting   </span> </a> 
	                <ul>
	                    <li><a href="javascript:void(0);" ng-click="viewProfileSetting()">Profile Settings</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);" ng-click="viewProfileSetting('zTabPrivSettZ')">Privacy Settings</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);" href="javascript:void(0);" ng-click="viewProfileSetting('zTabCrtGrpZ')">Create Groups</a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);" ng-click="viewProfileSetting('zTabNotifySettingZ')">Notifications and Settings</a></li>
	                </ul>
	            </li>
	            <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> <ion-icon name="document-outline" class="side-icon"></ion-icon> <span> Pages </span>  </a> 
	                <ul>
	                    <!-- <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> Statement of faith </a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> Church Information </a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> Church Members </a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> Our Connections </a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> Core Value </a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> Our Pastor </a></li>
	                    <li><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);"> Our Leaderships </a></li> -->
	                    <li ng-repeat="(key, value) in loggedUserDataObj.PageData"><a ng-class="(flagBlurMenu==1)? 'blurMenu':''" href="javascript:void(0);">{{value.name}}</a></li>
	                </ul>
	            </li>
	        </ul>

	        <div class="footer-links">
	            <a href="about.html">About</a>
	            <a href="privacypolicy.html">Privacy policy </a>
	            <a href="supportform.html">Support</a>
	            <a href="contact.html">Contact </a>
	            <a href="reportform.html">Report a problem</a>
	            <a href="term.html">Terms of service</a>
	        </div>
	    </div>
	    <!-- sidebar overly for mobile -->
	    <div class="side_overly" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></div>
	</div>
	
	<!-- Start  dynamicContentViewer --> 
	<div id="angularMainContent">