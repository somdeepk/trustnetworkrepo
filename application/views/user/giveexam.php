<div id="content-page" class="content-page" ng-controller="taskController" ng-init="getExamData(<?php echo $this->session->userdata('user_auto_id'); ?>);">
  <div class="container">
    <input type="hidden" id="hidden_id_string" value="<?php echo $idString; ?>">

    <div class="row">

        <div class="form-group col-sm-12">
           <h4 class="card-title">{{examData.exam_title}}</h4>
        </div>

        <div style="margin-bottom: 20px;width: 100%;" ng-repeat="(key, value) in allQuestionnaireObj"  class="row">
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

        <div style="clear:both"></div>  

        <a href="javascript:void();" ng-click="submitExam();" class="mr-3 btn btn-primary rounded zsubmitExamz">Submit</a>
        <a href="javascript:void();" ng-click="backToTaskPage();" class="mr-3 btn btn-secondary rounded"><i class="ri-arrow-left-circle-line"></i> Back</a>

    </div>
  </div>



    <div id="examReultModal" class="modal" role="dialog" style="z-index:999999 ">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Result</h4> 
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="form-group col-sm-12">
                     <label><strong style="font-size: 18px;">Total Question:</strong><span style="color: #01A5CB;font-weight:bold;font-size: 24px;"> {{submitExamData.allQuestionnaireObj.length }}</span></label>
                  </div>
                  <div class="form-group col-sm-12">
                     <label><strong style="font-size: 18px;">Total Coreect Anwer:</strong> <span style="color: #01A5CB;font-weight:bold;font-size: 24px;">{{submitExamData.totalCorrectAnswer}}</span></label>
                  </div>

                  <div class="form-group col-sm-12">
                     <label><strong style="font-size: 18px;">Percentage Got:</strong> <span style="color: #01A5CB;font-weight:bold;font-size: 24px;">{{submitExamData.total_percentage_got}}% </span></label>
                  </div>

                  <div class="form-group col-sm-12">
                     <label><strong style="font-size: 18px;">Result:</strong> <span style="color: #01A5CB;font-weight:bold;font-size: 24px;">{{submitExamData.str_is_exam_pass}} </span></label>
                  </div>

                  <div style="font-size: 34px;color: #f75151" class="form-group col-sm-12">
                     <i  ng-if="(submitExamData.is_exam_pass=='Y')" class="ri-emotion-happy-line"></i>
                     <i  ng-if="(submitExamData.is_exam_pass=='Y')" class="ri-emotion-happy-line"></i>
                     <i  ng-if="(submitExamData.is_exam_pass=='Y')" class="ri-emotion-happy-line"></i>

                     <i  ng-if="(submitExamData.is_exam_pass=='N')" class="ri-emotion-unhappy-line"></i>
                     <i  ng-if="(submitExamData.is_exam_pass=='N')" class="ri-emotion-unhappy-line"></i>
                     <i  ng-if="(submitExamData.is_exam_pass=='N')" class="ri-emotion-unhappy-line"></i>
                  </div>

                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-info zbtnLeaveLivez" ng-click="leave_result_popup()" >Close</button>
              </div>
          </div>
        </div>
    </div>


</div>