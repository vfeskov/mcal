var Days = Backbone.Collection.extend({
    url: '/days',
    model: Day,
    getDayModel: function(date){
        var _day=null;
        var _date=date.startOf('day').format('YYYY-MM-DD');
        this.each(function(day){
            if(day.attributes.date == _date) _day = day;
        });
        if(_day===null){
            _day = new Day({'date': _date});
            this.add(_day);
        }
        return _day;
    }
});