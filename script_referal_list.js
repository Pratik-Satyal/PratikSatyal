(function ($,undefined){

		initialize = function (){

			_bindings();
			_triggers();

		},
		_bindings = function (){
			referal_list_datatable();

			$('.params')
		    .on('change', function () {
			$referal
			.fnDraw();
		    });	
		},

		referal_list_datatable = function (){
//alert('test');
			var
				referal_listUrl = SITE_URL+'referal/ajax/action/referal_list/',
				$fnServerData= function(sSource, aoData, fnCallback, oSettings){

					$('.params').each(function () {
						//alert($(this).attr('name')+"pop"+$(this).val())
						aoData.push({
	                            name    : $(this).attr('id'),
	                            value   : $(this).val()
	                    });
				    });

					oSettings.jqXHR= $.ajax({
						"dataType": 'json',
						"type"    : 'post',
						"url"     : sSource,
						"data"    : aoData,
						"success" : fnCallback
					});
				},
				$columns = [

					// {
					// 	"sTitle": 'S.N.',
					// 	"mDataProp":'',
					// 	"sWidth": '10%',
					// 	"bSortable" : true

					// },

					{
						"sTitle": 'Customer Name',
						"mDataProp":'customer_name',
						"bSortable" : true

					},
					{
						"sTitle": 'Package',
						"mDataProp":'service_type',
						"bSortable" : true

					},
					// {
					// 	"sTitle": 'Service Details',
					// 	"mDataProp":'service_details',
					// 	"bSortable" : true

					// },
					{
						"sTitle": 'Branch',
						"mDataProp":'name',
						"bSortable" : true

					},
					{
						"sTitle": 'Department',
						"mDataProp":'department',
						"bSortable" : true

					},
				],

				$configs= {
					"sDom"         :  "<'row'<'col-md-10 referal'><'col-md-2'f>>t<'row'<p><'col-md-6'l>>",
					
					'sAjaxSource' 	: referal_listUrl,
					'aoColumns'   	: $columns,
					'fnServerData'	: $fnServerData,
					'bServerSide' 	: true,
					'bProcessing' 	: true,
					'bFilter'     	: true,
					'iDisplayLength': 10,
					'fnDrawCallback': referal_DrawBindings
				};

				$referal = $('table#referal_list').dataTable($configs);

		};
		referal_DrawBindings = function(){


		}


		_triggers = function(){
				$('#level').appendTo('.referal')
				},
$(document).ready(function () {
		initialize();
	});
})(jQuery);