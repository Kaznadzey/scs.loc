if(window.jQuery)
{
	$(document).ready(function(){
		loadDatePicker();
	});
	
	function loadDatePicker()
	{
		if($('.datepicker').length > 0)
		{
			$('.datepicker').each(function(){
				if($(this).hasClass('hasDatepicker'))
					$(this).datepicker('destroy');
			});

			var oMinDate 	= new Date($('select[name=report_year] :selected').val(), 0, 1);
			var oNow 			= new Date();
			if($('select[name=report_year] :selected').val() == oNow.getFullYear())
				oMinDate 	= oNow;		

			$('.datepicker').datepicker({
					dateFormat:'dd.mm',
					changeMonth: true,
        	minDate: oMinDate,
        	maxDate: new Date($('select[name=report_year] :selected').val(), 11, 31)
			});
			$('.datepicker').datepicker('setDate', oMinDate);
		}
		
		return false;
	}
	
	function loadActualReports()
	{
		var p = new Object;
		var sErrors = "";
		p['group_type'] 	= parseInt($('select[name=group_type] :selected').val());
		p['year'] 				= parseInt($('select[name=report_year] :selected').val());
		p['report_type'] 	= parseInt($('select[name=report_type] :selected').val());
		p['date_from']		= $('input[name=date_from]').val();
		p['date_to']			= $('input[name=date_to]').val();
		
		if(p['group_type'] <= 0 || isNaN(p['group_type']))
			sErrors += "Выберите Вашу группу \n";
		if(p['year'] <= 0 || isNaN(p['year']))
			sErrors += "Выберите год \n";
		if(p['report_type'] <= 0 || isNaN(p['report_type']))
			sErrors += "Выберите периодичность сдачи \n";
			
		if(sErrors != '')
		{
			alert(sErrors);
			return false;
		}
			
		$.post('load-actual-reports', p, function(oResult){
			if(isValidJSON(oResult))
			{
				var aResult = $.parseJSON(oResult);
				$('#actual_reports').html(aResult['content']);
			}
			else
				alert('Server error!');
		});
			
		return;
	}
	
	function isValidJSON(sJson)
	{
		try{JSON.parse(sJson);}catch (e){return false;}		
		return true;
	}
}
else
	alert('jQuery is not loaded!');