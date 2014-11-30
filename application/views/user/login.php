<%extends file="common/base.tpl"%>

<%block name="title"%>登录<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/css/login-b.min.css?v=<%#v#%>">
<%/block%>

<%block name="custom_js"%>
<%/block%>
<%block name="bd"%>
<div id="main-body">
	<div class="ads-pic">
		<img src="<%#resUrl#%>/css/img/index-ads.jpg?v=<%#v#%>"/>
	</div>
	<div class="login-place">
		<div id="login-form">
			
		</div>
		<div id="form-submit">
			<input class="btn-submit" type="button" value=""/>
			<img class="login-qq-btn" src="<%#resUrl#%>/css/img/login-qq.jpg?v=<%#v#%>" />
		</div>
	</div>
</div>
<%/block%>

<%block name="foot_js"%>
<script type="text/javascript">
var login_url = "<%$login_url%>";     
	$(document).ready(function(){
		$(".btn-submit").click(function(){
			var oauth_login_window = window.open(login_url, "oauth_login_window", "width=700,height=600,toolbar=yes,menubar=yes,resizable=yes,status=yes");

		    oauth_login_window.focus();
		});
	});
</script>
<%/block%>