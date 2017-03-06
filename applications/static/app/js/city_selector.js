/*
 * @description: 地址选择
 * @author: 15010880
 */
window.Const = {
    PARAM: {
        STORE_ID: "10052",
    },
     WAP_GET_CITY_URL: "http://www.suning.com/webapp/wcs/stores/servlet/SNiPhoneCityView", // ${wap.getCity.url}
    WAP_GET_DISTRICT_URL: "http://www.suning.com/webapp/wcs/stores/servlet/SNiPhoneDistrictView", //${wap.getDistrict.url}
    WAP_GET_TOWN_URL: "http://www.suning.com/webapp/wcs/stores/servlet/SNiPhoneTownView" //${wap.getTown.url}
};

/*
 * @description: 多级地域选择组件
 * @author: 15010880
 */
(function(){
    window.AddressChooser = function(config){
        var _this = this;
        var $back, $tabnavs, $lis, NO_DATA = "无门店";

        this.dataSource = [];
        NO_DATA = config.nodataMsg || NO_DATA;
        this.options=config;
        this.selectedValues = config.selectedValues || ["100", null, null, null];
        this.drillDownFunc = config.drillDown || function(){};
        this.selectFunc = config.select || function(){};
        this.fields = config.fields || [
            {valueField: "provinceCode", labelField: "label", placeHolder: "省"},
            {valueField: "cityNo", labelField: "cityName", placeHolder: "市"},
            {valueField: "distNo", labelField: "distName", placeHolder: "区"},
            {valueField: "shopCode", labelField: "shopName", placeHolder: "门店"}
            //{valueField: "townNo", labelField: "townName", placeHolder: "街道/乡"}
        ];
        $.map(this.fields, function(item, index){
            item.selected = (index == 0);
            item.level = index;
        });
        this.initData = [
            {provinceCode: "100", label: '江苏'},
            {provinceCode: "190", label: '广东'},
            {provinceCode: "10", label: '北京'},
            {provinceCode: "20", label: '上海'},
            {provinceCode: "320", label: '重庆'},
            {provinceCode: "150", label: '福建'},
            {provinceCode: "210", label: '广西'},
            {provinceCode: "260", label: '甘肃'},
            {provinceCode: "220", label: '贵州'},
            {provinceCode: "130", label: '浙江'},
            {provinceCode: "90", label: '黑龙江'},
            {provinceCode: "60", label: '河北'},
            {provinceCode: "180", label: '河南'},
            {provinceCode: "170", label: '湖北'},
            {provinceCode: "160", label: '湖南'},
            {provinceCode: "140", label: '江西'},
            {provinceCode: "80", label: '吉林'},
            {provinceCode: "70", label: '辽宁'},
            {provinceCode: "270", label: '宁夏'},
            {provinceCode: "280", label: '青海'},
            {provinceCode: "110", label: '安徽'},
            {provinceCode: "230", label: '四川'},
            {provinceCode: "50", label: '山西'},
            {provinceCode: "250", label: '陕西'},
            {provinceCode: "120", label: '山东'},
            {provinceCode: "30", label: '天津'},
            {provinceCode: "290", label: '新疆'},
            {provinceCode: "300", label: '西藏'},
            {provinceCode: "240", label: '云南'},
            {provinceCode: "200", label: '海南'},
            {provinceCode: "40", label: '内蒙古'}
        ];
        $.map(this.initData, function(item, index){
            item.selected = item.provinceCode == _this.selectedValues[0]
        });
        this.dataSource[0] = this.initData;

        this.$dom = $('<div class="cart-addr-chooser">');
        this.subTemplate = [
            '{{each dataSource[index] as data i}}',
            '{{if data.selected}}',
            '<li name="{{data[field.valueField]}}" class="selected">{{data[field.labelField]}}</li>',
            '{{else}}',
            '<li name="{{data[field.valueField]}}">{{data[field.labelField]}}</li>',
            '{{/if}}',
            '{{/each}}'
        ].join("");
        this.template = [
            '<div class="sn-nav">',
            '<div class="cart-back">',
            '<div class="sn-nav-back"><a class="sn-iconbtn" href="#">返回</a></div>',
            '</div>',
            '<div class="sn-nav-title of">地址选择</div>',
            '</div>',
            '<ul class="cart-tabnavi">',
            '{{each fields as field index}}',
            '{{if field.selected}}',
            '<li class="selected">',
            '{{else}}',
            '<li>',
            '{{/if}}',
            '<input placeholder="{{field.placeHolder}}" disabled>',
            '</li>',
            '{{/each}}',
            '</ul>',
            '<div class="cart-container">',
            '<div class="cart-content">',
            '{{each fields as field index}}',
            '{{if field.selected}}',
            '<div class="cart-tab current">',
            '{{else}}',
            '<div class="cart-tab">',
            '{{/if}}',
            '<div class="cart-scroll">',
            '<ul>',
            this.subTemplate,
            '</ul>',
            '</div>',
            '</div>',
            '{{/each}}',
            '</div>',
            '</div>'
        ].join("");

        this.updateState = function(level, selectedValue, auto){
            var valueField = _this.fields[level]["valueField"];
            var labelField = _this.fields[level]["labelField"];

            var data = _this.dataSource[level];
            if (!selectedValue){
                data = data.length == 0 ? {} : data[0];
                selectedValue = data[valueField];
            }
            var target = $.grep(data, function(item){
                return item[valueField] == selectedValue;
            });
            var selectedLabel = target.length > 0 ? target[0][labelField] : "";

            $.map(_this.dataSource[level], function(item, idx){
                item.selected = item[valueField] == selectedValue;
            });

            _this.$dom.find(".cart-tabnavi li").eq(level).find("input").val(selectedLabel || NO_DATA);
           
            _this.selectedValues[level] = selectedValue;
            if (!auto) {
                _this.selectedValues = $.grep(_this.selectedValues, function(item, idx){
                    return idx <= level;
                });
            }
        };
        this.initDisplayList = function(){
            _this.$dom.empty();
            _this.removeEventListeners();
            var templateData = {
                fields: _this.fields,
                dataSource: _this.dataSource
            };
            var render = template.compile(_this.template);
            var html = render(templateData);
            _this.$dom.html(html);

            _this.updateState(0, _this.selectedValues[0], true);
            _this.drillDownFunc(_this.fields[0], _this.selectedValues[0], true);

            _this.addEventListeners();
        };
        this.updateDisplayList = function(){
            _this.removeEventListeners();
            var level = arguments[0];
            var selectedValue = arguments[1];
            var auto = arguments[2];
            var $ul = _this.$dom.find(".cart-scroll > ul").eq(level);
            $ul.empty();

            if(arguments.length == 4) {
                _this.dataSource[level] = arguments[3];
            }
            _this.updateState(level, selectedValue, auto);

            var templateData = {
                index: level,
                field: _this.fields[level],
                dataSource: _this.dataSource
            };
            var render = template.compile(_this.subTemplate);
            var html = render(templateData);
            $ul.html(html);

            _this.addEventListeners();

            if ((level + 1) < _this.fields.length && selectedValue) {
                _this.drillDownFunc(_this.fields[level], selectedValue, true);
            }
        };

        this.removeEventListeners = function(){
            $back = _this.$dom.find("> .sn-nav > .cart-back");
            $tabnavs = _this.$dom.find("> ul > li");
            $lis =_this.$dom.find(".cart-scroll li");
            $back.off("click");
            $tabnavs.off("click");
            $lis.off("click");
        };
        this.addEventListeners = function(){
            $back = _this.$dom.find("> .sn-nav > .cart-back");
            $tabnavs = _this.$dom.find("> ul > li");
            $lis = _this.$dom.find(".cart-scroll li");

            $back.on("click", function(){
                _this.toggle();
            });
            $tabnavs.on("click", function(){
                var $tabs = _this.$dom.find(".cart-content > .cart-tab");
                var index = $(this).index();
                $.map(_this.fields, function(item, idx){
                    item.selected = idx == index;
                });
                $(this).addClass("selected").siblings().removeClass("selected");
                var width = $tabs.width();
                $tabs.eq(index).addClass("current").siblings().removeClass("current");
                _this.$dom.find(".cart-content").css({
                    "-webkit-transform": "translate(" + (-width * index) + "px, 0px) translateZ(0px)",
                    "transform": "translate(" + (-width * index) + "px, 0px) translateZ(0px)"
                });
            });
            $lis.on("click", function(){
                var data = $.grep(_this.fields, function(item, idx){
                    return item.selected;
                });
                if(data.length != 1){
                    throw new Error("component error!");
                }
                data = data[0];
                var level = data.level;
                var value = $(this).attr("name");
                var oldValue = _this.selectedValues[level];

                _this.updateDisplayList(level, value, false);

                if ((level + 1) == _this.fields.length) {
                    _this.selectFunc(_this.selectedItems());
                }

                _this.$dom.find("> ul >.selected").next().trigger("click");
            });
        };

        this.initDisplayList();
    };
    window.AddressChooser.prototype = {
        active: function(){
            $("body").append(this.$dom);
        },
        updateDataSource: function(level, data, auto){

            var valueField = this.fields[level]["valueField"];
            var value =  this.selectedValues[level] || (data.length != 0 ? data[0][valueField] : null);

            this.updateDisplayList(level, value, auto, data);
        },
        selectedItems: function(){
            var result = [];
            for(var i=0; i<this.dataSource.length; i++){
                var selectedItem = {};
                $.extend(selectedItem, $.grep(this.dataSource[i], function(item){
                    return item.selected;
                })[0]);
                result.push(selectedItem);
            }
            return result;
        },
        toggle: function(){
            this.$dom.toggleClass("active");
        }
    };
})();
/*
 * @description: 事件驱动模型
 * @author: 15010880
 */
(function(){
    window.EventDispatcher = function(){
        var _this = this;
        _this.eventListeners = {};
    };
    window.EventDispatcher.prototype = {
        dispatchEvent: function (eventName, data){
            if(!this.eventListeners.hasOwnProperty(eventName)){
                return;
            }
            var handlers = this.eventListeners[eventName];
            for(var i=0; i<handlers.length; i++) {
                var handler = handlers[i];
                console.log(eventName);
                handler(data);
            }
        },
        addEventListener: function(eventName, handler){
            if(!this.eventListeners.hasOwnProperty(eventName)){
                this.eventListeners[eventName] = [];
            }
            this.eventListeners[eventName].push(handler);
        },
        removeEventListener: function(eventName){
            if(!this.eventListeners.hasOwnProperty(eventName)){
                return;
            }
            delete this.eventListeners[eventName];
        }
    }
})();

/*
 * @description: 地区-市 service
 * @author: 15010880
 */
(function () {
    window.QueryCityService = {
        request: function (provinceCode, success, error) {
            $.ajax({
                url: Const.WAP_GET_CITY_URL,
                type: "GET",
                data: {
                    storeId: Const.PARAM.STORE_ID,
                    provinceCode: provinceCode
                },
                dataType: 'jsonp',
                jsonp: "callback",
                jsonpCallback: "getCity",
                success: function(data) {
                    success(data.cityList);
                },
                error: function(){
                    error ? error(arguments) : (function(){
                        $.alert({
                            type: "mini",
                            msg: "网络连接失败，请检测您的网络环境稍后重试"
                        });
                    })();
                }
            });
        }
    }
})();
/*
 * @description: 地区-区 service
 * @author: 15010880
 */
(function () {
    window.QueryDistrictService = {
        request: function (cityId, success, error) {
            $.ajax({
                url: Const.WAP_GET_DISTRICT_URL,
                type: "GET",
                data: {
                    storeId : Const.PARAM.STORE_ID,
                    cityID : cityId
                },
                dataType: 'jsonp',
                jsonp: "callback",
                jsonpCallback: "getDistrict",
                success: function(data) {
                    success(data.districtList);
                },
                error: function(){
                    error ? error(arguments) : (function(){
                        $.alert({
                            type: "mini",
                            msg: "网络连接失败，请检测您的网络环境稍后重试"
                        });
                    })();
                }
            });
        }
    }
})();
/*
 * @description: 地区-镇 service
 * @author: 15010880
 */
(function () {
    window.QueryTownService = {
        request: function (distId, success, error) {
            $.ajax({
                url: Const.WAP_GET_TOWN_URL,
                type: "GET",
                data: {
                    storeId: Const.PARAM.STORE_ID,
                    distID: distId
                },
                dataType: 'jsonp',
                jsonp: "callback",
                jsonpCallback: "getTown",
                success: function(data) {
                    success(data.townList);
                },
                error: function(){
                    error ? error(arguments) : (function(){
                        $.alert({
                            type: "mini",
                            msg: "网络连接失败，请检测您的网络环境稍后重试"
                        });
                    })();
                }
            });
        }
    }
})();
/*
 * @description: 收货地址新增及编辑 controller
 * @author: 15010880
 */
(function(){
    var addressChooser, type, addressNo = null;
    var updateResetState = function($input) {
        if ($input.get(0).tagName == "INPUT"){
            $input.val() ? $input.next().show() :$input.next().hide();
        }
    };

    var queryCityByProvince = function(updateLevel, province, auto){
        QueryCityService.request(
            province,
            function(data){
                addressChooser.updateDataSource(updateLevel, data, auto);
            }
        )
    };
    var queryDistrictByCity = function(updateLevel, city, auto){
        QueryDistrictService.request(
            city,
            function(data){
                addressChooser.updateDataSource(updateLevel, data, auto);
            }
        )
    };
    var queryTownByDistrict = function(updateLevel, district, auto){
        QueryTownService.request(
            district,
            function(data){
                addressChooser.updateDataSource(updateLevel, data, auto);
            }
        )
    };
    var DRILL_DOWN_SERVICE = {
        "1": queryCityByProvince,
        "2": queryDistrictByCity,
        "3": queryTownByDistrict
    };
    var addressChooserConfig = {
        nodataMsg: "无",
        fields: [
            {valueField: "provinceCode", labelField: "label", placeHolder: "省"},
            {valueField: "cityNo", labelField: "cityName", placeHolder: "市"},
            {valueField: "distNo", labelField: "distName", placeHolder: "区"},
            {valueField: "townNo", labelField: "townName", placeHolder: "街道/乡"}
        ],
        drillDown: function(data, value, auto){
            var updateLevel = data.level + 1;
            DRILL_DOWN_SERVICE[updateLevel](updateLevel, value, auto);
        },
        select: function(items){
            var scope=$.map(this.options.fields,function(item,i){
                return {
                    label:items[i][item["labelField"]],
                    value:items[i][item["valueField"]]
                };
            });
            addressChooser.toggle();
            if(this.options.onselect){
                this.options.onselect.call(this,scope);
            }
        }
    };


    var dispatcher = new EventDispatcher();

    $.fn.addressChooser = function(options){
        addressChooser = new AddressChooser($.extend({},addressChooserConfig,options||{}));
        addressChooser.active();
        this.on("click", function() {
            addressChooser.toggle();
        });
        this.supper = AddressChooser;
        this.supper(options||{});
        delete this.supper;
        return this;
    };

})();