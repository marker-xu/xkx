<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台-优惠设置<%/block%>
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
	<div class="center float_box" style="height:860px;">
		<%include file="inc/admin/left.inc"%>
		<div class="contents">
			
			<%include file="inc/admin/shop_header.inc"%>
			<div id="base-info">
				<h4 class="tit5">优惠设置</h4>
				<div class="form-body">
					<div class="tabs">
						<ul class="float_box">
							<li class="tabItem active"><span>优惠信息</span></li>
							<li class="tabItem"><span>每日特价</span></li>
						</ul>
						<div class="tabContent">
							<div class="float_box"><p class="h4link"><a href="javascript:viod(0)">编辑</a></p></div>
							<div class="youhui">盛大员工凭工牌打8折</div>
							<div class="youhui">刷招商银行信用卡打9折</div>
						</div>
						<div class="tabContent" style="display:none;">
							<div id="weekTabs" class="float_box">
								<ul>
									<li class="weekItem active2"><span>周一</span></li>
									<li class="weekItem"><span>周二</span></li>
									<li class="weekItem"><span>周三</span></li>
									<li class="weekItem"><span>周四</span></li>
									<li class="weekItem"><span>周五</span></li>
									<li class="weekItem"><span>周六</span></li>
									<li class="weekItem"><span>周日</span></li>
								</ul>
								<div class="weekTabContent">
									<ul class="caiListUl">
										<li>
											<div class="teHuiTit">虾兵哇将</div>
											<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
											<p><span class="prePrice">原价：98.00</span><span class="tePrice">特价：86.00</span></p>
										</li>
										<li>
											<div class="teHuiTit">虾兵哇将</div>
											<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
											<p><span class="prePrice">原价：98.00</span><span class="tePrice">特价：86.00</span></p>
										</li>
										<li>
											<div class="teHuiTit">虾兵哇将</div>
											<div class="teHuiPic"><a href="javascript:void(0);"><img src="<%#resUrl#%>/css/img/tajiacai.jpg"/></a></div>
											<p><span class="prePrice">原价：98.00</span><span class="tePrice">特价：86.00</span></p>
										</li>
										<li>
											<a href="javascript:void(0);" class="addCai"></a>
										</li>
									</ul>
								</div>
								<div class="weekTabContent" style="display:none;">
									<ul class="caiListUl">
										<li>
											<a href="javascript:void(0);" class="addCai"></a>
										</li>
									</ul>
								</div>
								<div class="weekTabContent" style="display:none;">
									<ul class="caiListUl">
										<li>
											<a href="javascript:void(0);" class="addCai"></a>
										</li>
									</ul>
								</div>
								<div class="weekTabContent" style="display:none;">
									<ul class="caiListUl">
										<li>
											<a href="javascript:void(0);" class="addCai"></a>
										</li>
									</ul>
								</div>
								<div class="weekTabContent" style="display:none;">
									<ul class="caiListUl">
										<li>
											<a href="javascript:void(0);" class="addCai"></a>
										</li>
									</ul>
								</div>
								<div class="weekTabContent" style="display:none;">
									<ul class="caiListUl">
										<li>
											<a href="javascript:void(0);" class="addCai"></a>
										</li>
									</ul>
								</div>
								<div class="weekTabContent" style="display:none;">
									<ul class="caiListUl">
										<li>
											<a href="javascript:void(0);" class="addCai"></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<%/block%>