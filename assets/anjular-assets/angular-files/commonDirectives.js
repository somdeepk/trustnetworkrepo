var mainApp = angular.module('mainApp',['ngSanitize', 'ui.select', 'treasure-overlay-spinner', 'angularSpinners', 'ngMessages', 'ngDialog']);


mainApp.run(run);

run.$inject = ['$rootScope'];
function run ($rootScope) {
	$rootScope.spinner = {
		active: false,
		on: function () {
		  this.active = true;
		},
		off: function () {
		  this.active = false;
		}
	};	
};

mainApp.directive('datepicker', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		link: function (scope, element, attrs, ngModelCtrl) {
			//alert(element);
			element.datepicker({
				dateFormat:'MM d yy',
				changeYear: true,
				changeMonth: true,
				yearRange: "-5:+5",				
				onSelect: function (date) {
					ngModelCtrl.$setViewValue(date);
					ngModelCtrl.$render();
					//scope.date = date;
					scope.$apply();
				}				
			});
		}
	}
});

mainApp.directive('podatepicker', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		link: function (scope, element, attrs, ngModelCtrl) {
			//alert(element);
			element.datepicker({
				dateFormat:'MM d yy',
				changeYear: true,
				changeMonth: true,
				yearRange: "-5:+5",
				maxDate: 0,
				onSelect: function (date) {
					ngModelCtrl.$setViewValue(date);
					ngModelCtrl.$render();
					//scope.date = date;
					scope.$apply();
				},
				onClose: function( selectedDate ) {
		        	jQuery( "#due_date" ).datepicker( "option", "minDate", selectedDate );
		        }
			});
		}
	}
});

mainApp.directive('poduedatedatepicker', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		link: function (scope, element, attrs, ngModelCtrl) {
			element.datepicker({
				dateFormat:'MM d yy',
				changeYear: true,
				changeMonth: true,
				yearRange: "-5:+5",				
				onSelect: function (date) {
					ngModelCtrl.$setViewValue(date);
					ngModelCtrl.$render();
					//scope.date = date;
					scope.$apply();
				}
			});
		}
	}
});

mainApp.directive('prevblockdatepicker', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		link: function (scope, element, attrs, ngModelCtrl) {
			element.datepicker({
				dateFormat:'MM d yy',
				changeYear: true,
				changeMonth: true,
				minDate: 0,
				onSelect: function (date) {
					ngModelCtrl.$setViewValue(date);
					ngModelCtrl.$render();
					//scope.date = date;
					scope.$apply();
				}
			});
		}
	}
});

mainApp.directive('myUiSelect', function() {
  return {
    require: 'uiSelect',
    link: function(scope, element, attrs, $select) {
      
    }
  };
});

mainApp.directive('nextblockdatepicker', function() {
	return {
		restrict : 'A',
		require : 'ngModel',			
		link: function (scope, element, attrs, ngModelCtrl) {
			//alert(element);
			element.datepicker({
				dateFormat:'MM d yy',
				changeYear: true,
				changeMonth: true,
				maxDate: 0,
				onSelect: function (date) {
					ngModelCtrl.$setViewValue(date);
					ngModelCtrl.$render();
					//scope.date = date;
					scope.$apply();
				}
			});
		}
	}
});

mainApp.directive('bootstrapDateTime', function() {
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
						showClose: true
					}).on('dp.change', function(dttm) {
						if (dttm.date._d!=undefined) {
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
						ngModelCtrl.$setViewValue(modstr);
						scope.$apply();
					});
				}
			}
		}
	}
});
mainApp.directive('currentstartdate', function() {
	return {
		require: 'ngModel',
		link: function (scope, element, attrs, ngModelCtrl) {
			//alert(element);
			element.datepicker({
				dateFormat:'MM d yy',
				changeYear: true,
				changeMonth: true,
				minDate: 0,
				onSelect: function (date) {
					ngModelCtrl.$setViewValue(date);
					ngModelCtrl.$render();
					//scope.date = date;
					scope.$apply();
				},
				onClose: function( selectedDate ) {
		        	jQuery( "#endDate" ).datepicker( "option", "minDate", selectedDate );
		        }
			});
		}
	}
});

mainApp.directive('currentenddate', function() {
	return {
		require: 'ngModel',
		link: function (scope, element, attrs, ngModelCtrl) {
			//alert(element);
			element.datepicker({
				dateFormat:'MM d yy',
				changeYear: true,
				changeMonth: true,
				minDate: 0,
				onSelect: function (date) {
					ngModelCtrl.$setViewValue(date);
					ngModelCtrl.$render();
					//scope.date = date;
					scope.$apply();
				},
				onClose: function( selectedDate ) {
		        	jQuery( "#startDate" ).datepicker( "option", "maxDate", selectedDate );
		        }
			});
		}
	}
});

mainApp.directive('validNumber', function() {
  	return {
	    require: '?ngModel',
	    link: function(scope, element, attrs, ngModelCtrl) {
	      if(!ngModelCtrl) {
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
	      	if(event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57))
			{
				event.preventDefault();
			}
	        /*if(event.keyCode === 32) {
	          event.preventDefault();
	        }*/
	      });
	    }
  	};
}); 

mainApp.directive('validDecimalNumber', function() {
	return {
	    require: '?ngModel',
	    link: function(scope, element, attrs, ngModelCtrl) {
	      if(!ngModelCtrl) {
	        return; 
	      }

	      ngModelCtrl.$parsers.push(function(val) {
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

mainApp.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});

mainApp.filter('capitalizeFirstCharater', function() {
    return function(input, scope) {
      if (input!=null) {
          var stringArr = input.split(" ");
          var result = "";
          var cap = stringArr.length;
          for(var x = 0; x < cap; x++) {
            stringArr[x].toLowerCase();
            if(x === cap - 1) {
              result += stringArr[x].substring(0,1).toUpperCase() + stringArr[x].substring(1);
            } else {
              result += stringArr[x].substring(0,1).toUpperCase() + stringArr[x].substring(1) + " ";
            }
          }
        return result;
      }
    }
});

mainApp.filter('limitChar', function () {
    return function (content, length, tail) {
        if (isNaN(length))
            length = 50;
        if (tail === undefined)
            tail = '...';												
        if (content.length <= length || content.length - tail.length <= length) {
            return content;
        } else {
            return String(content).substring(0, length-tail.length) + tail;
        }
    };
});

mainApp.directive('fileModel', ['$parse', function ($parse) {
	
	return {
       restrict: 'A',
       link: function(scope, element, attrs) {
          element.bind('change', function(){          	 
             alert("hi");
             $parse(attrs.fileModel).assign(scope,element[0].files);
             scope.$apply();
          });
       }
    };
}]);

mainApp.directive('fileUpload', function () {
	return {
	    scope: true,        //create a new scope
	    link: function (scope, el, attrs) {
	        el.bind('change', function (event) {
	            var files = event.target.files;
	            //iterate files since 'multiple' may be specified on the element
	            for (var i = 0;i<files.length;i++) {
	                //emit event upward
	                scope.$emit("fileSelected", { file: files[i] });
	            }                                       
	        });
	    }
	};	
});

mainApp.directive('singleFileUpload', function () {
	return {
	    scope: true,        //create a new scope
	    link: function (scope, el, attrs) {
	        el.bind('change', function (event) {
				var seqVal=$(el).closest('tr').find('.zseqz').val();
	            var files = event.target.files;	  
	            for (var i = 0;i<files.length;i++) {	                
	                scope.$emit("onlyfileSelected", { file: files[i] }, seqVal);
	            } 
	        });
	    }
	};	
});
