<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台-环境设置<%/block%>
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
				<h4 class="tit2">就餐环境</h4>
				<a href="/admin/shop/env_add" style="float: right;">上传新图</a>
				<div class="form-body">
					<ul class="shop-photo float_box">
					<%foreach $logo_list as $row%>
					<li><a href="" target="_blank"><img src="<%$row.thumb.165%>" /></a></li>
					<%/foreach%>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
						<li><a href="" target="_blank"><img src="<%#resUrl#%>/css/img/shop-photo.jpg?v=<%#v#%>" /></a></li>
					</ul>
<!-- 					<ol class="pages"> -->
<!-- 						<li>4</li><li>3</li><li>2</li><li class="active">1</li> -->
<!-- 					</ol> -->
					<%$pagination%>
				</div>
			</div>
			
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<script type="text/javascript">
</script>
<%/block%>