/**
 * Created by Baby on 2016/8/11.
 */
define(['bscroll', 'handlebars', 'data/constant'], function (BScroll, Handlebars, Constant) {
    return {
        _options: {
            typedescMap: {},
            orderlist: [],
            showCls: "visible",
            hideCls: "hidden",
            itemSelectedCls: 'coupon-item-selected',
            scroll_flag: true
        },
        create: function () {
            this.$closeCouponlist = $('.close-couponlist'),//关闭优惠券列表界面
                this.$couponListWrapper = $('.coupon-list-wrapper'),//优惠券列表--布局
                this.$couponList = $('.couponlist-hook'),//优惠券列表
                this.$loadmore = $('.load-more'),//加载更多
                this.$nodata = $('.nodata'),//无数据
                this.$pageCouponList = $('.page-couponlist'); // 优惠券列表界面
            this._init(),
                this._bindEvent();
        },
        _init: function () {
            var t = this;

            //初始化,请求优惠券列表数据
            this._loadCouponList();

        },
        _bindEvent: function () {
            var t = this;
            //关闭订单列表
            t.$closeCouponlist.on('tap', function () {
                /**关闭优惠券列表界面*/
                t.$pageCouponList.addClass(t._options.hideCls).removeClass(t._options.showCls);
            });
            t.$nodata.on('tap', function () {
                t._loadCouponList();
            });

        },
        _loadCouponList: function () {
            // 请求优惠券列表数据
            var t = this;
            t._options.scroll_flag = false;
            t.$couponList.html('');
            t.$loadmore.html("<em></em>正在加载").show();
            t.$nodata.hide();
            $.ajax({
                type: 'GET',
                url: '/order/get_couponlist',
                success: function (data) {
                    var json_obj = JSON.parse(data);
                    console.log('【优惠券列表界面】订单列表数据:');
                    console.log(json_obj);
                    if (json_obj.result == '1') {
                        var json_data = json_obj.data;
                        if (json_data.length > 0) {
                            json_data.forEach(function (data, index) {
                                data.money = parseFloat(data.money);//格式化金额为整数
                                var status = data.status;
                                data.status = Constant.coupon_status[status];//格式化优惠券状态
                                var expiretime = data.expiretime.trim().split(" ")[0];
                                data.expiretime = expiretime;//格式化时间为: yyyy-MM-dd
                                var id = data.id;
                                var typedesc = data.typedesc;
                                //将回车符 替换为html中的换行符
                                typedesc = typedesc.replace(/\r\n/g, "<br/>");
                                t._options.typedescMap[id] = typedesc;
                            });
                            var couponListHtml = t._genListHtml(json_data);
                            t.$couponList.html(couponListHtml);
                            t.$loadmore.html("没有更多数据了");
                            t.$loadmore.show();
                            //设置点击监听事件
                            t._setOnclickListener();
                            t._setScrollListener();
                        } else {
                            t.$nodata.show();
                            t.$loadmore.hide();
                        }
                    }
                    t._options.scroll_flag = true;
                },
                error: function (xhr, type) {
                    t._options.scroll_flag = true;
                }
            })
        },
        _setOnclickListener: function () {
            //点击监听事件
            var t = this;
            t.$couponMoney = $('.txt-coupon');//首页优惠券金额
            t.$txtCouponSelectDesc = $('.txt-item-select.coupon');//选择优惠券/无可用优惠券
            t.$couponItem = $('.coupon-item');
            t.$IconSelectCheckbox = $('.coupon-item .coupon-money .i-select-checkbox');//选择优惠券的checkbox
            //显示优惠券的checkbox
            t.$IconSelectCheckbox.show();
            t.$couponList.on('tap', '.coupon-item', function () {
                $(this).addClass(t._options.itemSelectedCls);
                t.$couponItem.removeClass('on');
                $(this).addClass('on');
                var id = $(this).attr('data-id');
                var money = $(this).attr('data-money');
                console.log('选择的优惠券信息, id=' + id + 'money=' + money);
                //填充首页的优惠券金额
                t.$couponMoney.attr('id', id);
                t.$couponMoney.attr('money', money);
                t.$couponMoney.text(money);
                t.$txtCouponSelectDesc.text('选择优惠券');
                //绑定改变监听
                $('.txt-coupon').trigger('coupon_change');
                //关闭当前界面,返回给上个界面
                t.$pageCouponList.addClass(t._options.hideCls).removeClass(t._options.showCls);
            });

        },
        _setScrollListener: function () {
            //滚动监听
            var t = this;
            $(document).on("scroll",
                function () {
                    var a = document.documentElement.clientHeight + document.body.scrollTop;
                    if (a >= document.body.scrollHeight - 50) {
                        //先清空
                        t.$couponList.html('');
                        console.log('滚动标记:' + t._options.scroll_flag);
                        if (t._options.scroll_flag) {
                            setTimeout(t._loadCouponList(), 1000);
                        }
                    }
                });
            var scroller = new BScroll(t.$couponListWrapper[0]);
            scroller.scrollTo(0, 0);
        },
        _genListHtml: function (data) {
            var couponListTpl = [
                '{{#each this}}',
                '<li class="coupon-item" data-id={{id}} data-money={{money}}>',

                '<div class="coupon-money"><span>￥{{money}}</span></div>',
                '<div class="coupon-desc">',
                '<div><span class="coupon-name">{{couponname}}</span></div>',
                '<div><span class="coupon-expiretime">有效期至{{expiretime}}</span></div>',
                '</div>',
                '<div class="coupon-status"><span>{{status}}</span></div>',
                '</li>',
                '{{/each}}'
            ].join('');
            var couponListHtml = Handlebars.compile(couponListTpl)(data);
            return couponListHtml;
        }
    }
})
