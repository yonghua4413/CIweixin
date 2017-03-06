
/**
 * Created by Baby on 2016/7/28.
 */
define(['handlebars'], function(Handlebars){
    return {
        _options: {
            showCls:"visible",
            hideCls:"hidden"
        },
        _show: function(data){
            this.$pageOrderfee = $('.page-orderfee'), // 订单费用界面
            this.$totalMoney = $('.total_money em'), // 总费用
            this.$totalFeeList = $('.total-fees-list'), // 费用明细列表
            this.$totalMoney.text(data.final_money), // 填充总费用
            this._fillData(data.list)
        },
        _hide: function() {

        },
        _fillData: function(list){
            console.log(list);
            var t = this;
            var itemTpl = [
                '{{#each this}}',
                  '<li><div>{{this.name}}</div><div>{{this.value}}</div></li>',
                '{{/each}}',
                '<li class="total-fees-list-line"></li>'
                ].join('');
            var contentHtml = Handlebars.compile(itemTpl)(list);
            t.$totalFeeList.html(contentHtml);
		    t.$pageOrderfee.addClass(t._options.showCls).removeClass(t._options.hideCls);
        }
    }
})
