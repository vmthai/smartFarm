/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// datapicker
(function ($) {
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var current = $('.current-date').datepicker('setStartDate',now);
    var start_date = $('.start-range').datepicker({
        startDate: now
    }).on('changeDate', function(ev) {
        var newDate = new Date(ev.date)
        newDate.setDate(newDate.getDate() + 1);
        $('.end-range').datepicker('setStartDate', ev.date);
        $('.end-range').datepicker('update', newDate);
        start_date.hide();
        $('.end-range')[0].focus();
    }).data('datepicker');
        
    var end_date = $('.end-range').datepicker({    
    }).on('changeDate', function(ev) {
        $('.start-range').datepicker('setEndDate', ev.date);
        end_date.hide();
    }).data('datepicker');
    
    ///=======================================================
    var start_date2 = $('.start-range2').datepicker({
        startDate: now
    }).on('changeDate', function(ev) {
        var newDate = new Date(ev.date)
        newDate.setDate(newDate.getDate() + 1);
        $('.end-range2').datepicker('setStartDate', ev.date);
        $('.end-range2').datepicker('update', newDate);
        start_date2.hide();
        $('.end-range2')[0].focus();
    }).data('datepicker');
        
    var end_date2 = $('.end-range2').datepicker({    
    }).on('changeDate', function(ev) {
        $('.start-range2').datepicker('setEndDate', ev.date);
        end_date2.hide();
    }).data('datepicker');
})(jQuery);