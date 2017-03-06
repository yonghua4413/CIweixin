define(['handlebars', 'indexOrderUtils'], function (Handlebars, indexOrderUtils) {
    return {
        _options: {
            page_menu_inited: false, //页面menu是否inited
            items: [],
            event: {},
            showClz: "visible",
            hideClz: "hidden",
            animationDelay: 50,
            appDownloadUrl: 'http://a.app.qq.com/o/simple.jsp?pkgname=com.llyc.passenger'
        },

        create: function () {
            /**创建界面*/
            var t = this;
            var dict = [
                {
                    name: 'm_phone',
                    value: ''
                },
                {
                    name: 'm_order',
                    value: '我的行程'
                },
                // {
                //     name: 'm_account',
                //     value: '账户充值'
                // },
                {
                    name: 'm_coupon',
                    value: '优惠券'
                },
                {
                    name: 'm_download',
                    value: '下载APP'
                },
            ];
            var menuTpl = [
                '<div class="l list-hook">',
                '<ul>',
                '{{#each this}}',
                '<li class="{{this.name}} item" idx="{{@index}}"><a><i class="icon-index"></i><span class="value{{@index}}">{{this.value}}</span></a></li>',
                '{{/each}}',
                '</ul>',
                '<div class="wrapper-download-qrcode">',
                '<i class="i-menu-download-qrcode"></i>',
                '<span class="txt-download-qrcode">扫二维码,关注66约车公众号</span>',
                '</div>',
                '</div>',
                '<div class="r close-hook">',
                '<a class="closeMenu"><i class="icon-index i-close-menu"></i></a>',
                '</div>',
            ].join('');
            var menuHtml = Handlebars.compile(menuTpl)(dict);
            $('.page-menu').html(menuHtml);
            t.$el = $(".page-menu");
            t.$close = $(".close-hook");
            t.$list = $(".list-hook");
            t._options.page_menu_inited = true;
            t.show();
            t._bindEvent();
            var mobile = $("input[name='user_mobile']").val();
            (typeof(mobile) == 'undefined' || '' == mobile || null == mobile) ? t.requestUserInfo() : $('.value0').text(indexOrderUtils.formatPhone(mobile));
        },
        requestUserInfo: function () {
            /**请求用户信息*/
            var t = this;
            $.ajax({
                type: 'GET',
                url: '/order/get_user_info',
                success: function (data) {
                    console.log('【请求用户信息】返回数据为:' + data);
                    var j_data = JSON.parse(data);
                    if (j_data.code == 1) {
                        var uid = j_data.uid;
                        var mobile = j_data.mobile;
                        if(! indexOrderUtils.isNull(mobile)) {
                            var f_mobile = indexOrderUtils.formatPhone(mobile);
                            console.log('格式化后的手机号:' + f_mobile);
                            $('.value0').text(f_mobile);
                        }
                    }
                },
                error: function (xhr, type) {
                }
            })
        },
        _bindEvent: function () {
            /**绑定事件*/
            var t = this;
            t.$close.on("tap",
                function () {
                    t.hide()
                });
            this.$list.on('tap', 'li', function () {
                var idx = $(this).attr("idx");
                switch (parseInt(idx)) {
                    case 0://个人信息
                        break;
                    case 1://我的行程
                        window.location = '/page/orderlist?is_from_usercenter=true';
                        break;
                    case 2://优惠券
                        window.location = '/page/couponlist?coupon_type=1';
                        break;
                    case 3://下载APP
                        window.location = t._options.appDownloadUrl;
                        break;
                    default:
                }
            });
        },
        show: function () {
            var t = this;
            if (t._options.page_menu_inited) {
                t.$el.removeClass(t._options.hideClz).addClass(t._options.showClz);
                setTimeout(function () {
                        t.$close.addClass(t._options.showClz)
                    },
                    t._options.animationDelay)
            }else {
                t.create();
            }

        },
        hide: function () {
            this.$close.removeClass(this._options.showClz);
            var t = this;
            setTimeout(function () {
                    t.$el.addClass(t._options.hideClz).removeClass(t._options.showClz)
                },
                this._options.animationDelay)
        }
    };
})