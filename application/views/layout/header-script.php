<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="<?php echo base_url();?>assets/images/favicon.ico" rel="icon" type="image/png">

    <!-- Basic Page Needs
    ================================================== -->
    <title>Christtube</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Socialite is - Professional A unique and beautiful collection of UI elements">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/icons.css">

    <!-- CSS 
    ================================================== --> 
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/uikit.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/anjular-assets/angular-files/js/sweetalert.min.js"></script>
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/animate.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/treasure-overlay-spinner.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/message.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/ngDialog/css/ngDialog.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/ngDialog/css/ngDialog-theme-default.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/ngDialog/css/ngDialog-theme-plain.css" />
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/js/jquery.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/js/jquery.dataTables.min.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular-sanitize.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular-sanitize.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/ng-infinite-scroll.js"></script>
    <!--<script type="text/javascript" src="https://angular-ui.github.io/ui-select/dist/select.js"></script>-->
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular-messages.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular-animate.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular-spinners.js"></script> 
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/spinner-service.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/treasure-overlay-spinner.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/spinner-directive.js"></script> 
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/ngDialog/js/ngDialog.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/churchModule.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/menuController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/loginController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/signupController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/profileSettingController.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-pages/bootstrap-datetimepicker.css" />
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-pages/moment.js_2.9.0_moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-pages/src_js_bootstrap-datetimepicker.js"></script>    

    <script src="<?php echo base_url();?>assets/anjular-assets/angular-pages/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/jquery-ui.css">

    <script>
        varGlobalAdminBaseUrl='<?php echo base_url();?>user/'
        varBaseUrl='<?php echo base_url();?>'
        varImageUrl='<?php echo IMAGE_URL;?>'
    </script>
    <style type="text/css">
        body{
            background-color: #f0f2f5;
        } 
        .loaderOverlay
        {
          position: fixed; /* Sit on top of the page content */
          display: none; /* Hidden by default */
          width: 100%; /* Full width (cover the whole page) */
          height: 100%; /* Full height (cover the whole page) */
          top: 0; 
          left: 0;
          right: 0;
          bottom: 0;
          background-color: rgba(0,0,0,0.5); /* Black background with opacity */
          z-index: 10001; /* Specify a stack order in case you're using a different order for other elements */
          cursor: pointer; /* Add a pointer on hover */
        }
    </style>

   </head>
   
   <body ng-app="trustApp"> <!-- sidebar-main -->
   <div class="loaderOverlay"></div>
   

    