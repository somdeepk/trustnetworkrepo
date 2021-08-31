var mainApp = angular.module('trustApp',['ngSanitize', 'treasure-overlay-spinner', 'angularSpinners', 'ngMessages', 'ngDialog']);
//var mainApp = angular.module('mainApp',['ngSanitize', 'ui.select', 'treasure-overlay-spinner', 'angularSpinners', 'ngMessages', 'ngDialog']);


mainApp.run(function ($rootScope)
{
	$rootScope.buttonSavingAnimation = function ($where,strtext,what)
	{        
		if(what=='loader')
		{
			$('.'+$where).html('<div style="position:relative;"><div class="loader"  style="position:absolute;">Loading...</div><div  style="position:relative;z-index: 999">'+strtext+'</div></div>');
		}
		else
		{
			$('.'+$where).html(strtext);
		}		
    };

    $rootScope.getGlobalCountryData = function ($http) {        
		var formData = new FormData();
		formData.append('id','1');
        $http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"getcountrydata",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData)
	        {
	        	aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		//alert("ss")
	        		$rootScope.countryData =aryreturnData.data.countryData;

	        		//console.log($rootScope.countryData)
	        	}
	        	else
	        	{
	        		swal("Error!",
		        		"No Data Found",
		        		"error"
		        	)
	        	}
			});
    };


    $rootScope.getGlobalStateData = function ($http,countryId) {        
		var formData = new FormData();
		formData.append('countryId',countryId);
        $http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"getstatedata",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData)
	        {
	        	aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$rootScope.stateData =aryreturnData.data.stateData;
	        		//console.log($rootScope.countryData)
	        	}
	        	else
	        	{
	        		swal("Error!",
		        		"No Data Found",
		        		"error"
		        	)
	        	}
			});
    };

    $rootScope.getGlobalCityData = function ($http,stateId) {        
		var formData = new FormData();
		formData.append('stateId',stateId);
        $http({
	            method  : 'POST',
	            url     : varGlobalAdminBaseUrl+"getcitydata",
	            transformRequest: angular.identity,
	            headers: {'Content-Type': undefined},                     
	            data:formData, 
	        }).success(function(returnData)
	        {
	        	aryreturnData=angular.fromJson(returnData);
	        	if(aryreturnData.status=='1')
	        	{
	        		$rootScope.cityData =aryreturnData.data.cityData;
	        		//console.log($rootScope.countryData)
	        	}
	        	else
	        	{
	        		swal("Error!",
		        		"No Data Found",
		        		"error"
		        	)
	        	}
			});
    };
});


mainApp.directive('singleFileUpload', function () {
	return {
	    scope: true,        //create a new scope
	    link: function (scope, el, attrs) {
	        el.bind('change', function (event) {
	            var files = event.target.files;	            
	            
	            for (var i = 0;i<files.length;i++) {	                
	                scope.$emit("fileSelected", { file: files[i] });
	            }                                
	        });
	    }
	};	
});

mainApp.directive('dobdate', function() {
	return {
		require: 'ngModel',
		link: function (scope, element, attrs, ngModelCtrl) {
			//alert(element);
			element.datepicker({
				dateFormat:'yy-mm-dd',
				changeYear: true,
				changeMonth: true,
				yearRange: "-100:+0",
				maxDate: 0,
				onSelect: function (date) {
					ngModelCtrl.$setViewValue(date);
					ngModelCtrl.$render();
					scope.$apply();
				},
				
			});
		}
	}
});

mainApp.directive('emailvalidate',function() {
    return {
        link:  function(scope, element, attrs) {
			element.bind('keyup', function() {
				var email=jQuery(this).val();
				if (jQuery.trim(email)!='') {
					
					var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					 if(!regex.test(email)) {
						jQuery(this).addClass('redBorder');
						jQuery(this).removeClass('greenBorder');
					 }else{
						jQuery(this).addClass('greenBorder');
						jQuery(this).removeClass('redBorder');
					 }
				}
			})
		}
	}
});

mainApp.directive('phoneMasking', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attrs, ngModel) {
            //console.log("In link function");

            var addSpaces = function(value) {
                if (typeof(value) == typeof(undefined))
                    return value;
                var parsedValue = value.toString()
                    .replace(/[^\dA-Za-z]/g, '')
                    .replace(/(.{3})/g, '$1 ').trim()
                    .toUpperCase()
                    .replace(/-$/, '');
                return parsedValue;
            }

            var removeSpaces = function(value) {
                if (typeof(value) == typeof(undefined))
                    return value;
                var parsedValue = value.toString().replace(/\s/g, '').replace(/-/g, '');
                return parsedValue;
            }

            var parseViewValue = function(value) {
                var viewValue = addSpaces(value);
                ngModel.$viewValue = viewValue;
                ngModel.$render();

                // Return what we want the model value to be
                return removeSpaces(viewValue);
            }

            var formatModelValue = function(value) {
                var modelValue = removeSpaces(value);
                ngModel.$modelValue = modelValue;
                return addSpaces(modelValue);
            }

            ngModel.$parsers.push(parseViewValue);
            ngModel.$formatters.push(formatModelValue);
        }
    }
});

mainApp.filter('capitalize', function() {
    return function(input) {
    	alert(input)
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
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
});*/
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

