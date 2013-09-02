var Day = Backbone.Model.extend({
    urlRoot:'/days',
    defaults:{
        flagO:0,
        flagZ:0,
        flagX:0,
        flagOX:0
    },
    isNoFlags:function(){
        return (this.attributes.flagO == 0 && this.attributes.flagZ == 0 && this.attributes.flagX == 0 && this.attributes.flagOX == 0)
    }
});