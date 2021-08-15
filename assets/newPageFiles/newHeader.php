<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="shortcut icon" href="images/favicon.ico" />
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php print $ttl ;?></title>
		<meta name="keywords" content="">
		<link rel="stylesheet" type="text/css" href="newPageFiles/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="newPageFiles/css/animate.css">
		<link rel="stylesheet" type="text/css" href="newPageFiles/css/style.css">
		<link rel="stylesheet" type="text/css" href="newPageFiles/css/treasure-overlay-spinner.css" />
		<link rel="stylesheet" type="text/css" href="newPageFiles/css/jquery.dataTables.css" />
		<link rel="stylesheet" type="text/css" href="newPageFiles/css/message.css" />
		<link rel="stylesheet" type="text/css" href="newPageFiles/ngDialog/css/ngDialog.css" />
		<link rel="stylesheet" type="text/css" href="newPageFiles/ngDialog/css/ngDialog-theme-default.css" />
		<link rel="stylesheet" type="text/css" href="newPageFiles/ngDialog/css/ngDialog-theme-plain.css" />
		<script type="text/javascript" src="newPageFiles/js/jquery.min.js"></script>
		
		<?php if (basename($_SERVER['PHP_SELF'])=='palletWorkOrder.php') { ?>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<?php } ?>
		<script type="text/javascript" src="newPageFiles/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="newPageFiles/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="newPageFiles/angular158/angular.js"></script>
		<script type="text/javascript" src="newPageFiles/angular158/angular-sanitize.js"></script>
		<script type="text/javascript" src="newPageFiles/angular158/angular-sanitize.min.js"></script>
		<!--<script type="text/javascript" src="https://angular-ui.github.io/ui-select/dist/select.js"></script>-->
		<script type="text/javascript" src="newPageFiles/angular158/angular-messages.js"></script>
		<script type="text/javascript" src="newPageFiles/angular158/angular-animate.js"></script>
		<script type="text/javascript" src="newPageFiles/angular-spinners.js"></script> 
        <script type="text/javascript" src="newPageFiles/spinner-service.js"></script>
        <script type="text/javascript" src="newPageFiles/treasure-overlay-spinner.js"></script>
        <script type="text/javascript" src="newPageFiles/spinner-directive.js"></script> 
        <script type="text/javascript" src="newPageFiles/ngDialog/js/ngDialog.js"></script>
		<?php if (basename($_SERVER['PHP_SELF'])=='InventoryManager.php'){ ?>
		<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"></script>
		<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
		<link rel="stylesheet" type="text/css" href="newPageFiles/css/bootstrap.min.css">
        <script type="text/javascript" src="newPageFiles/invManager.js"></script>
		<?php } else if (basename($_SERVER['PHP_SELF'])=='inspection.php') { ?>
		<link rel="stylesheet" type="text/css" href="newPageFiles/css/bootstrap.min.css">
		<script type="text/javascript" src="newPageFiles/inspectionController.js"></script>
		<?php } else if (basename($_SERVER['PHP_SELF'])=='empTrainingLog.php') { ?>
		<link rel="stylesheet" type="text/css" media="screen" href="trainingLogPages/bootstrap_3.3.1_css_bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="trainingLogPages/bootstrap-datetimepicker.css">
		<script type="text/javascript" src="trainingLogPages/moment.js_2.9.0_moment-with-locales.js"></script>
		<script type="text/javascript" src="trainingLogPages/src_js_bootstrap-datetimepicker.js"></script>
		<script type="text/javascript" src="trainingLogPages/select.js"></script>		
		<link type="text/css" rel="stylesheet" href="trainingLogPages/select2.css">    
		<link type="text/css" rel="stylesheet" href="trainingLogPages/selectize.default.css">
		<link type="text/css" rel="stylesheet" href="trainingLogPages/select.css">
		<script type="text/javascript" src="newPageFiles/commonDirectives.js"></script>
		<script type="text/javascript" src="newPageFiles/employeeTrainingLogController.js"></script>
		<?php } else if (basename($_SERVER['PHP_SELF'])=='supervisorOverrides.php') { ?>
		<link rel="stylesheet" type="text/css" href="newPageFiles/css/bootstrap.min.css">
		<script type="text/javascript" src="newPageFiles/overrideController.js"></script>
		<?php } else if (basename($_SERVER['PHP_SELF'])=='palletWorkOrder.php') { ?>
		<link rel="stylesheet" type="text/css" media="screen" href="trainingLogPages/bootstrap_3.3.1_css_bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="trainingLogPages/bootstrap-datetimepicker.css" >
		<script type="text/javascript" src="trainingLogPages/moment.js_2.9.0_moment-with-locales.js"></script>
		<script type="text/javascript" src="trainingLogPages/src_js_bootstrap-datetimepicker.js"></script>
		<script type="text/javascript" src="trainingLogPages/select.js"></script>
		<link type="text/css" rel="stylesheet" href="trainingLogPages/select2.css">    
		<link type="text/css" rel="stylesheet" href="trainingLogPages/selectize.default.css">
		<link type="text/css" rel="stylesheet" href="trainingLogPages/select.css">
        <script type="text/javascript" src="newPageFiles/palletWorkOrder.js"></script>
		<script type="text/javascript" src="orderProcessing/js/ui-bootstrap-tpls-0.12.1.min.js"></script>
		<?php } else if (basename($_SERVER['PHP_SELF'])=='palletWorkOrderDetails.php') { ?>
		<link rel="stylesheet" type="text/css" media="screen" href="trainingLogPages/bootstrap_3.3.1_css_bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="trainingLogPages/bootstrap-datetimepicker.css" >
		<script type="text/javascript" src="trainingLogPages/moment.js_2.9.0_moment-with-locales.js"></script>
		<script type="text/javascript" src="trainingLogPages/src_js_bootstrap-datetimepicker.js"></script>
		<script type="text/javascript" src="trainingLogPages/select.js"></script>
		<link type="text/css" rel="stylesheet" href="trainingLogPages/select2.css">    
		<link type="text/css" rel="stylesheet" href="trainingLogPages/selectize.default.css">
		<link type="text/css" rel="stylesheet" href="trainingLogPages/select.css">
        <script type="text/javascript" src="newPageFiles/palletWorkOrderDetails.js"></script>
		<script type="text/javascript" src="newPageFiles/js/ui-bootstrap-tpls-0.12.1.min.js"></script>
		<?php } ?>
		<style type="text/css">
		.overlayWholePage {
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
	<body>
	<div class="overlayWholePage"></div>
	<div class="centerNotifications"></div>
	<?php include("newPageHeader.php"); ?>
	<div id="wrapper">
		<div id="main-wrapper" class="col-md-12" <?php if (isset($_GET['palletNewWindow']) && !empty($_GET['palletNewWindow'])) {?> style="padding:0px;" <?php } ?>>
			<div id="main" ng-app="mainApp">
			<?php if(!isset($_GET['palletNewWindow'])) {?> <div class="clear60"></div> <?php } ?>
			