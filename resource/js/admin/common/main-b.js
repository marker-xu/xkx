/**
 * ...
 * @author 小辉
 */
$(document).ready(function(){
	/*基本信息*/
	var phoneNum = 1; //当前的电话输入框个数
	$('#addPhone').click(function(){
		phoneNum ++;
		var addPhoneHtml = '<br class="brs" /><input type="text" class="phone b-phone-input" name="phone[]" id="phone'+phoneNum+'" /><a class="delPhone margin-l-little" href="javascript:void(0)">删除</a>';
		$('.add-phones').append(addPhoneHtml);
		if(phoneNum==4){
			$('#addPhone').hide();  
			$('#lastTip').show().html('最多只能添加'+phoneNum+'条记录');
		}	
		
	});
	//委托绑定删除按钮事件
	$('.add-phones').delegate('.delPhone','click',function(e){
		var index = $('.delPhone').index(this);
		index = index + 1;
		
		$('.phone').eq(index-1).remove();
		$('.brs').eq(index-1).remove();
		$(this).remove();
		if(phoneNum==2){
			$('#lastTip').hide();
			$('#addPhone').show();
		}
		phoneNum --;
	});
	
	/*通用增加自定义选项*/
	var tips = new amw.tipsCustomInput(250,80);
	$('#addSelectItem').click(function(){
		var position = $(this).position();
		tips.show(position.left + 12,position.top + 22);
	});
	
	/*营业时间*/
	var timeTips = new amw.tipsTimeInput(158,80);
	$('.setTime a').click(function(){
		var position = $(this).position();
		timeTips.show(position.left,position.top + 48);
	});
	
	/*优惠信息设置*/
	
	//tabs
	var youhuiTabs = new amw.tabs('.tabs .tabItem','.tabs .tabContent','active');
	//增加优惠信息
	var youhuiNum = 1; //当前的输入框个数
	$('#addYouhui').click(function(){
		youhuiNum ++;
		var addPhoneHtml = '<br class="brs" /><input type="text" class="youhuiInfo b-youhui-input" /><a class="delYouhui margin-l-little" href="javascript:void(0)">删除</a>';
		$('.edit-youhui').append(addPhoneHtml);
		if(youhuiNum==4){
			$('#addYouhui').hide();  
			$('#lastTip').show().html('最多只能添加'+youhuiNum+'条记录');
		}	
	});
	//委托绑定删除按钮事件
	$('.edit-youhui').delegate('.delYouhui','click',function(e){
		var index = $('.delYouhui').index(this);
		index = index + 1;
		console.log(index);
		
		$('.youhuiInfo').eq(index).remove();
		$('.brs').eq(index-1).remove();
		$(this).remove();
		if(youhuiNum==2){
			$('#lastTip').hide();
			$('#addYouhui').show();
		}
		youhuiNum --;
		
	});
	
	//tabs周
	var weekTabs = new amw.tabs('#weekTabs .weekItem','#weekTabs .weekTabContent','active2');
	
	/*添加特价菜*/
	var addCaitips = new amw.tips(450,300,false);
	$('.addCai').click(function(){
		var position = $('#weekTabs').position();
		addCaitips.show(position.left + 180,position.top + 122);
	});
	//菜品tab
	var caiTabs = new amw.tabs('#caiTabs .weekItem','#caiTabs .weekTabContent','active2');
});