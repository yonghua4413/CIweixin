// 时间选择控件
var timeControl = {};
var yearsDatesMap = {};//日期对应年份的map
timeControl.autoShow = function (i) {
    resultSpinWheel = $("#result-spinWheel" + i);
    $(function () {
        var nowValue;
        setTimeout(function () {
            window.scrollTo(0, 0);
        }, 100);
        //获取需要向后推迟的时间
        // var afterHour = resultSpinWheel.attr("after") || 0.5; // TAG, 2016年10月29日，屏蔽了此行代码，ios10系统会报错
        var afterHour = 0.5;
        console.log('【下单时间】需要向后推迟的时间:' + afterHour);
        //初始化显示值
        InitValue(afterHour);
        /**选择时间的事件监听*/
        resultSpinWheel.off("click touchend").on("click touchend", function () {
            showTimePicker(afterHour, i);
            nowValue = getNowIndex(afterHour);
            slotSelect(nowValue);
            //禁止提交按钮
            $(".short-submit").addClass("short-invalid");
        });
    });
}

/**显示时间控件*/
function showTimePicker(afterHour, i) {
    var indexs = getIndex();
    openDateTime(indexs[0], indexs[1], indexs[2], afterHour, i);
    $("#maskDate").show();
    //监听滑动事件, 必须在界面渲染后才能设置监听事件,要不然会失效
    $('#sw-wrapper').on('touchend touchcancel mouseup', function () {
        nowValue = getNowIndex(afterHour);
        setTimeout(function () {
            slotSelect(nowValue);
        }, 100);
    });
}
//打开控件
function openDateTime(dateIndex, hourIndex, minuteIndex, afterHour, i) {
    var dateTime = new getThreeWheelData(afterHour);
    SpinningWheel.addSlot(dateTime.dates, 'date', dateIndex);
    SpinningWheel.addSlot(dateTime.hours, 'hour', hourIndex);
    SpinningWheel.addSlot(dateTime.minutes, 'minute', minuteIndex);
    SpinningWheel.setCancelAction(cancel);
    SpinningWheel.setDoneAction(done);
    SpinningWheel.open(i);

}


//今天的话，时间不能比现在早
function slotSelect(nowValue) {
    var results = SpinningWheel.getSelectedValues();
    var keys = results.keys;
    $("#sw-slots li").removeClass("checked");
    $.each(keys, function (i, key) {
        var $lala = $("#sw-slots ul").eq(i);
        var $choice = $lala.find("li").eq(key);
        $choice.addClass("checked");
    });

    if (keys[0] == 0) {
        //选择今天的日期, 需要控制选择的时间不能比当前时间早
        $('.sw-hour').show();
        $('.sw-minute').show();
        var changedMinute = Math.ceil(nowValue.indexMinute + 0);
        var changedHour = nowValue.indexHour;
        if (changedMinute >= 6) {
            if (nowValue.indexHour < 23) {
                changedMinute -= 6;
                changedHour = nowValue.indexHour + 1;
            } else {
                changedMinute = 5;
            }
        }
        // 设置提前30分钟后的小时和分钟
        if (keys[1] <= changedHour) {
            $(".sw-hour li").removeClass("checked");
            SpinningWheel.scrollToValue(1, changedHour);
            $(".sw-hour li").eq(changedHour).addClass("checked");

            //重新获取值。
            var result2 = SpinningWheel.getSelectedValues();
            if (result2.keys[1] == changedHour) {

                // 获取选择的新分钟数
                var selectedMinute;
                var firstLoad = $("#sw-slots").attr("data-today-first-load");
                if (firstLoad != 0) {
                    // 第一次加载今天选项
                    selectedMinute = parseInt(result2.keys[2] + 0) >= 6 ? parseInt(result2.keys[2] - 6) : parseInt(result2.keys[2] + 0);
                } else {
                    // 非第一次加载今天选项
                    selectedMinute = Math.ceil(result2.keys[2]);
                }
                if (selectedMinute <= changedMinute) {
                    SpinningWheel.scrollToValue(2, changedMinute);
                    $(".sw-minute li").removeClass("checked");
                    $(".sw-minute li").eq(changedMinute).addClass("checked");
                }
            }
        }
        $("#sw-slots").attr("data-today-first-load", "0");  // 非第一次选择今天
    } else {
        //不是选择今天的日期, 不需要控制选择的时间不能比当前时间早
        $('.sw-hour').show();
        $('.sw-minute').show();
        $("#sw-slots").attr("data-today-first-load", "1");  // 第一次选择今天
    }
}

/**
 初始化显示时间
 */
function InitValue(hour) {
    fillHtmlDateTime(1, hour);
}
/**确定*/
function done() {
    $("#maskDate").hide();
    fillHtmlDateTime(0, 0);
}
// 填充界面时间
function fillHtmlDateTime(type, hour) {
    var dateStr, time;
    if (type == 0) {
        //选择时间,点击"确认"按钮
        var results = SpinningWheel.getSelectedValues();
        resultSpinWheel.attr("keys", results.keys[0] + "," + results.keys[1] + "," + results.keys[2]);
        dateStr = results.values[0];
        time = results.values[1] + ":" + results.values[2];
    } else if (type == 1) {
        //初始化加载时间
        //获取 日 时 分 三个列表所在的索引位置
        var nowIndex = getNowIndex(hour);
        //生成三个时间轴列表的数据
        var nowTime = getThreeWheelData(hour);
        dateStr = nowTime.dates[0];//几月几日 周几
        time = nowTime.hours[nowIndex.indexHour] + ":" + nowTime.minutes[nowIndex.indexMinute];
    }
    var year = yearsDatesMap[dateStr];
    var splits = dateStr.split(" ");
    var date = splits[0];
    var info = splits[1];
    var content = date + "  " + time;
    //############-------------将时间渲染到界面中-------------############
    $("#start_go_time").html(content);
    resultSpinWheel.attr("timevalue", year + "-" + date.replace("月", "-").replace("日", "") + " " + time + ":00");
    console.log('【下单时间】保存选择的时间:' + resultSpinWheel.attr('timevalue'));
}
/**取消*/
function cancel() {
    $("#maskDate").hide();
}

/**获取索引*/
function getIndex() {
    var array = resultSpinWheel.attr("keys").split(",");
    var indexs = [];
    indexs.push(0 || array[0]);
    indexs.push(0 || array[1]);
    indexs.push(0 || array[2]);
    return indexs;
}

/**
 初始化 日,时,分 三个列表索引位置
 */
function getNowIndex(hour) {
    var now, indexHour, indexMinute, indexfirstMinute, dateFlag = 0;
    var beDate, afDate;
    var serverTime = getServerTime();
    now = new Date(parseFloat(serverTime));
    beDate = now.getDate();
    now.setTime(now.getTime() + hour * 60 * 60 * 1000);

    afDate = now.getDate();
    // 判断是不是要把日期改为明天
    if (afDate - beDate >= 1) {
        dateFlag++;
    }
    indexHour = now.getHours();
    //改为10分钟一个单位，不足10分钟的，往后跳一个
    if (now.getMinutes() % 10 == 0) {
        indexMinute = parseInt(now.getMinutes() / 10);
    } else {
        indexMinute = parseInt(now.getMinutes() / 10) + 1;
    }
    if (indexMinute >= 6) {
        indexHour++;
        indexMinute -= 6;
    }
    if (indexHour >= 24) {
        indexHour = 0;
        dateFlag++;
    }
    this.dateFlag = dateFlag;
    this.indexHour = indexHour;
    this.indexMinute = indexMinute;
    this.indexfirstMinute = now.getMinutes();
    return this;
}

/**
 根据需要推迟的 N 小时 (afterHour),计算-->生成三个时间轴列表的数据
 dates{}
 hours{}
 minutes{}
 */
var getThreeWheelData = function (afterHour) {
    yearsDatesMap = {};
    var serverTime = getServerTime();
    var now = new Date(parseFloat(serverTime));
    console.log('【下单时间】当前服务器时间为:' + now);
    var dates = {};
    var hours = {};
    var minutes = {0: '00', 1: '10', 2: '20', 3: '30', 4: '40', 5: '50'};
    var firstMinutes = [];

    var dateFlag = getNowIndex(afterHour).dateFlag;
    var date = new Date(parseFloat(serverTime));

    //创建日期列表
    for (var i = 1; i < 5; i++) {
        if (dateFlag == 0) {  //当今天23:20之后
            date = getDay(i);
            dates[i - 1] = getDateStr(date, i);
            var year = date.getFullYear();
            yearsDatesMap[dates[i - 1]] = year;
        } else {
            date = getDay(i + 1);
            dates[i - 1] = getDateStr(date, i + 1);
            var year = date.getFullYear();
            yearsDatesMap[dates[i - 1]] = year;
        }
    }

    for (var i = 0; i < 24; i++) {
        hours[i] = showNum(i);
    }

    for (var i = 0; i < 60; i++) {
        firstMinutes[i] = showNum(i);
    }
    this.dates = dates;
    this.hours = hours;
    this.minutes = minutes;
    this.firstMinutes = firstMinutes;
    return this;
}

/**得到今天,明天,后天-->描述信息*/
function getDateStr(date, i) {
    var dateStr;
    dateStr = showNum(date.getMonth() + 1) + "月" + showNum(date.getDate()) + "日";
    switch (i) {
        case 1:
            dateStr += (" " + "今天");
            break;
        case 2:
            dateStr += (" " + "明天");
            break;
        case 3:
            dateStr += (" " + "后天");
            break;
        default:
            dateStr += (" " + getWeekDay(date));
    }
    return dateStr;
}

/**
 得到 周几 样式
 */
function getWeekDay(date) {
    var days = {0: "周日", 1: "周一", 2: "周二", 3: "周三", 4: "周四", 5: "周五", 6: "周六"};
    return days[date.getDay()];
}

//获取时间
function getDay(day) {
    var serverTime = getServerTime();
    var date = new Date(parseFloat(serverTime));
    var targetday_milliseconds = serverTime + 1000 * 60 * 60 * 24 * (day - 1);
    date.setTime(targetday_milliseconds); //注意，这行是关键代码
    return date;
}

//把个位数的0补全
function showNum(num) {
    num = num > 9 ? num : "0" + num;
    return num;
}

/**得到服务器当前时间*/
function getServerTime() {
    var serverTime = new Date().getTime();
    return serverTime;
}
