define(['bscroll', 'city', 'store', 'dialogUtils', 'indexOrderUtils', 'handlebars', 'http://webapi.amap.com/maps?v=1.3&key=d53e69a5a885cf218ae5bdc1a311826f&callback=init'], function (BScroll, city, store, dialogUtils, indexOrderUtils, Handlebars) {
	//地图对象
	var map;
	//地图标记对象
	var map_maker;
    var suggestSearch = {
        _options: {
            // 基础配置
            addressPlaceholder: "",
            noMatchTpl: '<div class="no-result">没有匹配城市</div>',
            showCls: "visible",
            hideCls: "hidden",
            defaultCls: "default",
            inputDelay: 150,
            sugMaxLength: 20,
            qtype: 0,	//标识选择起点还是终点, 0: 起点, 1: 终点
            is_first_select_startAddress: true,  //标识是第一次选择起点地址
            cityData: [],  //开通的城市列表数据
            locationSearchTypes: indexOrderUtils._getAmapTypeDesc(), //地图地址搜索类型限制
            defaultHtmlData: '',  //初始化此界面时,的页面内容数据
            is_first_init: true //是否为第一次初始化
        },
        _show: function (qtype, addressPlaceholder, cityid, cityname) {
            var t = this;
            t._options.is_first_init = true;
            t._options.defaultHtmlData = '';
            t.showCity = !1;
            t.posScroll = null;
            $('.page_1').hide();
            // 显示suggest界面
            this._init(qtype, addressPlaceholder, cityid, cityname);

            this._bindEvent();

            //显示地图
            map = new AMap.Map('show_map',{
            	 resizeEnable: true,
            })
            map_maker = new AMap.Marker({map:map})
            if(cityname == ''){
            	t._showLocationMap(qtype);
            }else{
            	t._showCityMap(cityname);
            }
            //判断起点和终点是否为空
            var posInfo = store.getPosInfo();
            var currentAddressInfo = store.getCurrentAddressInfo();
            this._switchMenu(0)
            
        },
        _hide: function () {
            // 隐藏suggest界面
            this.$suggest.addClass(this._options.hideCls).removeClass(this._options.showCls);
            $('.page_1').show();
        },
        _init: function (qtype, addressPlaceholder, cityid, cityname) {
            // 初始化变量
            this.is_show = false;
            this.$mainPage = $('.page_1'),//首页
                this.$txtFrom = $('.txt-from'),//起点
                this.$txtTo = $('.txt-to'),//终点
                this.$txtFromAddress = $('.txt-from-address'),//起点--详细地址
                this.$txtToAddress = $('.txt-to-address'),//终点--详细地址
                this.$suggest = $('.suggest'),
                this.$city = $('.city'),
                this.$cities = $('.cities-hook'),
                this.$cityname = $('.cityname'),
                this.$current = $('.current-hook'),
                this.$cancel = $(".cancel-hook"),
                this.$citywrapper = $(".city-wrapper-hook"),

                this.$cityinput = $(".city-input-hook"),
                this.$addressinput = $('.address-input-hook'),

                this.$cityselectwrapper = $('.city-select-wrapper-hook'),
                this.$cityselect = $('.city-select-hook'),
                this.$addressselect = $('.address-select-hook'),

                this.$poswrapper = $(".pos-wrapper-hook"),
                this.$posscroller = $('.pos-scroller-hook'),

                this.$match = $(".match-hook"),
                this.$matchscroller = $('.match-scroller-hook'),
                this._options.qtype = qtype,
                this._options.addressPlaceholder = addressPlaceholder,
                this.$suggest.addClass(this._options.showCls).removeClass(this._options.hideCls),
                this.$addressinput.attr("placeholder", this._options.addressPlaceholder);
            //设置城市id和城市名字
            this.$cityname.attr('cityid', cityid),
                this.$cityname.attr('cityname', cityname),
                this.$cityname.text(indexOrderUtils.isNull(cityname) ? '选择城市' : cityname);
            this.$addressinput.focus(); // init时, 增加输入地址input控件的焦点
            this.$addressinput.val(""); // init时, 增加输入地址input控件的焦点
        },
        _bindEvent: function () {
            var t = this;
            function s() {
                a !== e && (a = e, "" === e ? t.fillDefaultHtml() : t._searchKeywords(t._options.sugMaxLength))
            }
            this.$addressinput.on("click", function () {
                t.$addressinput.focus();
            });
            // 绑定点击事件
            this.$citywrapper.on("cityscroll", function () {
                //当滚动时,屏蔽焦点
                t.$cityinput.blur()
            });
            this.$match.on("cityscroll", function () {
                //当滚动时,屏蔽焦点
                t.$cityinput.blur()
            });
            this.$poswrapper.on("posscroll", function () {
                //当滚动时,屏蔽焦点
                t.$addressinput.blur()
            });
            this.$cityselect.on("tap", function () {
                //切换--选择城市
                t.showCity || (t.showCity = !0, t._switchMenu(t.showCity))
            });
            this.$addressselect.on("tap", function () {
                //切换--选择地址
                t.showCity && (t.showCity = !1, t._switchMenu(t.showCity))
            });
            this.$cityinput.on('input', function () {
                //输入城市搜索
                //先判断缓存中是否已经有citydata数据
                if (t._options.cityData.length > 0) {
                    t._matchCity(t._options.cityData);
                } else {
                    t._requestCityListData(1);
                }

            });
            var o = 0,
                e = null,
                a = null,
                c = this._options.inputDelay;
            this.$addressinput.on('input', function () {
                // 输入地址搜索
                e = $(this).val().trim(),
                    clearTimeout(o),
                    o = setTimeout(s, c)
            });
            this.$cancel.on("tap", function () {
                t._hide();
                // 取消
                t.is_show = false;
            });

            this.$current.on('tap', function () {
                //选择当前城市
                var cur_cityid = t.$current.attr('cityid'),
                    cur_cityname = t.$current.attr('cityname');
                cur_cityid == '0' ? indexOrderUtils.isNull(cur_cityname) ? dialogUtils.showToast(0, '无法获取当前城市,请选择其他城市', 2000, "240px", "-120px") : dialogUtils.showToast(0, '当前城市未开通,请选择其他城市', 2000, "240px", "-120px") : t._fillCity($(this));
            });
            this.$matchscroller.on('tap', 'li', function () {
                //选择匹配的城市
                t._fillCity($(this));
            });
            this.$posscroller.on('tap', 'li', function (e) {
                //选择poi信息
                var cityid = t.$cityname.attr('cityid'),
                    cityname = t.$cityname.attr('cityname'),
                    district = $(this).attr('adname'),
                    address = $(this).attr('address'),
                    name = $(this).attr('name'),
                    lat = $(this).attr('lat'),
                    lng = $(this).attr('lng');
                var d = {
                    'qtype': t._options.qtype,
                    'cityid': cityid,
                    'cityname': cityname,
                    'district': district,
                    'address': address,
                    'name': name,
                    'lat': lat,
                    'lng': lng
                };
                if (t._options.qtype == 0) {
                    var from_args = {
                        'fromcityid': cityid,
                        'fromcityname': cityname,
                        'fromdistrict': district,
                        'fromaddress': address,
                        'fromname': name,
                        'fromlat': lat,
                        'fromlng': lng
                    };
                    store.savePosInfo(from_args);
                } else {
                    var to_args = {
                        'tocityid': cityid,
                        'tocityname': cityname,
                        'todistrict': district,
                        'toaddress': address,
                        'toname': name,
                        'tolat': lat,
                        'tolng': lng
                    };
                    store.savePosInfo(to_args);
                }
                // $('.suggest').trigger("sugselect", d);
                t._hide();
                var s = d;
                var a = s.qtype == 0 ? t.$txtFrom : t.$txtTo;
                var b = s.qtype == 0 ? t.$txtFromAddress : t.$txtToAddress;
                a.attr('cityid', s.cityid),
                    a.attr('cityname', s.cityname),
                    a.attr('district', s.district),
                    a.attr('address', s.address),
                    a.attr('name', s.name),
                    a.attr('lat', s.lat),
                    a.attr('lng', s.lng);
                a.text(s.cityname).removeClass(t._options.defaultCls);
                b.text(' ' + s.name).removeClass(t._options.defaultCls).show();
                //填充预估价
                indexOrderUtils._requestLinePrice();
            });
        },
        fillDefaultHtml: function () {
            /**填充默认界面数据*/
            var t = this;
            $('.pos-scroller-hook').html(t._options.defaultHtmlData);
        },
        _switchMenu: function (s) {
            // 切换----选择城市 / 选择地址
            s ?
                (
                    // 选择城市
//                    this.$cityselect.hide(),	// "选择城市"标识 / 当前城市名称
                        this.$poswrapper.hide(),	//poi地址信息
//                        this.$cityinput.show().val(""),	//搜索城市名字输入框
                        this.$addressinput.blur(),
                        this._selectFromCityList(),	//加载城市列表
                        this.$citywrapper.show(),	//城市列表布局
                        this.$match.hide()	//匹配的城市列表
                ) :
                (
                    // 选择地址
                    this.$cityselect.show(),
                        this.$poswrapper.show(),
//                        this.$cityinput.hide(),
                        this.$city.hide(),
                        this.$addressinput.val("")
                );
//            var t = (s == 1) ? "50%" : this.$cityselectwrapper.width() + 20;
//            this.$addressselect.css({left: t});
        },
        _fillCity: function (a) {
            //填充城市名称
            var t = this;
            var cityid = a.attr('cityid'),
                cityname = a.attr('cityname');
            this.$cityname.attr('cityid', cityid),
                this.$cityname.attr('cityname', cityname),
                this.$cityname.html(cityname);
            t.showCity = !1;
             this._searchKeywords(t._options.sugMaxLength);
                this._switchMenu(t.showCity);
            t._options.is_first_init = true;
            t._options.defaultHtmlData = '';
            dialogUtils.showLoadingToast('');
        },
        _selectFromCityList: function () {
            //从城市列表中选择城市
            var t = this;
            this.$city.show();
            if (!this.is_show) {
                this.is_show = true;
                // this._requestCityListData();
                //先判断缓存中是否已经有citydata数据
                if (t._options.cityData.length > 0) {
                    city.addCityList(t._options.cityData);
                    this._bindCityOnTap()
                } else {
                    t._requestCityListData(0);
                }
            }
        },
        _requestCityListData: function (flag) {
            /**请求获取城市列表数据*/
            var t = this;
            dialogUtils.showLoadingToast('');
            $.ajax({
                type: 'POST',
                url: '/line/citylist',
                data: {
                    departurecity: ''
                },
                success: function (data) {
                    if (!indexOrderUtils.isNull(data)) {
                        var list = data.data;
                        t._options.cityData = list;
                        if (flag == 0) {
                            //展示城市列表
                            city.addCityList(t._options.cityData);
                            t._bindCityOnTap()
                        } else {
                            //搜索城市列表
                            t._matchCity(t._options.cityData);
                        }
                    }
                    dialogUtils.hideLoadingToast();
                },
                error: function (xhr, type) {
                    dialogUtils.hideLoadingToast();
                }
            });
        },
        _bindCityOnTap: function () {
            var t = this;
            // 绑定城市列表的选择事件
            this.$cities.find('ul').each(function () {
                $(this).find('li').each(function () {
                    $(this).on('tap', function () {
                        t._fillCity($(this));
                    });
                });
            })
        },

        //获取地址列表
        get_address_list: function (lng_lat, queryType, is_need_search_poi) {
            /**
             * 查询用户常用地址
             * @param: lng_lat: 经纬度
             * @param: queryType: 查询类型, 0: 查询周边, 1: 查询关键字
             * @param: is_need_search_poi: 是否需要搜索poi, 只有当选择终点地址并且终点地址经纬度为空时,这时才为false,不执行poi搜索
             * */
            $('.pos-scroller-hook').html('');
            var t = this;
            if (is_need_search_poi) {
                queryType == 0 ? t._searchAround(lng_lat, t._options.sugMaxLength) : t._searchKeywords(t._options.sugMaxLength);
            }
        },
        _searchAround: function (lng_lat, offeset) {
            /**根据经纬度, 搜索周边pois*/
            var t = this;
            dialogUtils.showLoadingToast('');
            var city = this.$cityname.attr('cityname');
            t.placeSearch ? t.goSearchNearBy(city, offeset, lng_lat) : AMap.service('AMap.PlaceSearch', function () {//回调函数
                //实例化PlaceSearch
                t.placeSearch = new AMap.PlaceSearch({
                    pageIndex: 1,
                    citylimit: 'true',
                    extensions: 'all',
                    type: t._options.locationSearchTypes
                });
                t.goSearchNearBy(city, offeset, lng_lat);
            });
        },
        _searchKeywords: function (offset) {
            /**根据关键字, 搜索匹配的pois*/
            var t = this;
            // 高德地图poi搜索
            // $('.pos-scroller-hook').html('');
            var city = this.$cityname.attr('cityname'),
                searchKey = this.$addressinput.val().trim();
            var keywords = (indexOrderUtils.isNull(searchKey)) ? city : searchKey;
            t.placeSearch ? t.goPlaceSearch(city, offset, keywords) : AMap.service('AMap.PlaceSearch', function () {//回调函数
                //实例化PlaceSearch
                t.placeSearch = new AMap.PlaceSearch({
                    pageIndex: 1,
                    citylimit: 'true',
                    extensions: 'all',
                    type: t._options.locationSearchTypes
                });
                t.goPlaceSearch(city, offset, keywords);
            });
        },
        goSearchNearBy: function (city, offeset, lng_lat) {
            /**搜索周边*/
            var t = this;
            t.placeSearch.setCity(city);
            t.placeSearch.setPageSize(offeset);
            t.placeSearch.searchNearBy("", lng_lat, 1000, function (status, result) {
                //隐藏加载中
                dialogUtils.hideLoadingToast();
                if (status === 'complete' && result.info == 'OK') {
                    var pois = result.poiList.pois;
                    var lnglat = new AMap.LngLat(pois[0].location.lng, pois[0].location.lat)
                    map.setCenter(lnglat)
                    map.setZoom(15)
                    var center = map.getCenter();
		        	var lng_lat = [center.lng, center.lat];
		        	map_maker.setPosition(lng_lat);
                    var dragListener = AMap.event.addListener(map, 'dragend', function(){t._dragMap()})
                    if (pois.length > 0) {
                        t._liLoop($('.pos-scroller-hook'), pois, offeset);
                    }
                } else {
                  
                }
            });
        },
        goPlaceSearch: function (city, offeset, keywords) {
            /**关键字查询*/
            var t = this;
            t.placeSearch.setCity(city);
            t.placeSearch.setPageSize(offeset);
            t.placeSearch.search(keywords, function (status, result) {
                //隐藏加载中
                dialogUtils.hideLoadingToast();
                if (status === 'complete' && result.info == 'OK') {
                    var pois = result.poiList.pois;
                    var lnglat = new AMap.LngLat(pois[0].location.lng, pois[0].location.lat)
                    map.setCenter(lnglat)
                    map.setZoom(15)
                    var center = map.getCenter();
		        	var lng_lat = [center.lng, center.lat];
		        	map_maker.setPosition(lng_lat);
                    var dragListener = AMap.event.addListener(map, 'dragend', function(){t._dragMap()})
                    if (pois.length > 0) {
                        t._liLoop($('.pos-scroller-hook'), pois, offeset);
                    }
                }
            });
        },
        _liLoop: function (loopClass, pois, offset) {
            // 遍历地图搜索的pois集合
            var t = this;
            var resultTpl = '';
            pois.forEach(function (poi, index) {
                var name = poi.name,
                    address = (poi.address == false || poi.address.length == 0) ? poi.name : poi.address,
                    adname = poi.adname, // 区域
                    lng = poi.location.lng,
                    lat = poi.location.lat;
                var subHtml = '<li data-index=' + index + ' lat=' + lat + ' lng=' + lng + ' adname=' + adname + ' address=' + address + ' name=' + name + '><div class="poi-item-icon"><i class="icon-index i-location-address"></i></div><div class="poi-item"><span class="name name-hook">' + name + '</span><span class="border-1px address address-hook">' + address + '</span></div></li>';
                resultTpl += subHtml;
            });
            offset == t._options.sugMaxLength ? loopClass.html(resultTpl) : loopClass.append(resultTpl);
            if (t._options.is_first_init) {
                //第一次加载进来
                t._options.is_first_init = false;
                t._options.defaultHtmlData += resultTpl;
            }
            var a = this;
            a.posScroll ? a.posScroll.refresh : (a.posScroll = new BScroll(a.$poswrapper[0], {
                tap: "scrollTap"
            }),
                a.posScroll.on("beforeScrollStart", function () {
                    //当滚动时,屏蔽焦点
                    a.$addressinput.blur()
                }));

            a.posScroll.scrollTo(0, 0);
        },
        _matchCity: function (cityData) {
            var t = this;
            // 匹配城市
            $(".match-scroller-hook li").remove();
            var cityName = this.$cityinput.val();
            if ("" === cityName) {
                return this.$match.hide(), this.$citywrapper.show();
            } else {
                this.$citywrapper.hide(), this.$match.show();
            }
            var matchList = [];
            var reg = new RegExp("^" + t._pregQuote(cityName), "i");
            cityData.forEach(function (group, index) {
                if (index > 0) {
                    group.cities.forEach(function (city) {
                        var tag = city.tags.split(",");
                        if (reg.test(tag[0]) || reg.test(tag[1])) {
                            matchList.push({
                                cityid: city['cityid'],
                                cityname: city['cityname']
                            });
                        }
                    });
                }
            });
            if (matchList.length > 0) {
                var matchList_html = '';
                matchList.forEach(function (city) {
                    matchList_html += '<li class="item border-1px " cityname=' + city.cityname + ' cityid=' + city.cityid + '>' + city.cityname + '</li>';
                });
                this.$matchscroller.html(matchList_html);
                this.$match.show();
                this.$citywrapper.hide();
                var a = this;
                a.matchScroll ? a.matchScroll.refresh : (a.matchScroll = new BScroll(a.$match[0]),
                    this.matchScroll.on("beforeScrollStart", function () {
                        a.$match.trigger("cityscroll")
                    }));
                a.matchScroll.scrollTo(0, 0);

            } else {
                this.$matchscroller.html(this._options.noMatchTpl);
            }
        },
        _pregQuote: function (n) {
            return (n + "").replace(new RegExp("[.\\\\+*?\\[\\^\\]$(){}=!<>|:\\" + (0 || "") + "-]", "g"), "\\$&");
        },
        //显示当前位置地图
        _showLocationMap: function(qtype){
        	//定位
        	var t = this;
            var lng_lat;
            map.plugin('AMap.Geolocation', function() {
                geolocation = new AMap.Geolocation({
                    enableHighAccuracy: true,//是否使用高精度定位，默认:true
                    timeout: 10000,          //超过10秒后停止定位，默认：无穷大
                    buttonOffset: new AMap.Pixel(10, 20),//定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
                    zoomToAccuracy: false,      //定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
                    buttonPosition:'RB',
                    showButton:false
                });
                map.addControl(geolocation);
                geolocation.getCurrentPosition();
                AMap.event.addListener(geolocation, 'complete', function(result){
                	//周边搜索
                	lng_lat = [result.position.lng, result.position.lat];
                	var dragListener = AMap.event.addListener(map, 'dragend', function(){t._dragMap()})
        			t._searchAround(lng_lat, 20);
                });//返回定位信息
                AMap.event.addListener(geolocation, 'error', function(error){
                	console.log(error)
                });      //返回定位出错信息
            });
        },
        //显示所选城市地图
        _showCityMap:function(cityname){
        	var t = this;
        	t.get_address_list('', 1, true);
        },
        //拖拽地图时获取中心点坐标，并更新地址列表
        _dragMap:function(){
        	t = this;
        	var center = map.getCenter();
        	var lng_lat = [center.lng, center.lat];
        	map_maker.setPosition(lng_lat);
        	t._searchAround(lng_lat, 20);
        }
    };
    return {
        suggestSearch: suggestSearch
    }
});

