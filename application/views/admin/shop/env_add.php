<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台-环境图片上传<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/css/main-b.min.css?v=<%#v#%>">
<style>
.txt{ height:22px; border:1px solid #cdcdcd; width:180px;} 
.btn{ background-color:#FFF; border:1px solid #CDCDCD;height:24px; width:70px;} 
.file{ position:absolute; top:479px; left:1024px; height:24px; filter:alpha(opacity:0);opacity: 0;width:260px }
</style>
<%/block%>

<%block name="custom_js"%>
<script type="text/javascript" src="<%#resUrl#%>/js/admin/common/common.js?v=<%#v#%>"></script>
<script type="text/javascript" src="<%#resUrl#%>/js/admin/common/main-b.js?v=<%#v#%>"></script>
<script type="text/javascript" src="<%#resUrl#%>/js/third/bootstrap/bootstrap.js"></script>
<%/block%>
<%block name="bd"%>
<div id="main-body">
	<div class="center float_box">
		<%include file="inc/admin/left.inc"%>
		<div class="contents">
			
			<%include file="inc/admin/shop_header.inc"%>
			<div id="base-info">
				<h4 class="tit2">就餐环境</h4>
				<div class="form-body">
				<form  method="post" enctype="multipart/form-data" action="/admin/shop/env_add"＞
                <br />
				<%Form::hidden('shop_id', $shop_id)%>
                <%Form::hidden('csrf_token', Security::token())%>
					<div class="no-shop-photo">
						<br/><br/><br/>
						你还没有上传就餐的环境照片，现在就来上传吧<br/>
						<input type='text' name='textfield' class='txt' /> 
						<input type="button" class="submit-shop-photo submit-mix" value="浏览..." />
						<input type="file" name="shop_photo" class="file" size="28"  /> 
					</div>
					<br/>
						<input type="submit" class="submit-shop-photo submit-mix"  value="提交"/>
			    </form>
				</div>
			</div>
			
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<script type="text/javascript">
$(document).ready(function(){
    $("input[name='shop_photo']").change(function(){
    	$("input[name='textfield']").val($(this).val());
        });
    var offsetTmp = $("input.submit-shop-photo").offset();
	$("input[name='shop_photo']").css('top', offsetTmp.top);
	$("input[name='shop_photo']").css('left', offsetTmp.left);
});
</script>
<%/block%>