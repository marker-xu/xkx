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
<h3>How do you see?</h3>
<div>
	<table>
		<thead>
			<th style="width: 25%;">标题</th>
			<th style="width: 17%;">日期</th>
			<th style="width: 8%;">来源</th>
			<th style="width: 5%;">性别</th>
			<th style="width: 10%;">挂牌者</th>
			<th style="width: 25%;">老照片</th>
			<th>操作</th>
		</thead>
		
		<tbody>
		<%foreach $show_list as $row%>
			<tr>
				<td><%$row.title%></td>
				<td><%$row.date%></td>
				<td><%if $row.from=="fudan_mb"%>复旦鹊桥<%elseif $row.from=="fudan_single"%>复旦Single<%elseif $row.from=="newsmth"%>水木清华<%else%>饮水思源<%/if%></td>
				<td><%if $row.gender==-1%>你猜<%elseif !$row.gender%>男<%else%>女<%/if%></td>
				<td><%$row.author|escape:"html"%></td>
				<td><%if isset($row.spot_pic) and $row.spot_pic%><img src="<%if $row.from=="sjtu"%>/mmshow/sjtu/piccontent?f=<%else%><%/if%><%$row.spot_pic%>" 
				style="width:100px;" /><%else%>暂无<%/if%></td>
				<td><a href="/mmshow/welcome/viewinfo?from=<%$row.from%>&pid=<%$row.post_id%>">查看</a></td>
			</tr>
		<%/foreach%>
		</tbody>
	</table>
</div>
</div>
<%/block%>

<%block name="foot_js"%>

<%/block%>