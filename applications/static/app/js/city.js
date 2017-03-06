define(['bscroll', 'handlebars'], function (BScroll, Handlebars) {

	var cityWrapper = document.querySelector('.city-wrapper-hook');
	var cityScroller = document.querySelector('.scroller-hook');
	var cities = document.querySelector('.cities-hook');
	var shortcut = document.querySelector('.shortcut-hook');
	var $cityWrapper = $('.city-wrapper-hook');

	var cityScroll;

	var anchorMap = {};

	function initCities(cityData) {
		var cityTpl = [
			'{{#each this}}',
			'<div class="title">',
			'{{name}}',
			'</div>',
			'<ul>',
			'{{#each cities}}',
			'<li class="item" cityname="{{cityname}}">',
			'<span class="border-1px cityname">{{cityname}}</span>',
			'</li>',
			'{{/each}}',
			'</ul>',
			'{{/each}}'].join('');

		var cityHtml = '<ul>';
		$.each(cityData, function(k, v){
			cityHtml += '<li class="item" cityname="'+v+'">';
			cityHtml += '<span class="border-1px cityname">'+v+'</span>';
			cityHtml += '</li>';
		})
		cityHtml += '</ul>';
		cities.innerHTML = cityHtml;
		//注册滚动监听事件
		cityScroll ? cityScroll.refresh : (cityScroll = new BScroll(
			$cityWrapper[0]),
            cityScroll.on("beforeScrollStart",function() {
            	$cityWrapper.trigger("cityscroll")
        	}
            )
		);
		cityScroll.scrollTo(0, 0);
	};

	function initShortCut(cityData) {
		var y = -44;
		var titleHeight = 28;
		var itemHeight = 44;
		var shortcutList = [];
		console.log(cityData)
		cityData.forEach(function (group) {
			var name = group.name.substr(0, 1);
			var len = group.cities.length;
			shortcutList.push(name);
			anchorMap[name] = y;
			y -= titleHeight + len * itemHeight;
		});

		var shortcutTpl = [
			'<ul>',
			'{{#each this}}',
			'<li data-anchor="{{this}}" class="item">{{this}}</li>',
			'{{/each}}',
			'</ul>'].join('');

		var shortcutHtml = Handlebars.compile(shortcutTpl)(shortcutList);
		shortcut.innerHTML = shortcutHtml;
		shortcut.style.top = (cityWrapper.clientHeight - shortcut.clientHeight) / 2 + 'px';
	};

	//bind Event
	function bindEvent() {
		var touch = {};
		var firstTouch;

		shortcut.addEventListener('touchstart', function (e) {

			var anchor = e.target.getAttribute('data-anchor');

			firstTouch = e.touches[0];
			touch.y1 = firstTouch.pageY;
			touch.anchor = anchor;
			scrollTo(anchor);
		});

		shortcut.addEventListener('touchmove', function (e) {

			firstTouch = e.touches[0];
			touch.y2 = firstTouch.pageY;

			var anchorHeight = 16;

			var delta = (touch.y2 - touch.y1) / anchorHeight | 0;

			var anchor = shortcutList[shortcutList.indexOf(touch.anchor) + delta];

			scrollTo(anchor);
			e.stopPropagation();
			e.preventDefault();

		});

		function scrollTo(anchor) {
			var maxScrollY = cityWrapper.clientHeight - cityScroller.clientHeight;

			var y = Math.min(0, Math.max(maxScrollY, anchorMap[anchor]));
			if (typeof y !== 'undefined') {
				cityScroll.scrollTo(0, y);
			}
		}
	};

	function addCityList(cityData) {
		initCities(cityData);
//		initShortCut(cityData);
		bindEvent();
 	};

 	 return {
 	 	addCityList:addCityList
 	 }
});


