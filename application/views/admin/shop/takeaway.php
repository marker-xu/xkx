<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台-外送设置<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/css/main-b.min.css?v=<%#v#%>">
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
				<h4 class="tit6">外送设置</h4>
				<div class="form-body">
					<table class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr><td class="keys">支持设置:</td><td class="values">
							<input id="isTake0" class="radios" name="isTake" type="radio" value="0" checked="checked" /><label for="isTake0">不支持</label>
							<input style="margin-left:30px;" id="isTake1" class="radios" name="isTake" type="radio" value="1" /><label for="isTake1">支持</label>
						</td></tr>
						<tr><td>外送范围:</td><td class="values"><select><option value="111">方圆三公里</option></select></td></tr>
						<tr><td>外送条件:</td><td class="values">订单满<input type="text" class="b-money-input" id="moneyInfo" name="moneyInfo" />元</td></tr>
						
					</table>
					<input id="submiter" type="button" name="submiter" class="submiter" value="保存" />
				</div>
			</div>
			
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<%/block%>