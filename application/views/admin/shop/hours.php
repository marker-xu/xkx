<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台-营业时间<%/block%>
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
				<h4 class="tit3"><p class="h4link"><a href="javascript:viod(0)">休业</a></p>营业时间</h4>
				<div class="form-body">
					<div class="tipstxt">下面的表格是设置每一周的营业时间段，如有突发事件需要临时终止营业，请点击右上角“休业”</div>
					<table class="form-table-time" cellpadding="0" cellspacing="0" border="0">
						<tr><th class="keys"></th><th class="values">工作日<span style="color:#999">（周一到周五）</span></th><th class="values">周末</th></tr>
						<tr><td class="keys">开门时间</td><td class="values"><div class="setTime"><a href="javascript:void(0)">设置时间</a></div></td><td class="values"><div class="setTime"><a href="javascript:void(0)">设置时间</a></div></td></tr>
						<tr><td class="keys">打烊时间</td><td class="values"><div class="setTime"><a href="javascript:void(0)">设置时间</a></div></td><td class="values"><div class="setTime"><a href="javascript:void(0)">设置时间</a></div></td></tr>
					</table>
					
				</div>
			</div>
			
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<%/block%>