<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Child Log</title>
		<meta name="keywords" content="">
		<link rel="stylesheet" type="text/css" href="../newPageFiles/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="../newPageFiles/css/animate.css">
		<link rel="stylesheet" type="text/css" href="../newPageFiles/css/style.css">
		<link rel="stylesheet" type="text/css" href="../newPageFiles/css/treasure-overlay-spinner.css" />
		<link rel="stylesheet" type="text/css" href="../newPageFiles/css/jquery.dataTables.css" />
		<link rel="stylesheet" type="text/css" href="../newPageFiles/css/message.css" />
		<link rel="stylesheet" type="text/css" href="../newPageFiles/ngDialog/css/ngDialog.css" />
		<link rel="stylesheet" type="text/css" href="../newPageFiles/ngDialog/css/ngDialog-theme-default.css" />
		<link rel="stylesheet" type="text/css" href="../newPageFiles/ngDialog/css/ngDialog-theme-plain.css" />
		<script type="text/javascript" src="../newPageFiles/js/jquery.min.js"></script>
		<script type="text/javascript" src="../newPageFiles/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="../newPageFiles/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../newPageFiles/angular158/angular.js"></script>
		<script type="text/javascript" src="../newPageFiles/angular158/angular-sanitize.js"></script>
		<script type="text/javascript" src="../newPageFiles/angular158/angular-sanitize.min.js"></script>
		<script type="text/javascript" src="../newPageFiles/angular158/angular-messages.js"></script>
		<script type="text/javascript" src="../newPageFiles/angular158/angular-animate.js"></script>
		<script type="text/javascript" src="../newPageFiles/angular-spinners.js"></script> 
        <script type="text/javascript" src="../newPageFiles/spinner-service.js"></script>
        <script type="text/javascript" src="../newPageFiles/treasure-overlay-spinner.js"></script>
        <script type="text/javascript" src="../newPageFiles/spinner-directive.js"></script> 
        <script type="text/javascript" src="../newPageFiles/ngDialog/js/ngDialog.js"></script>
		<link rel="stylesheet" type="text/css" href="../newPageFiles/css/bootstrap.min.css">
        <script type="text/javascript" src="../newPageFiles/invManager.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<div id="main-wrapper" class="col-md-12" style="padding:0px;">
				<div id="main" ng-app="mainApp">
					<div class="col-md-12" ng-controller="invManagerController" ng-init="initEmpTrainingLog();">
						<table width="100%" id="log_list"  class="table table-striped table-hover zmultidataviewz">
							<thead>
								<tr>
									<td align="left" width="11%" valign="top" class="job_class">
										<strong>ID</strong>
									</td>
									<td align="left" width="11%" valign="top" class="job_class">
										<strong>Log Time</strong>
									</td>
									<td align="left" width="11%" valign="top" class="job_class">
										<strong>Employee</strong>
									</td>
									<td align="left" width="12%" valign="top" class="job_class">
										<strong>Issue</strong>
									</td>
									<td align="left" width="12%" valign="top" class="job_class">
										<strong>Causation Event</strong>
									</td>
									<td align="left" width="11%" valign="top" class="job_class">
										<strong>Type</strong>
									</td>
									<td align="left" width="10%" valign="top" class="job_class">
										<strong>Entered By</strong>
									</td>
									<td align="center" width="8%" valign="top" class="job_class">
										<strong>CTC</strong>
									</td>
									<td align="left" width="18%" valign="top" class="job_class">
										<strong>Description</strong>
									</td>
									<td align="left" width="7%" valign="top" class="job_class">
										<strong>Action</strong>
									</td>
								</tr>
							</thead>
							<thead>
								<tr class="zsearcherz">
									<td width="" align="left" class="job_class">
										<input type="text" class="zsearch_inputz form-control length-validation" placeholder="Search" >
									</td>
									<td width="" align="left" class="job_class">
										<input type="text" class="zsearch_inputz form-control length-validation" placeholder="Search" >
									</td>
									<td width="" align="left" class="job_class">
										<input type="text" class="zsearch_inputz form-control length-validation" placeholder="Search" >
									</td>
									<td width="" align="left" >
										<input type="text" class="zsearch_inputz form-control length-validation" placeholder="Search" >
									</td>
									<td width="" align="left" class="job_class">
										<input type="text" class="zsearch_inputz form-control length-validation" placeholder="Search" >
									</td>
									<td width="" align="left" class="job_class">
										<input type="text" class="zsearch_inputz form-control length-validation" placeholder="Search" >
									</td>
									<td width="" align="left" class="job_class">
										<input type="text" class="zsearch_inputz form-control length-validation" placeholder="Search" >
									</td>
									<td width="" align="left" class="job_class">
										<input type="text" class="zsearch_inputz form-control length-validation" placeholder="Search" >
									</td>
									<td width="" align="left" class="job_class">
										<input type="text" class="zsearch_inputz form-control length-validation" placeholder="Search" >
									</td>
									<td width="" align="left" class="job_class">&nbsp;</td>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>