var days;
var calendar;
$(function(){
    days = new Days();
    calendar = new CalendarView({
        collection: days,
        el: '#calendar_container'
    });
    calendar.setDate(moment());
})