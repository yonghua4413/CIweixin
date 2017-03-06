/**主界面*/
require(['handlebars','dialogUtils', 'indexOrderUtils', 'data/constant', 'jquery.min'],function(Handlebars, dialogUtils, indexOrderUtils, Constant){
	var mainIndex = {
		_options:{
			onCls:"on",
			showCls:"visible",
        	hideCls:"hidden",
        	defaultCls: "default",
        	selectedCls:"selected",
			defaultText: "立即下单",
        	maxLength:100, // 常用留言的最大长度
			cache_remarkData_map:{} //缓存的常用留言列表数据
		},
		_init:function(){
			this.tabIndex = index; //初始化选中的订单类型
			this.$tabBox = $('.tabBox-tit'),
			this.$businesstype=$('.business_type'),
			this.$goRemark = $('.wrapper-remark-hook'),
			this.$txtRemark = $('.txt-remark'),
			this.$remark = $('.remark'),
			this.$radiogroup = $('.radiogroup'),
			this.$carLabels = $('.radiogroup label'),
			this.$radiobox = $('.radiobox'),
			this.$commitBtn = $('.order .btn'),//约车按钮
			this.$PageIndex = $('.page_1'), // 首页主界面
			this._bindEvent()
		},
		_bindEvent:function(){
			var t = this;
			this.$radiogroup.on('tap','label',function(){
				/**监听 选择专车类型*/
				t.$carLabels.removeClass('on');
				$(this).addClass('on');
				// 注册监听专车类型变化
				t.$carLabels.trigger('specialcar_type_change')
			});
			t.$tabBox.on('tap','li',function(){
			  var new_index = $(this).index();
			  if(new_index != t.tabIndex) {
				  $('.tabBox-tit li').eq(t.tabIndex).removeClass('on');
				  $(this).addClass('on');
				  t._switchMenu(new_index,t.tabIndex);
				  t.tabIndex = new_index;
			  }
			});
			t.$goRemark.on('click', function(){
				/**后台留言*/
				t.$remark.addClass(t._options.showCls).removeClass(t._options.hideCls);
				//隐藏主页
				t.$PageIndex.hide();
                t.getRequestRemark(t.tabIndex)
            });
		},
		_switchMenu:function(new_index,old_index){
			/**切换业务类型菜单*/
			var t = this;
			this.$businesstype.eq(new_index).addClass(this._options.onCls)
			this.$businesstype.eq(old_index).removeClass(this._options.onCls);
			// 注册监听业务类型的变化
			this.$businesstype.trigger('businesstype_change');
		},
		getRequestRemark: function(index) {
			/**获取留言数据*/
			var t = this;
			//显示加载中进度条
			dialogUtils.showLoadingToast();
			var list = t._options.cache_remarkData_map[index];
			if(!indexOrderUtils.isNull(list) && list.length > 0) {
				console.log('使用缓存中的留言列表数据');
				t._fillRemark(list);
			}else {
				console.log('请求网络中的留言列表数据');
				t._requestRemark(index);
			}
		},
		_requestRemark:function(index){
			/**请求留言*/
				var t = this;
                var car_type_array = ["sharingcar", "specialcar", "agencycar"];
                var cartype = car_type_array[index];
                $.ajax({
                      type: 'POST',
                      url: '/line/message_tpl',
                      data:{
                        cartype:cartype,
                      },
                      success: function(data){
                      	var list = data.data;
						  //添加进缓存中
						t._options.cache_remarkData_map[index] = list;
                      	t._fillRemark(list);
                       },
                      error: function(xhr, type){
						  //隐藏加载中进度条
						  dialogUtils.hideLoadingToast();
                      }
                })
            },
        _fillRemark:function(list){
			/**填充留言列表*/
			var t = this;
			var remarkContent = t.$txtRemark.hasClass('default') ? '' : t.$txtRemark.text();
			var length = this._options.maxLength - remarkContent.length;
        	var remarkTpl = [
				'<div class="title-bar-wrapper">',
            	'<div class="title-bar-left"><a class="i-back close-remark"></a></div>',
            	'<h2 class="title-bar-center-title">留言</h2></div>',
        		'<ul class="remark-list">',
        		'{{#each this}}',
        		'<li><span>+ {{this}}</span></li>',
        		'{{/each}}',
        		'</ul>',
        		'<div class="remark-input-wrapper">',
        		'<textarea class="remark-input" placeholder="请选择或输入您的特殊需求，如航班号、列车班次...">'+remarkContent+'</textarea>',
        		'<div class="remark-content-count-wrapper">',
        		'<span class="remark-count-hint">还可以输入</span>',
        		'<span class="remark-content-count">'+length+'</span>',
        		'<span class="remark-count-hint">个字</span></div>',
        		'</div>',
        		'<div class="btn-commit confirm">确认提交</div>'
        	].join('');
			var remarkHtml = Handlebars.compile(remarkTpl)(list);
			var remark = document.querySelector('.remark');
			remark.innerHTML = remarkHtml;
			//隐藏加载中进度条
			dialogUtils.hideLoadingToast();
			this._setOnclickListener();
        },
        _setOnclickListener:function(){
        	var t = this;
        	var maxLength = this._options.maxLength;
        	this.$back = $('.i-back.close-remark');
			this.$list = $('.remark-list');
			this.$input = $('.remark-input');
			this.$commit = $('.btn-commit.confirm');
			this.$count = $('.remark-content-count');

			t.$back.on('click', function(){
				t.$remark.addClass(t._options.hideCls).removeClass(t._options.showCls);
				//显示主页
				t.$PageIndex.show();
			});
			$('.remark-list li').each(function(index){
				$(this).on('click',function(){
					var d = t.$input.val();
					if(d.length < maxLength){
						var content = $(this).text();
						var c = content.substr(2,content.length);//去掉 '+ '
						var e = (typeof(d) == undefined || d.length < 1) ? c : (','+c);
						var f = (d + e).length > maxLength ? (d + e).substr(0,maxLength) : d + e;
						t._setRemainderCount(f);
					}
				});
			});
			t.$commit.on('tap', function(){
				var content = t.$input.val();
				if(content.length > 0){
					t.$txtRemark.text(content).removeClass(t._options.defaultCls);
				}else {
					//清空
					t.$txtRemark.text('给司机留言 (可不填)').addClass(t._options.defaultCls);
				}
				t.$remark.addClass(t._options.hideCls).removeClass(t._options.showCls);
				//显示主页
				t.$PageIndex.show();
			});
			//设置输入监听
			t._setOnvalueChangedListener();
			t.$input.on('valuechange',function(e, previous){
				var value = t.$input.val();
				if(value.length > maxLength){
					value = value.substr(0,maxLength);
				}
				t._setRemainderCount(value);
			});
        },
        _setRemainderCount:function(s){
        	//设置最终内容
        	this.$input.val(s);
			// 修改剩余字数
			var remainder_count = this._options.maxLength - s.length;
			this.$count.html(remainder_count);
        },
        _setOnvalueChangedListener:function(){
        	$(function(){
        	//textarea输入/粘贴/剪切监听
	        	$.event.special.valuechange = {
				  teardown: function (namespaces) {
				    $(this).unbind('.valuechange');
				  },
				  handler: function (e) {
				    $.event.special.valuechange.triggerChanged($(this));
				  },
				  add: function (obj) {
				    $(this).on('keyup.valuechange cut.valuechange paste.valuechange input.valuechange', obj.selector, $.event.special.valuechange.handler)
				  },
				  triggerChanged: function (element) {
				    var current = element[0].contentEditable === 'true' ? element.html() : element.val()
				      , previous = typeof element.data('previous') === 'undefined' ? element[0].defaultValue : element.data('previous')
				    if (current !== previous) {
				      element.trigger('valuechange', [element.data('previous')])
				      element.data('previous', current)
				    }
				  }
				};
			});
        }
	}
	//初始化
	mainIndex._init();
})
