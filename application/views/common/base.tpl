<!doctype html>
<%strip%>
<%config_load file='site.conf'%>
<%block name="view_conf"%>
<%/block%>
<html>
<head>
    <meta charset="utf-8">
    <title><%block name="title"%>-爱美味<%/block%></title> 
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>    
	<%block name="custom_css"%>
	<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/css/common.css?v=<%#v#%>">
	<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/css/reset.min.css?v=<%#v#%>">
	<%$smarty.block.child%>
	<%/block%>
	<%block name="custom_js"%>
	<script type="text/javascript" src="<%#resUrl#%>/js/third/jquery-1.7.2.min.js"></script>
	<%$smarty.block.child%>
	<%/block%>
</head>
<%/strip%>
<body>
    <div id="<%block name="doc"%>doc1<%/block%>">
        <%block name="hd"%>
            <%include file="common/header.tpl"%>
        <%/block%>
        <%block name="bd"%>
        <%/block%>
        <%block name="ft"%>
            <%include file="common/footer.tpl"%>
        <%/block%>
    </div>
    <%block name="foot_html"%>
    <%/block%>

    <%*其他尾部js*%>
    <%block name="foot_js"%>
        <%$smarty.block.child%>
    <%/block%>

    <%*其他自定义尾部数据*%>
    <%block name="custom_foot"%>
        <%$smarty.block.child%>
    <%/block%>    
</body>
</html>