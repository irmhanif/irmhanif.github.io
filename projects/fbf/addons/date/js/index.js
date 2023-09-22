var dateToday = new Date(); 
$(function () {
  $("#dateofdeparture").datepicker({ 
      format: 'dd-mm-yyyy',
        autoclose: true, 
        startDate: "+0d" ,
        todayHighlight: true
  });
});