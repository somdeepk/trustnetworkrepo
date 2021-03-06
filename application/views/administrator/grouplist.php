<div ng-controller="churchController" ng-init="getGroupListInit();">
    <div class="page-header">
        <div class="page-header-title">
            <h4>List Group</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Group</a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">List Group</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-sm-10">
        <button type="button" ng-click="addGroup();" class="btn btn-primary">Add</button>
    </div>
   
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
        <!-- DOM/Jquery table start -->
        <div class="card">
            <div class="card-block">
                <div class="table-responsive dt-responsive">
                    <table class="table table-striped table-bordered nowrap" width="98%" id="datatableGroupList">
                        <thead>
                            <tr>
                                <th width="2%" class="hiddenimportant">&nbsp;</th>
                                <th width="10%" class="align-left">Group Name</th>
                                <th width="15%">Create Date</th>
                                <th width="4%">Action</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="zsearcherz">
                                <td align="left" class="hiddenimportant">
                                    <input type="text" ng-model="searchGroup.Id" maxlength="25" class="zsearch_inputz form-control ">
                                </td>
                                <td align="left" >
                                    <input type="text" ng-model="searchGroup.groupName" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
                                </td>
                                <td align="left" >
                                    <input type="text" ng-model="searchGroup.createDate" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
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

  