<div ng-controller="churchMemberController" ng-init="getMemberListInit();">
    <div class="page-header">
        <div class="page-header-title">
            <h4>List Member</h4>
        </div>
        <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                    <a href="index-2.html">
                        <i class="icofont icofont-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Member</a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">List Member</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-sm-10">
        <button type="button" ng-click="addMember();" class="btn btn-primary">Add</button>
    </div>

    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
        <!-- DOM/Jquery table start -->
        <div class="card">
            <div class="card-block">
                <div class="table-responsive dt-responsive">
                    <table class="table table-striped table-bordered nowrap" width="98%" id="datatableMemberList">
                        <input id="filter_church_id" value="<?php echo $church_id; ?>" type="hidden">
                        <thead>
                            <tr>
                                <th width="2%" class="hiddenimportant">&nbsp;</th>
                                <th width="10%">Name</th>
                                <th width="15%">Birth Date</th>
                                <th width="15%">Email</th>
                                <th width="15%">Mobile</th>
                                <th width="15%">Membership Type</th>
                                <th width="15%">Church</th>
                                <th width="4%">Action</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="zsearcherz">
                                <td align="left" class="hiddenimportant">
                                    <input type="text" ng-model="searchMember.Id" maxlength="25" class="zsearch_inputz form-control ">
                                </td>
                                <td align="left" >
                                    <input type="text" ng-model="searchMember.full_name" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
                                </td>
                                <td align="left" >
                                    <input type="text" ng-model="searchMember.dob" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
                                </td>
                                <td align="left" >
                                    <input type="text" ng-model="searchMember.user_email" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
                                </td>
                                <td align="left" >
                                    <input type="text" ng-model="searchMember.contact_mobile" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
                                </td>
                                <td align="left" >
                                    <select ng-model="searchMember.membership_type" ng-change="filte_membership_type()" style="height:auto;width:85%" id="membership_type" class="form-control">
                                        <option value="">Select Membership Type</option>
                                        <option value="RM">Regular Membership</option>
                                        <option value="CM">Church Membership</option>
                                    </select>
                                    <input type="text" maxlength="25" class="zsearch_inputz form-control hiddenimportant" placeholder="Search">
                                </td>

                                <td align="left" >
                                    <input type="text" ng-model="searchMember.church_name" maxlength="25" class="zsearch_inputz form-control" placeholder="Search">
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

  