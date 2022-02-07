<!-- Main Contents -->
<div class="main_content">
        <div class="mcontainer">
        <div class="uk-switcher lg:mt-0 mt-0" id="timeline-tab" style="touch-action: pan-y pinch-zoom;">
            <!-- Timeline -->
            <div class="md:flex md:space-x-1 lg:mx-2 uk-active">                            
                <div class="space-y-5 flex-shrink-0 lg:w-4/6 lg:px-5 space-y-7">
                    <div class="text-2xl">General Wall</div>
                   <!-- create post  -->
                   <div class="card lg:mx-0 p-4" uk-toggle="target: #create-post-modal">
                       <div class="flex space-x-3">
                           <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" class="w-10 h-10 rounded-full">
                           <input placeholder="What's Your Mind ? Hamse!" class="bg-gray-100 hover:bg-gray-200 flex-1 h-10 px-6 rounded-full"> 
                       </div>
                       <div class="grid grid-flow-col pt-3 -mx-1 -mb-1 font-semibold text-sm">
                            <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                                <svg class="bg-blue-100 h-9 mr-2 p-1.5 rounded-full text-blue-600 w-9 -my-0.5 hidden lg:block" data-tippy-placement="top" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-tippy="" data-original-title="Tooltip">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Photo/Video 
                            </div>
                            <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                                <svg class="bg-green-100 h-9 mr-2 p-1.5 rounded-full text-green-600 w-9 -my-0.5 hidden lg:block" uk-tooltip="title: Messages ; pos: bottom ;offset:7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" title="" aria-expanded="false"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                Tag Friend 
                            </div>
                            <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                                <svg class="bg-red-100 h-9 mr-2 p-1.5 rounded-full text-red-600 w-9 -my-0.5 hidden lg:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Fealing /Activity 
                            </div>
                       </div> 
                   </div>
           
                   <div class="card lg:mx-0 uk-animation-slide-bottom-small">
           
                       <!-- post header-->
                       <div class="flex justify-between items-center lg:p-4 p-2.5">
                           <div class="flex flex-1 items-center space-x-4">
                               <a href="#">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                               </a>
                               <div class="flex-1 font-semibold capitalize">
                                   <a href="#" class="text-black dark:text-gray-100"> Johnson smith </a>
                                   <div class="text-gray-700 flex items-center space-x-2"> 5 <span>Hrs Ago Shared By Dennis Han </span> <ion-icon name="people" role="img" class="md hydrated" aria-label="people"></ion-icon></div>
                               </div>
                           </div>
                         <div>
                           <a href="#" aria-expanded="false"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                           <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 uk-drop" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                         
                               <ul class="space-y-1">
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-share-alt mr-1"></i> Share
                                     </a> 
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-comment-slash mr-1"></i>   Disable comments
                                     </a> 
                                 </li> 
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-favorite mr-1"></i>  Add favorites 
                                     </a> 
                                 </li>
                                 <li>
                                   <hr class="-mx-2 my-2 dark:border-gray-800">
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                      <i class="uil-trash-alt mr-1"></i>  Hide
                                     </a> 
                                 </li>
                               </ul>
                           
                           </div>
                         </div>
                       </div>
                       <div class="p-5 pt-0 border-b dark:border-gray-700">
           
                           Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim laoreet dolore magna aliquam erat volutpat
           
                       </div>
           
                       <div uk-lightbox="">
                           <a href="assets/images/avatars/avatar-lg-3.jpg">  
                               <img src="<?php echo base_url();?>assets/images/avatars/avatar-lg-4.jpg" alt="" class="max-h-96 w-full object-cover">
                           </a>
                       </div>
                       
           
                       <div class="p-4 space-y-3"> 
                          
                           <div class="flex space-x-4 lg:font-bold">
                               <a href="#" class="flex items-center space-x-2">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                       </svg>
                                   </div>
                                   <div> Bless</div>
                               </a>
                               <a href="#" class="flex items-center space-x-2">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                                       </svg>
                                   </div>
                                   <div> Comment</div>
                               </a>
                               <a href="#" class="flex items-center space-x-2 flex-1 justify-end">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                                       </svg>
                                   </div>
                                   <div> Share</div>
                               </a>
                           </div>
                           <div class="flex items-center space-x-3 pt-2"> 
                               <div class="flex items-center">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                               </div>
                               <div class="dark:text-gray-100">
                                   Blessed<strong> Johnson</strong> and <strong> 209 Others </strong>
                               </div>
                           </div>
           
                           <div class="border-t py-4 space-y-4 dark:border-gray-600">
                               <div class="flex">
                                   <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                       <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                                   </div>
                                   <div>
                                       <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                           <p class="leading-6">In ut odio libero vulputate <urna class="i uil-heart"></urna> <i class="uil-grin-tongue-wink"> </i> </p>
                                           <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                       </div>
                                       <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                           <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                           <a href="#"> Replay </a>
                                           <span> 3d </span>
                                       </div>
                                   </div>
                               </div>
                               <div class="flex">
                                   <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                       <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                                   </div>
                                   <div>
                                       <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                           <p class="leading-6"> sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. David !<i class="uil-grin-tongue-wink-alt"></i> </p>
                                           <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                       </div>
                                       <div class="text-xs flex items-center space-x-3 mt-2 ml-5">
                                           <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                           <a href="#"> Replay </a>
                                           <span> 3d </span>
                                       </div>
                                   </div>
                               </div>
                              
                           </div>
                           
                           <a href="#" class="hover:text-blue-600 hover:underline">  Veiw 8 more Comments </a>
           
                           <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                               <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5">
                               <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                   <a href="#">
                                       <ion-icon name="happy-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="happy outline"></ion-icon>
                                   </a>
                                   <a href="#">
                                       <ion-icon name="image-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="image outline"></ion-icon>
                                   </a>
                                   <a href="#">
                                       <ion-icon name="link-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="link outline"></ion-icon>
                                   </a> 
                               </div>
                           </div>
           
                       </div>
           
                   </div>
                   
                   <div class="card lg:mx-0 uk-animation-slide-bottom-small">
           
                       <!-- post header-->
                       <div class="flex justify-between items-center lg:p-4 p-2.5">
                           <div class="flex flex-1 items-center space-x-4">
                               <a href="#">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                               </a>
                               <div class="flex-1 font-semibold capitalize">
                                   <a href="#" class="text-black dark:text-gray-100"> Johnson smith </a>
                                   <div class="text-gray-700 flex items-center space-x-2"> 5 <span> hrs </span> <ion-icon name="people" role="img" class="md hydrated" aria-label="people"></ion-icon></div>
                               </div>
                           </div>
                         <div>
                           <a href="#" aria-expanded="false"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                           <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 uk-drop" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                         
                               <ul class="space-y-1">
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-share-alt mr-1"></i> Share
                                     </a> 
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                     </a> 
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-comment-slash mr-1"></i>   Disable comments
                                     </a> 
                                 </li> 
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-favorite mr-1"></i>  Add favorites 
                                     </a> 
                                 </li>
                                 <li>
                                   <hr class="-mx-2 my-2 dark:border-gray-800">
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                      <i class="uil-trash-alt mr-1"></i>  Delete
                                     </a> 
                                 </li>
                               </ul>
                           
                           </div>
                         </div>
                       </div>
           
           
                       <div uk-lightbox="">
                           <div class="grid grid-cols-2 gap-2 px-5">
           
                               <a href="assets/images/post/img-4.jpg" class="col-span-2">  
                                   <img src="<?php echo base_url();?>assets/images/post/img-4.jpg" alt="" class="rounded-md w-full lg:h-76 object-cover">
                               </a>
                               <a href="assets/images/post/img-4.jpg">  
                                   <img src="<?php echo base_url();?>assets/images/post/img-2.jpg" alt="" class="rounded-md w-full h-full">
                               </a>
                               <a href="assets/images/post/img-4.jpg" class="relative">  
                                   <img src="<?php echo base_url();?>assets/images/post/img-3.jpg" alt="" class="rounded-md w-full h-full">
                                   <div class="absolute bg-gray-900 bg-opacity-30 flex justify-center items-center text-white rounded-md inset-0 text-2xl"> + 15 more </div>
                               </a>
           
                           </div>
                       </div>
           
                       <div class="p-4 space-y-3"> 
                          
                           <div class="flex space-x-4 lg:font-bold">
                               <a href="#" class="flex items-center space-x-2">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                       </svg>
                                   </div>
                                   <div> Bless</div>
                               </a>
                               <a href="#" class="flex items-center space-x-2">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                                       </svg>
                                   </div>
                                   <div> Comment</div>
                               </a>
                               <a href="#" class="flex items-center space-x-2 flex-1 justify-end">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                                       </svg>
                                   </div>
                                   <div> Share</div>
                               </a>
                           </div>
                           <div class="flex items-center space-x-3 pt-2"> 
                               <div class="flex items-center">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                               </div>
                               <div class="dark:text-gray-100">
                                   Blessed<strong> Johnson</strong> and <strong> 209 Others </strong>
                               </div>
                           </div>
           
                           <div class="border-t py-4 space-y-4 dark:border-gray-600">
                               <div class="flex">
                                   <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                       <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                                   </div>
                                   <div>
                                       <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12 dark:bg-gray-800 dark:text-gray-100">
                                           <p class="leading-6">In ut odio libero vulputate <urna class="i uil-heart"></urna> <i class="uil-grin-tongue-wink"> </i> </p>
                                           <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                       </div>
                                       <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                           <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                           <a href="#"> Replay </a>
                                           <span> 3d </span>
                                       </div>
                                   </div>
                               </div>
                               <div class="flex">
                                   <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                       <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                                   </div>
                                   <div>
                                       <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12 dark:bg-gray-800 dark:text-gray-100">
                                           <p class="leading-6"> sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. David !<i class="uil-grin-tongue-wink-alt"></i> </p>
                                           <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                       </div>
                                       <div class="text-xs flex items-center space-x-3 mt-2 ml-5">
                                           <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                           <a href="#"> Replay </a>
                                           <span> 3d </span>
                                       </div>
                                   </div>
                               </div>
                              
                           </div>
                           
                           <a href="#" class="hover:text-blue-600 hover:underline">  Veiw 8 more Comments </a>
           
                           <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                               <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5">
                               <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                   <a href="#">
                                       <ion-icon name="happy-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="happy outline"></ion-icon>
                                   </a>
                                   <a href="#">
                                       <ion-icon name="image-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="image outline"></ion-icon>
                                   </a>
                                   <a href="#">
                                       <ion-icon name="link-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="link outline"></ion-icon>
                                   </a> 
                               </div>
                           </div>
           
                       </div>
           
                   </div> 
           
                   <div class="card lg:mx-0 uk-animation-slide-bottom-small">
           
                       <!-- post header-->
                       <div class="flex justify-between items-center lg:p-4 p-2.5">
                           <div class="flex flex-1 items-center space-x-4">
                               <a href="#">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                               </a>
                               <div class="flex-1 font-semibold capitalize">
                                   <a href="#" class="text-black dark:text-gray-100"> Johnson smith </a>
                                   <div class="text-gray-700 flex items-center space-x-2"> 5 <span> hrs </span> <ion-icon name="people" role="img" class="md hydrated" aria-label="people"></ion-icon></div>
                               </div>
                           </div>
                         <div>
                           <a href="#" aria-expanded="false"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                           <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 uk-drop" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                         
                               <ul class="space-y-1">
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-share-alt mr-1"></i> Share
                                     </a> 
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                     </a> 
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-comment-slash mr-1"></i>   Disable comments
                                     </a> 
                                 </li> 
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-favorite mr-1"></i>  Add favorites 
                                     </a> 
                                 </li>
                                 <li>
                                   <hr class="-mx-2 my-2 dark:border-gray-800">
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                      <i class="uil-trash-alt mr-1"></i>  Delete
                                     </a> 
                                 </li>
                               </ul>
                           
                           </div>
                         </div>
                       </div>
           
           
                       <div class="p-5 pt-0 border-b dark:border-gray-700">
           
                           Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim laoreet dolore magna aliquam erat volutpat
           
                       </div>
                       
           
                       <div class="p-4 space-y-3"> 
                          
                           <div class="flex space-x-4 lg:font-bold">
                               <a href="#" class="flex items-center space-x-2">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600 ">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                       </svg>
                                   </div>
                                   <div> Bless</div>
                               </a>
                               <a href="#" class="flex items-center space-x-2">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                                       </svg>
                                   </div>
                                   <div> Comment</div>
                               </a>
                               <a href="#" class="flex items-center space-x-2 flex-1 justify-end">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                                       </svg>
                                   </div>
                                   <div> Share</div>
                               </a>
                           </div>
                           <div class="flex items-center space-x-3 pt-2"> 
                               <div class="flex items-center">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                               </div>
                               <div class="dark:text-gray-100">
                                   Blessed<strong> Johnson</strong> and <strong> 209 Others </strong>
                               </div>
                           </div>
           
                           <div class="border-t py-4 space-y-4 dark:border-gray-600">
                               <div class="flex">
                                   <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                       <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                                   </div>
                                   <div>
                                       <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12 dark:bg-gray-800 dark:text-gray-100">
                                           <p class="leading-6">In ut odio libero vulputate <urna class="i uil-heart"></urna> <i class="uil-grin-tongue-wink"> </i> </p>
                                           <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                       </div>
                                       <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                           <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                           <a href="#"> Replay </a>
                                           <span> 3d </span>
                                       </div>
                                   </div>
                               </div>
                               <div class="flex">
                                   <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                       <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                                   </div>
                                   <div>
                                       <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12 dark:bg-gray-800 dark:text-gray-100">
                                           <p class="leading-6"> sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. David !<i class="uil-grin-tongue-wink-alt"></i> </p>
                                           <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                       </div>
                                       <div class="text-xs flex items-center space-x-3 mt-2 ml-5">
                                           <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                           <a href="#"> Replay </a>
                                           <span> 3d </span>
                                       </div>
                                   </div>
                               </div>
                              
                           </div>
                           
                           <a href="#" class="hover:text-blue-600 hover:underline">  Veiw 8 more Comments </a>
           
                           <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                               <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5">
                               <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                   <a href="#">
                                       <ion-icon name="happy-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="happy outline"></ion-icon>
                                   </a>
                                   <a href="#">
                                       <ion-icon name="image-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="image outline"></ion-icon>
                                   </a>
                                   <a href="#">
                                       <ion-icon name="link-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="link outline"></ion-icon>
                                   </a> 
                               </div>
                           </div>
           
                       </div>
           
                   </div>  
                   
                   <div class="card lg:mx-0 uk-animation-slide-bottom-small">
           
                       <!-- post header-->
                       <div class="flex justify-between items-center lg:p-4 p-2.5">
                           <div class="flex flex-1 items-center space-x-4">
                               <a href="#">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                               </a>
                               <div class="flex-1 font-semibold capitalize">
                                   <a href="#" class="text-black dark:text-gray-100"> Johnson smith </a>
                                   <div class="text-gray-700 flex items-center space-x-2"> 5 <span> hrs </span> <ion-icon name="people" role="img" class="md hydrated" aria-label="people"></ion-icon></div>
                               </div>
                           </div>
                         <div>
                           <a href="#" aria-expanded="false"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                           <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 uk-drop" uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                         
                               <ul class="space-y-1">
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-share-alt mr-1"></i> Share
                                     </a> 
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                     </a> 
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-comment-slash mr-1"></i>   Disable comments
                                     </a> 
                                 </li> 
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                      <i class="uil-favorite mr-1"></i>  Add favorites 
                                     </a> 
                                 </li>
                                 <li>
                                   <hr class="-mx-2 my-2 dark:border-gray-800">
                                 </li>
                                 <li> 
                                     <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                      <i class="uil-trash-alt mr-1"></i>  Delete
                                     </a> 
                                 </li>
                               </ul>
                           
                           </div>
                         </div>
                       </div>
           
                       <div class="w-full h-full">
                           <iframe src="https://www.youtube.com/embed/pQN-pnXPaVg?enablejsapi=1" frameborder="0" uk-video="automute: true" allowfullscreen="" uk-responsive="" class="w-full lg:h-64 h-40 uk-responsive-width"></iframe>
                       </div>
           
                       <div class="p-4 space-y-3"> 
                          
                           <div class="flex space-x-4 lg:font-bold">
                               <a href="#" class="flex items-center space-x-2">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                       </svg>
                                   </div>
                                   <div> Bless</div>
                               </a>
                               <a href="#" class="flex items-center space-x-2">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                                       </svg>
                                   </div>
                                   <div> Comment</div>
                               </a>
                               <a href="#" class="flex items-center space-x-2 flex-1 justify-end">
                                   <div class="p-2 rounded-full  text-black lg:bg-gray-100 dark:bg-gray-600">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                                           <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                                       </svg>
                                   </div>
                                   <div> Share</div>
                               </a>
                           </div>
                           <div class="flex items-center space-x-3 pt-2"> 
                               <div class="flex items-center">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                                   <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900 -ml-2">
                               </div>
                               <div class="dark:text-gray-100">
                                   Blessed<strong> Johnson</strong> and <strong> 209 Others </strong>
                               </div>
                           </div>
           
                           <div class="border-t py-4 space-y-4 dark:border-gray-600">
                               <div class="flex">
                                   <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                       <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                                   </div>
                                   <div>
                                       <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12 dark:bg-gray-800 dark:text-gray-100">
                                           <p class="leading-6">In ut odio libero vulputate <urna class="i uil-heart"></urna> <i class="uil-grin-tongue-wink"> </i> </p>
                                           <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                       </div>
                                       <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                           <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                           <a href="#"> Replay </a>
                                           <span> 3d </span>
                                       </div>
                                   </div>
                               </div>
                               <div class="flex">
                                   <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                       <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="absolute h-full rounded-full w-full">
                                   </div>
                                   <div>
                                       <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12 dark:bg-gray-800 dark:text-gray-100">
                                           <p class="leading-6"> sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. David !<i class="uil-grin-tongue-wink-alt"></i> </p>
                                           <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                       </div>
                                       <div class="text-xs flex items-center space-x-3 mt-2 ml-5">
                                           <a href="#" class="text-red-600"> <i class="uil-heart"></i> Love </a>
                                           <a href="#"> Replay </a>
                                           <span> 3d </span>
                                       </div>
                                   </div>
                               </div>
                              
                           </div>
                           
                           <a href="#" class="hover:text-blue-600 hover:underline">  Veiw 8 more Comments </a>
           
                           <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                               <input placeholder="Add your Comment.." class="bg-transparent max-h-10 shadow-none px-5">
                               <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                   <a href="#">
                                       <ion-icon name="happy-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="happy outline"></ion-icon>
                                   </a>
                                   <a href="#">
                                       <ion-icon name="image-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="image outline"></ion-icon>
                                   </a>
                                   <a href="#">
                                       <ion-icon name="link-outline" class="hover:bg-gray-200 p-1.5 rounded-full md hydrated" role="img" aria-label="link outline"></ion-icon>
                                   </a> 
                               </div>
                           </div>
           
                       </div>
           
                   </div> 
           
                   <div class="flex justify-center mt-6">
                       <a href="#" class="bg-white font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                           Load more ..</a>
                   </div>
               

                </div>

                <!-- Sidebar -->
                <div class="w-full space-y-6">
                
                                           
                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold"> Church Members </h4>
                                <p class="text-sm"> 451 Members</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a>
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>
                    
                    
                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold">Virtual Members</h4>
                                <p class="text-sm"> 210 Members</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a>
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>
                    
                    
                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold">Churches</h4>
                                <p class="text-sm"> 10 Church</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a>
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>
                    
                                                
                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold">Favourite</h4>
                                <p class="text-sm"> 143 Favourite</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a>
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>

                    <div class="widget card p-5 border-t">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-lg font-semibold">Fans</h4>
                                <p class="text-sm"> 143 Fans</p>
                            </div>
                            <a href="#" class="text-blue-600 ">See all</a>
                        </div>
                        <div class="grid grid-cols-3 gap-3 text-gray-600 font-semibold">
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-1.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Dennis Han </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-2.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Jones </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-3.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Stella Johnson </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-4.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Alex Dolgove</div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-5.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Jonathan Ali </div>
                            </a>
                            <a href="#">  
                                <div class="avatar relative rounded-md overflow-hidden w-full h-24 mb-2"> 
                                    <img src="<?php echo base_url();?>assets/images/avatars/avatar-6.jpg" alt="" class="w-full h-full object-cover absolute">
                                </div>
                                <div class="text-sm truncate"> Erica Han </div>
                            </a>
                        </div>
                      <a href="#" class="button gray mt-3 w-full">  See all </a>
                    </div>
                </div>
            </div>                  
        </div>
    </div>
</div>