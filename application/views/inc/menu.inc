	<ul class="widget_bar">
                <li class="<%if $current_action=="index"%>current<%/if%>"><a href="/widget/">首页</a></li>
                <li class="<%if $current_action=="addwidget" or $current_action=="modifywidget"%>current<%/if%>"><a href="/widget/addwidget">widget制定</a></li>
                <li class="<%if $current_action=="completecompanyinfo"%>current<%/if%>"><a href="/widget/completecompanyinfo">信息认证</a></li>
            </ul>