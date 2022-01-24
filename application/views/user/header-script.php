<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Follow Me Now - Making Disciples</title>
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/typography.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/responsive.css">

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
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/loginController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/signupController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/editProfileController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/profileController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/leftMenuController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/notificationController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/taskController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/indexController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/supportController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/photoController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/eventController.js"></script>


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-pages/bootstrap-datetimepicker.css" />
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-pages/moment.js_2.9.0_moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-pages/src_js_bootstrap-datetimepicker.js"></script>    

    <script src="<?php echo base_url();?>assets/anjular-assets/angular-pages/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/jquery-ui.css">


    <!-- <script src="<?php //echo base_url();?>assets/agora-assets/jquery-3.4.1.min.js"></script> -->
   <!--  <script src="<?php //echo base_url();?>assets/agora-assets/bootstrap.bundle.min.js"></script> -->
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    <!-- <script type="text/javascript" src="<?php //echo base_url();?>assets/agora-assets/basicLive.js"></script> -->

   </head>
   
   <body ng-app="trustApp" class="right-column-fixed ng-scope "> <!-- sidebar-main -->
   

    <script>
    varGlobalAdminBaseUrl='<?php echo base_url();?>user/'
    varBaseUrl='<?php echo base_url();?>'
    varImageUrl='<?php echo IMAGE_URL;?>'
    </script>