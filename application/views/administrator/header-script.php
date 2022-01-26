<!DOCTYPE html>
<html lang="en">

<head>
    <title>Administrator - Login</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo base_url(); ?>admintemplate/assets/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo base_url();?>assets/anjular-assets/angular-files/js/sweetalert.min.js"></script>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/icon/themify-icons/themify-icons.css">
     <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/css/bootstrap.icon-large.css">
     <!--  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/css/bootstrap.icon-large.min.css"> -->
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/icon/icofont/css/icofont.css">
    <!-- flag icon framework css -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/pages/flag-icon/flag-icon.min.css"> -->
    <!-- Menu-Search css -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/pages/menu-search/css/component.css"> -->
    <!-- Horizontal-Timeline css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/pages/dashboard/horizontal-timeline/css/style.css">
    <!-- amchart css -->
   <!--  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/pages/dashboard/amchart/css/amchart.css"> -->
    <!-- flag icon framework css -->
   <!--  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/pages/flag-icon/flag-icon.min.css"> -->
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/css/style.css">
    <!--color css-->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admintemplate/assets/css/color/color-2.css" id="color"/>
 -->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/animate.css">
   <!--  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/style.css"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/treasure-overlay-spinner.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/message.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/ngDialog/css/ngDialog.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/ngDialog/css/ngDialog-theme-default.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/anjular-assets/angular-files/ngDialog/css/ngDialog-theme-plain.css" />
   <!--  <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/js/jquery.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admintemplate/bower_components/jquery/dist/jquery.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/js/jquery.dataTables.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/js/bootstrap.min.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url(); ?>admintemplate/bower_components/tether/dist/js/tether.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>admintemplate/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular-sanitize.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular-sanitize.min.js"></script>
    <!--<script type="text/javascript" src="https://angular-ui.github.io/ui-select/dist/select.js"></script>-->
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular-messages.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular158/angular-animate.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/angular-spinners.js"></script> 
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/spinner-service.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/treasure-overlay-spinner.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/spinner-directive.js"></script> 
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/ngDialog/js/ngDialog.js"></script>

    <!-- <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>assets/anjular-assets/angular-pages/bootstrap_3.3.1_css_bootstrap.min.css" /> -->
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url();?>assets/anjular-assets/angular-pages/bootstrap-datetimepicker.css" > -->
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-pages/moment.js_2.9.0_moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-pages/src_js_bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/churchModule.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/groupController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/memberController.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/anjular-assets/angular-files/supportController.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/anjular-assets/angular-files/css/jquery-ui.css">
</head>
<body ng-app="trustApp" class="vertical-static">
<!-- Pre-loader start -->
<div class="theme-loader">
    <div class="ball-scale">
        <div></div>
    </div>
</div>
<script>
varGlobalAdminBaseUrl='<?php echo base_url();?>administrator/'
varBaseUrl='<?php echo base_url();?>'
</script>