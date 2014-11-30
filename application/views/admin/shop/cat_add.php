<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台-菜单品类上传<%/block%>
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
				<h4 class="tit4">菜单品类</h4>
				<div class="form-body">
					<table class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr><td class="keys">菜　　名:</td><td class="values"><input class="b-name-input" type="input" /></td></tr>
						<tr><td>类　　别:</td><td class="values"><select><option value="111">干锅</option></select><a id="addSelectItem" class="margin-l-little" href="javascript:void(0)">没有你要的选项？</a></td></tr>
						<tr><td rowspan="2">口　　味:</td><td class="values">
							<input class="radioBase" type="radio" name="kouwei" id="kw01" value="清淡" /><label class="margin-r-little" for="kw01">清淡</label>
							<input class="radioBase" type="radio" name="kouwei" id="kw02" value="微辣" /><label class="margin-r-little" for="kw02">微辣</label>
							<input class="radioBase" type="radio" name="kouwei" id="kw03" value="中辣" /><label class="margin-r-little" for="kw03">中辣</label>
							<input class="radioBase" type="radio" name="kouwei" id="kw04" value="重辣" /><label class="margin-r-little" for="kw04">重辣</label>
							</td></tr>
						<tr><td class="values">
							<input class="radioBase" type="checkbox" name="kouwei" id="kw05" value="甜" /><label class="margin-r-little" for="kw05">甜</label>
							<input class="radioBase" type="checkbox" name="kouwei" id="kw06" value="酸" /><label class="margin-r-little" for="kw06">酸</label>
							<input class="radioBase" type="checkbox" name="kouwei" id="kw07" value="苦" /><label class="margin-r-little" for="kw07">苦</label>
							<input class="radioBase" type="checkbox" name="kouwei" id="kw08" value="咖喱" /><label class="margin-r-little" for="kw08">咖喱</label>
						</td></tr>
						<tr><td>价　　格:</td><td class="values add-phones">
							<input type="text" class="b-price-input" />
						</td></tr>
						<tr><td>实拍照片:</td><td class="values add-phones">
							浏览
						</td></tr>
					</table>
					<input id="submiter" type="button" name="submiter" class="submiter" value="保存" /><a class="margin-l-little" href="Menu2.html">返回</a>
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