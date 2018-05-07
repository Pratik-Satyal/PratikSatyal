(function ($,undefined){

		initialize = function (){
	        var 

	        that = $(this)
 			/*token = $('#depart').val();
 			alert(token);*/
			_bindings();
			_triggers();

		},
		_bindings = function (){
			//department_list_datatable();
			   $('button').click (function(){
              	var that=$(this),
	        	branch = $(this).attr('branch');

		        $.post(
		            SITE_URL + 'referal/ajax/action/emp_list/',
		            {
		        		branch : branch,
		            }
		            ).success(function(data){

		              bootbox.dialog({
		                message:data,
		                buttons:{
		                  success:{
		                        label: 'Close', 
		                        className: 'btn-danger',
		                        callback : function() { 
		                        }
		                      },
		                },
		              });
		        })  

          })

		},


// 		department_list_datatable = function (){
// //alert('test');
// 			var
// 				department_listUrl = SITE_URL+'',
// 				$fnServerData= function(sSource, aoData, fnCallback, oSettings){

// 					oSettings.jqXHR= $.ajax({
// 						"dataType": 'json',
// 						"type"    : 'post',
// 						"url"     : sSource,
// 						"data"    : aoData,
// 						"success" : fnCallback
// 					});
// 				},
// 				$columns = [
// 					{
// 						"sTitle": 'Employee Name',
// 						"mDataProp":'',
// 						"bSortable" : true

// 					},
// 					{
// 						"sTitle": 'Customer Name',
// 						"mDataProp":'',
// 						"bSortable" : true

// 					},
					
// 				],

// 				$configs= {
// 					"sDom"         :  "<'row'<'col-md-10 referal'><'col-md-2'f>>t<'row'<p><'col-md-6'l>>",
					
// 					'sAjaxSource' 	: department_listUrl,
// 					'aoColumns'   	: $columns,
// 					'fnServerData'	: $fnServerData,
// 					'bServerSide' 	: true,
// 					'bProcessing' 	: true,
// 					'bFilter'     	: true,
// 					'iDisplayLength': 10,
// 					'fnDrawCallback': department_employee_DrawBindings
// 				};

// 				$department_employee = $('table#department_employee_list').dataTable($configs);

// 		};
// 		department_employee_DrawBindings = function(){


// 		}


		_triggers = function(){
				$('#level').appendTo('.referal')
				},
$(document).ready(function () {
		initialize();
	});
})(jQuery);