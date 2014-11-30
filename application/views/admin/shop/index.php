<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到爱美味管理平台<%/block%>
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
            <%if $is_edit%>
				<h4>基本信息</h4>
				<div class="form-body">
				<form action="javascript:void(0)" method="post" id="shop_info">
					<%Form::hidden('csrf_token', Security::token())%>
					<table class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr><td class="keys">商户名称:</td><td class="values"><input class="b-name-input" type="input" name="shop_name" value="<%$shop_info.s_name%>" /></td></tr>
						<tr><td>地　　址:</td><td class="values"><select><option value="111">上海浦东新区</option></select><input class="b-sdr-input margin-l-little" type="input" name="shop_address" value="<%$shop_info.s_addr%>" /></td></tr>
						<tr><td>主打菜系:</td><td class="values">
						<select name="cuisine">
						<option value="">请选择</option>
						<%foreach $cuisine_list as $row%>
						<option value="<%$row.s_name%>" <%if $shop_info.j_tags && in_array($row.s_name, $shop_info.j_tags)%>selected<%/if%>><%$row.s_name%></option>
						<%/foreach%>
						</select>
						<a class="margin-l-little" href="#">没有你要的选项？</a></td></tr>
						<tr><td>服务电话:</td><td class="values add-phones">
						<%if $shop_info.j_tel_number%>
						<%foreach $shop_info.j_tel_number as $phone%>
						<input type="text" class="phone b-phone-input" name="phone[]" value="<%$phone%>" />
						<a class="delPhone margin-l-little" href="javascript:void(0)">删除</a>
						<br class="brs">
						<%/foreach%>
						<%/if%>
						<input type="text" class="b-phone-input" name="phone[]" id="phone01" /><a id="addPhone" class="margin-l-little" href="javascript:void(0)">增加</a></td></tr>
					</table>
					<input id="submiter" type="button" name="submiter" class="submiter" value="保存" />
				</form>
				</div>
            <%else%>
                <h4 class="tit1"><p class="h4link"><a href="/admin/shop/index?edit=1">编辑</a></p>基本信息</h4>
				<div class="form-body">
					<table class="form-table" cellpadding="0" cellspacing="0" border="0">
						<tr><td class="keys">商户名称:</td><td class="values"><%$shop_info.s_name%></td></tr>
						<tr><td>地　　址:</td><td class="values"><%$shop_info.s_addr%></td></tr>
						<tr><td>主打菜系:</td>
                        <%if $shop_info.j_tags%>
						<%foreach $shop_info.j_tags as $tag%>
                        <td class="values">
							<%$tag%>
						</td>
                        <%/foreach%>
						<%/if%>
                        </tr>
						<tr><td>服务电话:</td>
                        <%if $shop_info.j_tel_number%>
                        <td class="values">
						<%foreach $shop_info.j_tel_number as $phone%>
							<p><%$phone%></p>
                        <%/foreach%>
						</td>
						<%/if%>
                        </tr>
					</table>
					
				</div>
            <%/if%>
			</div>
			
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<script type="text/javascript">
$("#submiter").click(function(){
    $.post("/admin/shop/index", $("#shop_info").serialize(), function(data){
    	if(data.err=='ok'){
        	alert("保存成功");
    		window.location.reload();
 		}else{
 			alert(data.msg);
 		}
    } );
	return false;
})
</script>
<%/block%>