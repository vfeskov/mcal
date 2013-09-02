var CalendarView = Backbone.View.extend({
    initialize: function(attributes){
        this.collection = attributes.collection;
        this.template = _.template( $("#calendar").html() );
        this.templateDay = _.template( $("#calendar_day").html() );
    },
    events: {
        'click span[flag]': 'setFlag',
        'click button[prev]': 'prev',
        'click button[next]': 'next'
    },
    setDate: function(date){
        if(date){
            this.date = date;
        } else {
            date = this.date;
        }
        date = moment(date).startOf('month')
        this.from = date.clone().startOf('week');
        this.to = date.clone().add('months',1).endOf('week');
        var self = this;
        this.collection.fetch({
            data:{
                from: this.from.format('YYYY-MM-DD'),
                to: this.to.format('YYYY-MM-DD')
            },
            error:function(){
                self.render();
            },
            success: function(){
                self.render();
            }
        });
    },
    render: function(){
        this.$el.html(this.template({
            date: this.date,
            templateDay: this.templateDay,
            days: this.collection,
            from: this.from,
            to: this.to
        }));
    },
    setFlag: function(e){
        var $this=$(e.target);
        $this.toggleClass('checked');
        var $day = $this.closest('.day');
        var cid = $day.attr('cid');
        var dayModel = this.collection.get(cid);
        var flagname = 'flag'+$this.attr('flag').toUpperCase();
        dayModel.attributes[flagname] = ($this.hasClass('checked')) ? 1 : 0;
        if(dayModel.isNoFlags()){
            dayModel.clone().destroy({
                success:function(){
                    $this.removeClass('checked');
                    dayModel.id = null;
                }
            });
        }else{
            dayModel.save({
                success:function(){
                    $this.toggleClass('checked');
                }
            });
        }

    },
    prev: function(){
        this.setDate(this.date.add('months',-1));
    },
    next: function(){
        this.setDate(this.date.add('months',1));
    }
});