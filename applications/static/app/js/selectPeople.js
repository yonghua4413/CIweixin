var $selectPoepleNum = $('.wrapper-togetherCar-hook');
var data1 = [
	// {
	// 	text: '0成人',
	// 	value: 0
	// },
	{
		text: '1成人',
		value: 1
	}, {
		text: '2成人',
		value: 2
	}, {
		text: '3成人',
		value: 3
	}, {
		text: '4成人',
		value: 4
	}, {
		text: '5成人',
		value: 5
	}, {
		text: '6成人',
		value: 6
	}
];

var data2 = [
	{
		text: '0儿童',
		value: 0
	},
	{
		text: '1儿童',
		value: 1
	},{
		text: '2儿童',
		value: 2
	},{
		text: '3儿童',
		value: 3
	},{
		text: '4儿童',
		value: 4
	},{
		text: '5儿童',
		value: 5
	},{
		text: '6儿童',
		value: 6
	},

];

$selectPoepleNum.picker({
	data: [data1, data2],
	selectIndex: [0, 0],
	title: '选择人数'
}).on('picker.select', function (e, selectVal, selectIndex) {
	var adult = data1[selectIndex[0]].value;
	var child = data2[selectIndex[1]].value;
	$('.txt-people.adult').text(adult);
	$('.txt-people.child').text(child);
	//注册监听事件
	$('.txt-people.adult').trigger("people_num_change");
	$selectPoepleNum.picker('hide');
}).on('picker.change', function (e, index, selectIndex) {
	console.log(index);
	$('.txt-people.adult').trigger("people_num_change");
}).on('picker.valuechange', function (e, selectVal, selectIndex) {
	$('.txt-people.adult').trigger("people_num_change");
});

$selectPoepleNum.on('tap', function () {
	//再使用webpack的情况下,同时加载jquery,这行代码报错
	// $(this).picker('show');
	$selectPoepleNum.picker('show');
});



