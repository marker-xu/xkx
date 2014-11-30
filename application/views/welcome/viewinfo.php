<%extends file="common/base.tpl"%>

<%block name="title"%>欢迎来到摘牌秀<%/block%>
<%block name="view_conf"%>
<%/block%>

<%block name="custom_css"%>
<link rel="stylesheet" type="text/css" href="<%#resUrl#%>/css/video/widget.css?v=<%#v#%>">
<%/block%>

<%block name="custom_js"%>
<%/block%>
<%block name="bd"%>
<div id="bd">
<h3>标题：<%$post_info.title%></h3>
<div>
	正文：
	<%nl2br($post_info.content)%>
</div>
</div>
<%/block%>

<%block name="foot_js"%>
<script type="text/javascript">
	var from="<%$post_info.from%>";
	$(document).ready(function(){
		if( from=="sjtu" ) {
			$("div#bd img").each(function(){
				var imgFile = $(this).attr( "src" );
				$(this).attr("src", "/mmshow/sjtu/piccontent?f="+imgFile);
				$(this).css("max-width", "500px");
			});
		}
	});
</script>
<%/block%>