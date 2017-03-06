/**
 * Created by Baby on 2016/7/30.
 */
define(['orderfee', 'wx'], function (orderfee, wx) {
    return {
        _options: {
            disableCls: 'disable',
            defaultBtnOrderText: '立即下单'
        },
        _requestLinePrice: function () {
            /** 请求线路价格信息*/
            var t = this;
            t.$submiteOrderBtn = $('.order .btn'), // 约车下单按钮
                t.$txtFrom = $('.txt-from'),//起点
                t.$txtTo = $('.txt-to'),//终点
                t.$couponMoney = $('.txt-coupon'),//优惠券金额;
                t.$dotProgressBar = $('.order-estimated-all-price-layout .dots-loading'), // 点状进度条
                t.$orderFeeLayout = $('.order-estimated-price-layout'), //客单--订单费用布局
                t.$goodsOrderFeeLayout = $('.order-estimated-goods-price-layout'), //物价预估价费用布局
                t.$orderFinalMoney = $('.order-estimated-price-wrapper .money'); // 车费 预估价
            t.$goodsOrderFinalMoney = $('.order-estimated-goods-price-wrapper .money'), // 物单--车费 预估价
                // 隐藏物单预估价信息,隐藏客单预估价信息,显示点状进度条
                t.$goodsOrderFeeLayout.hide();
            t.$orderFeeLayout.hide();
            t.$dotProgressBar.show();
            var tabIndex = $('.tabBox-tit li.on').index(),  // 约车类型的索引, 0: 专车, 1: 拼车 2: 小件托运
                cartype = tabIndex == 0 ? 'specialcar' : (tabIndex == 1 ? 'sharingcar' : 'agencycar'), // 约车类型, "sharingcar", "specialcar", "agencycar"
                carLabelIndex = $('.radiobox.cartype.on').attr('id'),  // 专车类型的索引, 0: 4人座, 1: 6人座
                departurecity_name = t.$txtFrom.attr('cityname'), // 出发城市名称
                arrivalcity_name = t.$txtTo.attr('cityname'), // 目的城市名称
                coupon_money = t.$couponMoney.text(), // 优惠券金额
                coupon_flag = t.$couponMoney.attr('flag'), // 优惠券是否已选择的标识, 已选择则填 is_selected
                baochemannum = tabIndex == 0 ? (carLabelIndex == '0' ? '4' : '6') : '0', // 包车人数
                pmemberqty = tabIndex == 1 ? $('.txt-people.adult').text() : '0',  // 成人人数 （物单为0）
                cmemberqty = tabIndex == 1 ? $('.txt-people.child').text() : '0';  // 儿童人数（物单为0）
            var baochemannumInt = parseInt(baochemannum),
                pmemberqtyInt = parseInt(pmemberqty),
                cmemberqtyInt = parseInt(cmemberqty);

            var validateFlag = false;
            //出发城市,目的城市,优惠券id 均不为空
            if (tabIndex == 0) {
                //包车
                validateFlag = baochemannumInt < 1 ? false : true;
            } else if (tabIndex == 1) {
                //拼车
                validateFlag = (pmemberqtyInt < 1 && cmemberqtyInt < 1) ? false : true;
            } else {
                validateFlag = true;
            }
            if (validateFlag) {
                //参数验证通过
                $.ajax({
                    type: 'POST',
                    url: '/line/get_line_price',
                    data: {
                        'cartype': cartype,
                        'start': departurecity_name,
                        'end': arrivalcity_name,
                        'all_num': baochemannum,
                        'people_num': pmemberqty,
                        'child_num': cmemberqty
                    },
                    success: function (data) {
                        console.log('【请求线路价格信息】data[' + data + ']');
                        //请求出错
                        if(data.status != 0){
                        	dialogUtils.showToast(0, '参数错误');
                        	return false;
                        }
                        var j_data = data.data;
                        var code = j_data.code;
                        if (code == 1) {
                            //此线路已开通,显示线路价格信息
                        	$('#road_id').val(j_data.road_id);
                            var final_money = j_data.final_money;  // 最终价格,预估价
                            // 查看订单费用
                            t.$orderFeeLayout.on('tap', function () {
                                //传递参数
                                orderfee._show(j_data);
                            });
                            //隐藏点状进度条,显示客单预估价信息
                            t.$dotProgressBar.hide();
                            if (tabIndex == 2) {
                                //刷新预估价
                                t.$goodsOrderFinalMoney.text('客服确认后定价');
                                t.$goodsOrderFeeLayout.show();
                                t.$orderFeeLayout.hide();
                            } else {
                                t.$goodsOrderFeeLayout.hide();
                                t.$orderFeeLayout.show();
                                //刷新预估价
                                t.$orderFinalMoney.text(final_money);
                            }
                            t.$submiteOrderBtn.html(t._options.defaultBtnOrderText);
                            t.$submiteOrderBtn.removeClass(t._options.disableCls);
                        } else {
                            //此线路未开通,显示未开通提示信息
                            t.$dotProgressBar.hide();
                            if (tabIndex == 2) {
                                //刷新预估价
                                t.$goodsOrderFinalMoney.text('客服确认后定价');
                                t.$goodsOrderFeeLayout.show();
                                t.$orderFeeLayout.hide();
                            } else {
                                t.$goodsOrderFeeLayout.hide();
                                t.$orderFeeLayout.show();
                                //刷新预估价
                                t.$orderFinalMoney.text('0');
                            }
                            var msg = j_data.msg;
                            t.$submiteOrderBtn.html(msg);
                            t.$submiteOrderBtn.addClass(t._options.disableCls);
                        }

                    },
                    error: function (xhr, type) {
                    }
                });
            }
        },
        getFloatValue: function (value) {
            /**得到浮点型值*/
            return !(this.isNull(value)) ? parseFloat(value) : 0;
        },
        isNull: function (n) {
            /**判断是否为空*/
            return (typeof(n) == 'undefined' || '' == n || null == n) ? true : false;
        },
        isContains: function (str, substr) {
            /**判断一个字符串是否包含一个子字符串*/
            return new RegExp(substr).test(str);
        },

        formatPhone: function (phone) {
            /**手机号中间四位加星号*/
            return phone.replace(/(\d{3})\d{4}(\d{4})/, "$1****$2");
        },
        _validateCity: function (open_cityList, locationCityName) {
            /**验证定位城市,是不是在开通城市列表内*/
            var t = this;
            var cityList = open_cityList;
            for (var i = 0; i < cityList.length; i++) {
                cityid = cityList[i].cityid;
                cityname = cityList[i].cityname;
                var name = cityname + '市';
                if (name == locationCityName) {
                    return cityid + '_' + cityname;
                }
            }
            return '';
        },
        _requestSignPackage: function (pageUrl) {
            /**
             * 获取JS-SDK权限签名配置
             * pageUrl: 调用该接口的对应的界面地址,例如: index, orderlist
             */

            $.ajax({
                type: 'GET',
                url: '/order/get_signPackage?pageUrl=' + pageUrl,
                success: function (signPackage) {
                    console.log('获取JS-SDK权限签名配置:' + signPackage.appId);
                    wx.config({
                        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                        appId: signPackage.appId, // 必填，公众号的唯一标识
                        timestamp: signPackage.timestamp, // 必填，生成签名的时间戳
                        nonceStr: signPackage.nonceStr, // 必填，生成签名的随机串
                        signature: signPackage.signature,// 必填，签名，见附录1
                        jsApiList: ['hideOptionMenu'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
                    });
                },
                error: function (xhr, type) {
                }
            });
            wx.ready(function () {
                //隐藏右上角菜单接口
                wx.hideOptionMenu();
            });
        },
        _getAmapTypeDesc: function () {
            /** 获取自定义的POI搜索类型 */
            var typeDesc = "";
            // POI搜索类型共分为以下20种：

            // 1.汽车服务
            typeDesc += "加油站|加气站|";

            // 2.汽车销售
            typeDesc += "";

            // 3.汽车维修
            typeDesc += "";

            // 4.摩托车服务
            typeDesc += "";

            // 5.餐饮服务
            typeDesc += "";

            // 6.购物服务
            typeDesc += "商场|超级市场|特色商业街|";

            // 7.生活服务
            typeDesc += "邮局|物流速递|售票处|";

            // 8.体育休闲服务
            typeDesc += "运动场馆|影剧院|";

            // 9.医疗保健服务
            typeDesc += "专科医院|综合医院|急救中心|疾病预防机构|";

            // 10.住宿服务
            typeDesc += "宾馆酒店|";

            // 11.风景名胜
            typeDesc += "公园广场|风景名胜|";

            // 12.商务住宅
            typeDesc += "产业园区|商务写字楼|住宅小区|社区中心|";

            // 13.政府机构及社会团体
            typeDesc += "政府机构及社会团体|";

            // 14.科教文化服务
            typeDesc += "博物馆|展览馆|会展中心|美术馆|图书馆|科技馆|天文馆|文化宫|档案馆|文艺团体|传媒机构|学校|科研机构|驾校|";

            // 15.交通设施服务
            typeDesc += "长途汽车站|火车站|飞机场|机场相关|港口码头|地铁站|轻轨站|班车站|过境口岸|轮渡站|索道站|";

            // 16.金融保险服务
            typeDesc += "";

            // 17.公司企业
            typeDesc += "";

            // 18.道路附属设施
            typeDesc += "收费站|服务区|";

            // 19.地名地址信息
            typeDesc += "普通地名|交通地名|路口名|标志性建筑物|";

            // 20.公共设施
            typeDesc += "紧急避难场所";

            return typeDesc;
        }
    }
})
