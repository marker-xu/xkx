<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台-菜单品类<%/block%>
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
				<h4 class="tit4"><p class="h4link"><a href="/admin/shop/cat_add">上传菜品</a></p>菜单品类</h4>
				<div class="form-body">
					<div id="caiTabs" class="float_box">
						<ul>
							<li class="weekItem active2"><span>干锅</span></li>
							<li class="weekItem"><span>例汤</span></li>
							<li class="weekItem"><span>甜品</span></li>
						</ul>
						<div class="weekTabContent">
							<ul class="caiListUl">
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
							</ul>
						</div>
						<div class="weekTabContent" style="display:none;">
							<ul class="caiListUl">
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
							</ul>
						</div>
						<div class="weekTabContent" style="display:none;">
							<ul class="caiListUl">
								<li>
									<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
									<p><span class="prePrice">98.00</span><span class="tePrice">虾兵瓦匠</span></p>
								</li>
							</ul>
						</div>
					</div>
					<ol class="pages">
						<li>4</li><li>3</li><li>2</li><li class="active">1</li>
					</ol>
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