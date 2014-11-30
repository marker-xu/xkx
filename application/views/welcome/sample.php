<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到后台<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/css/video/widget.css?v=<%#v#%>">
<%/block%>

<%block name="custom_js"%>
<%/block%>
<%block name="bd"%>
<div id="bd">
<h1>This is a sample view.</h1>
<div>Hello <%$person|capitalize%>!</div>
</div>
<%/block%>

<%block name="foot_js"%>

<%/block%>