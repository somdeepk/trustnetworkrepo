<div ng-controller="churchController" ng-init="getChurchListInit();">
    <div class="page-header">
        <div class="page-header-title">
            <h4>List Church</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#!">Church</a>
                </li>
                <li class="breadcrumb-item"><a href="#!">List Church</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-sm-10">
        <button type="button" ng-click="addChurch();" class="btn btn-primary">Add</button>
    </div>
   
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
        <!-- DOM/Jquery table start -->
        <div class="card">
            <div class="card-block">
                <div class="table-responsive dt-responsive">
                    <table class="table table-striped table-bordered nowrap" width="98%" id="datatableChurchList">
                        <thead>
                            <tr>
                                <th width="2%" class="hiddenimportant">&nbsp;</th>
                                <th width="10%">Church Name</th>
                                <th width="15%">Trustee Board</th>
                                <th width="15%">Foundation Date</th>
                                <th width="15%">Contact Person</th>
                                <th width="4%">Action</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="zsearcherz">
                                <td align="left" class="hiddenimportant">
                                    <input type="text" ng-model="searchChurch.Id" maxlength="25" class="zsearch_inputz form-control ">
                                </td>
                                <td align="left" >
                                    <input type="text" ng-model="searchChurch.churchName" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
                                </td>
                                <td align="left" >
                                    <input type="text" ng-model="searchChurch.trusteeBoard" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
                                </td>
                                <td align="left" >
                                    <input type="text" ng-model="searchChurch.foundationDate" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
                                </td>

                                <td align="left" >
                                    <input type="text" ng-model="searchChurch.contachPerson" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
                                </td> 

                                <td align="left" >&nbsp;</td>
                            </tr>
                        </thead>
                    </table>
                    
                </div>
            </div>
        </div>
        <!-- DOM/Jquery table end -->
    </div>
</div>

  