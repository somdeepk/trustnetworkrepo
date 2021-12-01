<div id="content-page" class="content-page" ng-controller="taskController" ng-init="getExamData(<?php echo $this->session->userdata('user_auto_id'); ?>,'<?php echo $this->session->userdata('parent_id'); ?>','<?php echo $this->session->userdata('membership_type'); ?>','<?php echo $this->session->userdata('is_admin'); ?>');">
  <!-- Start Video Section-->
  <div class="container">
    <input type="hiddens" id="hidden_exam_id" value="<?php echo $examId; ?>">

    <div class="row">

        <div class="form-group col-sm-12">
           <h4 class="card-title">{{examData.exam_title}}</h4>
        </div>

        <div style="margin-bottom: 20px;" ng-repeat="(key, value) in allQuestionnaireObj"  class="row">
          <div class="form-group col-sm-12" style="margin-bottom: 0px;">
            <p class="qtext">{{parseInt(key)+1}}. {{value.question}}</p>
          </div>
          <!--left-->
          <div ng-repeat="(key1, value1) in value.options" class="form-group col-sm-12">
            <div class="notranslate altcontainer">
              <label class="radiocontainer"> {{parseInt(key1)+1}} )
                <i style="font-size: 21px;cursor: pointer;"  ng-click="value.given_ans=key1" ng-class="(value.given_ans==key1) ? 'ri-checkbox-circle-line' : 'ri-checkbox-blank-circle-line'"></i>  {{value1.optionval}}
              </label>
            </div>
          </div>
        <div style="clear:both"></div>
        </div>

        <a href="javascript:void();" ng-click="submitExam();" class="mr-3 btn btn-primary rounded zsubmitExamz">Submit</a>

    </div>
  </div>
  <!-- End Video Section-->
</div>