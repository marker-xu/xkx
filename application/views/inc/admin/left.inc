			<div class="navgations">
			<div class="head-pic">
				<div class="pic">
					<img src="<%if $current_shop_info.s_image%><%$current_shop_info.s_image%><%else%><%#resUrl#%>/css/img/headphoto.jpg?v=<%#v#%><%/if%>" class="head" />
				</div>
			</div>
			<ul id="navlist">
				<li class="<%if $current_action=="index"%>active<%/if%> nav1 "><a href="/admin">基本信息</a></li>
				<li class="<%if $current_action=="environment" or $current_action=="env_add"%>active<%/if%> nav2"><a href="/admin/shop/environment">就餐环境</a></li>
				<li class="<%if $current_action=="hours"%>active<%/if%> nav3"><a href="/admin/shop/hours">营业时间</a></li>
				<li class="<%if $current_action=="category" or $current_action=="cat_add"%>active<%/if%> nav4"><a href="/admin/shop/category">菜单品类</a></li>
				<li class="<%if $current_action=="preferential"%>active<%/if%> nav5"><a href="/admin/shop/preferential">优惠设置</a></li>
				<li class="<%if $current_action=="takeaway"%>active<%/if%> nav6"><a href="/admin/shop/takeaway">外送设置</a></li>
				<li class="<%if $current_action=="comments"%>active<%/if%> nav7"><a href="javascript:void(0);">用户评论</a></li>
			</ul>
		</div>
			
