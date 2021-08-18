<?php
/* echo "<pre>";
print_r(expression)
exit;*/
?>
<div ng-controller="churchController" ng-init="getChurchData('<?php echo $id; ?>');">
            <div class="page-header">
                <div class="page-header-title">
                    <h4>Church</h4>
                </div>
                <div class="page-header-breadcrumb">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index-2.html">
                                <i class="icofont icofont-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>administrator/churchlist">Church</a>
                        </li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Add Church</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Page header end -->
            <!-- Page body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Product edit card start -->
                        <div class="card">
                            <div class="card-header">
                                <h5>Add Church</h5>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <input ng-model="churchData.id" id="id" type="hidden">

                                    <div class="col-sm-12">
                                        <div class="product-edit">
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                    <input class="form-control" ng-model="churchData.churchName" id="churchName" placeholder="Church Name" type="text">
                                                                </div>
                                                                <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(churchDataCheck==true && isNullOrEmptyOrUndefined(churchData.churchName)==true)? 'Church Name Required' : ''}}</div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <select ng-model="churchData.churchType" id="churchType" class="form-control form-control-primary">
                                                                    <option value="0">Select Church Type</option>
                                                                    <?php foreach($churchTypeData as $key=>$val) : ?>
                                                                         <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                                     <?php endforeach; ?>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                    <input class="form-control" ng-model="churchData.foundationDate" id="foundationDate" placeholder="Foundation Date" type="text" dobdate>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                    <input class="form-control" ng-model="churchData.trusteeBoard" id="trusteeBoard" placeholder="Trustee Board" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            
                                                        </div>


                                                        <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Contact Information</h5>
                                                            </div>
                                                            <div class="card-block">

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                            <input class="form-control" ng-model="churchData.contachPerson" id="contachPerson" placeholder="Contact Person" type="text">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                            <input class="form-control" ng-model="churchData.contact_email" id="contact_email" placeholder="Email" type="text" emailvalidate>
                                                                        </div>
                                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(churchDataCheck==true && isNullOrEmptyOrUndefined(churchData.contact_email)==true)? 'Email Required' : ''}}</div>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                            <input class="form-control" ng-model="churchData.contact_mobile" id="contact_mobile" placeholder="Mobile" type="text" maxlength="15" type="text" phone-masking valid-number>
                                                                        </div>
                                                                        <div class="col-md-12 padding-lr0" style="color:#d43f3a;" >{{(churchDataCheck==true && isNullOrEmptyOrUndefined(churchData.contact_mobile)==true)? 'Mobile Required' : ''}}</div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                            <input class="form-control" ng-model="churchData.contact_alt_mobile" id="contact_alt_mobile" placeholder="Alternate Mobile" maxlength="15" type="text" phone-masking valid-number>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                        

                                                             
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h5>Church Location</h5>
                                                                        </div>
                                                                        <div class="card-block">
                                                                            <div class="row">
                                                                                <div class="col-sm-12">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon"><i class="icofont icofont-copy-alt"></i></span>
                                                                                        <textarea class="form-control" ng-model="churchData.address" id="address" placeholder="Address"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                                        <input class="form-control" ng-model="churchData.city" id="city" placeholder="City" type="text">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <select ng-model="churchData.country" id="country" class="form-control form-control-primary">
                                                                                        <option value="">Select Country</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                
                                                                                <div class="col-sm-6">
                                                                                    <select ng-model="churchData.state" id="state" class="form-control form-control-primary">
                                                                                        <option value="">Select State</option>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="col-sm-6">
                                                                                    <div class="input-group">
                                                                                        <span class="input-group-addon"><i class="icofont icofont-ui-user"></i></span>
                                                                                        <input class="form-control" ng-model="churchData.postalCode" id="postalCode" placeholder="Post Code" type="text">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            

                                                             <div class="form-group">
                                                                    <button type="button" ng-click="submitChurch();" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product edit card end -->
                    
                </div>
                        <!-- Basic Form Inputs card end -->
</div>
             

   

