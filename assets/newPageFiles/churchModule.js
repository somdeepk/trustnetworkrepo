var mainApp = angular.module('trustApp',['ngSanitize', 'treasure-overlay-spinner', 'angularSpinners', 'ngMessages', 'ngDialog']);
//var mainApp = angular.module('mainApp',['ngSanitize', 'ui.select', 'treasure-overlay-spinner', 'angularSpinners', 'ngMessages', 'ngDialog']);

mainApp.directive('bootstrapDate', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		compile: function() {
			return {
				pre: function(scope, element, attrs, ngModelCtrl) {
					var format, dateObj;
					format1 = (!attrs.dpFormat) ? 'MM/DD/YYYY' : attrs.dpFormat;
					$(element).datetimepicker({
						format: format1,
						sideBySide: false,
						toolbarPlacement: 'default',
						showClear: true,
						showClose: true
					}).on('dp.change', function(dttm) {
						if (dttm.date._d!=undefined) {
							var selectDate=dttm.date._d.getDate();
							var str = selectDate.toString();
							var newSelectedDate=(str.length<2)? "0" + str : str ;
							var selectYear=dttm.date._d.getFullYear();
							var mstr=(Number(dttm.date._d.getMonth())+1).toString();
							var newSelectedMonth=(mstr.length<2)? "0" + mstr : mstr ;
							var modstr=selectYear+'-'+newSelectedMonth+'-'+newSelectedDate ;
						} else {
							var modstr='';
						}
						if (attrs.ngModel=='genWorkOrder.manage.gwoDate') {
							scope.genWorkOrder.manage.gwoDateEdit=modstr ;
						} else if (attrs.ngModel=='genWorkOrder.manage.gwoCompleteDate') {
							scope.genWorkOrder.manage.gwoCompleteDateEdit=modstr ;
						}
						ngModelCtrl.$setViewValue(modstr);
						scope.$apply();
					});
				}
			}
		}
	}
});
mainApp.filter('nl2br', function ($sce) {
	return function(msg, is_xhtml) { 
		var is_xhtml = is_xhtml || true;
		var breakTag = (is_xhtml) ? '<br />' : '<br>';
		var msg = (msg + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
		return $sce.trustAsHtml(msg);
	};
});
mainApp.filter('nl2br2', function ($sce) {
	return function(msg, is_xhtml) { 
		var is_xhtml = is_xhtml || true;
		var breakTag = (is_xhtml) ? '  ' : '    ';
		var msg = (msg + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
		return $sce.trustAsHtml(msg);
	};
});

mainApp.directive('validDecimalNumber', function () {
    return {
        require: '?ngModel',
        link: function (scope, element, attrs, ngModelCtrl) {
            if (!ngModelCtrl) {
                return; 
            }

            ngModelCtrl.$parsers.push(function (val) {
                if (angular.isUndefined(val)) {
                    var val = '';
                }
                var clean = val.replace( /[^0-9.]+/g, '');
                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });

            element.bind('keypress', function(event) {
                if(event.keyCode === 32) {
                    event.preventDefault();
                }
            });
        }
    };
});

mainApp.directive('validNumber', function() {
    return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
            if (!ngModelCtrl) {
                return; 
            }
            ngModelCtrl.$parsers.push(function(val) {
                if (angular.isUndefined(val)) {
                    var val = '';
                }
                var clean = val.replace( /[^0-9]+/g, '');
                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });

            element.bind('keypress', function(event) {
                if (event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57)) {
                    event.preventDefault();
                }
            });
        }
    };
});
/*
mainApp.directive('startDateTime', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		compile: function() {
			return {
				pre: function(scope, element, attrs, ngModelCtrl) {
					var format, dateObj;
					format1 = (!attrs.dpFormat) ? 'MM/DD/YYYY hh:mm A' : attrs.dpFormat;
					$(element).datetimepicker({
						format: format1,
						sideBySide: false,
						toolbarPlacement: 'default',
						showClear: true,
						showClose: true,
					}).on('dp.change', function(dttm) {
						var thisId=attrs.id;
						if (dttm.date._d!=undefined) {
							var res = thisId.replace("start", "finish");
							if ($('#'+res).data("DateTimePicker")) {
								$('#'+res).data("DateTimePicker").minDate(dttm.date);
							}
							var selectDate=dttm.date._d.getDate();
							var str = selectDate.toString();
							var newSelectedDate=(str.length<2)? "0" + str : str ;
							var selectYear=dttm.date._d.getFullYear();
							var mstr=(Number(dttm.date._d.getMonth())+1).toString();
							var newSelectedMonth=(mstr.length<2)? "0" + mstr : mstr ;
							var hstr=(dttm.date._d.getHours()).toString();
							var newSelectedHour=(hstr.length<2)? "0" + hstr : hstr ;
							var mistr=(dttm.date._d.getMinutes()).toString();
							var newSelectedMinute=(mistr.length<2)? "0" + mistr : mistr ;
							var sstr=(dttm.date._d.getSeconds()).toString();
							var newSelectedSecond=(sstr.length<2)? "0" + sstr : sstr ;
							var modstr=selectYear+'-'+newSelectedMonth+'-'+newSelectedDate+' '+newSelectedHour+':'+newSelectedMinute+':'+newSelectedSecond ;
						} else {
							var modstr='';
						}
						var tArr=thisId.split('_');
						var indx=tArr[1];
						scope.taskObj.taskDetails[indx].startTimeStr=modstr ;
						if ($('#'+thisId)) {
							ngModelCtrl.$setViewValue($('#'+thisId).val());
						}
						//$(this).data('DateTimePicker').hide();
					});
				}
			}
		}
	}
});

mainApp.directive('endDateTime', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		compile: function() {
			return {
				pre: function(scope, element, attrs, ngModelCtrl) {
					var format, dateObj;
					format1 = (!attrs.dpFormat) ? 'MM/DD/YYYY hh:mm A' : attrs.dpFormat;
					$(element).datetimepicker({
						format: format1,
						sideBySide: false,
						toolbarPlacement: 'default',
						showClear: true,
						showClose: true,
						useCurrent: false
					}).on('dp.change', function(dttm) {
						if (dttm.date._d!=undefined) {
							var thisId=attrs.id;
							var res = thisId.replace("finish", "start");
							if ($('#'+res).data("DateTimePicker")) {
								$('#'+res).data("DateTimePicker").maxDate(dttm.date);
							}
							var selectDate=dttm.date._d.getDate();
							var str = selectDate.toString();
							var newSelectedDate=(str.length<2)? "0" + str : str ;
							var selectYear=dttm.date._d.getFullYear();
							var mstr=(Number(dttm.date._d.getMonth())+1).toString();
							var newSelectedMonth=(mstr.length<2)? "0" + mstr : mstr ;
							var hstr=(dttm.date._d.getHours()).toString();
							var newSelectedHour=(hstr.length<2)? "0" + hstr : hstr ;
							var mistr=(dttm.date._d.getMinutes()).toString();
							var newSelectedMinute=(mistr.length<2)? "0" + mistr : mistr ;
							var sstr=(dttm.date._d.getSeconds()).toString();
							var newSelectedSecond=(sstr.length<2)? "0" + sstr : sstr ;
							var modstr=selectYear+'-'+newSelectedMonth+'-'+newSelectedDate+' '+newSelectedHour+':'+newSelectedMinute+':'+newSelectedSecond ;
						} else {
							var modstr='';
						}
						var tArr=thisId.split('_');
						var indx=tArr[1];
						scope.taskObj.taskDetails[indx].finishTimeStr=modstr ;
						if ($('#'+thisId)) {
							ngModelCtrl.$setViewValue($('#'+thisId).val());
						}
						//$(this).data('DateTimePicker').hide();
					});
				}
			}
		}
	}
});*/

