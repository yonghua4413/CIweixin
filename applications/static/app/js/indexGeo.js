/**
 * Created by Baby on 2016/7/12.
 */
require(['wx', 'store', 'dialogUtils', 'indexOrderUtils', 'http://webapi.amap.com/maps?v=1.3&key=d53e69a5a885cf218ae5bdc1a311826f&callback=init'], function (wx, store, dialogUtils, indexOrderUtils) {

    var geo = {
        _options: {
            defaultFromText: "您在哪儿上车",
            defaultToText: "您要去哪儿",
            defaultFromAddressText: "  点击选择详细地址",
            defaultToAddressText: "  点击选择详细地址",
            defaultCls: "default",
            cityList: [],
            pageUrl: 'index'  //当前界面网页地址, 微信网页JS-SDK开发验证签名所需
        },
        _init: function () {
            var t = this;

            this.$txtFrom = $('.txt-from'),//起点
                this.$txtTo = $('.txt-to'),//终点
                this.$txtFromAddress = $('.txt-from-address'),//起点--详细地址
                this.$txtToAddress = $('.txt-to-address'),//终点--详细地址
                this.$txtFromAddress.text(t._options.defaultFromAddressText).show(),
                this.$txtToAddress.text(t._options.defaultToAddressText).show(),
                this.$current = $('.current-hook'); //当前城市
            //监听当前城市变化
            this.$current.on('current_city_change', function (o) {
                //设置当前城市id和城市名字
                var currentCityInfo = store.getCurrentAddressInfo();
                console.log(currentCityInfo);
                t.$current.html(!indexOrderUtils.isNull(currentCityInfo.current_cityname) ? '当前城市:' + currentCityInfo.current_cityname : '当前城市:定位中..'),
                    t.$current.attr('cityid', currentCityInfo.current_cityid);
                t.$current.attr('cityname', currentCityInfo.current_cityname);
            });
            // 正在定位
//            t._geoLoading();
            //请求所有城市列表数据
            t.getCityList('', 0);
        },
        getCityList: function (departurecity, type) {
            /**获取城市列表数据*/
            var t = this;
            //先从sessionStore中取
            if (type == 0) {
                var openCityList = store.getSessionStorage('allCityList', '');
                if (indexOrderUtils.isNull(openCityList)) {
                    console.log('sessionStorage中所有城市列表为空,请求网络');
                    t._requestCityList(departurecity, type);
                } else {
                    console.log('所有城市列表不为空,使用sessionStorage中的数据');
                    t._options.cityList = openCityList;
                }
            } else {
                var endCityList = store.getSessionStorage(departurecity, '');
                if (indexOrderUtils.isNull(endCityList)) {
                    console.log('终点城市列表为空');
                    t._requestCityList(departurecity, type);
                } else {
                    console.log('终点城市列表不为空');
                    t._fillEndAddress(endCityList);
                }
            }


        },
        _requestCityList: function (departurecity, type) {
            /**请求所有城市列表, 或起点城市对应的城市列表, type:0 请求所有城市列表, type:1请求起点城市匹配的城市列表*/
            var t = this;
            $.ajax({
                type: 'POST',
                url: '/line/citylist',
                data: {
                    'departurecity': departurecity
                },
                success: function (data) {
                    console.log('【获取开通城市列表】>>>' + data);
                    if (data.status == 0) {
                        var citylist = data.data;
                        if (type == 0) {
                            t._options.cityList = citylist;
                            store.setSessionStorage('allCityList', citylist);
                        } else {
                            store.setSessionStorage(departurecity, citylist);
                            t._fillEndAddress(citylist);
                        }
                    }
                },
                error: function (xhr, type) {
                }
            })
        },
        _fillEndAddress: function (citylist) {
            //填充终点城市和地址
            var t = this;
            if (citylist.length > 0) {
                var cityname = citylist[0];
                console.log(cityname)
                // 屏蔽这个功能, 2016/08/27
//                 t._requestPlaceSearch(cityid, cityname);
                t.$txtTo.text(cityname).removeClass(t._options.defaultCls);
                t.$txtToAddress.text(t._options.defaultToAddressText).addClass(t._options.defaultCls).show();
                    t.$txtTo.attr('cityname', cityname),
                    t.$txtTo.attr('district', ''),
                    t.$txtTo.attr('address', ''),
                    t.$txtTo.attr('name', ''),
                    t.$txtTo.attr('lat', ''),
                    t.$txtTo.attr('lng', '');
                var args = {
                    'tocityname': cityname,
                    'todistrict': '',
                    'toaddress': '',
                    'toname': '',
                    'tolat': '',
                    'tolng': ''
                }
                store.savePosInfo(args);
                //填充预估价
                indexOrderUtils._requestLinePrice()
            }
        },
        _geoLoading: function () {
            /**开始加载定位*/
            var t = 0,
                o = ["", ".", "..", "..."];
            this.stopTimeHandler();
            var s = this;
            this.timerHandler = setInterval(function () {
                    s.$txtFrom.text("定位中" + o[t]).removeClass(s._options.defaultCls),
                        t++,
                    t >= 4 && (t = 0)
                },
                300)
        },
        showLoadLocationFail: function () {
            /**加载当前位置失败*/
            $('#dialog2 .weui_dialog .weui_dialog_bd').html('加载当前位置失败,请重试');
            $('#dialog2').show();
            //取消
            $('#dialog2_default').on('tap', function () {
                $('#dialog2').hide();
            });
            //确认
            $('#dialog2_primary').on('tap', function () {
                $('#dialog2').hide();
                // 正在定位
                t._geoLoading();
            });
        },
        stopTimeHandler: function () {
            /**停止计时器*/
            var t = this;
            console.log('停止定时器');
            t.timerHandler && clearInterval(t.timerHandler);
        },
        _geo_findAddress_by_lnglat: function (lnglatXY) {
            /**通过经纬度查询地址*/
            console.log('通过经纬度查询地址');
            var t = this;
            var type = indexOrderUtils._getAmapTypeDesc();
            AMap.service('AMap.Geocoder', function () {//回调函数
                //实例化Geocoder
                geocoder = new AMap.Geocoder({
                    city: "010",//城市，默认：“全国”
                    radius: 3000,
                    extensions: "all"
                });
                geocoder.getAddress(lnglatXY, function (status, result) {
                    if (status === 'complete' && result.info === 'OK') {
                        //获得了有效的地址信息:
                        try {
                            var regeocode = result.regeocode,
                                formattedAddress = regeocode.formattedAddress, //地址信息=基本行政区信息+具体信息
                                addressComponent = regeocode.addressComponent,
                                province = addressComponent.province,
                                city = addressComponent.city,
                                district = addressComponent.district,
                                township = addressComponent.township,
                                street = addressComponent.street,
                                pois = regeocode.pois,
                                baseDistrict = province + city + district + township; //基本行政信息=省+市+区+乡镇
                            console.log(addressComponent)
                            var p_name, p_address, p_lng, p_lat, geoSuccess = false;
                            if (indexOrderUtils.isContains(formattedAddress, baseDistrict)) {
                                //具体地址信息
                                p_name = formattedAddress.replace(baseDistrict, ''),
                                    p_address = p_name,
                                    p_lng = lnglatXY[0],
                                    p_lat = lnglatXY[1];
                                geoSuccess = true;
                            } else {
                                //取poi第一条
                                if (pois.length > 0) {
                                    var obj = pois[0];
                                    p_name = obj.name,
                                        p_address = obj.address + p_name,
                                        p_lng = obj.location.lng,
                                        p_lat = obj.location.lat;
                                    geoSuccess = true;
                                }
                            }
                            console.log(result)
                            if (geoSuccess) {
                                var cityInfo = indexOrderUtils._validateCity(t._options.cityList, city);
                                if (cityInfo.length > 0) {
                                    var cityid = cityInfo.split('_')[0],
                                        cityname = cityInfo.split('_')[1];
                                    t.$txtFrom.attr('cityid', cityid),
                                        t.$txtFrom.attr('cityname', cityname),
                                        t.$txtFrom.attr('district', district),
                                        t.$txtFrom.attr('address', p_address),
                                        t.$txtFrom.attr('name', p_name),
                                        t.$txtFrom.attr('lat', p_lat),
                                        t.$txtFrom.attr('lng', p_lng);
                                    t.$txtFrom.text(cityname).removeClass(t._options.defaultCls);
                                    t.$txtFromAddress.text('  ' + p_name).removeClass(t._options.defaultCls).show();
                                    var current_address_args = {
                                        'current_cityid': cityid,
                                        'current_cityname': cityname
                                    }
                                    // 将当前位置信息保存至sessionStorage中
                                    store.saveCurrentAddressInfo(current_address_args);
                                    //绑定当前城市变化事件
                                    t.$current.trigger('current_city_change', '');
                                    var args = {
                                        'fromcityid': cityid,
                                        'fromcityname': cityname,
                                        'fromdistrict': district,
                                        'fromaddress': p_address,
                                        'fromname': p_name,
                                        'fromlat': p_lat,
                                        'fromlng': p_lng
                                    }
                                    store.savePosInfo(args);
                                    //请求匹配到的终点城市
                                    t.getCityList(cityid, 1);
                                } else {
                                    //当前城市不在开通城市列表数据内
                                    var current_address_args = {
                                        'current_cityid': '0',
                                        'current_cityname': city
                                    }
                                    // 将当前位置信息保存至sessionStorage中
                                    store.saveCurrentAddressInfo(current_address_args);
                                    //绑定当前城市变化事件
                                    t.$current.trigger('current_city_change', '');
                                    //当前城市不在开通城市列表内, 需要取出默认值
                                    var first_cityname = t._options.cityList[0];
                                    t.$txtFrom.text(first_cityname).removeClass(t._options.defaultCls);
                                    t.$txtFromAddress.text(t._options.defaultFromAddressText).addClass(t._options.defaultCls).show();
                                        t.$txtFrom.attr('cityname', first_cityname),
                                        t.$txtFrom.attr('district', ''),
                                        t.$txtFrom.attr('address', ''),
                                        t.$txtFrom.attr('name', ''),
                                        t.$txtFrom.attr('lat', ''),
                                        t.$txtFrom.attr('lng', '');
                                    var args = {
                                        'fromcityname': first_cityname,
                                        'fromdistrict': '',
                                        'fromaddress': '',
                                        'fromname': '',
                                        'fromlat': '',
                                        'fromlng': ''
                                    }
                                    store.savePosInfo(args);
                                    //请求匹配到的终点城市
                                    t.getCityList('', 1);
                                    //搜索城市列表数据----屏蔽这个事件:2016/08/27
                                    // t._requestPlaceSearch(first_cityid, first_cityname, 0);
                                }
                            }
                        } catch (err) {
                            //获取地址错误
                            console.log('获取地址错误err=' + err.message);
                        }
                    } else {
                        //获取地址失败
                        console.log('获取地址失败status=' + status + ',result=' + result);
                    }
                });
            })
        }
    };
    geo._init()
})
