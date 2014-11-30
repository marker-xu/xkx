/**
 * ...
 * @author 
 */
var amw = function(){};
	amw.extend=function(c,d){
		for(var e in d){c[e]=d[e]}
		return c;
	};
 /*tips组件*/
(function() {
	var _a = amw;
	/*tips*/
	var tips = function(width,height,isShowGrow){
		var o = this;
		o.width = width;
		o.height = height;
		o.isShowGrow = typeof isShowGrow == 'undefined'?true:isShowGrow;
		o.htmlStr = '<div id="tips-addphone" class="float-tips" style="width:'+width+'px;height:'+height+'px;">';
		o.htmlStr += '<div class="contenter">sss</div>';
		o.htmlStr += '<div class="close"></div>';
		if(o.isShowGrow){
			o.htmlStr += '<b class="up"></b>';
		}
		o.htmlStr += '</div>';
		
		o.border = $(this.htmlStr);
		o.closer = this.border.find(".close");
		o.contenter = this.border.find(".contenter");
		o.closer.click(function(){
			o.hide();
		});
	};
	tips.prototype = {
		width:100,
		height:100,
		has:false,
		isShow:false,
		_EventHander:function(e){
			var o = e.data.theThis;
			o.hide();
		},
		setContent:function(obj){
			var o = this;
			o.contenter.html(obj);
		},
		show:function(x,y){
			var o = this;
			o.border.css("left",x).css("top",y);
			if(!o.has){
				$("body").append(o.border);
				o.has = true;
				
			}
			if(!o.isShow){
				o.border.show();
				//绑定事件
				$(window).resize({theThis:o},o._EventHander);
				o.isShow = true;
			}
		},
		hide:function(){
			var o = this;
			if(o.isShow){
				o.border.hide();
				//移除事件
				$(window).unbind("resize",o._EventHander);
				o.isShow = false;
			}
		}
	};
	_a.tips = tips;
	/*tips - 输入自定义选项*/
	var tipsCustomInput = function(width,height){
		this.tips = new tips(width,height);
		//加入内部表单
		var formHtml = '<input type="text" class="b-addCustom-input" id="addCustomInput" name="addCustomInput" /><br/><br/>';
			formHtml += '<input type="button" name="submit-addCustom" class="submit-addCustom submit-mix" value="确定" />';
		this.tips.setContent(formHtml);
	};
	tipsCustomInput.prototype = {
		show:function(x,y){
			var o = this;
			o.tips.show(x,y);
		},
		hide:function(){
			var o = this;
			o.tips.hide();
		}
	};
	_a.tipsCustomInput = tipsCustomInput;
	
	/*tips - 输入时间控件*/
	var tipsTimeInput = function(width,height){
		this.tips = new tips(width,height);
		//加入内部表单
		var formHtml = '<input type="text" class="b-time-input" id="timeInput" name="timeInput" /><span class="maohao">:</span><input type="text" class="b-time-input" id="timeInput" name="timeInput" /><br/><br/>';
			formHtml += '<input type="button" name="submit-addCustom" class="submit-addCustom submit-mix" value="确定" />';
		this.tips.setContent(formHtml);
	};
	tipsTimeInput.prototype = {
		show:function(x,y){
			var o = this;
			o.tips.show(x,y);
		},
		hide:function(){
			var o = this;
			o.tips.hide();
		}
	};
	_a.tipsTimeInput = tipsTimeInput;
})();

/*tabs组件*/
(function() {
	var tabs = function(tabsClassSeletor,tabContentClassSeletor,activeClassName){
		this.init(tabsClassSeletor,tabContentClassSeletor,activeClassName);
	};
	tabs.prototype = {
		nowNum:0,
		init:function(a,b,c){
			var o = this;
			o.tabsClassSeletor = a;
			o.tabContentClassSeletor = b;
			o.activeClassName = c;
			$(o.tabsClassSeletor).click(function(){
				o.setActive($(this).index());
			});
			o.setActive(0);
		},
		setActive:function(num){
			var o = this;
			if(num == o.nowNum)return;
			$(o.tabsClassSeletor).each(function(){
				$(this).removeClass(o.activeClassName);
			});
			$(o.tabsClassSeletor).eq(num).addClass(o.activeClassName);
			$(o.tabContentClassSeletor).each(function(){
				$(this).hide();
			});
			$(o.tabContentClassSeletor).eq(num).show();
			o.nowNum = num;
		}
	};
	amw.tabs = tabs;
})();
function processErrorMsg( msg ) {
	var return_msg = "";
	var query = "";
	if( typeof(msg)=="object" ) {
		for(var i in msg) {
			query = "input[name='"+i+"'], select[name='"+i+"']";
			if($(query).siblings("label").length) {
				return_msg = $(query).siblings("label").text();
			} else if($(query).parent().siblings().children().length) {
				return_msg = $(query).parent().siblings().children().text();
			}
			return_msg = return_msg.replace(":", "").replace("：", "")+msg[i];
			
			break;
		}
	} else {
		return_msg = msg || "error";
	}
	return return_msg;
}