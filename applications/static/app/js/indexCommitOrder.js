require(['suggest', 'menu', 'selectCoupon', 'dialogUtils', 'orderfee', 'indexOrderUtils', 'handlebars', 'data/constant', 'utils'], function (suggest, menu, selectCoupon, dialogUtils, orderfee, indexOrderUtils, Handlebars, Constant, Utils) {
    var location = {
        _options: {
            defaultFromText: "您在哪儿上车",
            defaultToText: "您要去哪儿",
            defaultFromAddressText: "  点击选择详细地址",
            defaultToAddressText: "  点击选择详细地址",
            defaultCls: "default",
            showCls: "visible",
            hideCls: "hidden",
            disableCls: 'disable',
            couponListData: [],
            orderData: {},
            commit_flag: true
        },
        _init: function () {
            this.suggest = suggest.suggestSearch;
            this.$mainPage = $('.page_1'),//首页
                this.$businesstype = $('.business_type'), // 业务类型区域
                this.$carLabels = $('.radiogroup label'), // 专车类型布局
                this.$time = $('#start_go_time'),//出发时间
                this.$timeWrapper = $("#result-spinWheel1"),//选择时间
                this.$fromAddress = $(".wrapper-from-hook"),//起点布局
                this.$toAddress = $(".wrapper-to-hook"),//终点布局
                this.$txtFrom = $('.txt-from'),//起点
                this.$txtTo = $('.txt-to'),//终点
                 this.$txtFromAddress = $('.txt-from-address'),//起点--详细地址
                this.$txtToAddress = $('.txt-to-address'),//终点--详细地址
                this.$suggest = $('.suggest'),//搜索地址
                this.$carlabelOn = $('.radiobox.cartype.on'),//专车类型--选择
                this.$adultValue = $('.txt-people.adult'), //拼车,成人人数
                this.$childValue = $('.txt-child.adult'), //拼车,儿童人数
                this.$commit = $('.order .btn'),//提交订单
                this.$txtRemark = $('.txt-remark'),//留言
                this.$couponLayout = $('.coupon-layout'),//选择优惠券
                this.$couponMoney = $('.txt-coupon'),//优惠券金额
                this.$txtCouponSelectDesc = $('.txt-item-select.coupon'),//选择优惠券/无可用优惠券
                this.$iCouponSelect = $('.i-item-select.coupon'),//选择优惠券的箭头
                this.current_pageNum = 1,//优惠券列表当前页码
                this.$pageCouponList = $('.page-couponlist'), // 优惠券列表界面
                this.$pageOrderfee = $('.page-orderfee'), // 订单费用界面
                this.$closePageOrderFee = $('.i-back.close-orderfee'), //关闭订单费用界面
                this._bindEvent(),
                //加载优惠券数据
                this._loadCouponData()
        },
        _bindEvent: function () {
            var t = this;
            $('#btnMenu').on('tap', function () {
                /**进入个人中心*/
                window.location.href="/usercenter/info";
            });
            t.$fromAddress.on("tap", function () {
                /**选择起点*/
                t.$mainPage.hide();
                var cityid = $('.txt-from').attr('cityid'),
                    cityname = $('.txt-from').attr('cityname');
                t.suggest._show(0, t._options.defaultFromText, cityid, cityname)
            });
            t.$toAddress.on("tap", function () {
                /**选择终点*/
                t.$mainPage.hide();
                var cityid = $('.txt-to').attr('cityid'),
                    cityname = $('.txt-to').attr('cityname');
                t.suggest._show(1, t._options.defaultToText, cityid, cityname)
            });
            t.$adultValue.on("people_num_change", function (o) {
                /**监听选择人数变化*/
                //填充预估价
                indexOrderUtils._requestLinePrice();
            });
            t.$couponMoney.on('coupon_change', function (o) {
                /**监听优惠券变化*/
                //填充预估价
                indexOrderUtils._requestLinePrice();
            });
            t.$businesstype.on('businesstype_change', function (o) {
                /**监听业务类型的变化*/
                //填充预估价
                indexOrderUtils._requestLinePrice();
            });
            t.$carLabels.on('specialcar_type_change', function (o) {
                /**监听专车类型变化*/
                //填充预估价
                indexOrderUtils._requestLinePrice();
            });
            t.$couponLayout.on('tap', function () {
                /**选择优惠券*/
                // window.location = '/page/couponlist?coupon_type=0';
                var couponId = t.$couponMoney.attr('id');
                if(indexOrderUtils.isNull(couponId)) {
                    dialogUtils.showToast(0, '没有可用的优惠券');
                }else{
                    /**打开优惠券列表界面*/
                    t.$pageCouponList.addClass(t._options.showCls).removeClass(t._options.hideCls);
                    //打开选择优惠券界面
                    selectCoupon.create();
                }
            });
            t.$closePageOrderFee.on('tap', function () {
                /**关闭订单预估费用界面*/
                t.$pageOrderfee.addClass(t._options.hideCls).removeClass(t._options.showCls);
            });
            t.$commit.on('tap', function () {
                /**点击提交订单*/
                var flag = t.$commit.hasClass(t._options.disableCls);
                if(!flag) t._checkParmeters();
            });
        },
        _loadCouponData: function () {
            /**请求优惠券列表数据*/
            var t = this;
//            $.ajax({
//                type: 'GET',
//                url: '/order/get_couponlist',
//                success: function (data) {
//                    // console.log('【下单界面】优惠券列表数据:' + data);
//                    var json_obj = JSON.parse(data);
//                    if (json_obj.result == '1') {
//                        json_data = json_obj.data;
//                        var total = parseInt(json_obj.total);
//                        if (json_data.length > 0) {
//                            json_data.forEach(function (data, index) {
//                                var money = parseFloat(data.money);//格式化金额为整数
//                                var id = data.id;
//                                t._options.couponListData.push({'id': id, 'money': money});
//                            });
//                            // 取出优惠券中金额最大的
//                                // console.log('【下单界面】优惠券数据,排序前'+JSON.stringify(t._options.couponListData));
//                                //按优惠券金额排序,降序
//                                t._options.couponListData.sort(function (m1, m2) {
//                                    return m2.money - m1.money;
//                                });
//                                // console.log('【下单界面】优惠券数据,[降序]排序后'+JSON.stringify(t._options.couponListData));
//                                t._showHasCoupon(t._options.couponListData[0]);
//                        }else {
                            //没有可用的优惠券
                                t._showNoCoupon();
//                        }
//                    }
//                },
//                error: function (xhr, type) {
//                    t._showNoCoupon();
//                }
//            })
        },
        _showHasCoupon: function (couponObj) {
            /**有优惠券*/
            var t = this;
            var id = couponObj.id;
            var money = couponObj.money;
            t.$couponMoney.attr('id', id);
            t.$couponMoney.attr('money', money);
            t.$couponMoney.attr('flag', 'is_selected');
            t.$couponMoney.text(money);
            t.$txtCouponSelectDesc.text('选择优惠券');
            $('.coupon-layout .wrapper .txt-item-select-wrapper .i-right-arrow').removeClass('nodata');
            //注册优惠券改变监听
            t.$couponMoney.trigger('coupon_change');
        },
        _showNoCoupon: function () {
            /**无优惠券*/
            var t = this;
            t.$couponMoney.attr('id', '');
            t.$couponMoney.attr('money', '0');
            t.$couponMoney.attr('flag', 'is_selected');
            t.$couponMoney.text('0');
            $('.coupon-layout .wrapper .txt-item-select-wrapper .i-right-arrow').addClass('nodata');
            t.$txtCouponSelectDesc.text('无可用优惠券');
            //注册优惠券改变监听
            t.$couponMoney.trigger('coupon_change');
        },
        _checkParmeters: function () {
            /**检查参数*/
        	this.$txtFrom = $('.txt-from')//起点
            this.$txtTo = $('.txt-to')//终点
            this.$txtFromAddress = $('.txt-from-address')//起点--详细地址
            this.$txtToAddress = $('.txt-to-address')//终点--详细地址
            var t = this;
            var time = t.$timeWrapper.attr('timevalue');
            if (!Utils.isValidate(time)) {
                dialogUtils.showToast(0, '请选择时间');
                return;
            }
            //检查下单时间是否提前15分钟提交
            var order_date = new Date(time);
            var current_date = new Date(new Date().getTime() + 15 * 60 * 1000);
            console.log(current_date);
            console.log(order_date);
            if (current_date.getTime() > order_date.getTime()) {
                dialogUtils.showToast(0, '至少提前15分钟完成下单,请重新选择时间');
                return;
            }
            var start_city = $('.txt-from').text();
            var end_city = $('.txt-to').text();
            var start_addr = $('.txt-from').attr('name');
            var end_addr = $('.txt-to').attr('name');
            var coupon_money = t.$couponMoney.text();
            var remark = t.$txtRemark.hasClass(t._options.defaultCls) ? '' : t.$txtRemark.text();
            if (start_city.length < 1 || start_city == t._options.defaultFromText) {
                dialogUtils.showToast(0, '请填写起点城市');
                return;
            }
            if (end_city.length < 1 || end_city == t._options.defaultToText) {
                dialogUtils.showToast(0, '请填写终点城市');
                return;
            }
            if (!start_addr || start_addr == t._options.defaultFromAddressText) {
                dialogUtils.showToast(0, '请选择起点详细地址');
                return;
            }
            if (!end_addr || end_addr == t._options.defaultToAddressText) {
                dialogUtils.showToast(0, '请选择终点详细地址');
                return;
            }
            //获取选中的索引
            var tabIndex = $('.tabBox-tit li.on').index();
            console.log('【下单界面】菜单索引:' + tabIndex);
            var businessContentTpl;
            switch (tabIndex) {
                case 0:
                    //专车
                    var carLabelIndex = $('.radiobox.cartype.on').attr('id');
                    var car_type = Constant.car_type[carLabelIndex];
                    console.log('【下单界面】专车类型索引:[' + carLabelIndex + ']名称为:[' + car_type + ']');
                    businessContentTpl = [
                        '<p><span class="layermcont-confirm-name">专车:</span><span class="layermcont-confirm-value">' + car_type + '</span><p>',
                    ].join('');
                    break;
                case 1:
                    //拼车
                    var adult_num = $('.txt-people.adult').text();
                    var child_num = $('.txt-people.child').text();
                    console.log('【下单界面】拼车人数:成人[' + adult_num + ']儿童[' + child_num + ']');
                    businessContentTpl = [
                        '<p><span class="layermcont-confirm-name">拼车:</span><span  class="layermcont-confirm-value">' + adult_num + ' 成人, ' + child_num + ' 儿童</span><p>',
                    ].join('');
                    break;
                case 2:
                    //小件托运
                    var goods_name = $('.txt-goods-input.txt-name-hook').val();
                    var goods_phone = $('.txt-goods-input.txt-phone-hook').val();
                    console.log('【下单界面】收件人信息:姓名[' + goods_name + ']手机号[' + goods_phone + ']');
                    if (!Utils.isValidate(goods_name)) {
                        dialogUtils.showToast(0, '请填写收件人姓名');
                        return;
                    }
                    if (!Utils.isValidate(goods_phone)) {
                        dialogUtils.showToast(0, '请填写收件人手机号');
                        return;
                    }
                    if (!Utils.checkPhone(goods_phone)) {
                        dialogUtils.showToast(0, '手机号不合法,请重新填写');
                        return;
                    }
                    businessContentTpl = [
                        '<p><span class="layermcont-confirm-name">姓名:</span><span  class="layermcont-confirm-value">' + goods_name + '</span><p>',
                        '<p><span class="layermcont-confirm-name">手机:</span><span  class="layermcont-confirm-value">' + goods_phone + '</span><p>'
                    ].join('');
                    break;
            }
            var data = {
                time: time,
                tiemStr: $('.go-time #start_go_time').text(),//格式为: 8月6日 15:35
                start_addr: start_city + start_addr,
                end_addr: end_city + end_addr,
                coupon_money: coupon_money,
                remark: remark,
            };
            t._fillConfirmDialogContent(data, businessContentTpl);
        },
        _fillConfirmDialogContent: function (data, businessContentTpl) {
            /**填充 确认订单 对话框内容*/
            var t = this;
            var startContentTpl = [
                '<div class="layermcont-confirm">',
                '<p><span class="layermcont-confirm-name">时间:</span><span  class="layermcont-confirm-value">{{tiemStr}}</span><p>',
                '<p><span class="layermcont-confirm-name">起点:</span><span  class="layermcont-confirm-value">{{start_addr}}</span><p>',
                '<p><span class="layermcont-confirm-name">终点:</span><span  class="layermcont-confirm-value">{{end_addr}}</span><p>',
            ].join('');
            var endContentTpl = [
                '<p><span class="layermcont-confirm-name">优惠:</span><span  class="layermcont-confirm-value">{{coupon_money}}元</span><p>',
                '<p><span class="layermcont-confirm-name">留言:</span><span  class="layermcont-confirm-value">{{remark}}</span><p>',
                '</div>'
            ].join('');
            var contentTpl = [
                startContentTpl,
                businessContentTpl,
                endContentTpl
            ].join('');
            t._options.orderData = data;
            var contentHtml = Handlebars.compile(contentTpl)(data);
            t._showConfirmDialog(contentHtml);
        },
        _showConfirmDialog: function (content) {
            /**显示确认对话框*/
            var t = this;
            console.log('订单确认信息' + t._options.orderData.remark);
            $('#dialog1 .weui_dialog .weui_dialog_bd').html(content);
            $('#dialog1').show();
            //取消
            $('#dialog1_default').on('tap', function () {
                $('#dialog1').hide();
            });
            //确认
            $('#dialog1_primary').on('tap', function () {
                $('#dialog1').hide();

                if (t._options.commit_flag) {
                    //显示加载中进度条
                    dialogUtils.showLoadingToast('提交订单中...');
                    setTimeout(t._commitOrder(), 500);
                }

            });
        },
        _commitOrder: function () {
            /** 提交订单 */
            var t = this;
            t._options.commit_flag = false;
            var tabIndex = $('.tabBox-tit li.on').index(),  // 约车类型的索引, 0: 专车, 1: 拼车 2: 小件托运
                cartype = tabIndex == 0 ? 'specialcar' : (tabIndex == 1 ? 'sharingcar' : 'agencycar'), // 约车类型, "sharingcar", "specialcar", "agencycar"
                carLabelIndex = $('.radiobox.cartype.on').attr('id');  // 专车类型的索引, 0: 4人座, 1: 6人座
            var departureregoin = t.$txtFrom.attr('district'),  // 出发区域名称
                arrivalregion = t.$txtTo.attr('district'),  // 目的区域名称
                departureaddress = t.$txtFrom.attr('name'), // 出发地（填写详细地址）
                arrivaladdress = t.$txtTo.attr('name'),  // 目的地（详细地址）
                departuretime = t._options.orderData.time,  // 出发时间
                remark = t._options.orderData.remark,  // 备注
                baochemannum = tabIndex == 0 ? (carLabelIndex == '0' ? '4' : '6') : '0', // 包车人数
                pmemberqty = tabIndex == 1 ? $('.txt-people.adult').text() : '0',  // 成人人数 （物单为0）
                cmemberqty = tabIndex == 1 ? $('.txt-people.child').text() : '0',  // 儿童人数（物单为0）
                receivename = tabIndex == 2 ? $('.txt-goods-input.txt-name-hook').val() : '', // 收货人姓名
                receivetel = tabIndex == 2 ? $('.txt-goods-input.txt-phone-hook').val() : '',  // 收货人联系电话
                start_latitude = t.$txtFrom.attr('lat'),  // 起点纬度
                start_longitude = t.$txtFrom.attr('lng'),  // 起点经度
                end_latitude = t.$txtTo.attr('lat'),  // 终点纬度
                end_longitude = t.$txtTo.attr('lng');  // 终点经度
            var road_id = $('#road_id').val();
            $.ajax({
                type: 'POST',
                url: '/car/operate_order',
                data: {
                	road_id: road_id, //线路id
                    departureregoin: departureregoin,  // 出发区域名称
                    arrivalregion: arrivalregion,  // 目的区域名称
                    departureaddress: departureaddress, // 出发地（填写详细地址）
                    arrivaladdress: arrivaladdress,  // 目的地（详细地址）
                    ride_time: departuretime,  // 出发时间
                    people_num: pmemberqty,  // 成人人数 （物单为0）
                    child_num: cmemberqty,  // 儿童人数（物单为0）
                    ride_info: remark,  // 备注
                    receivename: receivename, // 收货人姓名
                    receivetel: receivetel,  // 收货人联系电话
                    start_latitude: start_latitude,  // 起点纬度
                    start_longitude: start_longitude,  // 起点经度
                    end_latitude: end_latitude,  // 终点纬度
                    end_longitude: end_longitude,  // 终点经度
                    baoche_num: baochemannum,  // 包车人数
                    cartype: cartype  // 约车类型
                },
                success: function (data) {
                    //隐藏加载中进度条
                    dialogUtils.hideLoadingToast();
                    var result = data.status;
                    if (result == 0) {
                        //提交成功
                        dialogUtils.showToast(1, '下单成功,请等待分配车辆!', 3000, "240px", "-120px");
                        // 跳到订单列表界面
                        window.location.href = '/order/detail?id='+data.data;
                    } else if (result == 1) {
                        //提交失败
                        var errorMsg = j_data.msg;
                        console.log('【提交订单】失败, errorMsg[' + errorMsg + ']');
                        dialogUtils.showToast(0, errorMsg, 3000, "240px", "-120px");
                    }
                    t._options.commit_flag = true;
                },
                error: function (xhr, type) {
                    t._options.commit_flag = true;
                    //隐藏加载中进度条
                    dialogUtils.hideLoadingToast();
                    dialogUtils.showToast(0, '下单失败,请重试!', 3000, "240px", "-120px");
                }
            });
        },
    };
    //初始化
    location._init();
})
